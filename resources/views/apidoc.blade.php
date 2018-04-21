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
    @include('data_dict_modal')
    <div class="cont">
        <div class="layout">
    {{--<div class="col-md-2" >--}}
            <div class="left">
        <h3>导航</h3>
        @foreach($tags as $tag)
            <h4>{{$tag->api_tag === null?'未分类':$tag->api_tag}}</h4>
            <div class="list-group">
                @foreach($apiInfos as $item)
                    @if($item->api_tag == $tag->api_tag)
                        <a href="{{'#header-'.$item->id}}" class="list-group-item">{{$item->api_name}}</a>
                    @endif
                @endforeach
            </div>
        @endforeach

    </div>
    <div class="right">
        <div class="container">
            <div class="page-header">
                <h1>
                    {{$collectionInfo->title}}
                    @if(!isset($collectionInfo->isFavor))
                        <a href="{{url('/api/doc/'.$collectionInfo->id.'/favor')}}"><button class="btn btn-warning"><span class="glyphicon glyphicon-star-empty"></span>收藏</button></a>
                    @else
                        <a href="{{url('/api/doc/'.$collectionInfo->id.'/unfavor')}}"><button class="btn btn-warning"><span class="glyphicon glyphicon-star"></span>已收藏</button></a>
                    @endif
                </h1>
                <small>{{$collectionInfo->description}}</small>
            </div>
        </div>
        <div class="container">
            <div class="btn-group">
                <button type="button"class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="tag_select">组别</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @foreach($tags as $tag)
                        <li><a onclick="switchValue('tag_select','{{$tag->api_tag === null?'未分类':$tag->api_tag}}')">{{$tag->api_tag === null?'未分类':$tag->api_tag}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="order_by_select">排序依据</span><span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a onclick="switchValue('order_by_select','创建时间')">创建时间</a></li>
                    <li><a onclick="switchValue('order_by_select','更新时间')">更新时间</a></li>
                    <li><a onclick="switchValue('order_by_select','拼音顺序')">拼音顺序</a></li>
                    <li><a onclick="switchValue('order_by_select','默认')">默认</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button"  class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="order_select">顺序</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a onclick="switchValue('order_select','升序')">升序</a></li>
                    <li><a onclick="switchValue('order_select','降序')">降序</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-default" onclick="jump()">筛选</button>
        </div>
        <br>
        <div class="row" style="max-width: 100%">


            <div class="container">



                @foreach($apiInfos as $item)
                <div class="container" style="max-width: 100%">
                    <blockquote>
                        <h3 id="{{'header-'.$item->id}}"><span style="font-size: 24px">[{{$item->api_tag}}] {{$item->api_name}}</span></h3>
                        <p>{{$item->api_description}}</p>
                    </blockquote>
                    <button class="btn btn-default"><a href="#">回顶部</a></button>
                    <p style="font-size: 16px"><span class="label label-info">{{$item->api_method}}</span>&nbsp {{$item->api_url}}</p>
                    @if($editMenuOn)
                        <div class="btn-group" role="group" aria-label="..." style="margin-bottom: 15px">
                            <button type="button" class="btn btn-default"><a href="{{url('/api/update/'.$item->id)}}" style="color:black;">编辑</a></button>
                            <button type="button" class="btn btn-danger"><a href="{{url('/api/delete/'.$item->id)}}" onclick="return confirmDel()" style="color: white">删除</a></button>
                        </div>
                    @endif
                    <ul class="nav nav-tabs">
                        <li id="{{'request-'.$item->id.'-tab'}}" role="presentation" class="active"><a onclick="{{"switchTab(".$item->id.",'request')"}}"><b>请求</b></a></li>
                        <li id="{{'response-'.$item->id.'-tab'}}" role="presentation"><a onclick="{{"switchTab(".$item->id.",'response')"}}"><b>响应</b></a></li>
                    </ul>

                    <br>

                    <div class="panel panel-default">

                        <div class="panel-body" id="{{'request-'.$item->id}}">

                            @if($item->request_params != null)
                                <h4>&nbsp QueryString</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->request_params as $param)
                                        <tr><td>{{$param['param_key']}}</td><td>{{$param['param_type']}}</td><td>{{$param['param_description']}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if($item->request_headers != null)
                                <h4>&nbsp Headers</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->request_headers as $header)
                                        <tr><td>{{$header['header_key']}}</td><td>{{$header['header_type']}}</td><td>{{$header['header_description']}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if($item->request_body != null)
                                <h4>&nbsp Body</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->request_body as $body)
                                        <tr><td>{{$body['body_key']}}</td><td>{{$body['body_type']}}</td><td>{{$body['body_description']}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif



                            @if($item->request_example != 'null')
                                    <h4>&nbsp Example</h4>
                                <pre id="{{'request-example-'.$item->id}}" class="prettyprint lang-js" style="font-size: 14px">{{$item->request_example}}</pre>
                                <script>
                                    var content = document.getElementById("{{'request-example-'.$item->id}}").innerHTML;
                                    content = JSON.parse(content);
                                    document.getElementById("{{'request-example-'.$item->id}}").innerHTML = JSON.stringify(content,null,'    ');
                                </script>
                            @endif
                        </div>

                        <div class="panel-body" id="{{'response-'.$item->id}}" style="display: none;">

                            @if($item->response_headers != null)

                                <h4>&nbsp Headers</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->response_headers as $header)
                                        <tr><td>{{$header['header_key']}}</td><td>{{$header['header_type']}}</td><td>{{$header['header_description']}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if($item->response_body != null)

                                <h4>&nbsp Body</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr><th>名称</th><th>类型</th><th style="text-align: center">说明</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->response_body as $body)
                                        <tr>
                                            <td class="{{ 'key-cell-'.$item->id }}">{{$body['body_key']}}</td><td>{{$body['body_type']}}</td>
                                            @if($body['body_description'] != '')
                                            <td style="text-align: center">{{$body['body_description']}}</td>
                                            @elseif(strpos($body['body_key'], '.'))
                                            <td style="text-align: center">
                                                    <a title="尝试在数据字典中匹配">
                                                <button type="button" class="btn btn-warning" onclick="onSearchClick('{{$collectionInfo->id}}','{{$item->id}}','{{$body['body_key']}}')">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                                    </a>
                                            </td>
                                            @else
                                                <td style="text-align: center">开发者偷懒了，暂无说明→_→</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                                @if($item->response_example != 'null')
                            <h4>&nbsp Example</h4>
                            <pre id="{{'response-example-'.$item->id}}" class="prettyprint lang-js" style="font-size: 14px">{{$item->response_example}}</pre>
                            <script>
                                var content = document.getElementById("{{'response-example-'.$item->id}}").innerHTML;
                                content = JSON.parse(content);
                                document.getElementById("{{'response-example-'.$item->id}}").innerHTML = JSON.stringify(content,null,'    ');
                            </script>
                                    @endif
                        </div>

                    </div>
                    <br>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function confirmDel()
        {
            if (confirm("确定要删除此文档？"))
                return true;
            else
                return false;
        }
    </script>
        </div>
    </div>
@endsection