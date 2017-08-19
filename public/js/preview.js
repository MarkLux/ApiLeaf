/**
 * Created by mark on 17/7/11.
 */

function switchTab(id,type) {
    if (type === 'request') {
        document.getElementById('request-'+id+'-tab').className = 'active';
        document.getElementById('response-'+id+'-tab').className = null;
        document.getElementById('response-'+id).style.display = 'none';
        document.getElementById('request-'+id).style.display = 'block';

    }else if (type === 'response') {
        document.getElementById('response-'+id+'-tab').className = 'active';
        document.getElementById('request-'+id+'-tab').className = null;
        document.getElementById('request-'+id).style.display = 'none';
        document.getElementById('response-'+id).style.display = 'block';

    }
}

function switchValue(spanId,value) {
    document.getElementById(spanId).innerHTML=value;
}

var apiGroup;
var orderBy;
var order;

function getSuffix(){
    apiGroup = document.getElementById('tag_select').innerHTML;
    orderBy = document.getElementById('order_by_select').innerHTML;
    order = document.getElementById('order_select').innerHTML;
    var suffix = '?';
    if (apiGroup !== '组别'&&apiGroup!=='未分类') {
        suffix+=('tag='+apiGroup);
    }else if (apiGroup!=='组别'){
        suffix+=('tag=null');
    }
    if (orderBy!=='排序依据') {
        switch (orderBy) {
            case '创建时间':
                suffix+='&order_by=created_at';
                break;
            case '更新时间':
                suffix+='&order_by=updated_at';
                break;
            case '拼音顺序':
                suffix+='&order_by=api_name';
                break;
        }
    }
    if (order!=='顺序') {
        if (order === '升序') {
            suffix+='&order=asc';
        }else if (order === '降序') {
            suffix+='&order=desc';
        }
    }
    return suffix;
}
function jump() {
    url = window.location.href;
    queryStringIndex = url.indexOf('?');
    hashStringIndex = url.indexOf('#');
    trimIndex = queryStringIndex>hashStringIndex?hashStringIndex:queryStringIndex;
    url = url.substring(0,trimIndex);
    window.location.href = url+getSuffix();
}