<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post">
        <div class="form-group sr-only">
            <label for="comment-post-id" class="col-form-label">Post ID:</label>
            <input type="text" class="form-control" id="comment-post-id" name="comment-post-id">
          </div>
          <div class="form-group">
            <label for="comment-text" class="col-form-label">Comment:</label>
            <textarea class="form-control" id="comment-text" name="comment-text"></textarea>
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
        <button type="submit" class="btn brand-primary rounded">Post Comment</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>