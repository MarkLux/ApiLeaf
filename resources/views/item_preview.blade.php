@extends('layouts.app')
@section('content')
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="{{url('/js')}}/preview.js"></script>
    <div class="container">
        <blockquote>
            <span style="font-size: 24px">{{$apiName}}</span>
            <p>{{$apiDescription}}</p>
        </blockquote>
            <p style="font-size: 16px"><span class="label label-info">{{$apiMethod}}</span>&nbsp {{$apiUrl}}</p>

        <br>
        <ul class="nav nav-tabs">
            <li id="request-1-tab" role="presentation" class="active"><a onclick="switchTab(1,'request')"><b>请求</b></a></li>
            <li id="response-1-tab" role="presentation"><a onclick="switchTab(1,'response')"><b>响应</b></a></li>
        </ul>

        <br>

        <div class="panel panel-default">

           <div class="panel-body" id="request-1">

               @if($requestParams != null)
               <h4>&nbsp QueryString</h4>
               <table class="table table-striped">
                   <thead>
                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                   </thead>
                   <tbody>
                   @foreach($requestParams as $param)
                   <tr><td>{{$param['param_key']}}</td><td>{{$param['param_type']}}</td><td>{{$param['param_description']}}</td></tr>
                   @endforeach
                   </tbody>
               </table>
               @endif

               @if($requestHeaders != null)
               <h4>&nbsp Headers</h4>
               <table class="table table-striped">
                   <thead>
                   <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                   </thead>
                   <tbody>
                   @foreach($requestHeaders as $header)
                       <tr><td>{{$header['header_key']}}</td><td>{{$header['header_type']}}</td><td>{{$header['header_description']}}</td></tr>
                   @endforeach
                   </tbody>
               </table>
                   @endif

                   @if($requestBody != null)
               <h4>&nbsp Body</h4>
               <table class="table table-striped">
                   <thead>
                   <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                   </thead>
                   <tbody>
                   @foreach($requestBody as $body)
                       <tr><td>{{$body['body_key']}}</td><td>{{$body['body_type']}}</td><td>{{$body['body_description']}}</td></tr>
                   @endforeach
                   </tbody>
               </table>
                   @endif

                <h4>&nbsp Example</h4>

                   @if($requestExample != null)
               <pre id="request-example-1" class="prettyprint lang-js" style="font-size: 14px">{{$requestExample}}</pre>
               <script>
                   var content = document.getElementById("request-example-1").innerHTML;
                   content = JSON.parse(content);
                   document.getElementById("request-example-1").innerHTML = JSON.stringify(content,null,'    ');
               </script>
                   @endif
           </div>

            <div class="panel-body" id="response-1" style="display: none;">

                @if($responseHeaders != null)

                <h4>&nbsp Headers</h4>
                <table class="table table-striped">
                    <thead>
                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                    </thead>
                    <tbody>
                    @foreach($responseHeaders as $header)
                        <tr><td>{{$header['header_key']}}</td><td>{{$header['header_type']}}</td><td>{{$header['header_description']}}</td></tr>
                    @endforeach
                    </tbody>
                </table>
                @endif

                @if($responseBody != null)

                <h4>&nbsp Body</h4>
                <table class="table table-striped">
                    <thead>
                    <tr><th>名称</th><th>类型</th><th>说明</th></tr>
                    </thead>
                    <tbody>
                    @foreach($responseBody as $body)
                        <tr><td>{{$body['body_key']}}</td><td>{{$body['body_type']}}</td><td>{{$body['body_description']}}</td></tr>
                    @endforeach
                    </tbody>
                </table>
                    @endif

                <h4>&nbsp Example</h4>
                <pre id="response-example-1" class="prettyprint lang-js" style="font-size: 14px">{{$responseExample}}</pre>
                <script>
                    var content = document.getElementById("response-example-1").innerHTML;
                    content = JSON.parse(content);
                    document.getElementById("response-example-1").innerHTML = JSON.stringify(content,null,'    ');
                </script>
            </div>

        </div>

    </div>
@endsection