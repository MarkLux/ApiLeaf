@extends('layouts.app')

@section('content')
    <script src="{{url('/')}}/js/request.js"></script>
    <script src="https://cdn.bootcss.com/ace/1.2.7/ace.js"></script>
    <form action="{{url('/')}}/api/edit" method="POST">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Request</h3>
            </div>
            <div class="panel-body">
                <!-- 警告框 -->
                <div class="alert alert-info" id="input-dismissible" role="alert" style="display: none;">请输入正确的地址！</div>
                <!-- URL输入框 -->
                <h5>URL</h5>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <span id="request-method">GET</span>&nbsp<span class="caret"></span>
                            <input type="hidden" id="request-method-input" name="api_method" value="GET">
                        </button>
                        <ul class="dropdown-menu">
                            <li><a onclick="switchMethod('GET')">GET</a></li>
                            <li><a onclick="switchMethod('POST')">POST</a></li>
                            <li><a onclick="switchMethod('PUT')">PUT</a></li>
                            <li><a onclick="switchMethod('DELETE')">DELETE</a></li>
                        </ul>
                    </div>
                    <input id="request-url" type="text" class="form-control" aria-label="..." name="api_url">
                </div>
                <br>
                <!--请求配置选项卡-->
                <ul class="nav nav-tabs">
                    <li role="presentation" id="request-headers-tab" class="active"><a onclick="switchRequestTabHead('headers')">Headers</a></li>
                    {{--<li role="presentation" id="params-tab"><a onclick="switchTab('params')">Params</a></li>--}}
                    <li role="presentation" id="request-body-tab" class="nav disabled"><a onclick="switchRequestTabBody('body')">Body</a></li>
                </ul>
                <!--三个状态-->

                <input type="hidden" name="request_headers" id="request-headers-input">
                <input type="hidden" name="request_body" id="request-body-input">

                <pre id="headers-editor" class="ace_editor" style="min-height:300px;margin-top: 5px"><textarea class="ace_text-input">{&#10    "Content-Type":"application/json"&#10}</textarea></pre>
                {{--<pre id="params-editor" class="ace_editor" style="min-height:300px;margin-top: 5px;display:none"><textarea class="ace_text-input"></textarea></pre>--}}
                <pre id="body-editor" class="ace_editor" style="min-height:300px;margin-top: 5px;display:none;"><textarea class="ace_text-input"></textarea></pre>
                <script>

                    editors = ["headers-editor","body-editor"];

                    editors.forEach(function (value, index, array) {
                        editor = ace.edit(value);
                        theme = "clouds";
                        language = "json";

                        editor.setTheme("ace/theme/" + theme);
                        editor.session.setMode("ace/mode/" + language);
                        editor.setFontSize(14);
                    })



                </script>
                <button class="btn btn-primary" type="button" onclick="sendTestRequest()"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 发送请求</button>
            </div>
        </div>
        <div id="response-panel" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Response&nbsp&nbsp&nbsp<span id="status-code"></span></h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li role="presentation" id="response-headers-tab" ><a onclick="switchResponseTab('headers')">Headers</a></li>
                    <li role="presentation" id="response-body-tab" class="active"><a onclick="switchResponseTab('body')">Body</a></li>
                </ul>
                <!--三个状态-->

                <input type="hidden" name="response_headers" id="response-headers-input">
                <input type="hidden" name="response_body" id="response-body-input">


                <pre id="headers-shower" class="ace_editor" style="min-height:300px;margin-top: 5px;display:none;"><textarea class="ace_text-input"></textarea></pre>
                {{--<pre id="params-editor" class="ace_editor" style="min-height:300px;margin-top: 5px;display:none"><textarea class="ace_text-input"></textarea></pre>--}}
                <pre id="body-shower" class="ace_editor" style="min-height:300px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                <script>

                    showers = ["headers-shower","body-shower"];

                    showers.forEach(function (value, index, array) {
                        shower = ace.edit(value);
                        theme = "clouds";
                        language = "json";

                        shower.setTheme("ace/theme/" + theme);
                        shower.session.setMode("ace/mode/" + language);
                        shower.setFontSize(14);
                        shower.setReadOnly(true);
                    })
                </script>
                <button class="btn btn-primary" type="submit" onclick="setFormValue()"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> 生成文档</button>
            </div>
        </div>
    </div>
    </form>
@endsection

