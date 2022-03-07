$(document).ready(function() {
	
	search_language();

});

function showinsertform(){
	$('#addlanguage').show();
	$('#viewlanguage').hide();
}
function showlanguagelist(){
	$('#addlanguage').hide();
	$('#viewlanguage').show();
	resetForm();
}
function resetForm() {

	$('#languagename').val('');
	$("span.pip").remove();
	$('#fimage').val('');
	$('#blah').attr('src','#');
	$('#language-btn').attr('onclick', 'addlanguage()');
	
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


function search_language(){

    $('.loader-custom').css('display','block');
	var date = "";

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/language/languagelist",
		data: {
			"date":date,
		},
		success: function (response)
		{
			$('#language-table tbody').html(response.data);

			$('#language-table').DataTable();
			
			$('.loader-custom').css('display','none');

		}
	});
}

function addlanguage(){
    
  

	var name = $('#languagename').val();
	if(name == '' ){
 	    (name == '') ? alert('Enter Language Name') : '';
 	} else {
		var image = $("#fimage")[0].files;
 	  $('.loader-custom').css('display','block');
 	    
     	data = new FormData(countryform);
        // data.append('name', name);
        // data.append('thumnail', image);
        
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/language/addlanguage",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			//alert(data.message)
    			resetForm();
    			search_language();
    			showlanguagelist();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	
    }

}

function editlanguage(id) {
    
    $('.pip').remove();

 $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/language/getlanguageforedit",
		data: {
			"id":id,
		},
		success: function (response)
		{	

			$('#languagename').val(response.data['name']);
			$('#languageid').val(response.data['id']);
            $('#language-btn').attr('onclick', 'updatelanguage()' );
			$('#blah').attr('src',  SPACE_STORE_URL+''+response.data['image']);

			
			showinsertform();
			 $('.loader-custom').css('display','none');
		}
	});

}

function updatelanguage(){
    
  

	var name = $('#languagename').val();
	var l_id = $('#languageid').val();
	if(name == '' ){
 	    (name == '') ? alert('Enter Language Name') : '';
 	} else {
		var image = $("#fimage")[0].files;
		
 	  $('.loader-custom').css('display','block');
 	    
     	data = new FormData(countryform);
        // data.append('name', name);
        // data.append('l_id', l_id);
		// data.append('thumnail', image);
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/language/updatelanguage",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			//alert(data.message)
    			resetForm();
    			search_language();
    			showlanguagelist();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	
    }

}

function deletelanguage(id){

     $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/language/deletelanguage",
		data: {
			"id":id,
		},
		success: function (data)
		{
			alert('language Remove successfully')
			search_language();
			 $('.loader-custom').css('display','none');
		}
	});
}