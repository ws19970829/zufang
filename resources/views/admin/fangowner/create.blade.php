@extends('admin.public.main')

@section('css')
    <link rel="stylesheet" href="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.css">

    <style>
        #imgbox img {
            height: 100px;
            width: 100px;
            border-radius: 5px;
            margin: 5px;
        }
    </style>


@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房东管理
        <span class="c-gray en">&gt;</span> 添加房东信息
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>

    @include('admin.public.msg')

    <article class="page-container">
        <form class="form form-horizontal" id="form-article-add" action="{{ route('admin.fangowner.store') }}" method="post">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房东姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">* </span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="sex" type="radio" value="男" checked>男
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="sex" type="radio" value="女">女
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房东年龄：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="age">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>手机号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>身份证号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="card">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" name="email">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">个人信息图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="pic" id="pic">
                    <div id="imgbox">

                    </div>

                    </div>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit">添加房东信息</button>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')
{{--//富文本--}}
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/ueditor.all.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript" src="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.min.js"></script>

    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>

    <script>
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-article-add").validate({
            rules: {
                name: {
                    required: true
                },
                age:{
                    required: true,
                    digits:true,
                    min:1,
                    max:100
                },
                phone:{
                    required: true,
                    checkPhone:true,
                },
                card:{
                    required: true,
                    checkCard: true
                },
                address:{
                    required: true,
                },
                email:{
                    required: true,
                    email:true
                }
            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                form.submit();
            }
        });
        jQuery.validator.addMethod('checkPhone',function(value,element){
            var reg = /^1[3-9]\d{9}$/;
            return this.optional(element)|| (reg.test(value));
        },'您输入的不是一个合法的手机号');
        jQuery.validator.addMethod('checkCard',function(value,element){
            var card = value.replace(' ','');
            var len = card.length;
            var bool = len == 18 ? true:false;
            return this.optional(element)|| bool;
        },'您输入的不是一个合法的身份证信息');

        // 富文本
        var ue = UE.getEditor('body', {
            initialFrameHeight: 500
        });



        // 异步文件上传
        var uploader = WebUploader.create({
            // 自动上传
            auto: true,
            // swf文件路径
            swf: '{{ staticAdmin() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: {
               id: '#filePicker',
                //允许多图片上窜
                multiple:true
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {_token: "{{ csrf_token() }}",node:'fangowner'},
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
           let val =  $('#pic').val();
            $('#pic').val(val+ '#' +url);
            //显示图片
            var imgobj = $('<img>');
            imgobj.attr('src',url);
            $('#imgbox').append(imgobj);
        });
        function delimg(){
//            alert('1');
            $('#showpic').attr('src','');
            $('#delsrc').attr('hidden',true)
        };

    </script>
@endsection
