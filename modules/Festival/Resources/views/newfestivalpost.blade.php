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
.form-check [type=checkbox]:checked, .form-check [type=checkbox]:not(:checked) {
    position: absolute !important;
    left: 10px !important;
    
}

</style>
<div class="page-header">
    <h4 class="page-title">Festival</h4>
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
            <a href="#">Festival</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" data-id="{{$fest_id}}" id="addfestival" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Festival</div>
            </div>
            <form id="countryform" name="countryform" action="{{route('addnewFestivalPost')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <!-- {{ csrf_field() }} -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="row">
                            	<div class="col-md-6">
                        		  	<div class="form-group">
		                            	<input type="hidden" name="festivalid" id="festivalid" value="">
		                                <label for="festivalname">Festival Name</label>
		                                <input type="text" class="form-control" id="festivalname" placeholder="Enter Festival Name" name="festivalname" required>
		                            </div>
                            	</div>
                            	<div class="col-md-6">
                        		  	<div class="form-group">
		                                <label for="ftype">Type</label>
		                               	<select name="ftype" id="ftype" class="form-control">
		                               		<option value="festival">Festival</option>
		                               		<option value="incident">Incident</option>
		                               	</select>
		                            </div>
                            	</div>
                            	
                            	<div class="col-md-6 festdatediv">
                        		  	<div class="form-group">
		                                <label for="festivaldate">Date</label>
		                                <input type="text" class="form-control" id="festivaldate" placeholder="date" name="festivaldate">
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
                                <div class="col-md-6">
                                    <label for="festivalname">Position</label>
                                        <input type="text" class="form-control" id="festivalposition" placeholder="Enter Position" name="festivalposition">
                                </div>
                                <div class="col-md-3">
                                    {{-- <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" name="new_cat" id="new_cat" class="form-check-input" value="1">New Category
                                      </label>
                                    </div> --}}
                                    <div class="form-check-inline">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="new_cat" name="new_cat" value="1">New Category
                                      </label>
                                    </div>
                                    <div class="form-check-inline">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="is_mark" name="new_cat" value="2">Is Highlight
                                      </label>
                                    </div>
                                    <div class="form-check-inline">
                                      <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="not_any" name="new_cat" value="0" checked>Not Any
                                      </label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" name="is_mark" id="is_mark" class="form-check-input" value="1">Is Highlight
                                      </label>
                                    </div>
                                </div> --}}
                                
                                <div class="col-md-12">
                                    <div class="form-group" id="showphotos">
                                        <div>
                                            <label class="active" for="files">Add Photos</label>
                                        </div>
                                        <div id="addphotos">
                                            <input type="file" class="form-control photos" id="files" name="files[]" multiple /><br>
                                        </div>
                                    </div>
                                </div>
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
                                                <div class="form-group">
                                                  <label for="flanguage">Select Language:</label>
                                                  <select class="form-control" name="flanguage" id="flanguage" required>
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
                                                  <select class="form-control" name="fsubcategory" id="fsubcategory" required>
                                                  </select>
                                                </div>
                                            </div>
                        </div>
                            {{-- <div class="form-group" id="showphotos">
                            <label for="addphotos">Add Photos</label></div>
                            <div id="addphotos">
                                <div class="row" >
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="file" id="files" onchange="photos(this)"  name="files[]" class="form-control photos" placeholder="Add photos">
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
                                                <div class="form-group">
                                                  <label for="flanguage">Select Language:</label>
                                                  <select class="form-control" name="flanguage[]" id="flanguage">
                                                    <option>Select Language</option>
                                                    @foreach($language as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
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
                            </div> --}}

                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="festival-btn" {{-- onclick="addFestival()" --}}>Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showfestivallist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>
    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Festival List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-3">
	        		  	<div class="form-group">
	            			<!-- <label for="getmonthdata">Date</label> -->
	                		<!--<input type="month" class="form-control" id="getmonthdata" name="getmonthdata" value="<?php echo date('Y-m'); ?>">-->
	                		<input type="month" class="form-control" id="getmonthdata" name="getmonthdata" value="">
	                	</div>
                	</div>
                	<div class="col-md-2">
	        		  	<div class="form-group">
	                		<button type="button" onclick="search_festival()" class="btn btn-primary form-control" id="search">Search</button>
	                	</div>
                	</div>
            	</div>
            
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="festival-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>type</th>
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
                <h4 class="card-title">Other Categories</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="incident-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <!--<th>Date</th>-->
                                <th>type</th>
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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/newfestivalpost.js?v='.rand()) }}"></script>
    <script>
        $(".photos").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertBefore("#addphotos");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          
        });
        fileReader.readAsDataURL(f);
      }
    });
   /* function photos(e) {
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
        
    }*/
    $('#festivaldate').datetimepicker({
			format: 'YYYY-MM-DD',
		});
		
		$('#ftype').change(function(){
		    if($(this).val() == 'festival'){
		        $('.festdatediv').show();
		    } else {
		         $('.festdatediv').hide();
		    }
		})
         
    </script>
@endsection