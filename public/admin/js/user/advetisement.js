$(document).ready(function() {
	
	search_advetisement();

});

function showinsertform(){
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

function resetForm() {

	$('#fimage').val('');
	$('#advid').val('');
	$('#advlink').val('');
	$('#phone').val('');
	
	$('#blah').attr('src', '#');
	$('#festival-btn').attr('onclick', 'addAdvetisement()');
	
}


function search_advetisement(){

    $('.loader-custom').css('display','block');
	var date = "";

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/advetisement/searchadvetisement",
		data: {
			"date":date,
		},
		success: function (response)
		{
			$('#advetisement-table tbody').html(response.data);

			$('#advetisement-table').DataTable();

			
			$('.loader-custom').css('display','none');

		}
	});
}

function editadvetisement(id) {
    
    $('.pip').remove();

 $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/advetisement/geteditadvetisement",
		data: {
			"id":id,
		},
		success: function (response)
		{	

			$('#advid').val(response.data['id']);
			$('#phone').val(response.data['adv_number']);
			$('#advlink').val(response.data['adv_link']);
			
			
			$('#blah').attr('src', SPACE_STORE_URL+response.data['adv_image']);
			$('#festival-btn').attr('onclick', 'updateAdvetisement()');

			
			showinsertform();
			 $('.loader-custom').css('display','none');
		}
	});

}

function addAdvetisement(){
    
  

	
 	var thumb = $('#fimage')[0].files[0];
 	var img = $('#fimage').val();
 	var number = $('#phone').val();
 	var link = $('#advlink').val();


	
 	
 	if(img == '' ){
 	    (img == '') ? alert('Enter Image') : '';
 	    
 	} else {
 	    
 	      $('.loader-custom').css('display','block');
 	    
     	data = new FormData();
        data.append('thumnail', thumb);
        data.append('phone', number);
        data.append('advlink', link);
        
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/advetisement/addadvetisement",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			search_advetisement();
    			showfestivallist();
    			resetForm();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	}


}

function updateAdvetisement(){
    
  

	
 	var thumb = $('#fimage')[0].files[0];
 	var img = $('#fimage').val();
 	var number = $('#phone').val();
 	var link = $('#advlink').val();
 	var advid = $('#advid').val();

 	$('.loader-custom').css('display','block');
 	    
     	data = new FormData();
     	if (img != "") 
     	{
        	data.append('thumnail', thumb);
     	}
        data.append('phone', number);
        data.append('advlink', link);
        data.append('advid', advid);
        
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/advetisement/addadvetisement",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			search_advetisement();
    			showfestivallist();
    			resetForm();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	


}

function deleteadvetisement(id){
	swal({
		title: 'Are you sure?',
		text: "Remove this advetisement",
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
				url:APP_URL+"/advetisement/removeadvetisement",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    //location.reload();
					    search_advetisement();
					  
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