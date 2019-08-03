<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodOrder extends Model
{
    protected $table = 'good_orders';

    use SoftDeletes;

    protected $fillable = [
        'sn',
        'ip',
        'price',
        'status',
        'receiver_name',
        'receiver_phone',
        'receiver_email',
        'address',
        'short_address',
        'leave_word'

    ];

    /**
     * 未审核
     */
    const NOT_AUDIT_TYPE = 0;

    /**
     * @审核通过
     */
    const AUDIT_PASSED_TYPE = 1;
    /**
     * @审核拒绝
     */
    const AUDIT_REFUSED_TYPE = 2;



    public function order_skus(){
        return $this->hasMany(GoodOrderSku::class);
    }

    public function admin_user(){
        return $this->belongsTo(AdminUser::class, 'last_audited_admin_user_id', 'id');
    }

    public function audit_logs(){
        return $this->hasMany(GoodAuditLog::class);
    }

    /**
     * 列表数据
     * @param $request
     * @return array
     */
    public function get_data($request){

        $base_query =  GoodOrder::with(['order_skus' => function($query){
        },'admin_user']);

        list($query, $search) = $this->query_conditions($base_query, $request);

        $data = $query->select(
            'good_orders.*'
        )
            ->orderBy('good_orders.id', 'desc')
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
            $base_query->whereBetween('good_orders.created_at', [$start_date, Carbon::parse($end_date)->endOfDay()]);
        }

        //审核状态筛选
        $status = $request->get('status');
        if(!is_null($status)){
            $base_query->where('good_orders.status', $status);
        }

        //关键词
        $keywords = $request->get('keywords');
        if($keywords){
            $base_query->where(function($query) use ($keywords){
                $query->where('good_orders.sn', $keywords);
            });
        }

        //分页大小
        $per_page = $request->get('per_page') ?: $this->page_size;
        $this->page_size = $per_page;


        $search = compact('start_date','end_date','status','keywords','per_page');

        return [$base_query, $search];
    }

    /**
     * @param $value
     * @return string
     */
    public function getIpAttribute($value){
        return long2ip($value);
    }
}
