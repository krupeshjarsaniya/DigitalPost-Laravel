var subcategorytable = '';
$(document).ready(function() {

	$('#imgposition').on("cut copy paste",function(e) {
		e.preventDefault();
	 });
    getallcat();
    

});
var table;
function getallcat(){
    table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/festival/getallcat',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'name', name: 'name'},
			{data: 'slider_img', name: 'slider_img'},
			{data: 'slider_img_position', name: 'slider_img_position'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}
function showinsertform(){
	$('#addCategory').show();
	$('#viewfestival').hide();
}

function showfestivallist(){
	$('#addCategory').hide();
	$('#viewfestival').show();
	resetForm();
}


function removeCat(id){

     $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/removeCat",
		data: {
			id:id,
		},
		success: function (data)
		{
            if(data.status == 401)
            {
                alert('Please First Remove Images');
            }

            if(data.status == 200)
            {
                table.destroy()
                alert('Category Removed successfully')
                getallcat();
            }
            $('.loader-custom').css('display','none');
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
		url:APP_URL+"/festival/getcatdetailforedit",
		data: {
			"id":id,
		},
		success: function (response)
		{	
            $('#categoryname').val(response.data['name']);
			$('#categoryid').val(response.data['custom_category_id']);

			$('#blah').attr('src', SPACE_STORE_URL+''+response.data['slider_img']);
			$('#blah').css('display','block');
			$('#imgposition').val(response.data['slider_img_position']);
			if(response.data['highlight'] == 0) {
				$('#no_highlight').attr('checked', 'checked');
			}
			if(response.data['highlight'] == 1) {
				$('#highlight_home').attr('checked', 'checked');
			}
			if(response.data['highlight'] == 2) {
				$('#highlight_greetings').attr('checked', 'checked');
			}
			if(response.data['highlight'] == 3) {
				$('#highlight_both').attr('checked', 'checked');
			}
            showinsertform();
			$('.loader-custom').css('display','none');
		}
	});

}

function readURL(input) {
	if (input.files && input.files[0]) {
	  var reader = new FileReader();
	  
	  reader.onload = function(e) {
		$('#blah').attr('src', e.target.result);
		$('#blah').css('display','block');
	  }
	  
	  reader.readAsDataURL(input.files[0]); // convert to base64 string
	}
}

function addCustomSubCategory(id) {
	$('#addSubCategoryModal').modal('show');
	$('#custom_category_id').val(id);
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
            url: APP_URL+'/festival/getSubCategoryTest',
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
		url:APP_URL+"/festival/addSubCategoryTest",
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
                url:APP_URL+"/festival/deleteSubCategoryTest",
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
	var custom_category_id = $(ele).data('custom-category-id');
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
        url:APP_URL+"/festival/editSubCategoryTest",
        data: {custom_category_id, sub_category_id, sub_category_name},
        success: function (data)
        {
        	if(!data.status) {
            	alert(data.message);
        	}
            $('.loader-custom').css('display','none');
        }
    });
}