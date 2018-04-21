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
            .left {
                display: none;
            }
        }
    </style>
    <div class="cont">
        <div class="layout">
            {{--<div class="col-md-2" >--}}
            <div class="left">
                <h3>导航</h3>
                <div class="list-group">
                    @foreach($dataDict as $dict)
                        <a href="#" class="list-group-item" onclick="showDict('{{$dict['id']}}')">{{$dict['name']}}</a>
                    @endforeach
                </div>
            </div>
            <div class="right">
                <div class="container">
                    <div class="page-header">
                        <h1>
                            {{$apiCollection->title}}
                            @if($access)
                            <a href="{{url('/api/data-dict/'.$apiCollection->id.'/create')}}"><button class="btn btn-success">+&nbsp添加新字典</button></a>
                            @endif
                        </h1>
                        <small>{{$apiCollection->description}}</small>
                    </div>
                </div>
                <div class="row" style="max-width: 100%">
                    <div class="container">
                        <div class="data-dict-div">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h4>在导航中选中一个字典以显示</h4>
                                </div>
                            </div>
                        </div>
                        @foreach($dataDict as $dict)
                            <div id="data-dict-{{$dict['id']}}" class="data-dict-div" style="display: none">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3><b>{{$dict['name']}}</b></h3>
                                            <small>{{$dict['description']}}</small>
                                        </div>
                                        <div class="col-md-4">
                                            @if($access)
                                            <a href="{{url('api/data-dict/'.$dict['id'].'/edit')}}" style="float: right; margin-right: 20px; margin-top: 10px;"><button class="btn btn-default">编辑</button></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="dict-table">
                                            <table class="table table-hover">
                                                <tr>
                                                    <th>字段名称(key)</th>
                                                    <th>字段类型</th>
                                                    <th>字段说明</th>
                                                </tr>
                                                @foreach($dict['body'] as $item)
                                                    <tr>
                                                        <td>{{$item->key}}</td>
                                                        <td>{{$item->type}}</td>
                                                        <td>{{$item->description}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <script>
                function showDict(id) {
                    var tables = document.getElementsByClassName('data-dict-div');
                    for (var i = 0; i < tables.length; i++) {
                        tables[i].style.display = 'none';
                    }
                    var dictTable = document.getElementById('data-dict-' + id);
                    dictTable.style.display = 'block';
                }
            </script>
@endsection