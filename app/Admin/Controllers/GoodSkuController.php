<?php

namespace App\Admin\Controllers;

use App\Models\GoodSku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodSkuController extends Controller
{


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $g_sku = GoodSku::find($id);

        $action = $request->post('action');

        switch ($action){
            case 'hidden':
                $disabled_at = Carbon::now();
                break;

            case 'showing':
                $disabled_at = null;
                break;

            default:
                return response()->json(['success' => false, 'msg' => '参数不对']);
        }

        $g_sku->disabled_at = $disabled_at;
        $res = $g_sku->save();

        $msg = $res ? '设置成功':'设置失败';

        return response()->json(['success' => $res, 'msg' => $msg]);

    }
}
