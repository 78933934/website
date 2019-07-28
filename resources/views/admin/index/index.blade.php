@extends('admin.layout')
@section('content')
    <section class="content-header">
        <h1>
            首页
        </h1>
    </section>
    <section class="content">

        <style>
            .operate_account{
                cursor:pointer;
            }
        </style>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row"><div class="col-md-12"><div class="box">

                    <div class="box-header with-border " id="filter-box">
                        <form action="" class="form-horizontal" method="get" id="fm">

                            <div class="row">
                                <div>
                                    <div class="box-body">
                                        <div class="fields-group">
                                            <div class="form-group">

                                                <label class="col-sm-1 control-label">平台</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control status" name="platform_id">
                                                        <option></option>

                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="btn-group pull-left">
                                                <button class="btn btn-info submit btn-sm"><i
                                                            class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
                                            </div>
                                            <div class="btn-group pull-left " style="margin-left: 10px;">
                                                <a href="" class="btn btn-default btn-sm"><i
                                                            class="fa fa-undo"></i>&nbsp;&nbsp;重置</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="pull-right">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#add">
                                <i class="fa fa-plus"></i> 新增
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-sm btn-twitter" title="导出">
                                <i class="fa fa-download"></i><span class="hidden-xs"> 导出</span>
                            </button>

                            <!-- 模态框（Modal） -->
                            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">新增活动费用</h4>
                                        </div>
                                        <form role="form"  method="post">
                                            <div class="modal-body">
                                                <table class="table">
                                                    <tr>
                                                        <td>平台：<select name="platform_id" class="">
                                                                <option></option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            是否VIP：<select name="vip">
                                                                <option></option>
                                                                <option value="1">是</option>
                                                                <option value="0">否</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                </table>

                                            </div>

                                            <div class="modal-footer">
                                                <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                <button type="button" class="btn btn-primary submit">提交</button>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal -->
                            </div>
                        </div>

                    </div>

                    <div  class="box box-default box-solid">
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                        <div class="box-body" style="display: block;">
                            共11条
                        </div><!-- /.box-body -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    平台
                                </th>
                                <th>
                                    类型
                                </th>
                                <th>
                                    VIP级别
                                </th>
                                <th>
                                    是否VIP
                                </th>

                                <th>
                                    短信
                                </th>
                                <th>
                                    旺旺聊天
                                </th>
                                <th>
                                    手淘问大家
                                </th>
                                <th>
                                    再次搜索下单
                                </th>
                                <th>
                                    评价/评价晒图
                                </th>
                                <th>
                                    追评/追评晒图
                                </th>


                                <th>坑位费</th>
                                <th>申请手续费/份</th>
                                <th>提成比例</th>
                                <th>提成最低值/最高值</th>
                                <th>
                                    操作
                                </th>
                            </tr>
                            </thead>

                            <tbody>


                            </tbody>
                        </table>

                    </div>


                    <div class="box-footer clearfix ">

                        <div class="pull-right">
                            <!-- Previous Page Link -->

                        </div>

                        <label class="control-label pull-right" style="margin-right: 10px;margin-top: 20px; font-weight: 100;">

                            <small>显示</small>&nbsp;
                            <select class="input-sm grid-per-pager" name="per-page">
                                @foreach(['10','20','30','50','100'] as $per_page)
                                    <option value="{{$per_page}}">{{$per_page}}</option>
                                @endforeach

                            </select>
                            &nbsp;<small>条</small>
                        </label>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>

@endsection


@section('script')

    <script>

        $(function () {
            $('#created_at_start').datetimepicker({"format":"YYYY-MM-DD","locale":"zh-CN"});
            $('#created_at_end').datetimepicker({"format":"YYYY-MM-DD","locale":"zh-CN","useCurrent":false});
            $("#created_at_start").on("dp.change", function (e) {
                $('#created_at_end').data("DateTimePicker").minDate(e.date);
            });
            $("#created_at_end").on("dp.change", function (e) {
                $('#created_at_start').data("DateTimePicker").maxDate(e.date);
            });

            $(".status").select2({
                placeholder: {"id":"","text":"\u9009\u62e9"},
                "allowClear":true
            });
        });

        //验证表单
        $("div[id*=EditModal_], #add").find('form .submit').click(function(){
            var tb = $(this).parents('form').find('.table');
            console.log(tb);
            var submit = true;
            tb.find('input').each(function(){
                if($(this).val() == ''){
                    submit = false;
                    $(this).parent('td').find('.error_tip').remove();
                    $(this).parent('td').append("<span class=\"error_tip\" style=\"color: red\"><br />该项必填</span>");
                }else{
                    $(this).parent('td').find('.error_tip').remove();
                }
            })

            if(submit){
                $(this).parents('form').submit();
            }
        })

    </script>
@endsection
