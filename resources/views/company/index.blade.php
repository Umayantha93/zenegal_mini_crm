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
