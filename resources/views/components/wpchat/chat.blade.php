<div class="card card-secondary card-outline direct-chat direct-chat-default">

        <div class="card-body">

            <div id="chat-messages" class="direct-chat-messages" style="height: 400px;">

            </div>
        </div>

        <div class="card-footer">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="wpChatId" id="wpChatId" value="1" />
            <div class="input-group">
                <input type="text" id="message" name="message" placeholder="Type Message ..." class="form-control">
                <span class="input-group-append">
                    <button onclick="sendTextMessage()" type="button" class="btn btn-success">Send Message</button>
                    <button onclick="" type="button" class="btn btn-info" data-toggle="modal" data-target="#messageTemplates">Send Template</button>
                </span>
            </div>
        </div>

</div>