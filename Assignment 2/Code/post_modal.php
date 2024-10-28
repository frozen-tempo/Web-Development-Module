<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="post-text" class="col-form-label">Post Text:</label>
            <textarea class="form-control" id="post-text" name="post-text"></textarea>
          </div>
          <div class="form-group">
            <label for="post-photo" class="col-form-label">Post Photo:</label>
            <input type="file" class="form-control" id="post-photo" name="post-photo">
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
        <button type="submit" class="btn brand-primary rounded">Create Post</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>