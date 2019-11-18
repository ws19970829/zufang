
@extends('admin.public.main')

@section('cnt')
@include('admin.public.msg')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <form>
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="st" value="{{ request()->get('st') }}">
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="et" value="{{ request()->get('et') }}">
            <input type="text" class="input-text"   value="{{ request()->get('ss') }}" style="width:250px" placeholder="输入搜索的内容" id="" name="ss">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="icon-search"></i>搜用户
            </button>
        </div>
    </form>

    <div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l">
        <a  class="btn btn-danger radius " onclick="delAll()">
            <i class="icon-trash"></i>批量删除
        </a>
    <a href="{{ route('admin.user.add') }}"  class="btn btn-primary radius"><i class="icon-plus"></i> 添加用户</a></span>
        <span class="r">共有数据：<strong>88</strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="100">用户名</th>
            <th width="40">性别</th>
            <th width="90">手机</th>
            <th width="150">邮箱</th>
            <th width="130">加入时间</th>
            <th width="100">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
        <tr class="text-c">
            <td><input type="checkbox" value="{{ $item->id }}" name="ids[]" ></td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->username }}</td>
            <td>{{$item->sex}}</td>
            <td>{{$item->phone}}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                @if($item->deleted_at)
                    <a onclick="changeUser(1,{{ $item->id }},this)" class="label label-warning radius" > 禁用</a>
                    @else
                    <a onclick="changeUser(0,{{$item->id }},this)" class="label label-success radius"> 激活</a>
                    @endif
            </td>
            <td>
                {!! $item->editBtn('admin.user.edit') !!}
                {!! $item->delBtn('admin.user.delete') !!}
            </td>
            {{--<td >--}}
                {{--<a class="label label-secondary radius"  href="{{ route('admin.user.edit',$item) }}"> 修改</a>--}}
                {{--<a class="label label-danger radius	 del"  data-href="{{ route('admin.user.delete',$item) }}">--}}
                    {{--删除--}}
                {{--</a>--}}
            {{--</td>--}}
        </tr>
            @endforeach
        </tbody>
    </table>
    <div >
        {{ $data->appends(request()->except('page'))->links()}}
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script>
        var   _token ="{{ csrf_token() }}";
        function changeUser(status,ids,obj){
            if(status==0){
                $.ajax({
                    url:"{{ route('admin.user.delall') }}",
                    type:'DELETE',
                    data:{
                        ids,
                        _token
                    }
                }).then(ret=>{
                       $(obj).removeClass('label-success').addClass('label-warning').html('禁用');
                })
            }else{
                $.ajax({
                url:"{{ route('admin.user.restore') }}",
                data:{
                    ids,
                }
            }).then(ret=>{
                $(obj).removeClass('label-warning').addClass('label-success').html('激活');
            })
            }
        };

            $('.del').click(function(){
                var url = $(this).attr('data-href');
                layer.confirm('您真的要删除吗？',{
                    btn:['确认删除','再想一下']
                },()=>{
                    $.ajax({
                        url,
                        type:'DELETE',
                        data:{ _token }
                    }).then(ret=>{
                        $(this).parents('tr').remove();
                        layer.msg(ret.msg,{icon:1,time:1000});
                    });
                });
                return false;
            });
            //全选删除

        function delAll(){
            console.log(1);
            var inputs = $('input[name="ids[]"]:checked');
            var ids = [];
            inputs.map((key,item)=>{
                ids.push($(item).val());
            });
            $.ajax({
                url:'{{ route("admin.user.delall") }}',
                type:'DELETE',
                data:{
                    ids,
                    _token
                }
            }).then(ret=>{
                inputs.map((key,item) =>{
                    $(item).parents('tr').remove();

                });
            });
        }

    </script>
@endsection

