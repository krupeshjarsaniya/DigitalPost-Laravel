@extends('admin.layouts.app')
@section('title', 'language')
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
    <h4 class="page-title">Language</h4>
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
            <a href="#">Language</a>
        </li>
    </ul>
</div>
<div class="row">
	<div class="col-md-12" id="viewlanguage">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Language List
                <button type="button" onclick="showinsertform()" class="btn btn-info btn-sm pull-right" id="add-language"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="language-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
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
    <div class="col-md-12" id="addlanguage" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">Add Language</div>
            </div>
            <form id="countryform" name="countryform" {{-- action={{route('addlanguage')}} --}} method="POST" enctype='multipart/form-data' onsubmit="return false;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        
                            @csrf
                            <div class="row">
                            	<div class="col-md-6">
                        		  	<div class="form-group">
		                            	<input type="hidden" name="languageid" id="languageid" value="">
		                                <label for="languagename">Language Name</label>
		                                <input type="text" class="form-control" id="languagename" placeholder="Enter language Name" name="languagename" required>
		                            </div>
                            	</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="fimage">Image</label>
                                         <input type="file" class="form-control" onchange="readURL(this);" id="fimage" name="thumnail">
                                  </div>
                              </div>
                              <div class="col-md-6"></div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <img id="blah" src="#"  alt="your image" height="100" width="100" />
                                </div>
                            </div>
                            </div>
                       
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="language-btn" onclick="addlanguage()">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button" onclick="showlanguagelist()">Cancel</button>
            </div>
             </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/language.js') }}"></script>
    
@endsection