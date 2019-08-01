<?php

namespace App\Listeners;

use App\Events\BindGoodAttributeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BindGoodAttributeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BindGoodAttributeEvent  $event
     * @return void
     */
    public function handle(BindGoodAttributeEvent $event)
    {
        $good = $event->good;


        $sku_datas = [
            [
                'sku_id' => 1001,
                'attrs' => [['id'=>1,'name'=>'红'],['id'=>4,'name'=>'大']],
                'price' => 100,
                'stock' => 0
            ],

            [
                'sku_id' => 1002,
                'attrs' => [['id'=>2,'name'=>'黄'],['id'=>4,'name'=>'大']],
                'price' => 200,
                'stock' => 0
            ],
            [
                'sku_id' => 1003,
                'attrs' => [['id'=>3,'name'=>'蓝'],['id'=>4,'name'=>'大']],
                'price' => 300,
                'stock' => 0
            ],
        ];

        foreach ($sku_datas as $sku_data){

            $tmp = [];
            foreach ($sku_data['attrs'] as $key=>$attr){
                $k = 's'.intval($key+1);
                $tmp[$k] = $attr['id'];
                $tmp[$k.'_name'] = $attr['name'];
            }

            $insert_data = array_merge($tmp,[
                    'sku_id' => $sku_data['sku_id'],
                    'price' => $sku_data['price'],
                    'stock' => $sku_data['stock']
                ]
            );

            $sku_obj = $good->skus()->create($insert_data);
        }

        $attr_data = [
            [
                'id' => 1,
                'name' => '颜色',
                'value' => [['name'=>'红','id'=>1],['name'=>'黄','id'=>2],['name'=>'蓝','id'=>3]],
            ],

            [
                'id' => 2,
                'name' => '尺寸',
                'value' => [['name'=> '大','id'=>4],['name' => '小', 'id' =>5]],
            ]
        ];

        foreach ($attr_data as $data){

            $attr_obj = $good->attributes()->create([
               'remote_id' => $data['id'],
               'name' => $data['name']
            ]);

            $values = collect([]);

            foreach ($data['value'] as $item){
                $values->push([
                    'remote_id' => $item['id'],
                    'name' => $item['name']
                ]);
            }

            $attr_obj->attribute_values()->createMany($values->all());
        }
    }
}
