var p_id = 1;
var options = "";
$(document).ready(function() {

	getallcat();
    getallcatPost();

});

var table;
function getallcatPost(){
    table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/CustomCategorypost/getCustomeCategoryPost',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getallcat(){
    $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'post',
		url:APP_URL+"/CustomCategorypost/getcatlist",
		success: function (response)
		{
            let data = response.data;
            var list = $("#custom_cat_id");
            $.each(data, function(index, item) {
                list.append(new Option(item.name, item.custom_cateogry_id));
            });

            options = response.category;
            var list1 = $("#fsubcategory");
            list1.append(new Option('Select Sub Category', 0));
            $.each(options, function(index, item) {
                list1.append(new Option(item.name, item.id));
            });

            $('.loader-custom').css('display','none');
		}
	});
}

function readURL(input,id) {
	console.log(id);
    if (input.files && input.files[0]) {
        $('#'+id).attr('src', '');
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+id)
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
        $('#'+id).css('display', 'block');
        reader.readAsDataURL(input.files[0]);
    }
}

function showinsertform(){
	$('#addCategory').show();
	$('#viewfestival').hide();
}

function showfestivallist(){
	$('#addCategory').hide();
	$('#viewfestival').show();
	$(".r_h").show();
	var p_id = 1;
	resetForm();
}


function removeCatPost(id){

    $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/removeCatPost",
		data: {
			id:id,
		},
		success: function (data)
		{
            table.destroy()
			alert('Category Removed successfully')
            $('.loader-custom').css('display','none');
            getallcat();
		}
	});
}

function editCat(id) {

    $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/CustomCategorypost/editCustomeCategoryPost",
		data: {
			"id":id,
		},
		success: function (response)
		{

			var categories = '<option value="0">Select Sub Category</option>';
            for (var i = 0; i < response.subCategories.length; i++) {
            	categories += '<option value="' + response.subCategories[i]['id'] + '">' + response.subCategories[i]['name'] + '</option>';
            }
            $('#fsubcategory').html(categories);

			for (var i = 0; i < response.images.length; i++) {
				var bannerimg = "bannerimg"+i;
				var imageone = "imageone"+i;
                $('<div class="rv rv'+i+'"><hr />\
                    <form id="categotyformdata'+i+'" name="categotyformdata'+i+'"  enctype="multipart/form-data" >\
                    <div class="row  row_'+i+'">\
                    <div class="col-md-10">\
                        <div class="form-group">\
                            <label for="customcatid'+i+'">Category Name</label>\
                            <select name="customcatid" id="custom_cat_id'+i+'" class="form-control">\
                            </select>\
                        </div>\
                            <div class="row">\
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="position_x">Text Position X</label>\
                                        <input type="text" name="position_x" id="position_x'+i+'" class="form-control" value="'+response.images[i]['position_x']+'" >\
                                    </div>\
                                </div> \
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="position_y">Text Position Y</label>\
                                        <input type="text" name="position_y" id="position_y'+i+'" class="form-control" value="'+response.images[i]['position_y']+'" >\
                                    </div>\
                                </div>\
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="img_position_x">Image Position X</label>\
                                        <input type="text" name="img_position_x" id="img_position_x'+i+'" class="form-control" value="'+response.images[i]['img_position_x']+'" >\
                                    </div>\
                                </div> \
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="img_position_y">Image Position Y</label>\
                                        <input type="text" name="img_position_y" id="img_position_y'+i+'" class="form-control" value="'+response.images[i]['img_position_y']+'" >\
                                    </div>\
                                </div>\
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="img_height">Image Height</label>\
                                        <input type="text" name="img_height" id="img_height'+i+'" class="form-control" value="'+response.images[i]['img_height']+'" >\
                                    </div>\
                                </div> \
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="img_width">Image Width</label>\
                                        <input type="text" name="img_width" id="img_width'+i+'" class="form-control" value="'+response.images[i]['img_width']+'" >\
                                    </div>\
                                </div>                  \
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="fimage">Banner Image</label>\
                                        <input type="file" class="form-control" onchange="readURL(this,'+"'"+bannerimg+"'"+');" id="fimage'+i+'" name="bannerimg">\
                                        <img id="bannerimg'+i+'" src="'+SPACE_STORE_URL+''+response.images[i]['banner_image']+'" alt="your image" height="100" width="100" />\
                                    </div>\
                                </div>\
                                <div class="col-md-3">\
                                    <div class="form-group">\
                                        <label for="imgone">Image One</label>\
                                        <input type="file" class="form-control" onchange="readURL(this,'+"'"+imageone+"'"+');" id="imgone'+i+'" name="imageone">\
                                        <img id="imageone'+i+'" src="'+SPACE_STORE_URL+''+response.images[i]['image_one']+'" alt="your image" height="100" width="100" />\
                                    </div>\
                                </div>\
                            <div class="col-md-6">\
                                <div class="form-group">\
                                    <label for="information">Type</label>\
                                </div>\
                                <div class="form-check-inline">\
                                    <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="btype" id="btypefree'+i+'" value="0" checked="checked">Free\
                                    </label>\
                                </div>\
                                <div class="form-check-inline">\
                                    <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="btype" id="btypepremium'+i+'" value="1">Premium\
                                    </label>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group">\
                                    <label for="flanguage">Select Language:</label>\
                                    <select class="form-control" name="flanguage" id="editflanguage_'+i+'">\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group">\
                                    <label for="flanguage">Select Sub Category:</label>\
                                    <select class="form-control" name="fsubcategory" id="editfsubcategory_'+i+'">\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-md-6">\
                                <div class="form-group">\
                                    <label for="fimagemode">Select Mode:</label>\
                                    <select class="form-control" name="fimagemode" id="editfimagemode_'+i+'">\
                                    <option value="light">Light</option>\
                                    <option value="dark">Dark</option>\
                                    </select>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="col-md-2 form-group pp">\
                        <button type="button" data-id="'+response.images[i]['custom_cateogry_data_id']+'"  data-p-id="'+i+'" onclick="update(this)" class="btn btn-primary">Update</i></button>\
                        <button type="button" data-id="'+response.images[i]['custom_cateogry_data_id']+'" data-p-id="'+i+'" onclick="remove(this)" class="btn btn-danger">Remove</i></button>\
                    </div>\
                </div></form></div>').insertBefore("#showphotos");

                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });

                var opn = $("#flanguage").html();
                $("#editflanguage_"+i).html(opn);
                $("#editflanguage_"+i).val(response.images[i]['language_id'])
                var opn1 = $("#fsubcategory").html();
                $("#editfsubcategory_"+i).html(opn1);
                $("#editfsubcategory_"+i).val(response.images[i]['custom_sub_category_id']);
                $("#editfimagemode_"+i).val(response.images[i]['post_mode']);
                var btype = response.images[i]['image_type'];
                if (btype == 1)
                {
                    $("#btypepremium"+i).attr('checked', 'checked');
                }
                else if (btype == 0)
                {
                    $("#btypefree"+i).attr('checked', 'checked');
                }
                var list = $('#custom_cat_id').html();
                $("#custom_cat_id"+i).html(list);
                // var list = $("#custom_cat_id"+i);
                // $.each(options, function(index, item) {
                //     list.append(new Option(item.name, item.custom_cateogry_id));
                // });
                $('#custom_cat_id'+i).val(response.images[i]['custom_cateogry_id']);
			}
			$(".r_h").hide();
            showinsertform();
			$('.loader-custom').css('display','none');
		}
	});

}

function validateForm() {

	var position_x = document.forms["categotyform"]["position_x"].value;
	var position_y = document.forms["categotyform"]["position_y"].value;
	var img_position_x = document.forms["categotyform"]["img_position_x"].value;
	var img_position_y = document.forms["categotyform"]["img_position_y"].value;
	var img_height = document.forms["categotyform"]["img_height"].value;
	var img_width = document.forms["categotyform"]["img_width"].value;

	if (position_x.trim() == "" || position_y.trim() == "" || img_position_x.trim() == "" || img_position_y.trim() == "" || img_height.trim() == "" || img_width.trim() == "") {
	  alert("all Field is require");
	  return false;
	}
	return true;
}

function fileValidation(fileInput) {

	var filePath = fileInput.value;

	// Allowing file type
	var allowedExtensions = /(\.jpg|\.png|\.jpeg)$/i;

	if (!allowedExtensions.exec(filePath)) {
		alert('Invalid file type');
		fileInput.value = '';
		return false;
	}

	return true;
}

function resetForm(){
	$('#position_x').val('');
	$('#position_y').val('');
	$('#img_position_x').val('');
	$('#img_position_y').val('');
	$('#img_height').val('');
	$('#img_width').val('');
	$(".rv").remove();
	$('#imageone').attr('src','');
	$('#bannerimg').attr('src','');

}

function addbox(){
	var op = $("#flanguage").html();
	var op1 = $("#fsubcategory").html();
	var bannerimg = "bannerimg"+p_id;
	var imageone = "imageone"+p_id;
	var field = '<div class="row rv row_'+p_id+'">\
				<div class="col-md-10">\
                        <div class="row">\
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="position_x">Text Position X</label>\
                                    <input type="text" name="position_x[]" id="position_x'+p_id+'" class="form-control" required>\
                                </div>\
                            </div> \
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="position_y">Text Position Y</label>\
                                    <input type="text" name="position_y[]" id="position_y'+p_id+'" class="form-control" required>\
                                </div>\
                            </div>\
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="img_position_x">Image Position X</label>\
                                    <input type="text" name="img_position_x[]" id="img_position_x'+p_id+'" class="form-control" required>\
                                </div>\
                            </div> \
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="img_position_y">Image Position Y</label>\
                                    <input type="text" name="img_position_y[]" id="img_position_y'+p_id+'" class="form-control" required>\
                                </div>\
                            </div>\
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="img_height">Image Height</label>\
                                    <input type="text" name="img_height[]" id="img_height'+p_id+'" class="form-control" required>\
                                </div>\
                            </div> \
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="img_width">Image Width</label>\
                                    <input type="text" name="img_width[]" id="img_width'+p_id+'" class="form-control" required>\
                                </div>\
                            </div>                  \
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="fimage">Banner Image</label>\
                                    <input type="file" class="form-control" onchange="readURL(this,'+"'"+bannerimg+"'"+');" id="fimage'+p_id+'" name="bannerimg[]">\
                                    <img id="bannerimg'+p_id+'" src="#" alt="your image" height="100" width="100" style="display: none;"/>\
                                </div>\
                            </div>\
                            <div class="col-md-3">\
                                <div class="form-group">\
                                    <label for="imgone">Image One</label>\
                                    <input type="file" class="form-control" onchange="readURL(this,'+"'"+imageone+"'"+');" id="imgone'+p_id+'" name="imageone[]">\
                                    <img id="imageone'+p_id+'" src="#" alt="your image" height="100" width="100" style="display: none;"/>\
                                </div>\
                            </div>\
	                    <div class="col-md-6">\
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
	                    <div class="col-md-6">\
	                        <div class="form-group">\
	                          <label for="flanguage">Select Language:</label>\
	                          <select class="form-control" name="flanguage[]" id="flanguage_'+p_id+'" required>\
	                          </select>\
	                        </div>\
	                    </div>\
	                    <div class="col-md-6">\
                            <div class="form-group">\
                              <label for="fsubcategory">Select Sub Category:</label>\
                              <select class="form-control" name="fsubcategory[]" id="fsubcategory_'+p_id+'" required>\
                                <option value="0">Select Sub Category</option>\
                              </select>\
                            </div>\
                        </div>\
                        <div class="col-md-6">\
                            <div class="form-group">\
                              <label for="fimagemode">Select Mode:</label>\
                              <select class="form-control" name="fimagemode[]" id="fimagemode_'+p_id+'" required>\
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
	$(curr).closest('.row').remove();
    p_id--;
}

function update(ele)
{
	var id = $(ele).attr("data-id");
	var g_id = $(ele).attr("data-p-id");

	var form = document.getElementById('categotyformdata'+g_id);
    var formData = new FormData(form);
    formData.append('id', id);


	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/CustomCategorypost/updateCustomCategoryvalue",
		data: formData,
		contentType: false,
    	processData : false,
		success: function (data)
		{
    		alert('Custom Category Post Update successfully');
		}
	});
}
function remove(ele){
	var id = $(ele).attr("data-id");
	var g_id = $(ele).attr("data-p-id");

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
				url:APP_URL+"/CustomCategorypost/RemoveCustomCategoryvalue",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
						$(".rv"+g_id).remove();
					    showinsertform();

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


function changeStatus(ele, status) {
    var id = $(ele).attr("data-id");
    var status = status;
    swal({
        title: 'Are you sure?',
        text: "Change Status",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, Change it!',
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
                url:APP_URL+"/CustomCategorypost/changeStatus",
                data: {"id":id, "status":status},
                success: function (data)
                {
                    if (data.status)
                    {
                        table.ajax.reload();
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
