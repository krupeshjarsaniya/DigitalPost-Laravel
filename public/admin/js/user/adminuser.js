var table = $('#adminuser-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/user/getuser',
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		{data: 'name', name: 'name'},
		{data: 'email', name: 'email'},
		{data: 'user_role', name: 'user_role'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});

function showinsertform(){
	$('#addfestival').show();
	$('#viewfestival').hide();
	$('#userpassword').removeAttr('disabled', 'disabled');
	$('#con_password').removeAttr('disabled', 'disabled');
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

	$('#userid').val('');
	$('#fullname').val('');
	$('#email').val('');
	$('#mobile').val('');
	$('#userpassword').val('');
	$('#con_password').val('');
	
	$('#blah').attr('src', '#');
	$('#festival-btn').attr('onclick', 'addadminuser()');
	
}






function addadminuser(){
    
	
 	
 	    $('.loader-custom').css('display','block');
 	    
     	var form = document.getElementById('adminuser');
    	var formData = new FormData(form);
        
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/user/adduser",
    		data: formData,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
    			$('.loader-custom').css('display','none');
    			if(data.status == 401)
	            {

	                $.each(data.error1, function(index, value) 
	                {

	                  if (value.length != 0)

	                    {

	                    $('.err_'+index).append('<span class="alerts">'+value+'</span>');

	                  }

	                });

	            }

	            if (data.status == 1) 
	            {
	            	location.reload();

	            }
    		}
    	});



}

function blockUser(id)
{
	swal({
		title: 'Are you sure?',
		text: "Block this user",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Bolck it!',
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
				url:APP_URL+"/user/block-users",
				data: {"id":id},
				success: function (data)
				{
					if (data.status==1)
					{
					    $('#adminuser-table').DataTable().draw();
					  
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

function unblockUser(id)
{
	swal({
		title: 'Are you sure?',
		text: "UnBlock this user",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Bolck it!',
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
				url:APP_URL+"/user/unblock-users",
				data: {"id":id},
				success: function (data)
				{
					if (data.status==1)
					{
					    $('#adminuser-table').DataTable().draw();
					  
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


function removeUser(id)
{
	swal({
		title: 'Are you sure?',
		text: "Delete this user",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Bolck it!',
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
				url:APP_URL+"/user/removeUsers",
				data: {"id":id},
				success: function (data)
				{
					if (data.status==1)
					{
					    $('#adminuser-table').DataTable().draw();
					  
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
function viewDetail(id) 
{
	$('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'post',
		url:APP_URL+"/user/edit",
		data: {
			"id":id,
		},
		success: function (response)
		{	
			//getcountries();
            showinsertform();
            $('#fullname').val(response.data['name']);
			$('#email').val(response.data['email']);
			$('#user_role').val(response.data['user_role']);
			/*$('#userphone').val(response.data['mobile']);*/
			$('#userid').val(response.data['id']);
			// $('#userpassword').attr('disabled', 'disabled');
			// $('#con_password').attr('disabled', 'disabled');
            
            $('.loader-custom').css('display','none');
		}
	});
}