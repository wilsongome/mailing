<div class="modal fade" id="messageDocuments" tabindex="-1" role="dialog" aria-labelledby="messageDocuments" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Media Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formDocumentMessage" method="post" enctype="multipart/form-data" action="{{route('wpmessage.send')}}">
          @csrf
          <input type="hidden" name="wpChatId" value="1" />
          <input type="hidden" name="messageType" value="media" />
          <input type="text" class="form-control" name="documentMessageCaption" id="documentMessageCaption" placeholder="Type a message" />
          <input type="file" class="form-control" name="documentMessageFile" id="documentMessageFile" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="sendDocumentMessage()" type="button" class="btn btn-success">Send Message</button>
      </div>
    </div>
  </div>
</div>