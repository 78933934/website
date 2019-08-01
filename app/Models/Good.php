<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Good extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $page_size = 20;


    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'name',
        'original_price',
        'price',
        'product_id',
        'product_name',
        'admin_user_id',
        'category_id',
        'pay_types',
        'show_comment',
        'detail_desc',
        'size_desc',
        'main_image_url',
        'main_video_url'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function list_images(){
        return $this->hasMany(GoodImage::class);
    }

    public function admin_user(){
        return $this->belongsTo(AdminUser::class);
    }

    public function category(){
        return $this->belongsTo(GoodCategory::class,'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes(){
        return $this->hasMany(GoodAttribute::class);
    }

    public function skus(){
        return $this->hasMany(GoodSku::class);
    }

    /**
     * 列表数据
     * @param $request
     * @return array
     */
    public function get_data($request){

        $base_query =  Good::withTrashed()->with(['list_images'])
            ->leftJoin('admin_users','admin_users.id','goods.admin_user_id');

        list($query, $search) = $this->query_conditions($base_query, $request);

        $data = $query->select(
                'goods.id',
                'goods.title',
                'goods.name',
                'goods.price',
                'goods.main_image_url',
                'goods.created_at',
                'goods.deleted_at',
                'admin_users.username'
            )
            ->orderBy('goods.id', 'desc')
            ->paginate($this->page_size);

        return [$data, $search];
    }

    /**
     * 条件筛选
     * @param $request
     * @param $base_query
     */
    protected function query_conditions($base_query, $request){

        //筛选时间
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        if($start_date && $end_date){
            $base_query->whereBetween('goods.created_at', [$start_date, Carbon::parse($end_date)->endOfDay()]);
        }

        //单品类型
        $category_id = $request->get('category_id');
        if($category_id){
            $base_query->where('category_id', $category_id);
        }

        //单品类型
        $product_id = $request->get('product_id');
        if($product_id){
            $base_query->where('product_id', $product_id);
        }

        //禁用
        $status = $request->get('status');
        switch($status){
            case 1:
                $base_query->whereNull('goods.deleted_at');
                break;
            case 2:
                $base_query->whereNotNull('goods.deleted_at');
                break;
        }

        //关键词
        $keywords = $request->get('keywords');
        if($keywords){
            $base_query->where(function($query) use ($keywords){
                $query->where('goods.title', 'like', '%'.$keywords.'%')
                    ->orWhere('goods.name','like', '%'.$keywords.'%');
            });
        }

        //分页大小
        $per_page = $request->get('per_page') ?: $this->page_size;
        $this->page_size = $per_page;


        $search = compact('start_date','end_date','category_id','product_id','status','keywords','per_page');

        return [$base_query, $search];
    }

    public function getPayTypesAttribute($value)
    {
        return json_decode($value);
    }

//    public function setMainImageUrlAttribute($value)
//    {
//        $this->attributes['main_image_url'] = asset('storage/'.$value);
//    }

    /**
     * @param $request
     * @return mixed
     */
    public function export($request){

        $base_query = Good::leftJoin('admin_users','admin_users.id','goods.admin_user_id');

        list($query, $search) = $this->query_conditions($base_query, $request);

        return $query->select(
            'goods.id',
            'goods.name',
            'goods.title',
            'goods.original_price',
            'goods.price',
            'goods.detail_desc',
            'admin_users.username',
            'goods.created_at',
            'goods.main_video_url'
        )
            ->orderBy('goods.id','desc')
            ->get();

    }
}
