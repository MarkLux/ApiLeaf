const tabNames = ["headers","params","body"];

function getInputs() {

    var url = document.getElementById("request-url").value;
    var method = document.getElementById("request-method").value;
    var headers = document.getElementById("request-headers").value;
    var body = document.getElementById("request-body").value;

    window.fetch('http://123.207.137.231:8080/chat/admin/test').then(function (res) {
        console.log(res);
    });
}

function switchMethod(method) {
    document.getElementById("request-method").innerHTML = method;
}

function switchTab(tabName) {
    tabNames.forEach(function (value, index, array) {
        document.getElementById(value+'-editor').style.display = 'none';
        document.getElementById(value+'-tab').className = null;
    });

    document.getElementById(tabName+'-editor').style.display = 'block';
    document.getElementById(tabName+'-tab').className = 'active';
}