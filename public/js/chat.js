function send(parameters)
{
    let post = JSON.stringify(parameters);
    const url = "../wpmessage/send";
    let xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.send(post);

    xhr.onload = function () {
        if(xhr.status === 200) {
            var jsonResponse = xhr.response;
            console.log(jsonResponse); 
        }
    }
}

function sendTemplate()
{
    let postObj = { 
        _token: document.getElementById('_token').value,
        messageType: 'template',
        wpChatId: document.getElementById('wpChatId').value, 
        wpMessageTemplateId: 1//Pegar de forma dinamica
    }

    send(postObj);
}

function sendTextMessage()
{
    let postObj = { 
        _token: document.getElementById('_token').value,
        messageType: 'text',
        wpChatId: ddocument.getElementById('wpChatId').value,
        message: document.getElementById('message').value, 
    }

    send(postObj);
}
