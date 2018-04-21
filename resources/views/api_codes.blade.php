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
                            <div class="panel-heading">
                                <h4>
                                    状态码表
                                    @if($access)
                                        <a href="{{url('/api/codes/'.$apiCollection->id.'/edit')}}"><button class="btn btn-default">编辑</button></a>
                                    @endif
                                </h4>
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr><th>状态码</th><th>说明</th></tr>
                                    @foreach($apiCodes as $code)
                                        <tr><td><h5 id="{{$code['code']}}"><b>{{$code['code']}}</b></h5></td><td>{{$code['description']}}</td></tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection