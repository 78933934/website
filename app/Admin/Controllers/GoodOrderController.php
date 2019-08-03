<?php

namespace App\Admin\Controllers;

use App\Events\AuditOrderSuccessEvent;
use App\Models\Good;
use App\Models\GoodOrder;
use App\Models\GoodOrderSku;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class GoodOrderController extends Controller
{
    public function index(Request $request){

        //列表
        $go = new GoodOrder();
        list($orders, $search) = $go->get_data($request);

        //状态
        $status = config('order.status');

        return view('admin.good_order.index', compact('orders', 'search', 'status'));
    }

    /**
     * 审核订单
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function audit(Request $request, $id){

        $good_order = GoodOrder::find($id);

        if(!$good_order){
            return redirect()->route('good_orders.index')->with('error', '订单不存在');
        }

        $status = $request->post('status');
        $remark = $request->post('remark');

        $good_order->status = $status;
        $good_order->last_audited_at = Carbon::now();
        $good_order->last_audited_admin_user_id = Admin::user()->id;
        $res = $good_order->save();

        if($res) {
            //记录审核日志
            event(new AuditOrderSuccessEvent($good_order, $remark));

            $msg = '审核成功';
        }else{
            $msg = '审核失败';
        }

        $alert_type = $res ? 'success' : 'error';

        return redirect()->route('good_orders.index')->with($alert_type, $msg);

    }

    //删除 禁用
    public function destroy(Request $request, $id){

        $go = GoodOrder::find($id);
        if(!$go){
            return returned(false, '订单不存在');
        }

        $res = $go->delete();
        $msg = $res ? '删除成功':'删除失败';

        return returned($res, $msg);

    }

}
