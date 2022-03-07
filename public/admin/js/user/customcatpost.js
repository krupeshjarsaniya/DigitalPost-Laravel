$(document).ready(function() {

	// $('#custom_cat_id').on("change",function(){
	// 	alert($(this).val());
	// });
	getallcat();
    getallcatPost();

});
var table;
function getallcatPost(){
    table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/festival/getallcatpost',
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
		type:'GET',
		url:APP_URL+"/festival/getcatlist",
		success: function (response)
		{	
            // $('#categoryname').val(response.data['name']);
			// $('#categoryid').val(response.data['custom_cateogry_id']);
            
            let data = response.data;
            
            var list = $("#custom_cat_id");
            $.each(data, function(index, item) {
            list.append(new Option(item.name, item.custom_cateogry_id));
            });

            $('.loader-custom').css('display','none');
		}
	});
}

function readURL(input,id) {
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
		url:APP_URL+"/festival/getcatpostdetailforedit",
		data: {
			"id":id,
		},
		success: function (response)
		{	
			$('#categoryname').val(response.data['name']);
			$('#custom_cateogry_data_id').val(response.data['custom_cateogry_data_id']);
			$('#custom_cat_id').val(response.data['custom_cateogry_id']);

			$('#position_x').val(response.data['position_x']);
			$('#position_y').val(response.data['position_y']);
			$('#img_position_x').val(response.data['img_position_x']);
			$('#img_position_y').val(response.data['img_position_y']);
			$('#img_height').val(response.data['img_height']);
			$('#img_width').val(response.data['img_width']);

			$('#imageone').attr('src',response.data['image_one']);
			$('#bannerimg').attr('src',response.data['banner_image']);
			$('#imageone').css('display', 'block');
			$('#bannerimg').css('display', 'block');
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

	// var fileInput =  document.getElementById('fimage'); 
		
	// if(!fileValidation(fileInput)){
	// 	return false;
	// }

	// var fileInput =  document.getElementById('imgone'); 
		
	// if(!fileValidation(fileInput)){
	// 	return false;
	// }

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

	$('#imageone').attr('src','');
	$('#bannerimg').attr('src','');
  }
