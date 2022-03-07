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
        ajax: APP_URL+'/festival/getallpoliticalcategory',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'pc_name', name: 'pc_name'},
			{data: 'free_business', name: 'pc_name', orderable: false, searchable: false},
			{data: 'premium_business', name: 'pc_name', orderable: false, searchable: false},
			{data: 'pc_image', name: 'pc_image'},
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
		url:APP_URL+"/festival/removePoliticalCategory",
		data: {
			id:id,
		},
		success: function (data)
		{
			if(data.status == 401)
			{
				alert('Plese Removed First Category in User')
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
		url:APP_URL+"/festival/getPoliticalCategoryforedit",
		data: {
			"id":id,
		},
		success: function (response)
		{	
            $('#categoryname').val(response.data['pc_name']);
			$('#categoryid').val(response.data['pc_id']);

			$('#blah').attr('src', SPACE_STORE_URL+''+response.data['pc_image']);
			$('#blah').css('display','block');
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
  