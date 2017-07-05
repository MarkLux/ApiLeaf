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
    document.getElementById("status-code").innerHTML = json.response.status_code;
    ace.edit("headers-shower").setValue(JSON.stringify(json.response.headers,null,"\t"));
    ace.edit("body-shower").setValue(JSON.stringify(json.response.body.data,null,"\t"));
}

function refreshStatusPanel(statusCode) {

    var panel = document.getElementById("response-panel");

    if (statusCode === 200) {
        panel.className = "panel panel-success";
    } else if (statusCode )
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