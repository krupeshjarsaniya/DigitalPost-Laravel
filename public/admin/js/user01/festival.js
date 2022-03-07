$(document).ready(function() {
	// $('#festivaldate').datepicker({
	// 	 autoclose: true,
	// });

	var today = new Date().toISOString().split('T')[0];
	// document.getElementById("festivaldate")[0].setAttribute('min', today);
	$('#festivaldate').attr('min', today);

	search_festival();

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

function search_festival(){

    $('.loader-custom').css('display','block');
	var date = $('#getmonthdata').val();

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/searchfestival",
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

function addFestival(){
    
  

	var name = $('#festivalname').val();
	var date = $('#festivaldate').val();
	var info = $('#information').val();
	var ftype = $('#ftype').val();
 	var thumb = $('#fimage')[0].files[0];
 	// var imagess = $('#files')[0].files;
 	
 	if(name == '' || date == ''){
 	    (name == '') ? alert('Enter Festval Name') : '';
 	    (date == '') ? alert('Enter Festval Date') : '';
 	} else {
 	    
 	      $('.loader-custom').css('display','block');
 	    
     	data = new FormData();
        data.append('image', thumb);
        data.append('name', name);
        data.append('info', info);
        data.append('ftype', ftype);
        data.append('date', date);
    
     	let TotalImages = $('#files')[0].files.length;  //Total Images
        let images = $('#files')[0];  
    
    	for (let i = 0; i < TotalImages; i++) {
    		data.append('imagess[]', images.files[i]);
    	}
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/festival/addfestival",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			alert(data.message)
    			search_festival();
    			showfestivallist();
    			resetForm();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	}


}

function deleteFestival(id){

     $('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/festival/deletefestival",
		data: {
			"id":id,
		},
		success: function (data)
		{
			alert('Festival Remove successfully')
			search_festival();
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
		url:APP_URL+"/festival/getfestdetailforedit",
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
			$('#blah').attr('src', response.data['fest_image']);
// 			$('#festival-btn').attr('onclick', 'updatefestival()');

            $('#countryform').attr('action', 'http://festivalpost.in/admin/festival/updatefestival' );

			for (var i = 0; i < response.images.length; i++) {
				$("<span class=\"pip\">" +
		            "<img class=\"imageThumb\" src=\"" + response.images[i]['post_content'] + "\" />" +
		            "<br/><span class=\"remove\" onclick='removethisimgae("+response.images[i]['post_id']+")'>Remove image</span>" +
		            "</span>").insertAfter("#files");
		          $(".remove").click(function(){
		            $(this).parent(".pip").remove();
		          });
			}
			
			showinsertform();
			 $('.loader-custom').css('display','none');
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
		url:APP_URL+"/festival/removefestivalimage",
		data: {
			"id":imgid,
		},
		success: function (data)
		{
			search_festival();
		}
	});
}
function updatefestival(){
    
     $('.loader-custom').css('display','block');

	var id = $('#festivalid').val();
	var name = $('#festivalname').val();
	var date = $('#festivaldate').val();
	var info = $('#information').val();
	var ftype = $('#ftype').val();
 	var thumb = $('#fimage')[0].files[0];

	if(name == '' || date == ''){
 	    (name === '') ? alert('Enter Festval Name') : '';
 	    (date === '') ? alert('Enter Festval Date') : '';
 	} else {
     	data = new FormData();
        data.append('image', thumb);
        data.append('name', name);
        data.append('info', info);
        data.append('ftype', ftype);
        data.append('date', date);
        data.append('id',id);
    
     	let TotalImages = $('#files')[0].files.length;  //Total Images
        let images = $('#files')[0];  
    
    	for (let i = 0; i < TotalImages; i++) {
    		data.append('imagess[]', images.files[i]);
    	}
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/festival/updatefestival",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			resetForm();
    			search_festival();
    			showfestivallist();
    			 $('.loader-custom').css('display','none');
    		}
    	});
 	}
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
	
}