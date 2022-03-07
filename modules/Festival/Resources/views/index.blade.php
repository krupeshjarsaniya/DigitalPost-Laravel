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
    <div class="col-md-12" id="addfestival" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Festival</div>
            </div>
            <form id="countryform" name="countryform" action={{route('addfestival')}} method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        
                            @csrf
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
                                        <img id="blah" src="#" alt="your image" height="100" width="100" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-field form-group">
                                        <label class="active" for="files">Photos</label>
                                        <input type="file" id="files" name="files[]" multiple /><br>
                                    </div>
                                </div>
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
@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/festival.js?v='.rand()) }}"></script>
    <script>
        $("#files").on("change", function(e) {
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
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          
        });
        fileReader.readAsDataURL(f);
      }
    });
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