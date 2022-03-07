function permissionChange() {
	var user_role = $('#user_role').val();
	if(user_role != "") {
		changeUserRole(user_role);
	}
}

function changeUserRole(user_role) {
	$('.loader-custom').css('display','block');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/permission/changeUserRole",
		data:{user_role : user_role },
		success: function (data)
		{
			$('#permission_view').html(data['form']);
			$('#updatePermissionButton').show();
			$('.loader-custom').css('display','none');
		}
	});
}

function updatepermission(){
	$('.loader-custom').css('display','block');
 	var form = document.getElementById('permission_form');
	var formData = new FormData(form);

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$.ajax({
		type:'POST',
		url:APP_URL+"/permission/updatepermission",
		data: formData,
		contentType: false,
		processData : false,
		success: function (data)
		{
			$('.loader-custom').css('display','none');
			if(data['status']) {
				swal(
				  'Permission!',
				  data['message'],
				  'success'
				);
			}
			else {
				swal(
				  'Permission!',
				  data['message'],
				  'error'
				);
			}
		}
	});
}