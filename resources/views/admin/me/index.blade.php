@extends('admin.public.main')

@section('cnt')
@include('admin.public.msg')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<article class="page-container">
    <form action="{{ route('admin.me.update',['id'=>$data->id]) }}" method="post" class="form form-horizontal" id="form-member-add">

        @csrf
        @method('PUT')
        <div class="row cl" >
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" name="username" value="{{ $data->username }} " disabled="disabled">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>实名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $data->truename }}" placeholder=""  name="truename" >
            </div>
        </div>
        {{--<div class="row cl">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9 skin-minimal">--}}
                {{--<div class="radio-box">--}}
                    {{--<input name="sex" type="radio" value="男"  checked>--}}
                    {{--<label for="sex-1">男</label>--}}
                    {{--</div>--}}
                {{--<div class="radio-box">--}}
                    {{--<input type="radio" value="女" name="sex" >--}}
                    {{--<label for="sex-2">女</label>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="sex" type="radio" value="先生"  @if($data->sex=='先生')checked @endif>
                    <label for="sex-1">先生</label>
                </div>
                <div class="radio-box">
                    <input type="radio" value="女士" name="sex"  @if($data->sex=='女士')checked @endif>
                    <label for="sex-2">女士</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $data->email }}" placeholder=""  name="email">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $data->phone }}" placeholder=""  name="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder=""  name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder=""  name="password_confirmation">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@endsection


