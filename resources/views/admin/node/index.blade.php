
@extends('admin.public.main')

@section('cnt')
@include('admin.public.msg')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限中心 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <form>
        <div class="text-c">
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
    <a href="{{ route('admin.node.create') }}"  class="btn btn-primary radius"><i class="icon-plus"></i>添加权限</a></span>
        <span class="r">共有数据：<strong>88</strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="200">节点名称</th>
            <th>路由别名</th>
            <th>是否菜单</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
        <tr class="text-c" >
            <td><input type="checkbox" value="{{ $item['id'] }}" name="ids[]" ></td>
            <td>{{ $item['id'] }}</td>
            <td style="padding-left:{{ $item['level']*20 }}px">{{ $item['name'] }}</td>
            <td>{{$item['route_name']}}</td>
            <td>
                @if($item['is_menu'] == '0')
                    <span class="label label-warning radius">否</span>
                @else
                    <span class="label label-success radius">是</span>
                @endif
            </td>

            <td >
                <a class="label label-success radius"  href="{{ route('admin.node.edit',$item) }}"> 修改</a>
                <a class="label label-danger radius del"  data-href="{{ route('admin.node.destroy',$item) }}">
                    删除
                </a>
                {{--{!! editBtn('admin.node.edit') !!}--}}
                {{--{!! delBtn('admin.node.destroy') !!}--}}
            </td>

        </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/laypage/1.2/laypage.js"></script>

@endsection

