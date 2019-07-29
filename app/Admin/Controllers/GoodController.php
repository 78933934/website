<?php

namespace App\Admin\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Encore\Admin\Facades\Admin;


/**
 * Class GoodController
 * @package App\Admin\Controllers
 */
class GoodController extends Controller
{
    //首页
    public function index(Request $request){

//        dd(Good::find(1)->category);

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

        $pay_types = json_encode($request->post('pay_types'));

        $main_image_file = $request->file('main_image_file');

        $list_image_files = $request->file('list_image_files');

        $main_video_file = $request->file('main_video_file');

        if($main_image_file){
            $main_image_url = $this->upload($main_image_file);
        }

        if($main_video_file){
            $main_video_url = $this->upload($main_image_file);
        }

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

        //加轮播图
        if($list_image_files && count($list_image_files) > 0){
            $list_image_urls = [];
            foreach ($list_image_files as $list_image_file){
                $url = $this->upload($list_image_file);
                if($url){
                    array_push($list_image_urls,['image_url' => $url]);
                }
            }

            $result = $mod->list_images()->createMany($list_image_urls);
        }

        if($mod){
            return redirect(route('goods.index'))->with('success','添加成功');
        }else{
            return redirect(route('goods.index'))->with('error','添加失败');
        }

    }

    //编辑
    public function update(Request $request, $id){

    }

    //详情
    public function show(Request $request, $id){

    }

    //删除
    public function destory(Request $request, $id){

    }

    protected function upload($file){

        # 允许上传的扩展名
        $allow_extensions = ['jpg','jpeg','png','gif','mp4'];
        $allow_extensions_str = implode(',',$allow_extensions);

        if(!$file->isValid())
        {
            admin_error('文件无效,附件上传失败,请联系管理员');
        }

        # 扩展名
        $extension = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);

        if(!in_array(strtolower($extension), $allow_extensions))
        {
            admin_error('只允许上传指定格式文件ext:'.$allow_extensions_str);
        }

//        # 文件大小
//        $file_size = $file->getClientSize();
//
//        if($file_size > AttachmentController::FILE_LIMIT)
//        {
//            admin_error('超过文件大小限制4MB');
//        }

        $doc_path = AttachmentController::ATTACHMENT_PATH.date('Y').'/'.date('m').'/'.date('d');

        $filename = md5(time()).'.'.$extension;

        Storage::makeDirectory($doc_path);

        $result = Storage::disk('public')->putFileAs($doc_path, $file, $filename);

        # 保存文件并, 路径,
        return $result ? $result : false;
    }

}
