var NoteService = {

  init: function() {
    $("#addTodoForm").validate({
      submitHandler: function(form) {

        var entity = Object.fromEntries((new FormData(form)).entries());
        NoteService.add(entity);

      }


    });
    NoteService.list();

  },

  list: function() {
    $.get("rest/notes", function(data) {

      $("#notes-list").html("");

      var html = "";
      for (let i = 0; i < data.length; i++) {

        html += `

        <div class="col-lg-3">
        <div class="card" style="width: 18rem;">
          <img src="data:image/png;base64,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" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">` + data[i].name + `</h5>
            <p class="card-text">` + data[i].description + ` </p>
            <button type="button" class="btn btn-primary note-button" onclick="NoteService.get(` + data[i].id + `)">Edit</button>
            <button type="button" class="btn btn-success note-button" onclick="NoteService.get_todos(` + data[i].id + `)">Manage</button>
            <button type="button" class="btn btn-danger note-button" onclick="NoteService.delete(` + data[i].id + `)">Delete</button>
          </div>
        </div>
        </div>

        `


      }

      $("#note-list").html(html);


      console.log(data);
      //alert("Load was performed.");
    });

  },

  get_todos:function(){
    $("#addModal2").modal("show");
  },

  get: function(id) {
    $('.note-button').attr('disabled', true);

    $.get('rest/notes/' + id, function(data) {
      console.log(data);
      //$("#exampleModal .modal-body").html(id);
      $("#description").val(data.description);
      $("#created").val(data.created);
      $("#id").val(data.id);
      $("#exampleModal").modal("show");
      $('.note-button').attr('disabled', false);

    })
  },

  add: function(note) {
    $.ajax({
      url: 'rest/notes',
      type: 'POST',
      data: JSON.stringify(note),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        NoteService.list();
        $("#addModal").modal("hide");

      }
    });

  },

  update: function() {
    $(".save-note").attr("disabled", true);

    var note = {};
    //note.id=$('#id').val();
    note.description = $('#description').val();
    note.created = $('#created').val();


    $.ajax({
      url: 'rest/notes/' + $('#id').val(),
      type: 'PUT',
      data: JSON.stringify(note),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        $("#exampleModal").modal("hide");
        $(".save-note").attr("disabled", false);
        $("#note-list").html('<span>Loading...</span>')
        NoteService.list();

      }
    });

  },

  delete: function(id) {
    $.ajax({
      url: 'rest/notes/' + id,
      type: 'DELETE',
      success: function(response) {
        $('.note-button').attr('disabled', true);
        NoteService.list();
      }
    });
  }



}
