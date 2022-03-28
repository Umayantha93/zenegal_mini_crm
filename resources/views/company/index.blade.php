@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="AddCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="AddCompanyFORM" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <ul class="alert alert-warning d-none" id="save_errorList"></ul>          
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Website</label>
                <input type="text" name="website" class="form-control">
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
<!-- End Model -->

<!-- Edit Company Modal -->

<div class="modal fade" id="EDITCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="UpdateCompanyFORM" method="POST" enctype="multipart/form-data">
        <div class="modal-body">

            <input type="hidden" name="cmp_id" id="cmp_id">

            <ul class="alert alert-warning d-none" id="update_errorList"></ul>          
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" name="name"  id="edit_name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="text" name="email" id="edit_email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Website</label>
                <input type="text" name="website" id="edit_website" class="form-control">
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
<!-- End edit Company Modal -->

<!-- Delete Company Modal -->
<div class="modal fade" id="DELETECompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

        <div class="modal-body">
                <h4>Are you sure? you want to delete this data?</h4>
                <input type="hidden" id="deleting_cmp_id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="delete_modal_btn btn btn-primary">Yes Delete</button>
        </div>


    </div>
  </div>
</div>
<!-- end Delete Company Modal -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Company Data 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddCompanyModal" class= "btn btn-primary btn-sm float-end">Add Company</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatb">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <span>

                        </span>
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

            fetchCompany();

            function fetchCompany(){
            $.ajax({
                type: "GET",
                url: "/fetch-companies",
                dataType: "json",
                success: function (response) {
                    console.log(response.company)

                    $('tbody').html("");
                    $.each(response.company, function(key, item){
                    $('tbody').append('<tr>\
                            <th>'+item.id+'</th>\
                            <th>'+item.name+'</th>\
                            <th>'+item.email+'</th>\
                            <th><img src="storage/app/public/'+item.logo+'" width="100px" height="100px" alt="image"></th>\
                            <th>'+item.website+'</th>\
                            <th><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></th>\
                            <th><button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></th>\
                            </tr>');
                    });
                }
            });
            }

            $(document).on('click', '.edit_btn', function (e){
                e.preventDefault();
                
                var cmp_id = $(this).val();
                $('#EDITCompanyModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/get-company/"+cmp_id,
                    success: function (response) {
                        if(response.status == 404)
                        {
                            alert(response.message);
                            $('#EDITCompanyModal').modal('hide');
                        }
                        else
                        {
                            $('#edit_name').val(response.company.name);
                            $('#edit_email').val(response.company.email);
                            $('#edit_website').val(response.company.website);
                            $('#cmp_id').val(cmp_id);
                        }
                    }
                });
                // alert(cmp_id);
            });



            $(document).on('submit', '#UpdateCompanyFORM', function(e) {
                e.preventDefault();

                var id = $('#cmp_id').val();
                let EditformData = new FormData($('#UpdateCompanyFORM')[0]);

                $.ajax({
                    type: "POST",
                    url: "/update-company/"+id,
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
                            $('#EDITCompanyModal').modal('hide');
                            location.reload(true);
                            fetchCompany();
                        }
                        // location.reload();
                    }
                });
            });


            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();

                var cmp_id = $(this).val();
                $('#DELETECompanyModal').modal('show');
                $('#deleting_cmp_id').val(cmp_id);
            });

            $(document).on('click', '.delete_modal_btn', function (e){
                e.preventDefault();

                var id = $('#deleting_cmp_id').val();

                $.ajax({
                    type: "DELETE",
                    url: "/delete-company/"+id,
                    dataType: 'json',
                    success: function (response){
                        if(response.status == 404)
                        {
  
                            alert(response.message);
                            $('DELETECompanyModal').modal('hide');
                        }
                        else if(response.status == 200)
                        {
                            alert(response.message); 
                            $('DELETECompanyModal').modal('hide');   
                            location.reload(true);   
                            fetchCompany();
                        }
                    }
                });
            });

            //add data
            $(document).on('submit', '#AddCompanyFORM', function(e) {
                e.preventDefault();

                let formData = new FormData($('#AddCompanyFORM')[0]);

                $.ajax({
                    type: "POST",
                    url: "/add-company",
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
                            // $('#AddCompanyFORM').find('input').val();
                            $('#AddCompanyModal').modal('hide');
                            alert(response.message);
                            location.reload(true);
                            fetchCompany();
                        }
                    }
                });
            });
        });
    </script>

@endsection