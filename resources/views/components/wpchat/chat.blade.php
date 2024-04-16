<div class="card card-secondary card-outline direct-chat direct-chat-default">
    <div class="card-body">
        <div id="chat-messages" class="direct-chat-messages" style="height: 400px;"></div>
    </div>
    <div class="card-footer">
    <input tabindex="-1" type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
    <input tabindex="-1" type="hidden" name="wpChatId" id="wpChatId" value="1" />
        <div class="input-group">
            <input on type="text" id="textMessage" name="textMessage" placeholder="Type a Message" class="form-control">
            <button class="btn btn-default btn-file" data-toggle="modal" data-target="#messageDocuments">
                <i class="fas fa-paperclip"></i>
            </button>
            <span class="input-group-append">
                <button id="btnSendTextMessage" onclick="sendTextMessage()" type="button" class="btn btn-success">
                Send Message
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#messageTemplates">
                    Send Template
                </button>
            </span>
        </div>
    </div>
</div>
