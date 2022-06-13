var allpost = "";

getAllpost();

var table = $('#user-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/user/view-user',
	deferRender: false,
    columns: [
        {data: 'DT_RowIndex', name: 'users.id'},
		{data: 'name', name: 'name'},
		{data: 'email', name: 'email'},
		{data: 'mobile', name: 'mobile'},
		{data: 'user_credit', name: 'user_credit'},
		{data: 'remaining_referral_amount', name: 'remaining_referral_amount', orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});

function getAllpost() {
	if(allpost != "") {
		allpost.destroy();
	}
	allpost = $('#allpost-table').DataTable({
	    processing: true,
	    serverSide: true,
	    ajax: APP_URL+'/user/allpostlist',
	    order: [[ 6, "desc" ]],
	    columns: [
	        {data: 'DT_RowIndex', name: 'photos.photo_id'},
	        {data: 'name', name: 'users.name'},
	        {data: 'mobile', name: 'users.mobile'},
	        {data: 'total', name: 'users.total_post_download'},
			{data: 'photo_url', name: 'photo_url'},
			{data: 'telecaller', name: 'users.tel_user'},
			{data: 'date_added', name: 'date_added'},
	    ]
	});
}



var current_userid = 0;

function PalnListsID()
{
	$("#planlist").html('');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $('.loader-custom').css('display','block');

    $.ajax({
        type:'POST',
        url:APP_URL+"/user/plan-list",
        success: function(respose)
        {
            let data = respose.data;
            var list = $("#planlist");
            list.append('<option value="" selected="selected" disabled>Select Paln</option>');
            $.each(data, function(index, item) {
            list.append(new Option(item.plan_or_name, item.plan_id));
            });

            $('.loader-custom').css('display','none');
        }
    });
}

function backtolist(){
	$('#viewDetail').hide();
	$('#viewUserlist').show();
	$('#editBusiness').hide();
	$("#political-business-table").dataTable().fnDestroy()
	// location.reload();
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
				url:APP_URL+"/user/block-user",
				data: {"id":id},
				success: function (data)
				{
					if (data.status==1)
					{
					    $('#user-table').DataTable().draw();

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
				text : 'Yes, UnBolck user!',
				className : 'btn btn-success'
			},
			cancel: {
				visible: true,
				className: 'btn btn-danger'
			}
		}
	}).then((unblock) => {
		if (unblock)
		{
		    $('.loader-custom').css('display','block');
			$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/user/unblock-user",
				data: {"id":id},
				success: function (data)
				{
					if (data.status==1)
					{
					    $('#user-table').DataTable().draw();
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

function approvebusiness(id){
	swal({
		title: 'Are you sure?',
		text: "Approv this business",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Approv it!',
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
				url:APP_URL+"/user/approv-business",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{

					    location.reload();

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

function declinebusiness(id){
	swal({
		title: 'Are you sure?',
		text: "Decline this business",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Decline it!',
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
				url:APP_URL+"/user/decline-business",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    location.reload();

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


function removeUser(id){
	swal({
		title: 'Are you sure?',
		text: "Remove this user",
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
				url:APP_URL+"/user/remove-user",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    location.reload();

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

$('#pills-normal-tab').on('click', () => viewDetail($('#user_id').val()));
function viewDetail(id){

	current_userid = id;
	PalnListsID();
	$('#viewDetail').show();
	$('#viewUserlist').hide();
	$('#editBusiness').hide();
	$("#myModal").modal('hide');
// 	$('#business-table').DataTable({
//       "destroy": true, //use for reinitialize datatable
//     });
	$('#business-table tbody').html('');
	$('#bcategory_list').html('');
	$('#business-table').DataTable().clear().destroy();
	$("#political-business-table").dataTable().fnDestroy()
	$('#frame-list').DataTable().clear().destroy();
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

    $('.loader-custom').css('display','block');

	$.ajax({
		type:'POST',
		url:APP_URL+"/user/view-user-detail",
		data: {"id":id},
		success: function (respose)
		{
		    $('.loader-custom').css('display','none');
		    $('#businessid').empty();
			var user_detail = respose.user_detail;

			$('#uname').text(user_detail['name']);
			$('#uemail').text(user_detail['email']);
			$('#umobile').html(user_detail['mobile']);

			$('#ref_userlistbtn').html('<button class="btn btn-info" onclick="viewRefUser('+user_detail['id']+')">View</button>');

			if(user_detail['status'] == '0'){
				$('#ustatus').text('Unblock');
			} else {
				$('#ustatus').text('Blocked');
			}
			$('#user_id').val(id);

				let business_category = respose.business_category;
                var list = $("#bcategory_list");
                list.append('<option value="" selected="selected" disabled>Select Category</option>');
                $.each(business_category, function(index, item) {
                list.append(new Option(item.name, item.name));
                });

			var business_detail = respose.business_detail;

			if(business_detail.length != 0){
				var row = '';
			    for (var i = 0; i <= business_detail.length - 1 ; i++) {

                  	let cur_id = i + 1;
					var purchaseornotstring;
					let source = '';
					let frame = '';
    			    if(business_detail[i].purc_plan_id == 1 || business_detail[i].purc_plan_id == 3){
    			        purchaseornotstring = '<button class="btn btn-primary" id="pr_'+business_detail[i].busi_id+'" onclick="purchaseplans('+business_detail[i].busi_id+')">Purchase</button>';
    			    } else {
    			    	if(business_detail[i].is_designer) {
    			    		frame = '<button onclick="editDesigner('+business_detail[i].busi_id+')" class="btn btn-primary">Edit Designer</button>';
    			    	}
    			    	else {
    			    		frame = '<button onclick="assignDesignerBusiness('+business_detail[i].busi_id+')" class="btn btn-primary">Assign Designer</button>';
    			    	}
						purchaseornotstring = "Purchased";
						purchaseornotstring += '<br><button class="btn btn-danger" onclick="cancelplan(this,'+business_detail[i].busi_id+')">Cencal</button>';
					}

					if(business_detail[i].purc_order_id != '' && business_detail[i].purc_order_id != 'FromAdmin' && business_detail[i].purc_plan_id != '3'){
						source = 'By User';
					}

					if(business_detail[i].purc_order_id == 'FromAdmin' && business_detail[i].purc_plan_id != '3'){
						source = 'By Admin';
					}

					if(business_detail[i].purc_plan_id == '3'){
						source = 'Not Purchase';

					}
					let second_mobile = '';
					if(business_detail[i].busi_mobile_second){
						second_mobile = '<br>'+ business_detail[i].busi_mobile_second;
					} else {
						second_mobile = '';
					}

					var plan_name_end_date;
					if (business_detail[i].purc_end_date != null && business_detail[i].purc_end_date != "")
                    {
                    	var date = business_detail[i].purc_end_date;
                        var datearray = date.split("-");

                        var newdate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
                        plan_name_end_date = business_detail[i].plan_or_name +'<br>'+ newdate;
                    }
                    else
                    {
                        plan_name_end_date = business_detail[i].plan_or_name;

                    }


    				if (user_detail['default_business_id'] == business_detail[i].busi_id)
                    {
                        row += '<tr class="bg-success text-white">'+
                             '<td>'+cur_id+'</td>'+
	    					 '<td>'+business_detail[i].busi_name+'</td>'+
	    					 '<td>'+business_detail[i].busi_email+'</td>'+
	    					 '<td>'+business_detail[i].busi_mobile+second_mobile+'</td>'+
	    					 '<td>'+business_detail[i].busi_website+'</td>'+
	    					 '<td>'+business_detail[i].busi_address+'</td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].busi_logo+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].watermark_image+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].busi_logo_dark+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].watermark_image_dark+'" height="100" width="100"></td>'+
							 '<td>'+source+'</td>'+
							 '<td>'+plan_name_end_date+'</td>'+
							'<td>'+purchaseornotstring+'</td>'+
							'<td>'+frame+'</td>'+
							'<td><button class="btn btn-primary" onclick="EditBusiness('+business_detail[i].busi_id+')"><i class="flaticon-pencil"></i></button></td>'+
							'<td><button class="btn btn-danger btn-sm" id="removeBusiness" onclick="removeBusiness('+business_detail[i].busi_id+','+id+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
	    					'</tr>';
                    }
                    else
                    {
                        row += '<tr>'+
                             '<td>'+cur_id+'</td>'+
	    					 '<td>'+business_detail[i].busi_name+'</td>'+
	    					 '<td>'+business_detail[i].busi_email+'</td>'+
	    					 '<td>'+business_detail[i].busi_mobile+second_mobile+'</td>'+
	    					 '<td>'+business_detail[i].busi_website+'</td>'+
	    					 '<td>'+business_detail[i].busi_address+'</td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].busi_logo+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].watermark_image+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].busi_logo_dark+'" height="100" width="100"></td>'+
							 '<td> <img src="'+SPACE_STORE_URL+''+business_detail[i].watermark_image_dark+'" height="100" width="100"></td>'+
							 '<td>'+source+'</td>'+
							 '<td>'+plan_name_end_date+'</td>'+
							'<td>'+purchaseornotstring+'</td>'+
							'<td>'+frame+'</td>'+
							'<td><button class="btn btn-primary" onclick="EditBusiness('+business_detail[i].busi_id+')"><i class="flaticon-pencil"></i></button></td>'+
							'<td><button class="btn btn-danger btn-sm" id="removeBusiness" onclick="removeBusiness('+business_detail[i].busi_id+','+id+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
	    					'</tr>';
                    }
                       $('#businessid').append(`<option value="${business_detail[i].busi_id}">${business_detail[i].busi_name}</option>`);
    				// $('#business-table tbody').html(row);
			//$('#business-table').DataTable().draw();
				}
				$('#business-table tbody').html(row);
			    $('#business-table').DataTable();

			} else {
				$('#business-table').DataTable();
			    $('#business-table tbody').html('<tr><td colspan="8">No data available in table</td></tr>');
			}

			var frameList = respose.frameList;

			if(frameList.length != 0){
				var row = '';
			    for (var i = 0; i <= frameList.length - 1 ; i++) {
                  	let cur_id = i + 1;
    				row += '<tr>'+
						 '<td>'+cur_id+'</td>'+
						 '<td>'+frameList[i].busi_name+'</td>'+
						 '<td> <img src="'+SPACE_STORE_URL+''+frameList[i].frame_url+'" height="100" width="100"></td>'+
						 '<td> <button class="btn btn-danger" onclick="removeFrame('+frameList[i].user_frames_id+')"><i class="fa fa-times" aria-hidden="true"></i></button></td>'+
    					'</tr>';

    				// $('#business-table tbody').html(row);
			//$('#business-table').DataTable().draw();
				}
				$('#frame-list tbody').html(row);
			    $('#frame-list').DataTable();

			} else {
				// $('#frame-list').DataTable();
				// $('#frame-list tbody').html('<tr><td colspan="4">No data available in table</td></tr>');
				$('#frame-list').dataTable( {
					"language": {
						"emptyTable": "No data available in table"
					}
				});
			}

			$('.loader-custom').css('display','none');
		//	$('#business-table').DataTable();

		}
	});
}

function editDesigner(business_id) {
	var business_type = 1;

	$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/user/viewDesignerPolitical",
				data: {"business_type":business_type, business_id: business_id},
				beforeSend: function () {
		        	$('span.alerts').remove();
		            $('.loader-custom').css('display','block');
		        },
		        complete: function (data, status) {
		            $('.loader-custom').css('display','none');
		        },
				success: function (data)
				{
					if(data.status) {
						$('#business_id_designer').val(business_id);
						$('#business_type_designer').val(1);
						$('#designer').val(data.data['designer_id']);
						$('#quantity').val(data.data['quantity']);
						$('#completed_div').show();
						$('#completed').val(data.data['completed']);
						$('#priority').val(data.data['priority']);
						$('#remark').val(data.data['remark']);
						$('#assignDesigner').modal('show');
					}
				}
			});
}

function editDesignerPolitical(business_id) {
	var business_type = 2;

	$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/user/viewDesignerPolitical",
				data: {"business_type":business_type, business_id: business_id},
				beforeSend: function () {
		        	$('span.alerts').remove();
		            $('.loader-custom').css('display','block');
		        },
		        complete: function (data, status) {
		            $('.loader-custom').css('display','none');
		        },
				success: function (data)
				{
					if(data.status) {
						$('#business_id_designer').val(business_id);
						$('#business_type_designer').val(2);
						$('#designer').val(data.data['designer_id']);
						$('#quantity').val(data.data['quantity']);
						$('#completed_div').show();
						$('#completed').val(data.data['completed']);
						$('#priority').val(data.data['priority']);
						$('#remark').val(data.data['remark']);
						$('#assignDesigner').modal('show');
					}
				}
			});
}

// function viewDesignerPolitical(business_id) {
// 	var business_type = 1;

// 	$.ajaxSetup({
// 			headers: {
// 			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 			}});

// 			$.ajax({
// 				type:'POST',
// 				url:APP_URL+"/user/viewDesignerPolitical",
// 				data: {"business_type":business_type, business_id: business_id},
// 				beforeSend: function () {
// 		        	$('span.alerts').remove();
// 		            $('.loader-custom').css('display','block');
// 		        },
// 		        complete: function (data, status) {
// 		            $('.loader-custom').css('display','none');
// 		        },
// 				success: function (data)
// 				{
// 					if(data.status) {
// 						$('#viewAssignDesigner').modal('show');
// 						$('#frame_designer_name').text(data.data.designer['name']);
// 						$('#frame_completed').text(data.data['completed']);
// 						$('#frame_quantity').text(data.data['quantity']);
// 						$('#frame_priority').text(data.data['priority']);
// 						$('#frame_remark').text(data.data['remark']);
// 					}
// 				}
// 			});
// }

function assignDesignerBusiness(business_id) {
	$('#business_id_designer').val(business_id);
	$('#business_type_designer').val(1);
	$('#quantity').val("");
	$('#priority').val(0);
	$('#remark').val("");
	$('#assignDesigner').modal('show');
	$('#completed_div').hide();
}

function assignDesignerPoliticalBusiness(business_id) {
	$('#business_id_designer').val(business_id);
	$('#business_type_designer').val(2);
	$('#quantity').val("");
	$('#priority').val(0);
	$('#remark').val("");
	$('#assignDesigner').modal('show');
	$('#completed_div').hide();
}

function addDesigner() {
	var form = document.addDesignerForm;
	var formData = new FormData(form);

	$.ajax({
        type: 'POST',
        url: APP_URL + '/user/addDesigner',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function () {
        	$('span.alerts').remove();
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status) {
            $('.loader-custom').css('display','none');
        },
        success: function (data) {
        	if (data.status == 401) {
                var i = 0;
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        if (i == 0) {
                            if ($("#" + index).attr('type') == "file") {
                                $('html, body').animate({
                                    scrollTop: $("#" + index).offset().top
                                }, 1000);
                            }
                            else {
                                $("#" + index).focus();
                            }
                        }
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }
                    i++;

                });
            }
            else {
            	$('#assignDesigner').modal('hide');
            	if($('#business_type_designer').val() == '2') {
            		getUsersPoliticalBusinessList();
            	}
            	else {
                	viewDetail(current_userid)
            	}
            }
        }
    })
}

function purchaseplans(id)
{
    $("#pur_id").val(id);
    $('#myPlan').modal('show');
}

function purchaseplan(){

var id = $("#pur_id").val();
var plan_id = $("#planlist").val();

	swal({
		title: 'Are you sure?',
		text: "Purchase this business",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Approv it!',
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
				url:APP_URL+"/user/purchase-plan",
				data: {"id":id,'plan_id':plan_id},
				success: function (data)
				{
					if (data.status)
					{
					    //location.reload();
					    $('#myPlan').modal('hide');
         //                $("#pr_"+id).attr('onclick', 'cancelplan(this,'+id+')');
         //                $("#pr_"+id).text('cancel');
         //                $("#pr_"+id).removeClass('btn-primary');
         //                $("#pr_"+id).addClass('btn-danger');
         					viewDetail(current_userid)

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

function cancelplan(ele,id){
	swal({
		title: 'Are you sure?',
		text: "Cancel this business",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes, Cancel it!',
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
				url:APP_URL+"/user/cancel-plan",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    //location.reload();
				      // $(ele).attr('onclick', 'purchaseplans('+id+')');
          //             $(ele).attr('id', 'pr_'+id);
          //             $(ele).text('Purchase');
          //             $(ele).removeClass('btn-danger');
          //             $(ele).addClass('btn-primary');
          					viewDetail(current_userid)

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

function AddFrame(){
	$('.loader-custom').css('display','block');
	var thumb = $('#frame')[0].files[0];
	data = new FormData();
        data.append('frame', thumb);
        data.append('user_id', current_userid);
		data.append('business_id', $('#businessid').val());
		data.append('business_type', $('#business_type').val());
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});

    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/user/addframe",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
				alert(data.message);
				$('#frame').val('');
				$('#blah').css('display','none');
				$('.loader-custom').css('display','none');
				viewDetail(current_userid);
    		}
    	});
}

$("#frame").change(function() {
	readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#blah').css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function removeFrame(id){

    swal({
		title: 'Are you sure?',
		text: "Remove this frame",
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
				}
			});

    		$.ajax({
				type:'POST',
				url:APP_URL+"/user/removeframe",
				data: {"id":id},
				success: function (data)
				{
					alert(data.message);
					viewDetail(current_userid);
				}
			});

		} else {
			swal.close();
		}
	});
}


function EditBusiness(id){

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}});

		$('.loader-custom').css('display','block');

		$.ajax({
			type:'POST',
			url:APP_URL+"/user/getBusinessforEdit",
			data: {"id":id},
			success: function (respose)
			{

				$('.loader-custom').css('display','none');
                var business_detail = respose.business_detail[0];
                $('#business_name').val(business_detail.busi_name);
                $('#business_email').val(business_detail.busi_email);
                $('#business_mobile').val(business_detail.busi_mobile);
                $('#business_mobile_second').val(business_detail.busi_mobile_second);
                $('#business_website').val(business_detail.busi_website);
                $('#business_address').val(business_detail.busi_address);
                $('#business_id').val(id);
                $('#bcategory_list').val(business_detail.business_category);
                $('#logoimg').attr('src',SPACE_STORE_URL+''+business_detail.busi_logo);
                $('#watermarkimg').attr('src',SPACE_STORE_URL+''+business_detail.watermark_image);
				$('#logodarkimg').attr('src',SPACE_STORE_URL+''+business_detail.busi_logo_dark);
                $('#watermarkdarkimg').attr('src',SPACE_STORE_URL+''+business_detail.watermark_image_dark);

				$('.loader-custom').css('display','none');
				$('#viewDetail').css('display','none');
				$('#editBusiness').css('display','block');
				$('#logoimg').css('display','block');
				$('#watermarkimg').css('display','block');
				$('#logodarkimg').css('display','block');
				$('#watermarkdarkimg').css('display','block');
				$('#viewUserlist').hide();

			}
		});
}

function showBusiness()
{
    $('#viewDetail').css('display','none');
	$('#editBusiness').css('display','block');
	$('#logoimg').css('display','block');
	$('#watermarkimg').css('display','block');
	$('#logodarkimg').css('display','block');
	$('#watermarkdarkimg').css('display','block');
	$('#editBusinessName').text('Add Business');
	$('#viewUserlist').hide();
}

$("#logo").change(function() {
	readURL1(this);
});

$("#watermark").change(function() {
	readURL1Watermark(this);
});

$("#logodark").change(function() {
	readURL1Dark(this);
});

$("#watermarkdark").change(function() {
	readURL1WatermarkDark(this);
});

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#logoimg')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#logoimg').css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL1Watermark(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#watermarkimg')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#watermarkimg').css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL1Dark(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#logodarkimg')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#logodarkimg').css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL1WatermarkDark(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#watermarkdarkimg')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#watermarkdarkimg').css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function back(){
	$('#viewDetail').css('display','block');
	$('#viewUserlist').css('display','none');
	$('#editBusiness').css('display','none');
	$('#editBusinessName').text('Edit Business');
	restBusinessForm();
}

function UpdateBusiness(){
    $('.loader-custom').css('display','block');
    var logo = $('#logo')[0].files[0];
    var watermark = $('#watermark')[0].files[0];
	var logodark = $('#logodark')[0].files[0];
    var watermarkdark = $('#watermarkdark')[0].files[0];
    data = new FormData();
        data.append('logo', logo);
        data.append('watermark', watermark);
		data.append('logodark', logodark);
        data.append('watermarkdark', watermarkdark);
        data.append('business_id', $('#business_id').val());
        data.append('user_id', $('#user_id').val());
        data.append('business_name', $('#business_name').val());
        data.append('business_email', $('#business_email').val());
        data.append('business_mobile', $('#business_mobile').val());
        data.append('business_mobile_second', $('#business_mobile_second').val());
        data.append('business_website', $('#business_website').val());
        data.append('business_address', $('#business_address').val());
        data.append('business_category', $('#bcategory_list').val());
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
    var nm = $('#business_name').val();
    var mb = $('#business_mobile').val();
    var id =  $('#user_id').val();
    if(nm != '' && mb != '')
    {
        $.ajax({
            type:'POST',
            url:APP_URL+"/user/updateBusiness",
            data: data,
            contentType: false,
            processData : false,
            success: function (data)
            {
                alert(data.message);
                //location.reload();
                restBusinessForm();
                $('#editBusinessName').text('Edit Business');
                $('#editBusiness').css('display','none');
                viewDetail(id)
            }
        });
    }
    else
    {
        $('.loader-custom').css('display','none');
        alert('Please insert value Name and Mobile');
    }
}

function viewRefUser(id){
	$('#user-reff-list').DataTable().clear().destroy();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	$('.loader-custom').css('display','block');

	$.ajax({
		type:'POST',
		url:APP_URL+"/user/get-reffer-user-list",
		data: {"id":id},
		success: function (respose)
		{
			$('.loader-custom').css('display','none');
			if(respose.status){
				var user_list = respose.user_list;
				if(user_list.length != 0){
					var row = '';
					var countrul = 1;
					for (var i = 0; i <= user_list.length - 1 ; i++) {
						row += '<tr>'+
							'<td>'+countrul+'</td>'+
							'<td>'+user_list[i].name+'</td>'+
							'<td>'+user_list[i].email+'</td>'+
							'<td>'+user_list[i].mobile+'</td>'+
							'<td><button class="btn btn-primary" onclick="viewDetail('+user_list[i].id+')"><i class="flaticon-medical"></i></button></td>'+
							'</tr>';
							countrul++;
					}
					$('#user-reff-list tbody').html(row);
					$('#user-reff-list').DataTable();
				}
			} else {
				$('#user-reff-list').dataTable( {
					"language": {
						"emptyTable": "No data available in table"
					}
				});
			}
			$('#myModal').modal();
		}
	});
}

function DeletePhotos(){

    swal({
		title: 'Are you sure?',
		text: "Remove Posts",
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
				}
			});

    		$.ajax({
				type:'POST',
				url:APP_URL+"/user/deletePhotos",
				data: {"from":from,'to':to},
				success: function (data)
				{
					//alert(data.message);
					$('#user-table').DataTable().draw();
					alert('Delete Photos');
		    		$('.loader-custom').css('display','none');
				}
			});

		} else {
			swal.close();
		}
	});
}

function restBusinessForm()
{
    $('#business_id').val('');
    $('#business_name').val('');
    $('#business_email').val('');
    $('#business_mobile').val('');
    $('#business_mobile_second').val('');
    $('#business_website').val('');
    $('#business_address').val('');
	$('#logo').val("");
	$('#logodark').val("");
	$('#watermark').val("");
	$('#watermarkdark').val("");
    $("#logoimg").attr('src', '#');
    $("#logodarkimg").attr('src', '#');
	$("#watermarkimg").attr('src', '#');
    $("#watermarkdarkimg").attr('src', '#');
}

function removeBusiness(id, userId)
{
    swal({
        title: 'Are you sure?',
        text: "Remove this business",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, remove it!',
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
                url:APP_URL+"/user/remove-business",
                data: {"id":id,user_id:userId},
                success: function (data)
                {
                    if (data.status)
                    {
                        //location.reload();
                        alert(data.message);
                        viewDetail(userId);

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
