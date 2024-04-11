<div class="modal fade" id="messageTemplates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message Templates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select class="form-control" id="wpTemplateId" name="wpTemplateId" onchange="showTemplateExample(this.options[this.selectedIndex].value)">
            <option value="">Select a template</option>
            @foreach($templates as $template)
                <option value="{{ $template->id }}">{{ $template->name }}</option>
            @endforeach
        </select>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Message example</h5>
                <p class="card-text" id="templateMessageExample"></p>
                @foreach($templates as $template)
                <p style="display:none" class="card-text" id="templateMessageExampleId{{ $template->id }}">{{ $template->template }}</p>
                @endforeach
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="sendTemplate()" type="button" class="btn btn-success">Send Template Message</button>
      </div>
    </div>
  </div>
</div>