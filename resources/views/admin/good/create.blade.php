@extends('admin.layout')
@section('content')

    <section class="content-header">
        <h1>
            创建商品
        </h1>

        <!-- breadcrumb start -->

        <!-- breadcrumb end -->

    </section>

    <section class="content">


        <div class="row"><div class="col-md-12"><div class="box box-info">
                    <div class="box-header with-border">

                        <div class="box-tools">
                            <div class="btn-group pull-right" style="margin-right: 5px">
                                <a href="{{route('goods.index')}}" class="btn btn-sm btn-default" title="列表"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;列表</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('goods.store')}}" method="post" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" pjax-container>

                        <div class="box-body">

                            <div class="fields-group">

                                <div class="form-group  ">

                                    <label for="title" class="col-sm-2 asterisk control-label">网页标题名</label>

                                    <div class="col-sm-8">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>

                                            <input type="text" id="title" name="title" value="" class="form-control title" placeholder="输入 网页标题名" required="1" />

                                        </div>


                                    </div>
                                </div>
                                <div class="form-group  ">

                                    <label for="name" class="col-sm-2 asterisk control-label">单品名</label>

                                    <div class="col-sm-8">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>

                                            <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 单品名" required="1" />

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  ">

                                    <label for="original_price" class="col-sm-2 asterisk control-label">原价</label>

                                    <div class="col-sm-8">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>

                                            <input type="text" id="original_price" name="original_price" value="" class="form-control original_price" placeholder="输入 原价" required="1" />

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="price" class="col-sm-2 asterisk control-label">单品价格</label>

                                    <div class="col-sm-8">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>

                                            <input type="text" id="price" name="price" value="" class="form-control price" placeholder="输入 单品原价" required="1" />

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="product_id" class="col-sm-2 asterisk control-label">选择产品</label>

                                    <div class="col-sm-8">

                                        <select class="form-control single_select" style="width: 100%;" name="product_id" required="1" >
                                            <option></option>
                                            <option value="1" >产品1</option>
                                            <option value="2" >产品2</option>
                                            <option value="3" >产品3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="category_id" class="col-sm-2 asterisk control-label">单品类型</label>

                                    <div class="col-sm-8">

                                        <select class="form-control single_select" style="width: 100%;" name="category_id" required="1" >
                                            <option></option>
                                            <option value="1" >类型1</option>
                                            <option value="2" >类型2</option>
                                            <option value="3" >类型3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="pay_types" class="col-sm-2 asterisk control-label">付款方式</label>

                                    <div class="col-sm-8">

                                        <select class="form-control single_select" style="width: 100%;" name="pay_types[]" multiple="multiple" required="1" >
                                            <option value="pay_arrived" >货到付款</option>
                                            <option value="paypal" >paypal支付</option>
                                        </select>
                                        <input type="hidden" name="pay_types[]" />
                                    </div>
                                </div>


                                <div class="form-group  ">

                                    <label for="main_image_file" class="col-sm-2 asterisk control-label">封面主图</label>

                                    <div class="col-sm-8">

                                        <input type="file" class="form-control main_image_file" name="main_image_file" required="1" />

                                    </div>
                                </div>

                                <div class="form-group  ">

                                    <label for="list_image_files" class="col-sm-2 control-label">轮播图(可选择多张)</label>

                                    <div class="col-sm-8">

                                        <input type="file" id="list_image_files" class="form-control list_image_files" name="list_image_files[]" multiple />

                                    </div>
                                </div>

                                <div class="form-group  ">

                                    <label for="main_video_file" class="col-sm-2 control-label">封面视频</label>

                                    <div class="col-sm-8">

                                        <input type="file" class="form-control main_video_file" name="main_video_file" />

                                    </div>
                                </div>


                                <div class="form-group  ">

                                    <label for="show_comment" class="col-sm-2  control-label">是否开启评论模块（默认开启）</label>

                                    <div class="col-sm-8">

                                        <input type="checkbox" name="show_comment" value="1" checked />

                                    </div>
                                </div>

                                <div class="form-group  ">

                                    <label for="detail_desc" class="col-sm-2 asterisk control-label">商品描述</label>

                                    <div class="col-sm-8">
                                        <textarea name="detail_desc"></textarea>

                                    </div>
                                </div>

                                <div class="form-group  ">

                                    <label for="size_desc" class="col-sm-2 asterisk control-label">商品规格</label>

                                    <div class="col-sm-8">
                                        <textarea name="size_desc"></textarea>

                                    </div>
                                </div>


                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <div class="col-md-2">
                                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            </div>

                            <div class="col-md-8">

                                <div class="btn-group pull-right">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>



                                <div class="btn-group pull-left">
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </div>


                        <!-- /.box-footer -->
                    </form>
                </div>

            </div></div>

    </section>

@endsection


@section('script')

    <script>
        $(function () {

            $(".main_image_file").fileinput({
                "overwriteInitial": true,
                "initialPreviewAsData": true,
                "browseLabel": "\u6d4f\u89c8",
                "cancelLabel": "\u53d6\u6d88",
                "showRemove": false,
                "showUpload": false,
                "showCancel": false,
                "dropZoneEnabled": false,
                {{--"uploadUrl": '/admin/upload',--}}
                {{--"uploadExtraData": {--}}
                    {{--'_token': '{{csrf_token()}}',--}}
                    {{--'_method': 'post'--}}
                {{--},--}}

                {{--"deleteUrl": "/admin/upload/1",--}}
                {{--"deleteExtraData": {--}}
                    {{--"_token": "{{csrf_token()}}",--}}
                    {{--"_method": "delete"--}}
                {{--},--}}
                "fileActionSettings": {"showRemove": true, "showDrag": false},
                "msgPlaceholder": "请选择图片",
                "allowedFileTypes": ["image"]
            });

            // $('.main_image_url').on('fileremoved', function(event, id, index) {
            //     console.log('id = ' + id + ', index = ' + index);
            // });

            $("#list_image_files").fileinput({
                "overwriteInitial": false,
                "initialPreviewAsData": true,
                "browseLabel": "\u6d4f\u89c8",
                "cancelLabel": "\u53d6\u6d88",
                "showRemove": false,
                "showUpload": false,
                "showCancel": false,
                "dropZoneEnabled": true,
                {{--"uploadUrl": '/admin/upload',--}}
                {{--"uploadExtraData": {--}}
                    {{--'_token': '{{csrf_token()}}',--}}
                    {{--'_method': 'post'--}}
                {{--},--}}
                {{--"deleteUrl": "/admin/upload/null",--}}
                {{--"deleteExtraData": {--}}
                    {{--"_token": "{{csrf_token()}}",--}}
                    {{--"_method": "delete"--}}
                {{--},--}}
                "fileActionSettings": {"showRemove": true, "showDrag": false},
                "msgPlaceholder": "\u9009\u62e9\u56fe\u7247",
                "allowedFileTypes": ["image"]
            });

            $('#list_image_urls').on('fileselectnone', function(event) {
                console.log("Huh! No files were selected.");
                return false;
            });

            $(".main_video_file").fileinput({
                "overwriteInitial": false,
                "initialPreviewAsData": true,
                "browseLabel": "\u6d4f\u89c8",
                "cancelLabel": "\u53d6\u6d88",
                "showRemove": false,
                "showUpload": false,
                "showCancel": false,
                "dropZoneEnabled": false,
                // "uploadUrl": '/admin/upload',
                        {{--"uploadExtraData": {--}}
                        {{--'_token': '{{csrf_token()}}',--}}
                        {{--'_method': 'post'--}}
                        {{--},--}}
                        {{--"deleteUrl": "/admin/upload/null",--}}
                        {{--"deleteExtraData": {--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--"_method": "delete"--}}
                        {{--},--}}
                "fileActionSettings": {"showRemove": true, "showDrag": false},
                "msgPlaceholder": "选择视频文件",
                "allowedFileTypes": ["video"]
            });

            // $('.main_image_url').on('fileselect', function(event, numFiles, label) {
            //     console.log("fileselect");
            //     $('.main_image_url').fileinput('upload');
            // })
            //
            // $('.main_image_url').on('fileuploaded', function(event, previewId, index, fileId) {
            //     console.log('File uploaded', previewId, index, fileId);
            // });

            $(".single_select").select2({"allowClear": true, "placeholder": {"id": "", "text": "请选择"}});

            $('.after-submit').iCheck({checkboxClass: 'icheckbox_minimal-blue'}).on('ifChecked', function () {
                $('.after-submit').not(this).iCheck('uncheck');
            });
            $('.container-refresh').off('click').on('click', function () {
                $.admin.reload();
                $.admin.toastr.success('刷新成功 !', '', {positionClass: "toast-top-center"});
            });

            $("[name='show_comment']").bootstrapSwitch({
                onText : '开',
                offText : '关',
                onSwitchChange: function (event, state) {
                    console.log(state);
                    if (state == true) {
                        $(this).val("1");
                        console.log($(this).val());
                    } else {
                        $(this).val("0");
                    }
                }
            });

            //编辑器
            KindEditor.create('textarea[name="detail_desc"]',{
                width : '100%',   //宽度
                height : '320px',   //高度
                resizeType : '0',   //禁止拖动
                allowFileManager : true,   //允许对上传图片进行管理
                uploadJson :   '/yxx/kindeditor/upload', //文件上传地址
                fileManagerJson : '/yxx/kindeditor/manager',   //文件管理地址
                deleteUrl  : '/yxx/kindeditor/delete', //文件删除地址
                //urlType : 'domain',   //带域名的路径
                extraFileUploadParams: {
                    '_token':"{{csrf_token()}}"
                },
                formatUploadUrl: true,   //自动格式化上传后的URL
                autoHeightMode: false,   //开启自动高度模式
                afterBlur: function () { this.sync(); }   //同步编辑器数据
            });

            KindEditor.create('textarea[name="size_desc"]',{
                width : '100%',   //宽度
                height : '320px',   //高度
                resizeType : '0',   //禁止拖动
                allowFileManager : true,   //允许对上传图片进行管理
                uploadJson :   '/yxx/kindeditor/upload', //文件上传地址
                fileManagerJson : '/yxx/kindeditor/manager',   //文件管理地址
                deleteUrl  : '/yxx/kindeditor/delete', //文件删除地址
                //urlType : 'domain',   //带域名的路径
                extraFileUploadParams: {
                    '_token':"{{csrf_token()}}"
                },
                formatUploadUrl: true,   //自动格式化上传后的URL
                autoHeightMode: false,   //开启自动高度模式
                afterBlur: function () { this.sync(); }   //同步编辑器数据
            });
        });
    </script>

@endsection
