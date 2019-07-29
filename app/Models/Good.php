<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function get_data(){

        return Good::with(['list_images'])
            ->leftJoin('admin_users','admin_users.id','goods.admin_user_id')
            ->select(
                'goods.id',
                'goods.title',
                'goods.name',
                'goods.price',
                'goods.created_at',
                'admin_users.username'
            )
            ->orderBy('goods.id', 'desc')
            ->paginate($this->page_size);
    }
}
