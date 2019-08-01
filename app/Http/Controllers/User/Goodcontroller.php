<?php

namespace App\Http\Controllers\User;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Goodcontroller extends Controller
{
    //

    public function index(){

    }

    public function show(Request $request, $id){

        $good = Good::find($id);

        //轮播图列表
        $list_images = $good->list_images()->pluck('image_url');

        //属性
        $attrs = collect([]);
        foreach ($good->attributes as $key=>$attribute){

            $key = $key+1;

            $item = [
                'k' => $attribute->name,
                'v' => $attribute->attribute_values()->select('remote_id as id','name','thumb_url as imageUrl')->get(),
                'k_s' => 's'.$key
            ];

            $attrs->push($item);
        }

        //sku list
        $skus = $good->skus()->select('sku_id as id','price','s1','s2','s3','stock as stock_num')->get();

        $good->tree = $attrs;
        $good->list = $skus;
        $good->list_images = $list_images;

        if($good->attributes->count() == 0){
            $good->none_sku = 0;
            $good->collection_id = $good->id;
        }

        $good->image_prefix = env('APP_URL','').'/storage/';

        unset($good->attributes);

        return compact('good');

    }
}
