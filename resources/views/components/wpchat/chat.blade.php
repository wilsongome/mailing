<div class="card card-info card-outline direct-chat direct-chat-info">

        <div class="card-body">

            <div class="direct-chat-messages">

                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <img class="direct-chat-img" src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" alt="Message User Image">
                    <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                    </div>
                </div>

                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">Sarah Bullock</span>
                        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <img class="direct-chat-img" src="https://adminlte.io/themes/v3/dist/img/user3-128x128.jpg" alt="Message User Image">
                    <div class="direct-chat-text">
                    You better believe it!
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="wpChatId" id="wpChatId" value="1" />
            <div class="input-group">
                <input type="text" id="message" name="message" placeholder="Type Message ..." class="form-control">
                <span class="input-group-append">
                    <button onclick="sendTextMessage()" type="button" class="btn btn-primary">Send</button>
                    <button onclick="sendTemplate()" type="button" class="btn btn-info">Send Template</button>
                </span>
            </div>
        </div>

</div>