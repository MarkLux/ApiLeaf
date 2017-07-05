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
                    <input type="text" class="form-control" placeholder="http://0.0.0.0:3000" aria-describedby="basic-addon1">
                </div>
                <br>
                <div class="input-group" id="API-URL">
                    <span class="input-group-addon" id="basic-addon1">URL</span>
                    <input type="text" class="form-control" placeholder="http://0.0.0.0:3000" aria-describedby="basic-addon1">
                </div>
                <br>
                <div class="input-group" id="API-METHOD">
                    <span class="input-group-addon" id="basic-addon1">METHOD</span>
                    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                </div>
                <br>
                <div class="input-group" id="API-DESCRIPTION">
                    <span class="input-group-addon" id="basic-addon1">DESCRIPTION</span>
                    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="API-HEADERS">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="request-headers-on" type="checkbox" checked>&nbsp&nbspAPI 请求头部</h3>
        </div>
            <div class="panel-body">
                <pre id="api-headers-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-PARAMS">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="request-params-on" type="checkbox" checked>&nbsp&nbspAPI 请求参数（QueryString）</h3>
            </div>
            <div class="panel-body">
                <pre id="api-params-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-REQUEST-BODY">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="request-body-on" type="checkbox" checked>&nbsp&nbspAPI 请求体（Body）</h3>
            </div>
            <div class="panel-body">
                <pre id="api-request-body-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-REQUEST-EXAMPLE">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="request-example-on" type="checkbox" checked>&nbsp&nbspAPI 请求示范</h3>
            </div>
            <div class="panel-body">
                <pre id="api-request-example-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-RESPONSE-HEADERS">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="response-headers-on" type="checkbox" >&nbsp&nbspAPI 响应头</h3>
            </div>
            <div class="panel-body">
                <pre id="api-response-headers-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-RESPONSE-BODY">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="response-body-on" type="checkbox" checked>&nbsp&nbspAPI 响应体</h3>
            </div>
            <div class="panel-body">
                <pre id="api-response-body-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
            </div>
        </div>

        <div class="panel panel-default" id="API-RESPONSE-EXAMPLE">
            <div class="panel-heading">
                <h3 class="panel-title"><input id="response-example-on" type="checkbox" checked>&nbsp&nbspAPI 响应示范</h3>
            </div>
            <div class="panel-body">
                <pre id="api-response-example-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
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
            "api-headers-editor",
            "api-params-editor",
            "api-request-body-editor",
            "api-request-example-editor",
            "api-response-headers-editor",
            "api-response-body-editor",
            "api-response-example-editor"
        ];

        editors.forEach(function (value, index, array) {
            editor = ace.edit(value);
            theme = "clouds";
            language = "json";

            editor.setTheme("ace/theme/" + theme);
            editor.session.setMode("ace/mode/" + language);
            editor.setFontSize(14);
        })
    </script>

@endsection