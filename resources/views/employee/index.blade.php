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

<!-- Edit Employee Modal -->
<div class="modal fade" id="EDITEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="UpdateEmployeeFORM" method="POST" enctype="multipart/form-data">
        <div class="modal-body">

            <input type="hidden" name="emp_id" id="emp_id">

            <ul class="alert alert-warning d-none" id="update_errorList"></ul>          
            <div class="form-group mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" id="edit_first_name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" id="edit_last_name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Company</label>
                <!-- <input type="text" name="company"  id="edit_company"class="form-control"> -->
                <select class="form-select" name="company" id="edit_company" aria-label="Default select example">
                    @foreach($data as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="text" name="email" id="edit_email"class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Phone</label>
                <input type="text" name="phone" id="edit_phone" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- end edit Employee Modal -->


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

            $(document).on('click', '.edit_btn', function (e){
                e.preventDefault();
                
                var emp_id = $(this).val();
                $('#EDITEmployeeModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-employee/"+emp_id,
                    success: function (response) {
                        // console.log(response.employee);
                        if(response.status == 404)
                        {
                            alert(response.message);
                            $('#EDITEmployeeModal').modal('hide');
                        }
                        else
                        {
                            $('#edit_first_name').val(response.employee.first_name);
                            $('#edit_last_name').val(response.employee.last_name);
                            $('#edit_company').append("<option selected value='"+response.employee.company+"'>"+response.employee.name+"</option>");
                            $('#edit_email').val(response.employee.email);
                            $('#edit_phone').val(response.employee.phone);
                            $('#emp_id').val(emp_id);
                        }
                    }
                });
                // alert(emp_id);
            });

            $(document).on('submit', '#UpdateEmployeeFORM', function(e) {
                e.preventDefault();

                var id = $('#emp_id').val();
                let EditformData = new FormData($('#UpdateEmployeeFORM')[0]);

                $.ajax({
                    type: "POST",
                    url: "/update-employee/"+id,
                    data: EditformData,
                    contentType: false,
                    processData: false,
                    success: function (response){
                        if(response.status == 400)
                        {
                            $('#update_errorList').html("");
                            $('#update_errorList').removeClass('d-none');

                            $.each(response.errors, function (key, err_value){
                                $('#update_errorList').append('<li>'+err_value+'</li>');
                            });
                        }
                        else if(response.status == 404)
                        {
                            alert(response.message);
                        }
                        else if(response.status == 200)
                        {
                            $('#update_errorList').html("");
                            $('#update_errorList').addClass('d-none');
                            alert(response.message);
                            $('#EDITEmployeeModal').modal('hide');                           
                            fetchEmployee();
                        }
                    }
                });
            });



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

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();

                var emp_id = $(this).val();
                $('#DELETEEmployeeModal').modal('show');
                $('#deleting_emp_id').val(emp_id);
            });

            $(document).on('click', '.delete_modal_btn', function (e){
                e.preventDefault();

                var id = $('#deleting_emp_id').val();

                $.ajax({
                    type: "DELETE",
                    url: "/delete-employee/"+id,
                    dataType: 'json',
                    success: function (response){
                        if(response.status == 404)
                        {
                            alert(response.message);
                            $('DELETEEmployeeModal').modal('hide');
                        }
                        else if(response.status == 200)
                        {
                            
                            $('DELETEEmployeeModal').modal('hide');
                            alert(response.message);
                            fetchEmployee();
                        }
                    }
                })
            });
           
        });
    </script> 

@endsection