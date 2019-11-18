@extends('admin.public.main')

@section('cnt')
    @include('admin.public.msg')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 权限修改<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<article class="page-container">
    <form action="{{ route('admin.user.update',['id'=>$data->id]) }}" method="post" class="form form-horizontal" id="form-member-add">

        @csrf
        @method('PUT')
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text"  placeholder=""  name="name" value="{{ $data->username }}">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="p2" value="" placeholder=""  name="password_confirmation">
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
@section('js')
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
    <script>
        $(function () {
            $('#checkbox-1').click(function () {
            if(!$(this).attr('checked')){
                $('#p1').val('');
                    $('#p2').val('');
            }
                    var passwd = $(this).attr('pass');
                    // passwd= encrypt(passwd);
                    // alert(passwd);
                    $('#p1').val(passwd);
                    $('#p2').val(passwd);  
            }

            // if(!$(this).val()){
            //     $('#checkbox-1').click(function () {
            //         // alert(passwd);
            //        
            // }
           



            )
        })

    </script>


    @endsection

