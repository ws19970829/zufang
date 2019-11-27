@extends('admin.public.main')

@section('css')
    <link rel="stylesheet" href="{{ staticAdmin() }}lib/webuploader/0.1.5/webuploader.css">
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 接口账号管理
        <span class="c-gray en">&gt;</span> 添加接口账号
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container" id="appform">
        <form class="form form-horizontal" id="form-article-add">

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 260px;" v-model="frmData.username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 260px;" v-model="frmData.password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>token：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 260px;" v-model="frmData.token">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">请求次数：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" style="width: 260px;" v-model="frmData.click">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="button" @click="dopost">添加接口账号</button>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')
    <!-- 引入vue -->
    <script src="/js/vue.js"></script>
    <script>
        new Vue({
            el: '#appform',
            // 初始化数据
            data: {
                // 表单数据
                frmData: {
                    username: '',
                    password: '',
                    token: '',
                    click: 20000,
                    _token:"{{ csrf_token() }}"
                }
            },
            methods:{
              dopost(){
                  if(this.frmData.username && this.frmData.password && this.frmData.token){
                      var url = '{{ route("admin.apiuser.store") }}';
                      $.post(url,this.frmData).then(ret=>{
                        if(ret.status==0){
                            layer.msg(ret.msg,{icon:1,timeout:1000},()=>{
                                location.href = ret.url;
                            })
                        }else{
                            layer.msg(ret.msg,{icon:2,timeout:1000})
                        }
                      });
                  }else{
                      layer.msg('兄台填一下才能提交哦',{icon:2,timeout:1000})
                  }

              }
            }
        });


    </script>
@endsection
