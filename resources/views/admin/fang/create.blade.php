@extends('admin.public.main')

@section('css')
    <link rel="stylesheet" href="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.css">
    <style>
        #imglist img{
            width:100px;
        }
    </style>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 添加房源
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>

    @include('admin.public.msg')

    <article class="page-container">
        <form class="form form-horizontal" id="form-article-add" action="{{ route('admin.fang.store') }}" method="post">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小区名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_xiaoqu">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_province" class="select" onchange="changecity(this,'fang_city')">
                            <option value="0">==选择省份==</option>
                            @foreach($pdata as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_city" id="fang_city" class="select" onchange="changecity(this,'fang_region')">
                            <option value="0">==选择市==</option>
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_region" class="select" id="fang_region">
                            <option value="0">==选择区==</option>
                        </select>
                    </span>
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" placeholder="房源详细地址" name="fang_addr">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源朝向：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_direction" class="select">
                            @foreach($arrdata['fang_direction']['sub'] as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" placeholder="房源面积" name="fang_build_area">
                    </span>
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" placeholder="使用面积" name="fang_using_area">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>建筑年代：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" placeholder="建筑年代" name="fang_year">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源租金：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" name="fang_rent">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源楼层：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 80px;">
                        <input type="text" class="select" placeholder="房源楼层" name="fang_floor">
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_shi" class="select">

                            @for($i=1;$i<=5;$i++)
                                <option value="{{$i}}"> {{$i}}室</option>
                            @endfor
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_ting" class="select">

                            @for($i=1;$i<=6;$i++)
                                <option value="{{ $i }}"> {{ $i }}厅</option>
                            @endfor
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_wei" class="select">
                            {{--<option value="区">几卫</option>--}}
                            @for($i=1;$i<=3;$i++)
                                <option value="{{$i}}"> {{$i}}卫</option>
                            @endfor
                        </select>

                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_rent_class" class="select">
                            <option value="区">租期方式</option>
                            @foreach($arrdata['fang_rent_class']['sub'] as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>配套设施：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    @foreach($arrdata['fang_config']['sub'] as $item)
                        <div class="check-box">
                            <label>
                                <input type="checkbox" value="{{ $item['id'] }}" name="fang_config[]">
                                {{ $item['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源区域：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_area" class="select">
                             @foreach($arrdata['fang_area']['sub'] as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>租金范围：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_rent_range" class="select">
                            @foreach($arrdata['fang_rent_range']['sub'] as $item)
                            <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                                @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>租期方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_rent_type" class="select">
                         @foreach($arrdata['fang_rent_type']['sub'] as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源状态：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="fang_status" type="radio" value="0" checked>
                            待租
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="fang_status" type="radio" value="1">
                            已租
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否推荐：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="0" checked>
                            不推荐
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="1">
                            推荐
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源房东：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_owner" class="select">
                               @foreach($fdata as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源小组：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_group" class="select">
                            @foreach($arrdata['fang_group']['sub'] as $item)
                                <option value="{{$item['id']}}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="fang_desn" class="textarea"></textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="fang_pic" id="pic">
                        <div id="imglist"></div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源详情：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="fang_body" name="fang_body"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit">添加新房源</button>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')
    <!-- 引入 ueditor js类库 -->
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/ueditor.all.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
    <!-- 引入webuploader插件 类库JS-->
    <script type="text/javascript" src="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.min.js"></script>
    <!-- 表单前端验证插件 jquery validate -->
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>

    <script>
      $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
      });

      function changecity(obj,selecter){

          let value = obj.value;
          $.get("{{route('admin.fang.city')}}",{pid:value}).then(
            ret=>{
//                ret.unshift({id:0,name:'==选择市=='});
                ret = [{id:0,name:'==选择市=='},...ret];
                let html = '';
                ret.forEach(item=>{
                    html += `<option value="${item.id}">${item.name}</option>`
                });
                $('#'+selecter).html(html);
            }
          )

      }

      //表单验证
      $("#form-article-add").validate({
        rules: {
          fang_name: {
            required: true
          },
          fang_desn: {
            required: true
          }
        },
        onkeyup: false,
        success: "valid",
        submitHandler: function (form) {
          form.submit();
        }
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
        pick: '#filePicker',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        // 表单传额外值
        formData: {
          _token: "{{ csrf_token() }}",
          node: 'fang'
        },
        // 上传表单名称
        fileVal: 'file'
      });
      // 回调方法监听
      uploader.on('uploadSuccess', function (file, {url}) {
          let val = $('#pic').val();
          $('#pic').val(val+'#'+url);
          let imgobj = $('<img/>');
          imgobj.attr('src',url);
          $('#imglist').append(imgobj);
      });
      // 富文本
      var ue = UE.getEditor('fang_body', {
        // 初始化高度
        initialFrameHeight: 500
      });
    </script>
@endsection
