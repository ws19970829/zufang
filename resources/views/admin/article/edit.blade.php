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
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 修改文章
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>

    @include('admin.public.msg')

    <article class="page-container">
        <form class="form form-horizontal" id="form-article-add" action="{{ route('admin.article.update',['id'=>$article->id,'url'=>$url_query]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$article->title}}" placeholder="" name="title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="cid" class="select">
                    @foreach($cateData as $item)
                        <option value="{{ $item['id'] }}"
                        @if($article->cid == $item['id']) selected @endif
                        >{{ $item['html'] }}{{ $item['cname'] }}</option>
                    @endforeach
				</select>
				</span></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="desn" cols="" rows=""  value="{{$article->desn}}" class="textarea" placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">封面图：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="pic" id="pic" value="{{ $article->pic }}">
                        <div class="imgbox">
                            <img src="{{ $article->pic }}" style="width: 100px; padding-left:10px" id="showpic" >
                            <i class="Hui-iconfont " onclick="delimage( '{{ $article->pic }}','{{ $article->id }}' )"  >&#xe706;</i>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="body" name="body" value="{{ $article->body }}"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit">添加新文章</button>
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

        $("#form-article-add").validate({
            rules: {
                title: {
                    required: true
                },
                desn: {
                    required: true
                }
            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                form.submit();
            }
        });

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
            server: '{{ route('admin.article.upfile') }}',
            // 选择文件的按钮
            pick: '#filePicker',
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {_token: "{{ csrf_token() }}"},
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
            $('#pic').val(url);
            $('#showpic').attr('src', url);
            $('.imgbox').slideDown('slow');

        });
        function delimage(src,id){
//            alert('1');
            $.get('{{route('admin.article.delimg')}}',{id,src}).then(ret=>{
                $('#pic').val('');
                $('#showpic').attr('src','');
                $('.imgbox').slideUp('slow');
            })


        };

    </script>
@endsection
