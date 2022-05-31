var subcategorytable = "";
$(document).ready(function() {
	// $('#festivaldate').datepicker({
	// 	 autoclose: true,
	// });

	var today = new Date().toISOString().split('T')[0];
	// document.getElementById("festivaldate")[0].setAttribute('min', today);
	$('#festivaldate').attr('min', today);

	search_festival();

});
var default_fest_id = $('#addfestival').data('id');
if(default_fest_id != 0) {
	editFestival(default_fest_id);
}

function showinsertform(){
	$('#fsubcategory').html('<option value="0">Select Sub Category</option>');
	$('#addfestival').show();
	$('#viewfestival').hide();
}

function showfestivallist(){
	$('#addfestival').hide();
	$('#viewfestival').show();
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

function search_festival(){

    $('.loader-custom').css('display','block');
	var date = $('#getmonthdata').val();

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/FestivalPost/getFestivalPostData",
		data: {
			"date":date,
		},
		success: function (response)
		{
			$('#festival-table tbody').html(response.data);

			$('#festival-table').DataTable();

			$('#incident-table tbody').html(response.incidents);

			$('#incident-table').DataTable();

			$('.loader-custom').css('display','none');

		}
	});
}

function editFestival(id) {

    $('.pip').remove();

 $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/FestivalPost/get-newFestivalPost-edit",
		data: {
			"id":id,
		},
		success: function (response)
		{

			$('#festivalname').val(response.data['fest_name']);
			$('#festivaldate').val(response.data['fest_date']);
			$('#information').val(response.data['fest_info']);
			$('#ftype').val(response.data['fest_type']);
			$('#festivalid').val(response.data['fest_id']);
			$('#festivalposition').val(response.data['position_no']);
			if(response.data['new_cat'] === 1)
			{
				//alert(response.data['new_cat']);
				$('#new_cat').attr('checked', 'checked');
			}
			else if(response.data['new_cat'] === 2)
			{
				$('#is_mark').attr('checked', 'checked');
			}
			else(response.data['new_cat'] === 0)
			{
				$('#not_any').attr('checked', 'checked');
			}
			/*if(response.data['is_mark'] === 1)
			{
				$('#is_mark').attr('checked', 'checked');
			}*/
			/*$('#flanguage').val(response.data['language_id']);
			var btype = response.data['btype'];
			if (btype == 1)
			{
				$("#btypepremium").attr('checked', 'checked');

			}
			else if (btype == 0)
			{
				$("#btypefree").attr('checked', 'checked');


			}*/
			var s_url = response.s_url;
			$('#blah').attr('src',  SPACE_STORE_URL+''+response.data['fest_image']);
// 			$('#festival-btn').attr('onclick', 'updatefestival()');
			$("#flanguage").removeAttr('required');
			showinsertform();
            //$('#countryform').attr('action', 'http://digitalpost365.com/admin/FestivalPost/FestivalPostUpdates' );
            var categories = '<option value="0">Select Sub Category</option>';
            for (var i = 0; i < response.categories.length; i++) {
            	categories += '<option value="' + response.categories[i]['id'] + '">' + response.categories[i]['name'] + '</option>';
            }
            $('#fsubcategory').html(categories);

			for (var i = 0; i < response.images.length; i++) {
				$("<span class=\"pip\">" +
					'<div class="row">'+
					'<div class="col-md-5">'+
		            "<img class=\"imageThumb\" src=\"" +SPACE_STORE_URL+""+ response.images[i]['post_thumb'] + "\" />" +
		            '<br /><span><a class="btn btn-primary btn-sm" target="_blank" href="'+SPACE_STORE_URL+''+ response.images[i]['post_content']+'">View Original</a></span>' +
		            '</div>'+
		            '<div class="col-md-6">'+
		            '<div class="form-check">'+
                      '<label class="form-check-label">'+
                        '<input type="radio" onchange="edittype('+response.images[i]['post_id']+',this)" class="form-check-input" name="btype'+i+'" id="btypefree'+i+'" value="0" checked="checked">Free'+
                      '</label>'+
                    '</div>'+
                    '<div class="form-check">'+
                      '<label class="form-check-label">'+
                        '<input type="radio" onchange="edittype('+response.images[i]['post_id']+',this)" class="form-check-input" name="btype'+i+'" id="btypepremium'+i+'" value="1">Premium'+
                      '</label>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12">'+
                    '<div class="form-group">'+
                      '<label for="flanguage">Select Language:</label>'+
                      '<select class="form-control" required="required name="flanguage'+i+'" id="editflanguage_'+i+'" onchange="editlanguage('+response.images[i]['post_id']+',this)">'+
                      '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12">'+
                    '<div class="form-group">'+
                      '<label for="flanguage">Select Sub Category:</label>'+
                      '<select class="form-control" required="required name="fsubcategory'+i+'" id="editfsubcategory_'+i+'" onchange="editsubcategory('+response.images[i]['post_id']+',this)">'+
                      '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12">'+
                    '<div class="form-group">'+
                      '<label for="fimagemode">Select Sub Category:</label>'+
                      '<select class="form-control" required="required name="fimagemode'+i+'" id="editfimagemode_'+i+'" onchange="editimagemode('+response.images[i]['post_id']+',this)">'+
                      '<option value="light">Light</option>'+
                      '<option value="dark">Dark</option>'+
                      '</select>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12">'+
		            '</div>'+
		            "<br/><span class=\"remove\" onclick='removethisimgae("+response.images[i]['post_id']+")'>Remove image</span>" +
		            "</span>").insertBefore("#showphotos");
		          $(".remove").click(function(){
		            $(this).parent(".pip").remove();
		          });
		          var opn = $("#flanguage").html();
					$("#editflanguage_"+i).html(opn);
					$("#editflanguage_"+i).val(response.images[i]['language_id'])
					$("#editfimagemode_"+i).val(response.images[i]['post_mode'])

				var opn1 = $("#fsubcategory").html();
					$("#editfsubcategory_"+i).html(opn1);
					$("#editfsubcategory_"+i).val(response.images[i]['sub_category_id'])
		          var btype = response.images[i]['image_type'];
					if (btype == 1)
					{
						$("#btypepremium"+i).attr('checked', 'checked');

					}
					else if (btype == 0)
					{
						$("#btypefree"+i).attr('checked', 'checked');


					}
			}


			 $('.loader-custom').css('display','none');
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
		url:APP_URL+"/FestivalPost/changeimagetypefestivalpost",
		data: {
			"id":typeid,
			"image_ty":val_data
		},
		success: function (data)
		{
			search_festival();
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
		url:APP_URL+"/FestivalPost/changelanguagefestivalpost",
		data: {
			"id":lid,
			"language_id":val_data
		},
		success: function (data)
		{
			search_festival();
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
		url:APP_URL+"/FestivalPost/changesubcategoryfestivalpost",
		data: {
			"id":lid,
			"sub_category_id":val_data
		},
		success: function (data)
		{
			search_festival();
		}
	});

}

function editimagemode(lid, ele)
{
	var val_data = $("#"+ele.id).val();
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/FestivalPost/changepostmodefestivalpost",
		data: {
			"id":lid,
			"post_mode":val_data
		},
		success: function (data)
		{
			search_festival();
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
		url:APP_URL+"/FestivalPost/newremovefestivalpostimage",
		data: {
			"id":imgid,
		},
		success: function (data)
		{
			search_festival();
		}
	});

}

function deleteFestival(id){

    $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/FestivalPost/removenewFestivalPost",
		data: {
			"id":id,
		},
		success: function (data)
		{
			$('.loader-custom').css('display','none');

			if(data.status == 401)
			{
				alert('Please First Remove Festival Images')
			}

			if(data.status == 200)
			{
				alert('Festival Remove successfully')
				search_festival();
			}
		}
	});
}

function resetForm() {

	$('#festivalname').val('');
	$('#festivaldate').val('');
	$('#information').val('');
	$('#ftype').val('');
	$('#festivalid').val('');
	$('#blah').attr('src', '#');
	$("span.pip").remove();
	$('#festival-btn').attr('onclick', 'addFestival()');
	$('#flanguage').attr('required', 'required');

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
            url: APP_URL+'/FestivalPost/getSubCategory',
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
		url:APP_URL+"/FestivalPost/addSubCategory",
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
                url:APP_URL+"/FestivalPost/deleteSubCategory",
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
        url:APP_URL+"/FestivalPost/editSubCategory",
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
