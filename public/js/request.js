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
        console.log(res.body);
    })
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