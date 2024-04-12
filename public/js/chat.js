document.addEventListener("DOMContentLoaded", function(e) {
    loadMessages();

});

function showTemplateExample(id)
{
    document.getElementById('templateMessageExample').textContent = '';
    var example = document.getElementById('templateMessageExampleId'+id).textContent;
    document.getElementById('templateMessageExample').textContent = example;
}

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
            loadMessages();
        }
    }
}

function sendTemplate()
{
    let wpTemplateId = document.getElementById('wpTemplateId');
    let id = wpTemplateId.options[wpTemplateId.selectedIndex].value
    
    let postObj = { 
        _token: document.getElementById('_token').value,
        messageType: 'template',
        wpChatId: document.getElementById('wpChatId').value, 
        wpMessageTemplateId: id
    }

    send(postObj); 

    $('#messageTemplates').modal('hide');
}

function sendTextMessage()
{
    let postObj = { 
        _token: document.getElementById('_token').value,
        messageType: 'text',
        wpChatId: document.getElementById('wpChatId').value,
        message: document.getElementById('textMessage').value, 
    }

    send(postObj);
}

function buildMessage(message, systemName, contactName)
{
    var msgAlign = '';
    var name = systemName;
    var margin = ' style="margin-left: 53%;"';
    var floatName = 'left';
    var floatTime = 'right';
    var userIcon = '<i class="far fa-user-circle direct-chat-img"></i>';
    if(message.direction == "IN"){
        msgAlign = ' right';
        margin = ' style="margin-right: 53%;"';
        name = contactName;
        floatName = 'right';
        floatTime = 'left';
        userIcon = '<i class="far fa-user direct-chat-img"></i>';
    }
   
    let htmlMessage = '';
    htmlMessage += '<div class="direct-chat-msg'+msgAlign+'"'+margin+'>';
    htmlMessage += '<div class="direct-chat-infos clearfix">';
    htmlMessage += '<span class="direct-chat-name float-'+floatName+'">'+name+'</span>';
    htmlMessage += '<span class="direct-chat-timestamp float-'+floatTime+'">'+message.send_time+'</span>';
    htmlMessage += '</div>';
    htmlMessage += userIcon;
    htmlMessage += '<div class="direct-chat-text">';
    htmlMessage += message.body;
    htmlMessage += '</div>';
    htmlMessage += '</div>'; 

    return htmlMessage;
}

function loadMessages()
{
    let systemName  = document.getElementById('system-name').textContent;
    let contactName = document.getElementById('contact-name').textContent;

    let id = document.getElementById('wpChatId').value;
    const url = "../wpmessage/load/"+id;
    let xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.open('GET', url, true);
    xhr.send();

    xhr.onload = function () {
        if(xhr.status === 200) {

            let chatBox = document.getElementById('chat-messages');

            const jsonResponse = xhr.response;
            var messages = "";
            for(const key in jsonResponse.messages){
                //console.log(jsonResponse.messages[key])
                messages += buildMessage(jsonResponse.messages[key], systemName, contactName);

            }
            
            chatBox.innerHTML = messages;
            chatBox.scrollTo(0, chatBox.scrollHeight);
        }

    }
}



