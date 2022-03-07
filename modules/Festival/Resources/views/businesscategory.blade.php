@extends('admin.layouts.app')
@section('title', 'category')
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

.select2-container {
        width: 100% !important;
    }

</style>

<div class="page-header">
    <h4 class="page-title">Business Category</h4>
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
            <a href="#">Business Category</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="viewcategory">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Business Category List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-category"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="category-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Free Business</th>
                                <th>Premium Business</th>
                                <th>image</th>
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
    <div class="col-md-12" id="addcategory" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Category</div>
            </div>
            <form id="buss_cat_form" name="buss_cat_form" {{-- action={{route('addcategory')}} --}} method="POST" enctype='multipart/form-data' onsubmit="return false;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">

                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="categoryid" id="categoryid" value="">
                                        <label for="categoryname">Category Name</label>
                                        <input type="text" class="form-control" id="categoryname" placeholder="Enter category Name" name="categoryname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group err_thumnail">
                                        <label for="fimage">Image</label>
                                        <input type="file" class="form-control" onchange="readURL(this);" id="fimage" name="thumnail">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img id="blah" src="#" id="fimage" alt="your image" height="100" width="100" />
                                    </div>
                                </div>

                            </div>
                            <div class="form-group" id="showphotos">
                            <label for="addphotos">Add Photos</label></div>
                            <div id="addphotos">
                                <div class="row" >
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="file" id="files" {{-- onchange="photos(this)" --}} multiple  name="files[]" class="form-control photos" placeholder="Add photos">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="information">Type</label>
                                                </div>
                                                <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="btype" id="btypefree" value="0" checked="checked">Free
                                                  </label>
                                                </div>
                                                <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="btype" id="btypepremium" value="1">Premium
                                                  </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group err_flanguage">
                                                  <label for="flanguage">Select Language:</label>
                                                  <select class="form-control" name="flanguage[]" id="flanguage">
                                                    <option value="">Select Language</option>
                                                    @foreach($language as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="fsubcategory">Select Sub Category:</label>
                                                  <select class="form-control" name="fsubcategory[]" id="fsubcategory" required>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="ffestivalId">Select Festival:</label>
                                                  <select class="form-control festivals_select" name="ffestivalId[]" id="ffestivalId" required>
                                                    <option value="0">Select Festival</option>
                                                    @foreach($festivals as $festival)
                                                        <option value="{{$festival->fest_id}}">{{$festival->fest_name}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="category-btn" onclick="addcategory()">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showcategorylist()">Cancel</button>
            </div>
             </form>
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
                    <input type="hidden" name="business_category_id" id="business_category_id" value="">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group err_sub_category_name err_business_category_id">
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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/businesscategory.js?v='.rand()) }}"></script>
    <script>
        $(".photos").on("change", function(e) {
            var object = $(this).parent('div');
            $(object).children('span.pip').remove();
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $(object).prepend("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/>" +
            "</span>");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });


        });
        fileReader.readAsDataURL(f);
      }
    });
    //     function photos(e) {
    //     console.log(e.id);
    //     var pid = e.id.replace(/[^0-9]/g,'');
    //     var files = e.target.files,
    //     filesLength = files.length;
    //       for (var i = 0; i < filesLength; i++) {
    //         var f = files[i];
    //         var fileReader = new FileReader();
    //         fileReader.onload = (function(e) {
    //           var file = e.target;

    //             $('<span class="pip pip_'+pid+'">' +
    //             "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
    //             "<br/><span data-id=\""+pid+"\" class=\"remove\">Remove image</span>" +
    //             "</span>").insertBefore("#addphotos");
    //           $(".remove").click(function(){
    //             var remove = $(this).attr("data-id");
    //             if (remove == "")
    //             {
    //                 $('#files').val('');
    //             }
    //             $('.pip_'+remove).remove();
    //             $('.row_'+remove).remove();

    //           });


    //         });
    //         fileReader.readAsDataURL(f);
    //       }


    // }
</script>
@endsection
