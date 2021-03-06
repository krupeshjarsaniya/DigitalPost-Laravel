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
            <a href="#">Business Category Video</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="addcategory">
        <div class="card">
            <div class="card-header">
                <div class="card-title" id="country-title">{{ $category->name }} Add Video</div>
            </div>
            <form id="buss_cat_form" name="buss_cat_form" action={{route('businesscategory.video.add')}} method="POST" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        @csrf
                        @foreach ($posts as $post)
                            <span class="pip">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img class="imageThumb" data-video="{{ Storage::url($post->video_url) }}" src="{{ Storage::url($post->video_thumbnail) }}" onclick="showvideo(this)" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="imgtype_{{$post->id}}" onchange="edittype({{ $post->id }},this)" class="form-check-input" @if($post->image_type == 0) checked="checked" @endif value="0">Free
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="imgtype_{{$post->id}}" onchange="edittype({{ $post->id }},this)" class="form-check-input" @if($post->image_type == 1) checked="checked" @endif value="1">Premium
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="flanguage">Select Language:</label>
                                            <select class="form-control" id="flanguage_{{$post->id}}" onchange="editlanguage({{ $post->id }},this)">
                                                <option value="">Select Language</option>
                                                @foreach($language as $value)
                                                    @if($value->id == $post->language_id)
                                                        <option selected value="{{$value->id}}">{{$value->name}}</option>
                                                    @else
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fsubcategory">Select Sub Category:</label>
                                            <select class="form-control" id="fsubcategory_{{$post->id}}" onchange="editsubcategory({{ $post->id }},this)">
                                                <option value="0">Select Sub Category</option>
                                                    @foreach($subcategory as $value)
                                                        @if($value->id == $post->business_sub_category_id)
                                                            <option selected value="{{$value->id}}">{{$value->name}}</option>
                                                        @else
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <span onclick="removeVideo(this)" data-id="{{$post->id}}" class="removevideo remove">Remove image</span>
                            </span>
                        @endforeach
                        <input type="hidden" name="business_category_id" value="{{$category->id}}">
                        <div class="form-group" id="showphotos">
                        <div id="addphotos">
                            <div class="row" >
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label >Thumbnail</label>
                                        <input type="file" class="form-control" id="files" name="files[]"onchange="photos(this)" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Video</label>
                                        <input type="file" class="form-control" id="video_file" name="video_file[]" required>
                                    </div>
                                    <div class="row">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="fsubcategory">Select Sub Category:</label>
                                              <select class="form-control" name="fsubcategory[]" id="fsubcategory" required>
                                                <option value="0">Select Sub Category</option>
                                                @foreach($subcategory as $value)
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action text-right">
                <button class="btn btn-success" type="submit"  id="category-btn">Submit</button>&nbsp;&nbsp;
                <button class="btn btn-danger"  type="button">Cancel</button>
            </div>
             </form>
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

@endsection

@section('js')
    {{-- <script type="text/javascript" src="{{ url('/public/admin/js/user/businesscategoryvideo.js') }}"></script> --}}
    <script>
        var p_id = 1;
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

    function removeVideo(ele) {
        var imgid = $(ele).data('id');
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
        $.ajax({
            type:'POST',
            url:APP_URL+"/businesscategory/video/delete",
            data: {
                "id":imgid,
            },
            success: function (data)
            {
                $(ele).parent(".pip").remove();
            }
        });
    }

    function addbox(){
        var op = $("#flanguage").html();
        var op1 = $("#fsubcategory").html();
        var field = '<div class="row rv row_'+p_id+'">\
                    <div class="col-md-8">\
                        <div class="form-group">\
                            <label >Thumbnail</label>\
                            <input type="file" onchange="photos(this)" class="form-control" id="files_'+p_id+'" name="files[]">\
                        </div>\
                        <div class="form-group">\
                             <label >Video</label>\
                             <input type="file" class="form-control" id="video_file_'+p_id+'" name="video_file[]">\
                        </div>\
                        <div class="row">\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <label for="information">Type</label>\
                                </div>\
                                <div class="form-check-inline">\
                                  <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="btype'+p_id+'" id="btypefree" value="0" checked="checked">Free\
                                  </label>\
                                </div>\
                                <div class="form-check-inline">\
                                  <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="btype'+p_id+'" id="btypepremium" value="1">Premium\
                                  </label>\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                  <label for="flanguage">Select Language:</label>\
                                  <select class="form-control" name="flanguage[]" id="flanguage_'+p_id+'" required>\
                                  </select>\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                  <label for="fsubcategory">Select Sub Category:</label>\
                                  <select class="form-control" name="fsubcategory[]" id="fsubcategory_'+p_id+'" required>\
                                    <option value="0">Select Sub Category</option>\
                                  </select>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="col-md-2 form-group">\
                        <button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>\
                        <button type="button" data-id="'+p_id+'" onclick="removebox(this)" class="btn btn-primary"><i class="fa fa-minus"></i></button>\
                    </div>\
                </div>';
        $('#addphotos').append(field);
        $("#flanguage_"+p_id).html(op);
        $("#fsubcategory_"+p_id).html(op1);
        p_id++;
    }

    function removebox(curr){
        //$(curr).closest('.row').remove();
        var remove = $(curr).attr("data-id");
        $('.pip_'+remove).remove();
        $('.row_'+remove).remove();
        p_id--;
    }

    function showvideo(ele) 
    {
        var src = $(ele).data('video');
        var data = "";
        data += '<video width="650" height="500" controls >';
        data += '<source src="'+src+'" type="video/mp4" >';
        data += '<source src="'+src+'" type="video/ogg" >';
        data += '</video>';
        $("#showvideomodel").html(data);
        $('#videomodel').modal('show');
    }

    function stopvideo() 
    {
        $('video').trigger('pause');
        $("#showvideomodel").html("");
        $('#videomodel').modal('hide'); 
    }

    function edittype(typeid, ele) 
    {
        var val_data = $('input[name="'+ele.name+'"]:checked').val()
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $.ajax({
            type:'POST',
            url:APP_URL+"/businesscategory/video/changeimagetype",
            data: {
                "id":typeid,
                "image_ty":val_data
            },
            success: function (data)
            {
                
            }
        });

    }
    function editlanguage(lid, ele) 
    {
        var val_data = $("#"+ele.id).val();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $.ajax({
            type:'POST',
            url:APP_URL+"/businesscategory/video/changelanguage",
            data: {
                "id":lid,
                "language_id":val_data
            },
            success: function (data)
            {
            }
        });

    }

    function editsubcategory(lid, ele) 
    {
        var val_data = $("#"+ele.id).val();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $.ajax({
            type:'POST',
            url:APP_URL+"/businesscategory/video/changesubcategory",
            data: {
                "id":lid,
                "sub_category_id":val_data
            },
            success: function (data)
            {
            }
        });

    }

</script>
@endsection