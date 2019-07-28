<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

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
        'created_admin_user_id',
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
        return $this->hasMany(GoodImage::class, 'good_id','id');
    }
}
