var ToDoService = {

  init: function() {
    $("#addTodoForm").validate({
      submitHandler: function(form) {

        var todo = Object.fromEntries((new FormData(form)).entries());
        ToDoService.add(todo);

      }


    });
    ToDoService.list();

  },

  list: function() {
    $.get("rest/todos", function(data) {

      $("#todo-list").html("");

      var html = "";
      for (let i = 0; i < data.length; i++) {

        html += `

        <div class="col-lg-4">
          <h2>` + data[i].created + ` </h2>
          <p>` + data[i].description + `</p>
          <p>
          </p>
          <button type="button" class="btn btn-primary todo-button" onclick="ToDoService.get(` + data[i].id + `)">Edit</button>
          <button type="button" class="btn btn-danger todo-button" onclick="ToDoService.delete(` + data[i].id + `)">Delete</button>
        </div>`


      }

      $("#todo-list").html(html);


      console.log(data);
      //alert("Load was performed.");
    });

  },

  get: function(id) {
    $('.todo-button').attr('disabled', true);

    $.get('rest/todos/' + id, function(data) {
      console.log(data);
      //$("#exampleModal .modal-body").html(id);
      $("#description").val(data.description);
      $("#created").val(data.created);
      $("#id").val(data.id);
      $("#exampleModal").modal("show");
      $('.todo-button').attr('disabled', false);

    })
  },

  add: function(todo) {
    $.ajax({
      url: 'rest/todos',
      type: 'POST',
      data: JSON.stringify(todo),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        ToDoService.list();
        $("#addModal").modal("hide");

      }
    });

  },

  update: function() {
    $(".save-todo").attr("disabled", true);

    var todo = {};
    //todo.id=$('#id').val();
    todo.description = $('#description').val();
    todo.created = $('#created').val();


    $.ajax({
      url: 'rest/todos/' + $('#id').val(),
      type: 'PUT',
      data: JSON.stringify(todo),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        $("#exampleModal").modal("hide");
        $(".save-todo").attr("disabled", false);
        $("#todo-list").html('<span>Loading...</span>')
        ToDoService.list();

      }
    });

  },

  delete: function(id) {
    $.ajax({
      url: 'rest/todos/' + id,
      type: 'DELETE',
      success: function(response) {
        $('.todo-button').attr('disabled', true);
        ToDoService.list();
      }
    });
  }



}
