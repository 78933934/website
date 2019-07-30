<?php

namespace App\Admin\Controllers;

use App\Models\Good;
use App\Models\GoodImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Log;


/**
 * Class GoodController
 * @package App\Admin\Controllers
 */
class GoodController extends Controller
{
    //首页
    public function index(Request $request){

        $gd = new Good();
        $goods = $gd->get_data();

        return view('admin.good.index',compact('goods'));
    }

    //新增页面
    public function create(Request $request){

        return view('admin.good.create');
    }

    //新增
    public function store(Request $request){

        $insert_data = $request->only([
            'title',
            'name',
            'original_price',
            'price',
            'product_id',
            'product_name',
            'category_id',
            'show_comment',
            'detail_desc',
            'size_desc'
        ]);

        if(is_null($request->post('show_comment'))){
            $insert_data['show_comment'] = 0;
        }

        $pay_types = json_encode($request->post('pay_types'));

        list($main_image_url, $main_video_url, $list_image_urls) = $this->upload_file($request);

        //添加商品
        $mod = Good::create(array_merge(
            $insert_data,
            [
                'admin_user_id' => Admin::user()->id,
                'main_image_url' => $main_image_url,
                'main_video_url' => $main_video_url ?? null,
                'pay_types' => $pay_types
            ]
        ));

        if($mod && count($list_image_urls)){
            $result = $mod->list_images()->createMany($list_image_urls);
        }

        if($mod){
            return redirect(route('goods.index'))->with('success','添加成功');
        }else{
            return redirect(route('goods.index'))->with('error','添加失败');
        }

    }

    //编辑保存
    public function update(Request $request, $id){

        $gd = Good::find($id);
        if(!$gd){
            return redirect(route('goods.index'))->with('error', '商品不存在');
        }

        $update_data = $request->only([
            'title',
            'name',
            'original_price',
            'price',
            'product_id',
            'product_name',
            'category_id',
            'show_comment',
            'detail_desc',
            'size_desc'
        ]);

        if(is_null($request->post('show_comment'))){
            $update_data['show_comment'] = 0;
        }

        $pay_types = json_encode($request->post('pay_types'));

        $update_data = collect($update_data)->merge(['pay_types' => $pay_types]);

        list($main_image_url, $main_video_url, $list_image_urls) = $this->upload_file($request);

        if($main_image_url){
            $update_data = collect($update_data)->merge(['main_image_url' => $main_image_url]);
        }

        if($main_video_url){
           $update_data = collect($update_data)->merge(['main_video_url' => $main_video_url]);
        }

        $result = Good::where('id', $id)->update($update_data->all());

        if($result){
            if(count($list_image_urls) >0){
                //删除原来的
                GoodImage::where('good_id',$id)->delete();
                //添加新的
                $gd->list_images()->createMany($list_image_urls);
            }
            return redirect(route('goods.index'))->with('success', '更新成功');
        }else{
            return redirect(route('goods.index'))->with('error', '更新失败');
        }


    }

    //编辑请求
    public function edit(Request $request, $id){

        $detail = Good::find($id);
        $list_images = $detail->list_images;

        $list_image_urls = '';
        if($list_images->count() >0){
            $list_image_urls = $list_images->map(function($item){
                return asset('storage/'.$item->image_url);
            });

            $list_image_urls = str_replace(['[',']'], '', json_encode($list_image_urls));
        }

        return view('admin.good.edit', compact('detail','list_image_urls'));
    }

    //删除
    public function destory(Request $request, $id){

    }

    /**
     * @param $request
     * @return array
     */
    public function upload_file($request){

        $main_image_file = $request->file('main_image_file');

        $list_image_files = $request->file('list_image_files');

        $main_video_file = $request->file('main_video_file');

        $main_image_url = $main_image_file ? $this->upload($main_image_file) : null;

        $main_video_url = $main_video_file ? $this->upload($main_video_file) : null ;

        //加轮播图
        $list_image_urls = [];
        if($list_image_files && count($list_image_files) > 0){
            foreach ($list_image_files as $list_image_file){
                $url = $this->upload($list_image_file);
                if($url){
                    array_push($list_image_urls,['image_url' => $url]);
                }
            }
        }

        return [$main_image_url, $main_video_url, $list_image_urls];

    }

    //do upload
    protected function upload($file){

        # 允许上传的扩展名
        $allow_extensions = ['jpg','jpeg','png','gif','mp4'];

//        if(!$file->isValid())
//        {
//            admin_error('文件无效,附件上传失败,请联系管理员');
//        }

        # 扩展名
        $extension = $file->extension();

        Log::info($extension);

        if(!in_array(strtolower($extension), $allow_extensions))
        {
            session()->flash('error','文件类型不正确,当前文件后缀:'.$extension);
            return false;
        }

        # 文件大小
        $file_size = $file->getClientSize();

        if($file_size > AttachmentController::FILE_LIMIT)
        {
            session()->flash('error','超过文件大小限制10MB');
            return false;
        }

        $doc_path = AttachmentController::ATTACHMENT_PATH.date('Y').'/'.date('m').'/'.date('d');

        $filename = md5(time()).'.'.$extension;

        Storage::makeDirectory($doc_path);

        $result = Storage::disk('public')->putFileAs($doc_path, $file, $filename);

        # 保存文件并, 路径,
        return $result ? $result : false;
    }

}
