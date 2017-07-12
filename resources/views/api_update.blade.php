@extends('layouts.app')
@inject('helper','App\ViewComposer\CollectionHelper')
@section('content')
    <script src="https://cdn.bootcss.com/ace/1.2.7/ace.js"></script>
    <script src="{{url('/js')}}/edit.js"></script>
    <div class="container">

        <form action="{{url('/api/update/'.$apiId)}}" method="POST">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">API 基本信息</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group" id="API-COLLECTION">
                        <span class="input-group-addon" id="basic-addon1">COLLECTION</span>
                        <select name="collection_id" class="form-control">
                            @foreach($helper->getAccessCollections() as $collection)
                                @if($collection['id'] == $collectionId)
                                    <option value="{{$collection['id']}}" selected>{{$collection['title']}}</option>
                                @else
                                    <option value="{{$collection['id']}}">{{$collection['title']}}</option>
                                @endif
                            @endforeach
                        </select>
                        {{--<input type="text" id="api-collection" name="api_collection" class="form-control" placeholder="API NAME" aria-describedby="basic-addon1" >--}}
                    </div>
                    <br>
                    <div class="input-group" id="API-NAME">
                        <span class="input-group-addon" id="basic-addon1">NAME</span>
                        <input type="text" id="api-name" name="api_name" class="form-control" placeholder="API NAME" aria-describedby="basic-addon1" value="{{$apiName}}">
                    </div>
                    <br>
                    <div class="input-group" id="API-URL">
                        <span class="input-group-addon" id="basic-addon1">URL</span>
                        <input type="text" id="api-url" class="form-control" aria-describedby="basic-addon1" name="api_url" value="{{$apiUrl}}">
                    </div>
                    <br>
                    <div class="input-group" id="API-METHOD">
                        <span class="input-group-addon" id="basic-addon1">METHOD</span>
                        <input type="text" id="api-method" class="form-control" aria-describedby="basic-addon1" name="api_method" value="{{$apiMethod}}">
                    </div>
                    <br>
                    <div class="input-group" id="API-DESCRIPTION">
                        <span class="input-group-addon" id="basic-addon1">DESCRIPTION</span>
                        <input type="text" id="api-description" class="form-control" placeholder="the description" name="api_description" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="panel panel-default" id="API-REQUEST-HEADERS">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="request-headers-on" type="checkbox" checked>&nbsp&nbspAPI 请求头部</h3>
                </div>
                <div class="panel-body">
                    <pre id="request-headers-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-REQUEST-PARAMS">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="request-params-on" type="checkbox" checked>&nbsp&nbspAPI 请求参数（QueryString）</h3>
                </div>
                <div class="panel-body">
                    <pre id="request-params-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-REQUEST-BODY">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="request-body-on" type="checkbox" checked>&nbsp&nbspAPI 请求体（Body）</h3>
                </div>
                <div class="panel-body">
                    <pre id="request-body-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-REQUEST-EXAMPLE">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="request-example-on" type="checkbox" checked>&nbsp&nbspAPI 请求示范</h3>
                </div>
                <div class="panel-body">
                    <pre id="request-example-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-RESPONSE-HEADERS">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="response-headers-on" type="checkbox" >&nbsp&nbspAPI 响应头</h3>
                </div>
                <div class="panel-body">
                    <pre id="response-headers-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-RESPONSE-BODY">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="response-body-on" type="checkbox" checked>&nbsp&nbspAPI 响应体</h3>
                </div>
                <div class="panel-body">
                    <pre id="response-body-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="panel panel-default" id="API-RESPONSE-EXAMPLE">
                <div class="panel-heading">
                    <h3 class="panel-title"><input id="response-example-on" type="checkbox" checked>&nbsp&nbspAPI 响应示范</h3>
                </div>
                <div class="panel-body">
                    <pre id="response-example-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                </div>
            </div>

            <div class="alert alert-info" id="warning" role="alert" style="margin-top:20px;display: none;">
                <strong id="validate-message">请检查您的输入</strong>
            </div>


            <input id="request-headers-input" name="request_headers" type="hidden" value="{{$requestHeaders}}">
            <input id="request-params-input" name="request_params" type="hidden" value="{{$requestParam}}">
            <input id="request-body-input" name="request_body" type="hidden" value="{{$requestBody}}">
            <input id="request-example-input" name="request_example" type="hidden" value="{{$requestExample}}">
            <input id="response-headers-input" name="response_headers" type="hidden" value="{{$responseHeaders}}">
            <input id="response-body-input" name="response_body" type="hidden" value="{{$responseBody}}">
            <input id="response-example-input" name="response_example" type="hidden" value="{{$responseExample}}">
            <button type="submit" class="btn btn-primary" onclick="checkBeforeSubmit()">确认修改</button>
        </form>

    </div>

    <!--实际存放内容的隐藏input-->

    <footer>
        <br>
        <br>
    </footer>

    <script>
        editors.forEach(function (value, index, array) {
            editor = ace.edit(value+'-editor');
            theme = "clouds";
            language = "json";

            editor.setTheme("ace/theme/" + theme);
            editor.session.setMode("ace/mode/" + language);
            editor.setFontSize(14);
            var input = document.getElementById(value+'-input').getAttribute("value");
            if (isJSON(input)) {
                input = JSON.parse(input);
                editor.setValue(JSON.stringify(input,null,'\t'));
            }
        });

    </script>

@endsection