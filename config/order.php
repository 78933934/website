<?php
/**
 * @订单配置
*/

use \App\Models\GoodOrder;

return [

    'status' => [
        GoodOrder::NOT_AUDIT_TYPE => '未审核',
        GoodOrder::AUDIT_PASSED_TYPE => '审核通过',
        GoodOrder::AUDIT_REFUSED_TYPE => '审核拒绝'
    ],

    'pay_types' => [
        1 => '货到付款',
        2 => '在线支付',
    ],
];




?>