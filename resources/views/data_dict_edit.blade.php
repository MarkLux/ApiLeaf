@extends('layouts.app')
@section('content')
    <script src="https://cdn.bootcss.com/ace/1.2.7/ace.js"></script>
    <script src="{{url('/js')}}/edit.js"></script>
    <div class="container">
        <div class="page-header">
            @if(!isset($update))
                <h1>创建新的数据字典</h1>
            @else
                <h1>修改数据字典</h1>
            @endif
            <p>所在文档：<a href="api/doc/{{$apiCollection->id}}">{{$apiCollection->title}}</a></p>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-4">
                        <label for="data_dict_name"><b>类型名:</b></label>
                        <input id="data_dict_name" type="text" class="form-control" value="{{isset($dictName)?$dictName:''}}"/>
                    </div>
                    <div class="col-md-8">
                        @if(isset($update))
                            <a href="{{url('/api/data-dict/'.$dictId.'/delete')}}" onclick="return confirmDelete()"><button style="float: right; margin-top: 10px;" class="btn btn-danger">删除此字典&nbsp<span class="glyphicon glyphicon-trash"></span></button></a>
                        @endif
                        <button style="float: right; margin-top: 10px; margin-right: 20px;" class="btn btn-success" onclick="onDone()">Done&nbsp<span class="glyphicon glyphicon-ok"></span></button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="err-report" class="alert alert-danger" role="alert" style="display: none"></div>
                <label for="data_dict_description"><b>类型描述:</b></label>
                <input id="data_dict_description" type="text" class="form-control" value="{{isset($dictDescription)?$dictDescription:''}}"/>
                <br>
                <ul class="nav nav-tabs">
                    <li id="create-tab" role="presentation" class="active"><a href="#" onclick="switchToCreate()">手动创建</a></li>
                    <li id="parse-tab" role="presentation"><a href="#" onclick="switchToParse()">自动解析(JSON)</a></li>
                </ul>
                <br>
                <div id="create-table">
                <table id="data-dict-table" class="table table-hover">
                    <tr><th>字段名称(key)</th><th>字段类型</th><th>字段说明</th><th><buttton class="btn btn-primary" onclick="onAddRow('','')">+添加字段</buttton></th></tr>
                    @if(isset($dictItems))
                        @foreach($dictItems as $item)
                            <tr class="data-dict-row" id="{{'item-'.$item->key}}">
                                <td><input name="dict_key" type="text" class="form-control" value="{{$item->key}}"></td>
                                <td><input name="dict_type" type="text" class="form-control" value="{{$item->type}}"></td>
                                <td><input name="dict_description" type="text" class="form-control" value="{{$item->description}}"></td>
                                <td><button class="btn btn-danger" onclick="onDelRow('example-row')"><span class="glyphicon glyphicon-trash"></span>&nbsp删除</button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="data-dict-row" id="example-row">
                            <td><input name="dict_key" type="text" class="form-control"></td>
                            <td><input name="dict_type" type="text" class="form-control"></td>
                            <td><input name="dict_description" type="text" class="form-control"></td>
                            <td><button class="btn btn-danger" onclick="onDelRow('example-row')"><span class="glyphicon glyphicon-trash"></span>&nbsp删除</button></td>
                        </tr>
                    @endif
                </table>
                </div>
                <div id="parse-table" style="display: none;">
                    <pre id="json-parse-editor" class="ace_editor" style="min-height:200px;margin-top: 5px"><textarea class="ace_text-input"></textarea></pre>
                    <button class="btn btn-primary" onclick="onParse()">解析</button>
                </div>
            </div>
        </div>
        @if(!isset($update))
        <form  id="data-dict-post-form" action="/api/data-dict/{{$apiCollection->id}}/create" method="POST">
            <input id="dict-data" name="data" type="text" hidden="true"/>
        </form>
        @else
            <form  id="data-dict-post-form" action="/api/data-dict/{{$dictId}}/update" method="POST">
                <input id="dict-data" name="data" type="text" hidden="true"/>
            </form>
        @endif
    </div>
    <script>
        editor = ace.edit('json-parse-editor');
        theme = "clouds";
        language = "json";

        editor.setTheme("ace/theme/" + theme);
        editor.session.setMode("ace/mode/" + language);
        editor.setFontSize(14);

        var newRowCnt = 0;
        function onAddRow(key, type)
        {
            var table = document.getElementById("data-dict-table");
            var newRow = table.insertRow(1);
            newRow.setAttribute("class","data-dict-row");
            newRow.id = 'new-dict-row-' + newRowCnt++;
            var newKeyCell = newRow.insertCell();
            var newTypeCell = newRow.insertCell();
            var newDescriptionCell = newRow.insertCell();
            var newDelButton = newRow.insertCell();
            newKeyCell.innerHTML = '<input name="dict_key" type="text" class="form-control" value="'+ key +'">';
            newTypeCell.innerHTML = '<input name="dict_type" type="text" class="form-control" value="'+type+'">';
            newDescriptionCell.innerHTML = '<input name="dict_description" type="text" class="form-control">';
            newDelButton.innerHTML = '<button class="btn btn-danger" onclick="onDelRow(\''+newRow.id+'\')"><span class="glyphicon glyphicon-trash"></span>&nbsp删除</button>';
        }
        function onDelRow(rowId) {
            document.getElementById(rowId).remove();
        }
        function switchToCreate() {
            document.getElementById('parse-table').style.display = 'none';
            document.getElementById('create-table').style.display = 'block';
            document.getElementById('parse-tab').setAttribute("class", "inactive");
            document.getElementById('create-tab').setAttribute("class", "active");
        }
        function switchToParse() {
            document.getElementById('create-table').style.display = 'none';
            document.getElementById('parse-table').style.display = 'block';
            document.getElementById('create-tab').setAttribute("class", "inactive");
            document.getElementById('parse-tab').setAttribute("class", "active");
        }
        function onParse() {
            var objStr = ace.edit('json-parse-editor').getValue();
            if (!isJSON(objStr)) {
                showError("请检查您输入的JOSN是否有误");
            }
            var obj = JSON.parse(objStr);
            for (var k in obj) {
                onAddRow(k, typeof(obj[k]));
            }
            switchToCreate();
        }
        function onDone() {
            // 逐行获取内容, 检查并提交
            var dictName = document.getElementById('data_dict_name').value;
            var dictDescription = document.getElementById('data_dict_description').value;
            if (dictName == '') {
                showError('请输入类型名！');
                return false;
            }
            var inputs = document.getElementsByClassName('data-dict-row');
            var data = [];
            for (var i = 0; i < inputs.length; i++) {
                var cells = inputs[i].getElementsByClassName('form-control');
                var newDictItem = {};
                for (var j = 0; j < cells.length; j++) {
                    if (cells[j].name == 'dict_key') {
                        if (cells[j].value == ''|| cells[j].value == undefined) {
                            showError('请检查是否有空行或未填写的数据！');
                            return false;
                        }
                        newDictItem.key = cells[j].value;
                    }else if (cells[j].name == 'dict_type') {
                        if (cells[j].value == ''|| cells[j].value == undefined) {
                            showError('请检查是否有空行或未填写的数据！');
                            return false;
                        }
                        newDictItem.type = cells[j].value;
                    }else if (cells[j].name == 'dict_description') {
                        newDictItem.description = cells[j].value;
                    }
                }
                data.push(newDictItem);
            }
            var dataDict = {
                name: dictName,
                description: dictDescription,
                items: data
            };
            console.log(dataDict);
            document.getElementById('dict-data').value = JSON.stringify(dataDict);
            document.getElementById('data-dict-post-form').submit();
            return true;
        }
        function showError(msg) {
            var errDiv = document.getElementById("err-report");
            errDiv.innerHTML = msg;
            errDiv.style.display = 'block';
        }
        function confirmDelete() {
            if (confirm("确定要删除此字典？")) {
                return true;
            }
            return false;
        }
    </script>
@endsection