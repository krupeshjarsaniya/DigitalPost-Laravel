var p_id = 1;
var vp_data = [];
var subcategorytable = "";
var table = "";
var festival_id_dropdown = "";

$(document).ready(function() {

    search_category();
    festival_id_dropdown = $('#ffestivalId').html();
    $('#ffestivalId').select2();

});

function showinsertform() {
    $('#fsubcategory').html('<option value="0">Select Sub Category</option>');
    $('#addcategory').show();
    $('#viewcategory').hide();
}

function showcategorylist() {
    $('#addcategory').hide();
    $('#viewcategory').show();
    resetForm();
}

function resetForm() {

    $('#categoryname').val('');
    $('#categoryid').val('');
    $("span.pip").remove();
    $('#category-btn').attr('onclick', 'addcategory()');
    $('#country-title').text('Add Category');
    $(".rv").remove();
    $('#flanguage').attr('required', 'required');
    $('#btypefree').attr('checked', 'checked');
    $('#flanguage').val("");
    $('#fimage').val("");
    $('#blah').attr('src', '#');



}

function search_category() {
    if (table != "") {
        table.destroy();
    }
    table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL + '/businesscategory/categorylist',
        deferRender: false,
        columns: [
            { data: 'DT_RowIndex', name: 'business_category.id' },
            { data: 'name', name: 'name' },
            { data: 'free_business', name: 'free_business' },
            { data: 'premium_business', name: 'premium_business' },
            { data: 'image', name: 'image' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    /* $('.loader-custom').css('display','block');
	var date = "";

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/businesscategory/categorylist",
		data: {
			"date":date,
		},
		success: function (response)
		{
			$('#category-table tbody').html(response.data);

			$('#category-table').DataTable();

			$('.loader-custom').css('display','none');

		}
	}); */
}

function addcategory() {



    var name = $('#categoryname').val();
    var categoryid = $('#categoryid').val();
    var img = $('#fimage').val();
    var set = "";
    if (categoryid == "") {
        if (img == '') {
            (img == '') ? alert('Select Image'): '';
            set = 1;
        }
    }
    if (name == '') {
        (name == '') ? alert('Enter category Name'): '';
    } else {
        if (set != 1) {

            $('.loader-custom').css('display', 'block');
            var form = document.getElementById('buss_cat_form');
            data = new FormData(form);
            /* data.append('categoryname', name);
             data.append('categoryid', categoryid);*/


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: APP_URL + "/businesscategory/addcategory",
                data: data,
                contentType: false,
                processData: false,
                success: function(data) {
                    //alert(data.message)
                    if (data.status == 401) {
                        $('.loader-custom').css('display', 'none');
                        $.each(data.error1, function(index, value) {

                            if (value.length != 0)

                            {

                                $('.err_' + index).append('<span class="alerts">' + value + '</span>');

                            }

                        });

                    }

                    if (data.status == 1) {
                        // resetForm();
                        // search_category();
                        // showcategorylist();
                        $('.loader-custom').css('display', 'none');
                        location.reload(true);
                    }
                }
            });
        }


    }

}

function editcategory(id) {

    $('.pip').remove();

    $('.loader-custom').css('display', 'block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/getcategoryforedit",
        data: {
            "id": id,
        },
        success: function(response) {

            $('#categoryname').val(response.data['name']);
            $('#categoryid').val(response.data['id']);
            $('#blah').attr('src', SPACE_STORE_URL + '' + response.data['image']);
            $('#country-title').text('Edit Category');
            $("#flanguage").removeAttr('required');
            $("#fsubcategory").html('');
            var option = '<option value="0">Select Sub Category:</option>';
            for (var i = 0; i < response.categories.length; i++) {
                option += '<option value="' + response.categories[i]['id'] + '">' + response.categories[i]['name'] + '</option>';
            }
            $("#fsubcategory").html(option);
            for (var i = 0; i < response.images.length; i++) {
                $("<span class=\"pip\">" +
                    '<div class="row">' +
                    '<div class="col-md-5">' +
                    "<img class=\"imageThumb\" src=\"" + SPACE_STORE_URL + '' + response.images[i]['post_thumb'] + "\" />" +
                    '<br /><span><a class="btn btn-primary btn-sm" target="_blank" href="' + SPACE_STORE_URL + '' + response.images[i]['thumbnail'] + '">View Original</a></span>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<div class="form-check">' +
                    '<label class="form-check-label">' +
                    '<input type="radio" onchange="edittype(' + response.images[i]['id'] + ',this)" class="form-check-input" name="btype' + i + '" id="btypefree' + i + '" value="0" checked="checked">Free' +
                    '</label>' +
                    '</div>' +
                    '<div class="form-check">' +
                    '<label class="form-check-label">' +
                    '<input type="radio" onchange="edittype(' + response.images[i]['id'] + ',this)" class="form-check-input" name="btype' + i + '" id="btypepremium' + i + '" value="1">Premium' +
                    '</label>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<div class="form-group">' +
                    '<label for="flanguage">Select Language:</label>' +
                    '<select class="form-control" name="flanguage' + i + '" id="editflanguage_' + i + '" onchange="editlanguage(' + response.images[i]['id'] + ',this)">' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<div class="form-group">' +
                    '<label for="fsubcategory">Select Sub Category:</label>' +
                    '<select class="form-control" name="fsubcategory' + i + '" id="editsubcategory_' + i + '" onchange="editsubcategory(' + response.images[i]['id'] + ',this)">' +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    '<div class="col-md-12">' +
                    '<div class="form-group">' +
                    '<label for="ffestivalId">Select Festival:</label>' +
                    '<select class="form-control" name="ffestivalId' + i + '" id="editffestivalId_' + i + '" onchange="editffestivalId(' + response.images[i]['id'] + ',this)">' +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '<div class="col-md-12">' +
                    '</div>' +
                    "<br/><span class=\"remove\" onclick='removethisimgae(" + response.images[i]['id'] + ")'>Remove image</span>" +
                    "</span>").insertBefore("#showphotos");
                $(".remove").click(function() {
                    $(this).parent(".pip").remove();
                });
                var opn = $("#flanguage").html();
                $("#editflanguage_" + i).html(opn);
                $("#editflanguage_" + i).val(response.images[i]['language_id'])
                var opn1 = $("#fsubcategory").html();
                $("#editsubcategory_" + i).html(opn1);
                $("#editsubcategory_" + i).val(response.images[i]['business_sub_category_id'])
                var opn2 = $("#ffestivalId").html();
                $("#editffestivalId_" + i).html(opn2);
                $("#editffestivalId_" + i).val(response.images[i]['festival_id'])
                $("#editffestivalId_" + i).select2();
                var btype = response.images[i]['image_type'];
                if (btype == 1) {
                    $("#btypepremium" + i).attr('checked', 'checked');

                } else if (btype == 0) {
                    $("#btypefree" + i).attr('checked', 'checked');


                }

            }
            $('#addcategory').show();
            $('#viewcategory').hide();
            // showinsertform();
            $('.loader-custom').css('display', 'none');
        }
    });

}

function deletecategory(id) {

    $('.loader-custom').css('display', 'block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/deletecategory",
        data: {
            "id": id,
        },
        success: function(data) {
            if (data.status == 401) {
                alert('Please First Remove Images OR Video');
            }

            if (data.status == 200) {
                alert('category Remove successfully')
                search_category();
            }
            $('.loader-custom').css('display', 'none');
        }
    });
}

function addbox() {
    var op = $("#flanguage").html();
    var op1 = $("#fsubcategory").html();
    var op2 = $("#ffestivalId").html();
    var field = '<div class="row rv row_' + p_id + '">\
				<div class="col-md-8">\
					<div class="form-group">\
                        <label >Thumbnail</label>\
                        <input type="file" class="form-control photos" id="files_' + p_id + '" multiple name="files' + p_id + '[]">\
                    </div>\
					<div class="row">\
	                    <div class="col-md-6">\
	                        <div class="form-group">\
	                            <label for="information">Type</label>\
	                        </div>\
	                        <div class="form-check-inline">\
	                          <label class="form-check-label">\
	                            <input type="radio" class="form-check-input" name="btype' + p_id + '" id="btypefree" value="0" checked="checked">Free\
	                          </label>\
	                        </div>\
	                        <div class="form-check-inline">\
	                          <label class="form-check-label">\
	                            <input type="radio" class="form-check-input" name="btype' + p_id + '" id="btypepremium" value="1">Premium\
	                          </label>\
	                        </div>\
	                    </div>\
	                    <div class="col-md-6">\
	                        <div class="form-group err_flanguage' + p_id + '">\
	                          <label for="flanguage">Select Language:</label>\
	                          <select class="form-control" name="flanguage[]" id="flanguage_' + p_id + '" required>\
	                          </select>\
	                        </div>\
	                    </div>\
	                    <div class="col-md-6">\
	                        <div class="form-group err_fsubcategory' + p_id + '">\
	                          <label for="fsubcategory">Select Sub Category:</label>\
	                          <select class="form-control" name="fsubcategory[]" id="fsubcategory_' + p_id + '" required>\
	                          </select>\
	                        </div>\
	                    </div>\
                        <div class="col-md-6">\
	                        <div class="form-group err_fffestivalId' + p_id + '">\
	                          <label for="fffestivalId">Select Festival:</label>\
	                          <select class="form-control" name="fffestivalId[]" id="fffestivalId_' + p_id + '" required>\
	                          </select>\
	                        </div>\
	                    </div>\
	                </div>\
				</div>\
				<div class="col-md-2 form-group">\
					<button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>\
					<button type="button" data-id="' + p_id + '" onclick="removebox(this)" class="btn btn-primary"><i class="fa fa-minus"></i></button>\
				</div>\
			</div>';
    $('#addphotos').append(field);
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
                $(".remove").click(function() {
                    $(this).parent(".pip").remove();
                });


            });
            fileReader.readAsDataURL(f);
        }
    });
    $("#flanguage_" + p_id).html(op);
    $("#fsubcategory_" + p_id).html(op1);
    $("#fffestivalId_" + p_id).html(festival_id_dropdown);
    $("#fffestivalId_" + p_id).select2();
    //console.log($("#flanguage_"+p_id).html(op));
    p_id++;
}

function removebox(curr) {
    //$(curr).closest('.row').remove();
    var remove = $(curr).attr("data-id");
    $('.pip_' + remove).remove();
    $('.row_' + remove).remove();
    p_id--;
}

function edittype(typeid, ele) {
    var val_data = $('input[name="' + ele.name + '"]:checked').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/changeimagetype",
        data: {
            "id": typeid,
            "image_ty": val_data
        },
        success: function(data) {
            search_category();
        }
    });

}

function editlanguage(lid, ele) {
    var val_data = $("#" + ele.id).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/changelanguage",
        data: {
            "id": lid,
            "language_id": val_data
        },
        success: function(data) {
            search_category();
        }
    });

}

function editsubcategory(lid, ele) {
    var val_data = $("#" + ele.id).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/changesubcategory",
        data: {
            "id": lid,
            "sub_category_id": val_data
        },
        success: function(data) {
            search_category();
        }
    });

}

function editffestivalId(lid, ele) {
    var val_data = $("#" + ele.id).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/changefestival",
        data: {
            "id": lid,
            "festival_id": val_data
        },
        success: function(data) {
            search_category();
        }
    });
}

function removethisimgae(imgid) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/removebussinessCATimage",
        data: {
            "id": imgid,
        },
        success: function(data) {
            search_category();
        }
    });
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function addSubCategory(id) {
    $('#addSubCategoryModal').modal('show');
    $('#business_category_id').val(id);
    $('#sub_category_name').val("");
    if (subcategorytable) {
        subcategorytable.destroy();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    subcategorytable = $('#sub-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL + '/businesscategory/getSubCategory',
            type: "POST",
            data: { id }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
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
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/addSubCategory",
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function() {
            $('.loader-custom').css('display', 'block');
        },
        complete: function(data, status) {
            $('.loader-custom').css('display', 'none');
        },
        success: function(data) {
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
        buttons: {
            confirm: {
                text: 'Yes, Remove it!',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((result) => {
        if (result) {
            $('.loader-custom').css('display', 'block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: APP_URL + "/businesscategory/deleteSubCategory",
                data: { "id": id },
                success: function(data) {
                    alert(data.message);
                    subcategorytable.ajax.reload();
                    $('.loader-custom').css('display', 'none');
                }
            });
        } else {
            swal.close();
        }
    });
}

function editSubCategory(ele) {
    var business_category_id = $(ele).data('business-category-id');
    var sub_category_id = $(ele).data('sub-category-id');
    var sub_category_name = $("#name_" + sub_category_id).val();
    $('.loader-custom').css('display', 'block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: APP_URL + "/businesscategory/editSubCategory",
        data: { business_category_id, sub_category_id, sub_category_name },
        success: function(data) {
            if (!data.status) {
                alert(data.message);
            }
            $('.loader-custom').css('display', 'none');
        }
    });
}