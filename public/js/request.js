const tabNames = ["headers","body"];

function getRequestInputs() {

    var requestMethod = document.getElementById("request-method").innerHTML;
    var requestURL = document.getElementById("request-url").value;
    var requestHeaders = ace.edit("headers-editor").getValue();
    var requestBody = ace.edit("body-editor").getValue();

    var requestInputs = {
        "url": requestURL,
        "method": requestMethod,
        "headers": requestHeaders,
        "body": requestBody
    };

    return requestInputs;
}

function refreshShowers(json) {
    refreshStatusPanel(json.response.status_code);
    ace.edit("headers-shower").setValue(JSON.stringify(json.response.headers,null,"\t"));
    ace.edit("body-shower").setValue(JSON.stringify(json.response.body.data,null,"\t"));
}

function refreshStatusPanel(statusCode) {

    var panel = document.getElementById("response-panel");

    if (statusCode === 200 || statusCode === 201) {
        panel.className = "panel panel-success";
    } else if (statusCode === 500 || statusCode === 501 || statusCode === 502 || statusCode === 503) {
        panel.className = "panel panel-danger";
    } else if (statusCode === 301 || statusCode === 302) {
        panel.className = "panel panel-info";
    } else if (statusCode === 403 || statusCode === 404) {
        panel.className = "panel panel-waring";
    }

    document.getElementById("status-code").innerHTML = statusCode;
}

function sendTestRequest() {
    var inputs =  getRequestInputs();

    console.log(inputs);

    fetch("/test-api",{
        method:'POST',
            body:JSON.stringify(inputs),
            headers:{
            'content-type':'application/json'
        }
    }).then(function (res) {
        return res.json();
    }).then(function (json) {
        // 设置将结果返回输出到编辑器中去
        console.log(json);
        console.log(json.response);

        refreshShowers(json);
    });
}

function switchMethod(method) {
    document.getElementById("request-method").innerHTML = method;
    document.getElementById("request-method-input").setAttribute("value",method);
}

function switchRequestTab(tabName) {
    tabNames.forEach(function (value, index, array) {
        document.getElementById(value+'-editor').style.display = 'none';
        document.getElementById('request-'+value+'-tab').className = null;
    });

    document.getElementById(tabName+'-editor').style.display = 'block';
    document.getElementById('request-'+tabName+'-tab').className = 'active';
}

function switchResponseTab(tabName) {
    tabNames.forEach(function (value, index, array) {
        document.getElementById(value+'-shower').style.display = 'none';
        document.getElementById('response-'+value+'-tab').className = null;
    });

    document.getElementById(tabName+'-shower').style.display = 'block';
    document.getElementById('response-'+tabName+'-tab').className = 'active';
}

function setFormValue() {
    var requestHeaders = ace.edit("headers-editor").getValue();
    var requestBody = ace.edit("body-editor").getValue();
    document.getElementById("request-headers-input").setAttribute("value",requestHeaders);
    document.getElementById("request-body-input").setAttribute("value",requestBody);
}