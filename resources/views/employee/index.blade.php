@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="AddEmployeeFORM" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <ul class="alert alert-warning d-none" id="save_errorList"></ul>          
            <div class="form-group mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Company</label>
                <!-- <input type="text" name="company" class="form-control"> -->
                <select class="form-select" name="company" aria-label="Default select example">
                    @foreach($data as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4> Employee Data Table 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class= "btn btn-primary btn-sm float-end">Add Employee</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

   <script>
        $(document).ready(function (){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchEmployee();

            function fetchEmployee(){
                $.ajax({
                    type: "GET",
                    url: "/fetch-employees",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.employee, function(key, item){
                        $('tbody').append('<tr>\
                                <th>'+item.id+'</th>\
                                <th>'+item.first_name+'</th>\
                                <th>'+item.last_name+'</th>\
                                <th>'+item.name+'</th>\
                                <th>'+item.email+'</th>\
                                <th>'+item.phone+'</th>\
                                <th><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></th>\
                                <th><button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></th>\
                                </tr>');
                        
                        });
                    }
                });
            }

            $(document).on('submit', '#AddEmployeeFORM', function(e) {
                e.preventDefault();

                let formData = new FormData($('#AddEmployeeFORM')[0]);

                $.ajax({
                    type: "POST",
                    url: "/add-employee",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response){
                        if(response.status == 400)
                        {
                            $('#save_errorList').html("");
                            $('#save_errorList').removeClass('d-none');
                            $.each(response.errors, function (key, err_value){
                                $('#save_errorList').append('<li>'+err_value+'</li>');
                            });
                        }else if(response.status == 200)
                        {
                            $('#save_errorList').html("");
                            $('#save_errorList').addClass('d-none');

                            // this.reset();
                            // $('#AddEmployeeFORM').find('input').val();
                            alert(response.message);
                            $('#AddEmployeeModal').modal('hide');
                            
                            fetchEmployee();


                        }
                    }
                });

            });

           
        });
    </script> 

@endsection