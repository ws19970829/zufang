@extends('admin.public.main')

@section('css')
    <link rel="stylesheet" href="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.css">
    <style>
        .imgbox {
            width: 100px;
            height: 100px;
            margin-left: 100px;
            position: relative;
        }

        .imgbox img {
            height: 100%;
            width: 100%;
            border-radius: 5px;
        }

        .imgbox i {
            position: absolute;
            right: 5px;
            top: 2px;
            font-weight: bold;
            color: #cccccc;
            font-size: 25px;
            cursor: pointer;
        }
    </style>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性管理
        <span class="c-gray en">&gt;</span> 添加房源属性
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">

        {{-- 错误信息 --}}
        @include('admin.public.msg')

        <form action="{{route('admin.fangattr.store')  }} " method="post" class="form form-horizontal" id="form-node-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">顶级属性：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pid" class="select" id="pid">
					@foreach($data as $id=>$name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
				</select>
				</span></div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>属性名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('name') }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>字段名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('field_name') }}" class="input-text" name="field_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">图标：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="icon" id="pic">
                        <div class="imgbox">
                            <img src=""  id="showpic" >
                            <i class="Hui-iconfont " onclick="delimg()"  id="delsrc" hidden="true">&#xe706;</i>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加新房源">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    {{--//webupload js--}}
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
        $('#form-node-add').validate({
            rules:{
                name:{
                    required:true
                },
                field_name :{
                    fieldname:true,

                }
            },
            message:{
                name:{
                    required:'权限名称不能为空'
                }
            },
            onkeyup: false,
            // 成功时样式
            success: "valid",
            submitHandler:function (form) {
                form.submit();
            }
        })
        //自定义jqery-valiate验证器
        jQuery.validator.addMethod('fieldname',function(value,element){
            var bool = $('#pid').val() == 0 ? false : true;
            var reg = /[a-zA-Z_]+/;
            return bool || (reg.test(value));
        },'选择顶级属性请一定要填写对应的字段名称');


        // 异步文件上传
        var uploader = WebUploader.create({
            // 自动上传
            auto: true,
            // swf文件路径
            swf: '{{ staticAdmin() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: '#filePicker',
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                node : 'fangattr'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
            $('#pic').val(url);
            $('#showpic').attr('src', url);
            $('.imgbox').slideDown('slow');
            $('#delsrc').attr('hidden',false)
        });
        function delimg(){
//            alert('1');
            $('#showpic').attr('src','');
            $('#delsrc').attr('hidden',true);
            $('.imgbox').slideUp('slow');
        };

    </script>
@endsection
