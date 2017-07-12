@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">我创建的项目</div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                        <tr><th>名称</th><th>操作</th></tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="table-text"><h4>NUEDC</h4></td>
                            <td>
                                <button class="btn btn-primary">查看文档</button>
                                <button class="btn btn-primary">管理成员</button>
                                <button class="btn btn-primary">修改项目信息</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">我参与的项目</div>

                <div class="panel-body">

                </div>
            </div>

        </div>
    </div>
@endsection
