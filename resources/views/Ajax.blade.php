<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container" style="margin-top: 50px;">
      <div class="row">
        <div class="col-12">
          <div class="d-flex flex-row-reverse">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Task
          </button>
          </div>
        </div>
      </div>
      <div class="row" style="margin-top: 50px;">
        <div class="col-12">
          <table class="table" id="task_table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="mb-3">
                  <input type="hidden" class="form-control" id="task_id">
                  <label for="exampleFormControlInput1" class="form-label">Task</label>
                  <input type="text" class="form-control" id="task">
                </div>
              </div>
              <div class="row">
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Description</label>
                  <input type="text" class="form-control" id="description">
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" class="form-control" id="operation">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="insert_data" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>


    <script type='text/javascript'>
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
      })

      $(document).ready(function(){
        $('#operation').val('insert');
        $('#task_id').val('0');
        fetchRecords();
        // $('#task_table').DataTable();
        setInterval(function(){
         fetchRecords(); }, 1000);


        $(document).on("click", "#exampleModal" , function() {
          $('#task').val("");
          $('#description').val("");
          $('#task_id').val("0");
          $('#operation').val('insert');
          $('#exampleModalLabel').text('Add Task');
          $('#insert_data').text('Submit');
        });

        // Add record
        $('#insert_data').click(function(){

          var task = $('#task').val();
          var description = $('#description').val();
          var operation = $('#operation').val();
          var id = $('#task_id').val();


        if(task != '' && description != ''){
          $.ajax({
            url: '/ajax-add',
            type: 'post',
            data: {
              _token: CSRF_TOKEN,
              task: task,
              description: description,
              operation: operation,
              id: id
            },
            success: function(response){
              // console.log(response);
              if (response.status == true) {
                  fetchRecords();
                  myModal.hide();
              }
              // Empty the input fields
              $('#task').val('');
              $('#description').val('');
            }
          });
        }else{
        alert('Fill all fields');
        }
      });

      // Update record
      $(document).on("click", ".update" , function() {
        var edit_id = $(this).data('id');
        console.log(edit_id);

        if(edit_id != ''){
          $.ajax({
            url: '/ajax-data/'+edit_id,
            type: 'get',
            success: function(response){
              console.log(response);
              if (response.status) {
                $('#task').val(response.data.task);
                $('#description').val(response.data.descr);
                $('#task_id').val(response.data.id);
                $('#operation').val('edit');
                $('#exampleModalLabel').text('Edit Task');
                $('#insert_data').text('Update');
                myModal.show();
              }
            }
          });
        }else{
          alert('Fill all fields');
        }
      });

      $(document).on("click", ".delete" , function() {
        var edit_id = $(this).data('id');
        var result = confirm("Want to delete?");
        if (result) {
            $.ajax({
              url: '/ajax-data/del/'+edit_id,
              type: 'get',
              success: function(response){
                console.log(response);
                if (response.status) {
                  alert(response.message);
                  fetchRecords();
                }
              }
          });
        }
        
      });

    });

     function fetchRecords(){
       $.ajax({
         url: '/ajax-data',
         type: 'get',
         dataType: 'json',
         success: function(response){
          console.log(response);

           var len = 0;
           $('#task_table tbody').empty(); // Empty <tbody>
           if(response != null){
              len = response.length;
           }

           if(len > 0){
              for(var i=0; i<len; i++){
                 var id = response[i].id;
                 var task = response[i].task;
                 var descr = response[i].descr;
                 var date = response[i].create_date;
                 var tr_str = "<tr>" +
                   "<td align='center'>" + (i+1) + "</td>" +
                   "<td align='center'>" + task + "</td>" +
                   "<td align='center'>" + descr + "</td>" +
                   "<td align='center'>" + date + "</td>" +
                   '<td align="center"><button type="button" class="btn btn-sm btn-primary update" data-id="'+id+'">Edit</button> <button type="button" class="btn btn-sm btn-danger delete" data-id="'+id+'">Delete</button></td>' +

                 "</tr>";

                 $("#task_table tbody").append(tr_str);
              }
           }else{
              var tr_str = "<tr>" +
                  "<td align='center' colspan='4'>No record found.</td>" +
              "</tr>";

              $("#task_table tbody").append(tr_str);
           }

         }
       });
     }
    </script>
  </body>
</html>
