@extends('admin.layouts.app')
@section('title', 'Advetisement')
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
    <h4 class="page-title">Advetisement</h4>
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
            <a href="#">Advetisement</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addfestival" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Advetisement</div>
            </div>
            <form id="countryform" name="countryform" {{-- action={{route('addadvetisement')}} --}} onsubmit="return false;" method="post" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        
                            @csrf
                            <div class="row">
                            	<div class="col-md-4">
                            		<input type="hidden" name="advid" id="advid" value="" placeholder="">
                        		  	<div class="form-group">
		                                <label for="fimage">Image</label>
		                               	<input type="file" class="form-control" onchange="readURL(this);" id="fimage" name="thumnail" >
		                            </div>
                            	</div>
                            	<div class="col-md-4">
                        		  	<div class="form-group">
		                                <label for="advnumber">Number</label>
		                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Number" >
		                            </div>
                            	</div>
                            	<div class="col-md-4">
                        		  	<div class="form-group">
		                                <label for="advlink">Link</label>
		                               	<input type="url" class="form-control" id="advlink" placeholder="Enter Link" name="advlink" >
		                            </div>
                            	</div>
                            	<div class="col-md-4">
                                    <div class="form-group">
                                        <img id="blah" src="#" id="fimage" alt="your image" height="100" width="100" />
                                    </div>
                                </div>
                            	
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="festival-btn" onclick="addAdvetisement()">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showfestivallist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>
    <div class="col-md-12" id="viewfestival">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Advetisement List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-festival"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="advetisement-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Number</th>
                                <th>Link</th>
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
    <script type="text/javascript" src="{{ url('/public/admin/js/user/advetisement.js?v='.rand()) }}"></script>
@endsection