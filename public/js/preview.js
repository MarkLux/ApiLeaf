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