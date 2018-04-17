@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{$collection->title}}</h3></div>

                <div class="panel-body">
                    <h4>当前成员列表</h4>
                    <div class="table-responsive" style="margin-top: 15px">
                        <table class="table table-striped task-table">
                            <thead>
                            <tr><th>用户名</th><th>邮箱</th><th style="text-align: center"><span></span></th></tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td class="table-text"><b>{{$member->name}}</b></td>
                                    <td class="table-text">{{$member->email}}</td>
                                    <td style="text-align: center;">
                                        @if(!isset($member->is_owner))
                                            <div class="btn-group" role="group" aria-label="...">
                                                <button type="button" class="btn btn-danger"><a href="{{url('/share/'.$collection->id.'/member/delete?member_id='.$member->id)}}" onclick="return confirmDel()" style="color: white">删除</a></button>
                                            </div>
                                        @else
                                            <div class="btn-group" role="group" aria-label="...">
                                                <button type="button" class="btn btn-info">创建者</button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            <tr>
                                <form action="{{url('/share/'.$collection->id.'/member/add')}}" method="POST">
                                <td>
                                    <b>输入新成员邮箱：</b>
                                </td>
                                <td>

                                    <input type="email" name="new_member_email" class="form-control" />
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn btn-primary" type="submit">+增加成员</button>
                                </td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                        @if(!empty($error))
                            <div class="alert alert-warning" role="alert">
                                {{$error['message']}}
                            </div>
                        @endif
                        @if(!empty($info))
                            <div class="alert alert-success" role="alert">
                                {{$info['message']}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDel()
        {
            if(confirm("确定删除该成员?"))
                return true;
            else
                return false;
        }
    </script>
@endsection