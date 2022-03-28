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
                            // location.reload(true);
                        }
                    }
                });
            });
        });
    </script>

@endsection