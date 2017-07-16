/**
 * Created by mark on 17/7/11.
 */

editors = [
    "request-headers",
    "request-params",
    "request-body",
    "request-example",
    "response-headers",
    "response-body",
    "response-example"
];

function isJSON(str) {
    if (typeof str === 'string') {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            console.log(e);
            return false;
        }
    }
}

function checkBeforeSubmit() {

    // 检查基本信息

    baseInfoKeys = [
        'api-name','api-url','api-method'
    ];

    for (i=0;i<baseInfoKeys.length;i++) {
        key = baseInfoKeys[i];
        infoValue = document.getElementById(key).value;
        console.log(key+' '+infoValue);
        // todo 检查同一collection里是否有重名的api
        if (infoValue === null||infoValue === '') {
            setValidateInfo('请检查基本信息是否填写完成');
            return false;
        }
    }

    for (i=0;i<editors.length;i++) {
        key = editors[i];
        // 首先判断checkbox
        isOn = document.getElementById(key+'-on').checked;

        if (isOn === true) {
            // 检查输入是否为空，以及是否是json
            editorValue = ace.edit(key+'-editor').getValue();

            if (editorValue === '') {
                setValidateInfo('请检查输入是否有空值');
                return false;
            }else if (!isJSON(editorValue)) {
                setValidateInfo('请检查输入是否有非法JSON');
                return false;
            }

            document.getElementById(key+'-input').setAttribute('value',editorValue);
        } else {
            // 直接设空value
            document.getElementById(key+'-input').setAttribute('value','null');
        }
    }

    return true;
}

function setValidateInfo(message) {
    document.getElementById('validate-message').innerHTML = message;
    document.getElementById('warning').style.display = 'block';
}