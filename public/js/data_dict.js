var fullKeyMaps = {};

// 定义一个全局的数组，动态补充

function getFullKeys(apiId, keyName) {
    var keys = [];
    // 定位到实际的key
    var realKeyName = keyName.split('.')[0];
    if (apiId + '-' +realKeyName in fullKeyMaps) {
        return fullKeyMaps[apiId + '-' +realKeyName];
    }
    var keyCells = document.getElementsByClassName('key-cell-' + apiId);
    for (var i = 0; i < keyCells.length; i++) {
        if (keyCells[i].innerHTML.split('.')[0] == realKeyName && keyCells[i].innerHTML.split('.')[1] != undefined) {
            keys.push(keyCells[i].innerHTML.split('.')[1]);
        }
    }
    fullKeyMaps[apiId + '-' +realKeyName] = keys;
    return keys;
}

function refreshModal(result) {
    if (result.code != 0) {
        document.getElementById('dict-name').innerText = "没有找到匹配结果 : (";
        document.getElementById('dict-description').innerText = "";
        document.getElementById('match-percent').innerText = "";
        refreshPanelColor(0);
        refreshModalTable([]);
        return;
    }
    var matchPercent = result.jd;
    refreshPanelColor(matchPercent);
    var dataDict = result.dataDict;
    var macthedKeys = result.matchedKeys;
    document.getElementById('dict-name').innerText = dataDict.name;
    document.getElementById('dict-description').innerText = dataDict.description;
    document.getElementById('match-percent').innerText = '(匹配度: ' + (parseFloat(matchPercent) * 100).toFixed(2) + '%)';
    var rows = [];
    for (var i = 0; i < dataDict.body.length; i++) {
        if (dataDict.body[i].key in macthedKeys) {
            dataDict.body[i].matched = true;
        }else {
            dataDict.body[i].matched = false;
        }
        rows.push(dataDict.body[i]);
    }
    refreshModalTable(rows);
}

function refreshPanelColor(percent) {
    if (percent <= 0) {
        document.getElementById('data-dict-panel').setAttribute('class', 'panel panel-danger');
    }else if(percent > 0 && percent <= 0.4) {
        document.getElementById('data-dict-panel').setAttribute('class', 'panel panel-warning');
    }else if(percent > 0.4 && percent <= 0.8) {
        document.getElementById('data-dict-panel').setAttribute('class', 'panel panel-info');
    }else if(percent > 0.8) {
        document.getElementById('data-dict-panel').setAttribute('class', 'panel panel-success');
    }
}

function refreshModalTable(rows) {
    // 清空原有的数据列
    var table = document.getElementById('data-dict-table');
    for (var i = table.rows.length-1; i > 0; i--) {
        table.deleteRow(i);
    }
    for (var i = 0; i < rows.length; i++) {
        var newRow = table.insertRow();
        if (!rows[i].matched) {
            newRow.innerHTML = '<td>' + rows[i].key + '</td><td>' + rows[i].type + '</td><td>' + rows[i].description + '</td>';
        }else {
            newRow.innerHTML = '<td><b>' + rows[i].key + '</b></td><td>' + rows[i].type + '</td><td>' + rows[i].description + '</td>';
        }
    }
}

function onSearchClick(collectionId, apiId, keyName) {
    var fullKeys = getFullKeys(apiId, keyName);
    var rows = [];
    for (var i = 0; i < fullKeys.length; i++) {
        rows.push({
            key: fullKeys[i],
            type: '',
            description: ''
        })
    }
    getMatchResult(collectionId, fullKeys);
    $('#dict-match-div').modal();
}

function getMatchResult(collectionId, keys) {
    var data = {
        dict_keys:JSON.stringify(keys)
    };
    console.log(data);
    fetch('/api/' + collectionId + '/data-dict/match', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (res) {
        return res.json();
    }).then(function (json) {
        refreshModal(json);
    })
}