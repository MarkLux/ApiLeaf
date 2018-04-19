@extends('layouts.app')
@section('content')
    {{--<script src="https://cdn.bootcss.com/prettify/r298/run_prettify.min.js"></script>--}}
    {{--<link href="https://cdn.bootcss.com/prettify/r298/prettify.min.css" rel="stylesheet">--}}
    <script src="{{url('/js')}}/preview.js"></script>
    <style>
        .layout {
            display: flex;

        }
        .left {
            max-height: 100vh;
            flex: 0 0 200px;
            width: 30%;
            overflow: scroll;
            margin-left: 40px;
            padding-right: 20px;
        }
        .right {
            flex: auto;
            max-height: 100vh;
            overflow: scroll;
            padding-right: 20px;
        }
        @media screen and (max-width: 768px) {
            .left{
                display:none;
            }
        }
    </style>
    <div class="cont">
        <div class="layout">
            {{--<div class="col-md-2" >--}}
            <div class="left">
                <h3>列表</h3>
                <div class="list-group">
                    @foreach($apiCodes as $code)
                        <a href="#{{$code['code']}}" class="list-group-item"><b>{{$code['code']}}</b></a>
                    @endforeach
                </div>
            </div>
            <div class="right">
                <div class="container">
                    <div class="page-header">
                        <h1>
                            {{$apiCollection->title}}
                        </h1>
                        <small>{{$apiCollection->description}}</small>
                    </div>
                </div>
                <div class="row" style="max-width: 100%">
                    <div class="container">
                        <div class="panel panel-danger">
                            <div class="panel-heading"><h4>状态码表 &nbsp&nbsp</h4></div>
                            <div class="panel-body">
                                    <button class="btn btn-primary" onclick="addRow()">+新增</button>
                                    &nbsp
                                    &nbsp
                                    <button class="btn btn-success" onclick="onSubmitClick()"><span class="glyphicon glyphicon-ok"></span>&nbsp完成修改</button>
                                <form id="api-code-form" action="{{url('/api/codes/'.$apiCollection->id.'/update')}}" method="POST">
                                    <input id="updated-codes" name="api_codes" type="text" value="" hidden="true"/>
                                </form>
                                <br>
                                <br>
                                @if(isset($info))
                                <div id="success_info" class="alert alert-success" role="alert">
                                    修改成功！
                                </div>
                                @endif
                                <div id="error_info" class="alert alert-danger" role="alert" style="display: none">
                                    输入有误，请检查状态码是否为数字类型并填写所有空白！
                                </div>
                                <table class="table" id="api-code-table">
                                    <tr>
                                        <th>状态码</th><th>说明</th>
                                        <th style="text-align: center">操作</th>
                                    </tr>
                                    @foreach($apiCodes as $code)
                                        <tr id="tr-{{$code['code']}}" class="api-code">
                                            <td>
                                                <input type="text" name="code" class="form-control" value="{{$code['code']}}"/>
                                            </td>
                                            <td>
                                                <input type="text" name="description" class="form-control" value="{{$code['description']}}" />
                                            </td>
                                            <td style="text-align: center">
                                                <button class="btn btn-danger" onclick="delRow('{{'tr-'.$code['code']}}')"><span class="glyphicon glyphicon-trash"></span>删除</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var newRowId = 0;
                function delRow(id)
                {
                    document.getElementById(id).remove();
                }

                function addRow() {
                    newRowId++;
                    var table = document.getElementById("api-code-table");
                    var newRow = table.insertRow(1);
                    newRow.id = 'newRow-' + newRowId;
                    newRow.setAttribute('class', 'api-code');
                    var newCodeCell = newRow.insertCell();
                    var newDescriptionCell = newRow.insertCell();
                    var newDeleteButton = newRow.insertCell();
                    newCodeCell.innerHTML = '<input type="text" class="form-control" name="code" />';
                    newDescriptionCell.innerHTML = '<input type="text" class="form-control" name="description"  />';
                    newDeleteButton.innerHTML = '<button class="btn btn-danger" onclick="delRow(\''+newRow.id+'\')"><span class="glyphicon glyphicon-trash"></span>删除</button>';
                    newDeleteButton.style.setProperty('text-align', 'center');
                }

                function onSubmitClick() {
                    // 组装数据，然后请求
                    var codes = [];
                    var rows = document.getElementsByClassName("api-code");
                    for (var i = 0; i< rows.length; i++) {
                        var newCode = {};
                        var inputs = rows[i].getElementsByTagName('input');
                        for (var j = 0; j< inputs.length; j++) {
                            if (inputs[j].name == "code") {
                                newCode.code = inputs[j].value;
                                if (isNaN(newCode.code)) {
                                    showErrorInfo();
                                    return false;
                                }
                            }else if (inputs[j].name == "description") {
                                newCode.description = inputs[j].value;
                                if (newCode.description == null || newCode.description == '') {
                                    showErrorInfo();
                                    return false;
                                }
                            }
                        }
                        codes.push(newCode);
                    }
                    document.getElementById("updated-codes").value = JSON.stringify(codes);
                    document.getElementById("api-code-form").submit();
                    return true;
                }

                function showErrorInfo() {
                    document.getElementById('success_info').style.display = 'none';
                    document.getElementById('error_info').style.display = 'block';
                }
            </script>
        </div>
    </div>
@endsection