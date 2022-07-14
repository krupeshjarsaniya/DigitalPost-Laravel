@extends('admin.layouts.app')
@section('title', 'Festival')
@section('content')

<style>
    .imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}

</style>
<div class="page-header">
    <h4 class="page-title">Custom</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Custom</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addCategory" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Custom Category</div>
            </div>
            <form id="categotyform" name="categotyform" action={{route('addcategory')}} method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="categoryid" id="categoryid" value="">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" class="form-control" id="categoryname" placeholder="Enter Category Name" name="categoryname" required>
                                </div>
                            </div>


                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cat_slider_img">Image</label>
                                    <input type="file" class="form-control" onchange="readURL(this);" id="cat_slider_img" name="cat_slider_img">
                                    <img id="blah" src="#" alt="your image" height="100" width="100" style="display: none;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="imgposition">Image Postion</label>
                                    <input type="text" class="form-control" id="imgposition" placeholder="1, 2, 3 etc.." name="imgposition" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check-inline">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="highlight_home" name="highlight" value="1">Home
                                  </label>
                                </div>
                                <div class="form-check-inline">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="highlight_greetings" name="highlight" value="2">Greetings
                                  </label>
                                </div>
                                <div class="form-check-inline">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="highlight_both" name="highlight" value="3">Both
                                  </label>
                                </div>
                                <div class="form-check-inline">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="no_highlight" name="highlight" value="0" checked>Not Any
                                  </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imgposition">Type</label>
                                    <select class="form-control" id="type" placeholder="1, 2, 3 etc.." name="type">
                                        <option value="0">General</option>
                                        <option value="1">Business</option>
                                        <option value="2">Political</option>
                                    </select>
                                </div>
                            </div>

                        <!--
                            <div class="col-md-6">
                                <div class="form-group">
                                    <img id="blah" src="#" alt="your image" height="100" width="100" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-field form-group">
                                    <label class="active" for="files">Photos</label>
                                    <input type="file" id="files" name="files[]" multiple /><br>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="festival-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showfestivallist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>

    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Category List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="category-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>image</th>
                                <th>Position</th>
                                <th>Action</th>
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

<div class="modal fade" id="addSubCategoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Sub Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="addSubCategoryForm" id="addSubCategoryForm">
                    <input type="hidden" name="custom_category_id" id="custom_category_id" value="">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group err_sub_category_name err_custom_category_id">
                                <label>Sub Category</label>
                                <input type="text" id="sub_category_name" multiple name="sub_category_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-success"  onclick="insertSubCategory()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center w-100" id="sub-category-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/customcat.js?v='.rand()) }}"></script>
@endsection

