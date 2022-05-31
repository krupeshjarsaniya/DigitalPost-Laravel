var p_id = 1;
var vp_data = [];
var store_url = SPACE_STORE_URL;
var subcategorytable = "";

$(document).ready(function() {
	$('#videodate').datetimepicker({
		format: 'YYYY-MM-DD',
	});
	var today = new Date().toISOString().split('T')[0];
	$('#videodate').attr('min', today);
    search_video();
});

function ChangeType()
{
	var date = $("#ftype").val();

	if (date == 'festival')
	{
		$("#videodate").attr('required', 'required');
	}
	else if (date == 'incident')
	{
		$("#videodate").removeAttr('required', 'required');
	}
}

function search_video(){

    $('.loader-custom').css('display','block');
    var date = "";
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/getVideoData",
		data: {
			"date":date,
		},
		success: function (response)
		{
			$('#video-post-table tbody').html(response.data);

			$('#video-post-table').DataTable();

			$('#video-post-tables tbody').html(response.incidents);

			$('#video-post-tables').DataTable();

			$('.loader-custom').css('display','none');

		}
	});
}

$('#festivaldate').datetimepicker({
    format: 'YYYY-MM-DD',
});

function showinsertform(){
	$('#fsubcategory').html('<option value="0">Select Sub Category</option>');
	$('#addVideo').show();
	$('#viewVideosList').hide();
}

function showvideolist(){
	$('#addVideo').hide();
	$('#viewVideosList').show();
	var p_id = 1;
	resetForm();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function resetForm() {

	$('#videoid').val('');
	$('#videoname').val('');
	$('#ftype').val('');
	$('#videodate').val('');
	$('#fimage').val('');
	$('#video_file').val('');
	$('#video_file').val('');
	$('#videocolor').val('');
	$('#blah').attr('src', '#');
	$("span.pip").remove();
	$(".rv").remove();
	$('#video-btn').attr('onclick', 'addFestival()');
	$('#flanguage').attr('required', 'required');

}

function removeVideo(id){
	swal({
		title: 'Are you sure?',
		text: "Remove this video",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Remove it!',
				className : 'btn btn-success'
			},
			cancel: {
				visible: true,
				className: 'btn btn-danger'
			}
		}
	}).then((block) => {
		if (block)
		{
		    $('.loader-custom').css('display','block');
			$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/festival/removenewvideo",
				data: {"id":id},
				success: function (data)
				{

					if(data.status == 401)
					{
						alert('Please First Remove Festival Videos')

					}

					if (data.status == 200)
					{
						location.reload();

					}
					$('.loader-custom').css('display','none');
				}
			});
		}
		else
		{
			swal.close();
		}
	});
}

function editVideoPost(id){
	$('.loader-custom').css('display','block');

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type:'POST',
        url:APP_URL+"/festival/get-newvideo-post-edit",
        data: {"id":id},
        success: function (response)
        {
            if (response.status)
            {
                var s_url = response.s_url;

                $('#videoname').val(response.data['video_name']);
                $('#videodate').val(response.data['video_date']);
                $('#information').val(response.data['video_info']);
                $('#ftype').val(response.data['video_type']);
                $('#videoid').val(response.data['video_id']);
                $('#blah').attr('src', SPACE_STORE_URL+''+response.data['video_image']);
                $("#flanguage").removeAttr('required');

                if (response.data['video_type'] == 'incident')
                {
                    $('.festdatediv').hide();
                    $("#videodate").removeAttr('required', 'required');
                    $("#videocolor").removeAttr('required', 'required');
                }
                showinsertform();
                var categories = '<option value="0">Select Sub Category</option>';
                for (var i = 0; i < response.categories.length; i++) {
                    categories += '<option value="' + response.categories[i]['id'] + '">' + response.categories[i]['name'] + '</option>';
                }
                $('#fsubcategory').html(categories);
                for (var i = 0; i < response.images.length; i++) {
                    $("<span class=\"pip\">" +
                        '<div class="row">'+
                        '<div class="col-md-5">'+
                        "<img class=\"imageThumb\" src=\""+SPACE_STORE_URL+''+response.images[i]['thumbnail'] + "\" onclick=\"showvideo("+i+")\" />" +
                        '</div>'+
                        '<div class="col-md-6">'+
                        '<div class="form-check">'+
                            '<label class="form-check-label">'+
                            '<input type="radio" onchange="edittype('+response.images[i]['id']+',this)" class="form-check-input" name="btype'+i+'" id="btypefree'+i+'" value="0" checked="checked">Free'+
                            '</label>'+
                        '</div>'+
                        '<div class="form-check">'+
                            '<label class="form-check-label">'+
                            '<input type="radio" onchange="edittype('+response.images[i]['id']+',this)" class="form-check-input" name="btype'+i+'" id="btypepremium'+i+'" value="1">Premium'+
                            '</label>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label for="flanguage">Select Language:</label>'+
                            '<select class="form-control" name="flanguage'+i+'" id="editflanguage_'+i+'" onchange="editlanguage('+response.images[i]['id']+',this)">'+
                            '</select>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label for="fsubcategory">Select Sub Category:</label>'+
                            '<select class="form-control" name="fsubcategory'+i+'" id="editfsubcategory_'+i+'" onchange="editsubcategory('+response.images[i]['id']+',this)">'+
                            '</select>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label for="fvideomode">Select Sub Category:</label>'+
                            '<select class="form-control" name="fvideomode'+i+'" id="editfvideomode_'+i+'" onchange="editvideomode('+response.images[i]['id']+',this)">'+
                            '<option value="light">Light</option>'+
                            '<option value="dark">Dark</option>'+
                            '</select>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label for="videoname">Color</label>'+
                            '<input type="text" class="form-control"  id="videocolor'+i+'" placeholder="Enter color" name="videocolor" value="'+response.images[i]['color']+'">'+
                            '<button type="button" class="btn btn-success" onclick="editcolor('+response.images[i]['id']+',this)"  id="videocolor_'+i+'">Update color</button>'+
                        '</div>'+
                        '</div>'+
                        "<br/><span class=\"remove\" onclick='removethisimgae("+response.images[i]['id']+")'>Remove image</span>" +
                        "</span>").insertBefore("#showphotos");
                        $(".remove").click(function(){
                        $(this).parent(".pip").remove();
                        });
                        var opn = $("#flanguage").html();
                        $("#editflanguage_"+i).html(opn);
                        $("#editflanguage_"+i).val(response.images[i]['language_id']);
                        var opn1 = $("#fsubcategory").html();
                        $("#editfsubcategory_"+i).html(opn1);
                        $("#editfsubcategory_"+i).val(response.images[i]['sub_category_id']);
                        $("#editfvideomode_"+i).val(response.images[i]['post_mode']);
                        var btype = response.images[i]['image_type'];
                        if (btype == 1)
                        {
                            $("#btypepremium"+i).attr('checked', 'checked');
                        }
                        else if (btype == 0)
                        {
                            $("#btypefree"+i).attr('checked', 'checked');
                        }
                        if(response.images[i]['video_store'] == "LOCAL") {
                            var vp_url = APP_URL+'/'+response.images[i]['video_url'];
                            vp_data.push(vp_url);
                        }
                        else {
                            var vp_url = SPACE_STORE_URL+''+response.images[i]['video_url'];
                            var vp_url = APP_URL+'/'+response.images[i]['video_url'];
                            vp_data.push(vp_url);
                        }
                }


            }
            $('.loader-custom').css('display','none');
        }
    });
}

function editcolor(cid, ele)
{
	var str = ele.id;
	var res = str.replace("_", "");
	var val_data = $("#"+res).val();
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/changeColor",
		data: {
			"id":cid,
			"color":val_data
		},
		success: function (data)
		{
			search_video();
		}
	});

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
		url:APP_URL+"/festival/changeimagetype",
		data: {
			"id":typeid,
			"image_ty":val_data
		},
		success: function (data)
		{
			search_video();
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
		url:APP_URL+"/festival/changelanguage",
		data: {
			"id":lid,
			"language_id":val_data
		},
		success: function (data)
		{
			search_video();
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
		url:APP_URL+"/festival/changesubcategory",
		data: {
			"id":lid,
			"sub_category_id":val_data
		},
		success: function (data)
		{
			search_video();
		}
	});

}

function editvideomode(lid, ele)
{
	var val_data = $("#"+ele.id).val();
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/changevideomode",
		data: {
			"id":lid,
			"post_mode":val_data
		},
		success: function (data)
		{
			search_video();
		}
	});

}

function  removethisimgae(imgid) {
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});
	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/newremovefestivalimage",
		data: {
			"id":imgid,
		},
		success: function (data)
		{
			search_video();
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
                                <label for="videocolor">Color</label>\
                                <input type="text" class="form-control" id="videocolor'+p_id+'" placeholder="Enter color" name="videocolor[]">\
                            </div>\
                        </div>\
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
                        <div class="col-md-4">\
                            <div class="form-group">\
                              <label for="fvideomode">Select Mode:</label>\
                              <select class="form-control" name="fvideomode[]" id="fvideomode_'+p_id+'" required>\
                                <option value="light">Light</option>\
                                <option value="dark">Dark</option>\
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
	console.log($("#flanguage_"+p_id).html(op));
	p_id++;
}

function removebox(curr){
	var remove = $(curr).attr("data-id");
	$('.pip_'+remove).remove();
    $('.row_'+remove).remove();
    p_id--;
}

function showvideo(ele)
{
	var data = "";
    data += '<video width="650" height="500" controls >';
    data += '<source src="'+vp_data[ele]+'" type="video/mp4" >';
    data += '<source src="'+vp_data[ele]+'" type="video/ogg" >';
    data += '</video>';
	$("#showvideomodel").html(data);
	$('#videomodel').modal('show');
}

function stopvideo()
{
	$('video').trigger('pause');
    $('#videomodel').modal('hide');
}


function addFestivalCategory(id) {
	$('#addSubCategoryModal').modal('show');
	$('#festival_id').val(id);
	$('#sub_category_name').val("");
	if(subcategorytable) {
        subcategorytable.destroy();
    }
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    subcategorytable = $('#sub-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/festival/getSubCategory',
            type: "POST",
            data: {id}
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function insertSubCategory() {
	$('span.alerts').remove();

    var form = document.addSubCategoryForm;

    var formData = new FormData(form);

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/addSubCategory",
		processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },
        success: function (data)
        {
            $('#sub_category_name').val('');
            subcategorytable.ajax.reload();
		}
	});
}

function deleteSubCategory(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this sticker",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, Remove it!',
                className : 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((result) => {
        if (result) {
            $('.loader-custom').css('display','block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:APP_URL+"/festival/deleteSubCategory",
                data: {"id":id},
                success: function (data)
                {
                    alert(data.message);
                    subcategorytable.ajax.reload();
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });
}

function editSubCategory(ele) {
	var festival_id = $(ele).data('festival-id');
	var sub_category_id = $(ele).data('sub-category-id');
	var sub_category_name = $("#name_" + sub_category_id).val();
	$('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/festival/editSubCategory",
        data: {festival_id, sub_category_id, sub_category_name},
        success: function (data)
        {
        	if(!data.status) {
            	alert(data.message);
        	}
            $('.loader-custom').css('display','none');
        }
    });
}
