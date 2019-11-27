
@extends('admin.public.main')
<title>资讯列表</title>
    @section('css')

        @endsection
@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 文章管理 <span class="c-gray en">&gt;</span> 文章列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
		</span> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;">
            <input type="text" name="kw"  style="width:250px" class="input-text" id="kw">
            <button name="" id="" class="btn btn-success" type="button" onclick="searchBtn()">
                <i class="Hui-iconfont" >&#xe665;</i> 搜索文章
            </button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius delall">
                    <i class="Hui-iconfont">&#xe6e2;</i>
                    批量删除
                </a>
                <a class="btn btn-primary radius" data-title="添加文章"   href="{{ route('admin.fangowner.create')}}">
                    <i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
                 <a class="btn btn-success radius" data-title="导出房东excel"   href="{{ route('admin.fangowner.export')}}">
                    <i class="Hui-iconfont">&#xe600;</i> 导出房东excel</a>
                <a  style="display: @if($isshow) inline-block; @else none;@endif"    class="btn btn-success radius" data-title="导出房东excel"   href="/uploads/fangownerexcel/fangowner.xlsx">
                    <i class="Hui-iconfont">&#xe600;</i> 下载</a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="40">ID</th>
                    <th width="40">房东姓名</th>
                    <th width="100">身份证号</th>
                    <th width="40">房东性别</th>
                    <th width="100">房东年龄</th>
                    <th width="100">联系号码</th>
                    <th width="100">家庭住址</th>
                    <th width="100">邮箱</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
             <tbody>
             @foreach($data as $item)
                 <tr>
                     <td>{!! $item->checkbox() !!}</td>
                     <td>{{$item->id}}</td>
                     <td>{{$item->name}}</td>
                     <td>{{$item->card}}</td>
                     <td>{{$item->sex}}</td>
                     <td>{{$item->age}}</td>
                     <td>{{$item->phone}}</td>
                     <td>{{$item->address}}</td>
                     <td>{{$item->email}}</td>
                     <td>
                         {!! $item->showBtn('admin.fangowner.show') !!}
                     {!! $item->editBtn('admin.fangowner.edit') !!}
                         {!! $item->delBtn('admin.fangowner.destroy') !!}
                     </td>
                 </tr>
                 @endforeach
             </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script>
        $('.showbtn').click(function(){
            let url=$(this).attr('href');
            $.get(url).then(({status,msg,data})=>{
              if(status==0){
                  let content='';
                  data.forEach(item=>{
                    content +=`<img src="${item}" style="width:150px;" />&nbsp;`
                  });
                  layer.open({
                      type:1,
                      area:['600px','300px'],
                      content
                  });
              }
            })
            return false;
        })
        $('.delall').click(function(){
            var inputs = $('input[name="ids[]"]:checked');
            var ids = [];
            inputs.map((key,item)=>{
                ids.push($(item).val())
            });
//            alert(ids);
            $.ajax({
                url: "{{ route('admin.article.delall') }}",
                type:'delete',
               data: {
                    ids,
                   _token:'{{ csrf_token() }}'
               }
            }).then(ret=>{
                inputs.map((key,item)=>{
                    $(item).parents('tr').remove();
                })
            })
        });
        $('.table-sort').on('click','.del',function(){
            let url = $(this).attr('href');
//            alert(url);
            fetch (url,{
                method:'delete',
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}',
                    'content-type':'application/json'
                },
//                body:JSON.stringify({ age:1 }) 可以传数组
            }).then(res=>{
                return res.json();
            }).then(()=>{
               layer.confirm('您真的要删除吗？',{
               btn:['确认删除','再想一下']
           }).then(ret=>{
               layer.msg(ret.msg,{icon:1,time:1000},()=>{
                   $(this).parents('tr').remove();
               });
           });
            });
            return false;
        });
      const datatable=  $('.table-sort').dataTable({
           //页码修改
            lengthMenu:[10,20,30,50,100],
            //指定不排序
            columnDefs:[
                {targets:[0,3],orderable:false}
            ],
          //指定谁可以排序
            order:[[{{request()->get('field')?? 1 }},'{{request()->get('order')??"desc"}}']],
            //从第几条显示
           displayStart: {{ request()->get('start')?? 0 }},
            //开启服务端分页
            serverSide:true,
            //ajax配置
            ajax:{
                url:'{{ route("admin.article.index") }}',
                type:'GET',
                data:function(ret){
                    ret.kw = $.trim($('#kw').val())
                }
            },
            columns:[
                {data:'checkBox',className:'text-c'},
                {data:'id',className:'text-c'},
                {data:'title'},
                {data:'cate.cname'},
                {data:'updated_at',className:'text-c'},
               {data:'actionBtn',className:'text-c'}
            ],
        });
        function searchBtn(){
            datatable.api().ajax.reload();
        }

    </script>

@endsection


