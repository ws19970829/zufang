
@extends('admin.public.main')

@section('cnt')
@include('admin.public.msg')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>房源属性管理<span class="c-gray en">&gt;</span>房源属性列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20" >
    <form>
        <div class="text-c">
            <input type="text" class="input-text"   value="{{ request()->get('ss') }}" style="width:250px" placeholder="输入搜索的内容" id="" name="ss">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="icon-search"></i>搜索
            </button>
        </div>
    </form>
    <div id="ws">
        <div id="app">
            <div class="cl pd-5 bg-1 bk-gray mt-20" >
    <span class="l">
        <a  class="btn btn-danger radius " onclick="delAll()">
            <i class="icon-trash"></i>批量删除
        </a>
    <a href="{{ route('admin.fangattr.create') }}"  class="btn btn-primary radius"><i class="icon-plus"></i>添加房源属性</a></span>
                <span class="r">共有数据：<strong>88</strong> 条</span>
            </div>
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="200">属性名称</th>
                    <th>图标</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items">
                    <td v-html="item.checkbox"></td>
                    <td v-text="item.id" class="iid"> </td>
                    <td :style="'padding-left:'+(item.level*10)+'px'">@{{ item.name }} </td>
                    <td>
                        <img :src="item.icon" style="width: 100px;" alt="">
                    </td>
                    <td v-html="item.actionBtn" ></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>


@endsection

@section('js')
    <script src="/js/vue.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        const app = new Vue({
            el:'#app',
            data:{
                items:[]
            },
            mounted(){
                $.get("{{route('admin.fangattr.index')}}").then(ret=>{
                    this.items = ret;
                })
            },

        })
    </script>
@endsection

