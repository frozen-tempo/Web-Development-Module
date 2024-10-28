$("#commentModal").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Button attached to post that triggered modal
  var postID = button.data("post_id"); // places post_id into hidden input to be used when form is submitted
  var modal = $(this);
  modal.find(".modal-body input").val(postID);
});
