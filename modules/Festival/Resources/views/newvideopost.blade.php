@extends('admin.layouts.app')
@section('title', 'New Video')
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
    <h4 class="page-title">New Video</h4>
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
            <a href="#">New Video</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addVideo" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Video</div>
            </div>
            <form id="categotyform" name="categotyform" action={{route('addnewvideopost')}} method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">

                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="videoid" id="videoid" value="">
                                        <label for="videoname">video Name</label>
                                        <input type="text" class="form-control" id="videoname" placeholder="Enter video Name" name="videoname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ftype">Type</label>
                                        <select name="ftype" id="ftype" class="form-control" onchange="ChangeType()" >
                                            <option value="festival">festival</option>
                                            <option value="incident">Incident</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 festdatediv">
                                    <div class="form-group">
                                        <label for="videodate">Date</label>
                                        <input type="text" class="form-control" id="videodate" placeholder="date" name="videodate" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fimage">Image</label>
                                        <input type="file" class="form-control" onchange="readURL(this);" id="fimage" name="thumnail">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="information">Information</label>
                                        <textarea class="form-control" name="information" id="information" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img id="blah" src="#" id="fimage" alt="your image" height="100" width="100" />
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                                    <div class="input-field form-group">
                                        <label class="active" for="files">Photos</label>
                                        <input type="file" id="files" name="files[]" multiple /><br>
                                    </div>
                                </div> --}}
                        </div>
                            <div class="form-group" id="showphotos">
                            <label for="addphotos">Add Videos</label></div>
                            <div id="addphotos">
                                <div class="row" >
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label >Thumbnail</label>
                                            <input type="file" class="form-control" id="files" name="files[]"onchange="photos(this)">
                                        </div>
                                        <div class="form-group">
                                            <label >Video</label>
                                            <input type="file" class="form-control" id="video_file" name="video_file[]">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="videoname">Color</label>
                                                    <input type="text" class="form-control" id="videocolor" placeholder="Enter color" name="videocolor[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="flanguage">Select Language:</label>
                                                  <select class="form-control" name="flanguage[]" id="flanguage" required>
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
                                                  <label for="fvideomode">Select Mode:</label>
                                                  <select class="form-control" name="fvideomode[]" id="fvideomode" required>
                                                      <option value="light">Light</option>
                                                      <option value="dark">Dark</option>
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
                <button class="btn btn-success" type="submit"  id="video-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showvideolist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>

    <div class="col-md-12" id="viewVideosList">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Fastival Video List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-video"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="video-post-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Information</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Incident Video List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="video-post-tables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Information</th>
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

<div class="modal" id="videomodel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Video</h4>
        <button type="button"  class="close" onclick="stopvideo()">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="text-center" id='showvideomodel'>

        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="stopvideo()" {{-- data-dismiss="modal" --}}>Close</button>
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
                    <input type="hidden" name="festival_id" id="festival_id" value="">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group err_sub_category_name err_festival_id">
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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/newvideo.js?v='.rand()) }}"></script>
    <script>
        function photos(e) {
        console.log(e.id);
        var pid = e.id.replace(/[^0-9]/g,'');
        var files = $("#"+e.id)[0].files[0];

        var f = files;
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;

            $('<span class="pip pip_'+pid+'">' +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span data-id=\""+pid+"\" class=\"remove\">Remove image</span>" +
            "</span>").insertBefore("#addphotos");
          $(".remove").click(function(){
            var remove = $(this).attr("data-id");
            if (remove == "")
            {
                $('#files').val('');
            }
            $('.pip_'+remove).remove();
            $('.row_'+remove).remove();

          });


        });
        fileReader.readAsDataURL(f);

    }

    $('#ftype').change(function(){
            if($(this).val() == 'festival'){
                $('.festdatediv').show();
            } else {
                 $('.festdatediv').hide();
            }
        })
    </script>
@endsection
