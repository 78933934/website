<?php

namespace App\Http\Controllers\User;

use App\Models\GoodOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodOrderController extends Controller
{

    public function store(Request $request){

        $ip = ip2long($request->ip());

        $cart_data = collect([
            ['sku_id' => 1001,'price' => 99,'sku_nums' => 1,'good_id' => 24],
            ['sku_id' => 1002,'price' => 99,'sku_nums' => 2,'good_id' => 24],
            ['sku_id' => 2001,'price' => 199,'sku_nums' => 1,'good_id' => 25],
            ['sku_id' => 3001,'price' => 299,'sku_nums' => 1,'good_id' => 26],
        ]);

        $address = [
            'receiver_name' => '收货人姓名',
            'receiver_phone' => '收货人电话',
            'receiver_email' => '收货人邮箱',
            'address' => '主地址；省市区镇',
            'short_address' => '短地址；街道门牌号',
            'leave_word' => '留言',
        ];


        $skus_price = $cart_data->map(function($item){
            return ($item['price'] * $item['sku_nums']);
        });

        $insert_data = [
            'price' => $skus_price->sum(),
            'ip' => $ip,
            'sn' => generate_sn(),
        ];

        $go = GoodOrder::create(array_merge($insert_data, $address));

        if($go){
            $go->order_skus()->createMany($cart_data->all());
            return returned(true, '提交订单成功');
        }else{
            return returned(false, '提交订单失败');
        }
    }
}
