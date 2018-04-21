 <script src="{{url('/js/data_dict.js')}}"></script>

    <!-- Modal -->
    <div class="modal fade" id="dict-match-div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">匹配结果</h3>
                    <small>以下是数据字典中最接近的字段描述</small>
                </div>
                <div class="modal-body">
                    <div id="data-dict-panel" class="panel panel-danger">
                        <div class="panel-heading">
                            <h4><b id="dict-name">没有找到匹配结果 :(</b><span id="match-percent"></span></h4>
                            <small id="dict-description"></small>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="data-dict-table">
                                <tr>
                                    <th>字段名</th>
                                    <th>字段类型</th>
                                    <th>字段说明</th>
                                </tr>
                                <tr class="data-dict-row">
                                    <td>key</td>
                                    <td>type</td>
                                    <td>description</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>