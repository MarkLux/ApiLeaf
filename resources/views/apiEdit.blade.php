@extends('layouts.app')

@section('content')
    <script src="https://cdn.bootcss.com/ace/1.2.7/ace.js"></script>
    <br>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">API 基本信息</h3>
            </div>
            <div class="panel-body">
                <div class="input-group" id="API-NAME">
                    <span class="input-group-addon" id="basic-addon1">NAME</span>
                    <input type="text" class="form-control" placeholder="API NAME" aria-describedby="basic-addon1" >
                </div>
                <br>
                <div class="input-group" id="API-URL">
                    <span class="input-group-addon" id="basic-addon1">URL</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" value="{{$apiUrl}}">
                </div>
                <br>
                <div class="input-group" id="API-METHOD">
                    <span class="input-group-addon" id="basic-addon1">METHOD</span>
                    <input type="text" class="form-control" aria-describedby="basic-addon1" value="{{$apiMethod}}">
                </div>
                <br>
                <div class="input-group" id="API-DESCRIPTION">
                    <span class="input-group-addon" id="basic-addon1">DESCRIPTION</span>
                    <input type="text" class="form-control" placeholder="the description" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>

        <!--实际存放内容的隐藏input-->

        <input id="request-headers-editor-input" name="request_headers" type="hidden" value="{{$requestHeaders}}">
        <input id="request-params-editor-input" name="request_params" type="hidden" value="{{$requestParam}}">
        <input id="request-body-editor-input" name="request_body" type="hidden" value="{{$requestBody}}">
        <input id="request-example-editor-input" name="request_example" type="hidden" value="{{$requestExample}}">
        <input id="response-headers-editor-input" name="response_headers" type="hidden" value="{{$responseHeaders}}">
        <input id="response-body-editor-input" name="response_body" type="hidden" value="{{$responseBody}}">
        <input id="response-example-editor-input" name="response_example" type="hidden" value="{{$responseExample}}">

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

        <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>&nbsp生成文档!</button>

    </div>

    <footer>
        <br>
        <br>
    </footer>

    <script>
        editors = [
            "request-headers-editor",
            "request-params-editor",
            "request-body-editor",
            "request-example-editor",
            "response-headers-editor",
            "response-body-editor",
            "response-example-editor"
        ];

        editors.forEach(function (value, index, array) {
            editor = ace.edit(value);
            theme = "clouds";
            language = "json";

            editor.setTheme("ace/theme/" + theme);
            editor.session.setMode("ace/mode/" + language);
            editor.setFontSize(14);
            var input = document.getElementById(value+'-input').getAttribute("value");
            console.log(value);
            console.log(input);
            if (isJSON(input)) {
                console.log(value+'s input is json');
                input = JSON.parse(input);
                editor.setValue(JSON.stringify(input,null,'\t'));
            }
        });

        function isJSON(str) {
            if (typeof str === 'string') {
                try {
                    JSON.parse(str);
                    return true;
                } catch(e) {
                    console.log(e);
                    return false;
                }
            }
            console.log('It is not a string!')
        }
    </script>

@endsection