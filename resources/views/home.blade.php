@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">我创建的项目</div>

                <div class="panel-body">
                    <a href="{{url('/collection/create')}}"><button class="btn btn-primary">+ 新建项目</button></a>
                    <div class="table-responsive" style="margin-top: 15px">
                    <table class="table table-striped task-table">
                        <thead>
                        <tr><th>名称</th><th style="text-align: right"><span style="margin-right: 90px">操作</span></th></tr>
                        </thead>
                        <tbody>
                        @foreach($createdCollections as $collection)
                        <tr>
                            <td class="table-text"><h4>{{$collection->title}}</h4></td>
                            <td style="text-align: right">
                                {{--<a href="{{url('/api/doc/'.$collection->id)}}"><button class="btn btn-primary">查看文档</button></a>--}}
                                {{--<button class="btn btn-primary">管理成员</button>--}}
                                {{--<a href="{{url('/collection/update')}}"><button class="btn btn-primary">修改项目信息</button></a>--}}
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default" ><a href="{{url('/api/doc/'.$collection->id)}}" style="color: black">查看</a></button>
                                    <button type="button" class="btn btn-default"><a href="{{url('/collection/update/'.$collection->id)}}" style="color: black">编辑</a></button>
                                    <button type="button" class="btn btn-default"><a href="{{url('/share/'.$collection->id)}}" style="color: black">管理成员</a></button>
                                    <button type="button" class="btn btn-danger"><a href="{{url('/collection/delete/'.$collection->id)}}" onclick="return confirmDel()" style="color: white">删除</a></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">我参与的项目</div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                        <tr><th>名称</th><th style="text-align: right"><span style="margin-right: 90px">操作</span></th></tr>
                        </thead>
                        <tbody>
                        @foreach($sharedCollections as $collection)
                            <tr>
                                <td class="table-text"><h4>{{$collection->title}}</h4></td>
                                <td style="text-align: right">
                                    {{--<a href="{{url('/api/doc/'.$collection->id)}}"><button class="btn btn-primary">查看文档</button></a>--}}
                                    {{--<button class="btn btn-primary">管理成员</button>--}}
                                    {{--<a href="{{url('/collection/update')}}"><button class="btn btn-primary">修改项目信息</button></a>--}}
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default" ><a href="{{url('/api/doc/'.$collection->id)}}" style="color: black">查看</a></button>
                                        <button type="button" class="btn btn-default"><a href="{{url('/collection/update/'.$collection->id)}}" style="color: black">编辑</a></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function confirmDel()
        {
            if(confirm("确定删除本项目？删除后该项目的所有文档都会被删除！"))
                return true;
            else
                return false;
        }
    </script>
@endsection
