var search_data = '';
var search = '';
$(document).ready(function () {
	$('.default').closest('tr').css('backgroundColor', '#31ce36');
});
//viewDetail();
var politicalTable = "";
$('#pills-political-tab').on('click', () => { getUsersPoliticalBusinessList(); getPoliticalBusinessFrameList(); PoliticalPalnListsID() });
$('#pills-normal-tab').on('click', () => {
    $("#frame-list").dataTable().fnDestroy()
    $("#frame").html('')
});
function getUsersPoliticalBusinessList()
{
	if(politicalTable != "") {
    	$("#political-business-table").dataTable().fnDestroy()
	}
	search = $('input[type="search"]').val();
    user_id = $('#user_id').val();
	politicalTable = $('#political-business-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url:APP_URL+'/user/view-political-user-business-list',
			type: "GET",
			dataType: "json",
			data:{ search : search, filter:search_data,user_id:user_id },
			dataSrc: function ( json ) {
				
				setdefaultColor();
				return json.data;
            }       
		},
		deferRender: false,
		columns: [
			{data: 'DT_RowIndex', name: 'political_business.pb_id'},
			{data: 'pb_name', name: 'pb_name'},
			{data: 'pb_mobile', name: 'pb_mobile'},
			{data: 'pb_designation', name: 'pb_designation'},
			{data: 'pb_party_logo', name: 'pb_party_logo'},
			{data: 'pb_watermark', name: 'pb_watermark'},
			{data: 'pb_left_image', name: 'pb_left_image'},
			{data: 'pb_right_image', name: 'pb_right_image'},
			{data: 'PurchaseDate', name: 'PurchaseDate'},
			{data: 'PurchasePlan', name: 'PurchasePlan'},
			{data: 'AssignDesigner', name: 'AssignDesigner'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],
		
	});



}

const setdefaultColor = () =>{
	
	$('.default').closest('tr').css('backgroundColor', '#31ce36');
}

function getPoliticalBusinessFrameList() {
    $("#frame-list").dataTable().fnDestroy()
    $("#businessid").html('')
    $('#frame-list tbody').html('');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    user_id = $('#user_id').val();
    $.ajax({
        type:'POST',
        url: APP_URL + "/user/political-user-business-frame-list",
        data:{user_id : user_id },
        success: function(respose)
        {
            let data = respose.data;
            var list = $("#businessid");
            $.each(data, function(index, item) {
            list.append(new Option(item.pb_name, item.pb_id));
            });

            $('.loader-custom').css('display', 'none');
            

            var frameList = respose.frameList;

			if(frameList.length != 0){
				var row = '';
			    for (var i = 0; i <= frameList.length - 1 ; i++) {
                  	let cur_id = i + 1;
    				row += '<tr>'+
						 '<td>'+cur_id+'</td>'+
						 '<td>'+frameList[i].pb_name+'</td>'+
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
        }
    });
}

var row = '';


function PoliticalPalnListsID() 
{
	$("#politicalplanlist").html('');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $('.loader-custom').css('display','block');
    
    $.ajax({
        type:'POST',
        url:APP_URL+"/user/political-plan-list",
        success: function(respose)
        {
            let data = respose.data;
            var list = $("#politicalplanlist");
            list.append('<option value="" selected="selected" disabled>Select Paln</option>');
            $.each(data, function(index, item) {
            list.append(new Option(item.plan_or_name, item.plan_id));
            });

            $('.loader-custom').css('display','none');
        }
    });
}

function purchaseplanspolitical(id) 
{
    $("#pur_id").val(id);
    $('#myPoliticalPlan').modal('show');
}

function purchaseplanpolitical(){

var id = $("#pur_id").val();
var plan_id = $("#politicalplanlist").val();

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
				url:APP_URL+"/user/purchasePoliticalPlan",
				data: {"id":id,'plan_id':plan_id,'business_type' : 2},
				success: function (data)
				{
					if (data.status)
					{
						$('#myPoliticalPlan').modal('hide');
                        getUsersPoliticalBusinessList();
						
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


function cancelplanpolitical(id){
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
				url:APP_URL+"/user/political-plan-cencal",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    getUsersPoliticalBusinessList();
					  
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

function EditBusinesspolitical(id){
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}});
	
		$('.loader-custom').css('display','block');
		
		$.ajax({
			type:'POST',
			url:APP_URL+"/user/getPoliticalBusinessforEdit",
			data: {"id":id},
			success: function (respose)
			{

				$('.loader-custom').css('display','none');
				var business_detail = respose.business_detail;
				console.log(business_detail);
				$('#political_business_name').val(business_detail.pb_name);
				$('#political_business_mobile').val(business_detail.pb_mobile);
				$('#political_business_designation').val(business_detail.pb_designation);
				
				$('#political_list').val(business_detail.pb_pc_id);
                $('#political_business_id').val(id);

                $('#twitter_url').val(business_detail.pb_twitter);
                $('#instagram_url').val(business_detail.pb_instagram);
                $('#linkedin_url').val(business_detail.pb_linkedin);
                $('#youtube_url').val(business_detail.pb_youtube);
                $('#fb_url').val(business_detail.pb_facebook);
                
                $('#political_logoimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_party_logo);
                $('#political_watermarkimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_watermark);
                $('#political_leftimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_left_image);
                $('#political_rightimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_right_image);
                

				$('.loader-custom').css('display','none');
				$('#viewDetail').css('display','none');
				$('#editPoliticalBusiness').css('display','block');
				$('#political_logoimg').css('display','block');
				$('#political_watermarkimg').css('display','block');
				$('#political_leftimg').css('display','block');
				$('#political_rightimg').css('display','block');
	
			}
		});
}

$("#political_logo").change(function() {
	readURL(this,'political_logoimg');
});
$("#political_watermark").change(function() {
	readURL(this,'political_watermarkimg');
});
$("#political_left").change(function() {
	readURL(this,'political_leftimg');
});
$("#political_right").change(function() {
	readURL(this,'political_rightimg');
});

function readURL(input,container_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+container_id)
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
		$('#'+container_id).css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

function UpdatePoliticalBusiness(){
	$('.loader-custom').css('display','block');
	var thumb = $('#political_logo')[0].files[0];
	var watermark = $('#political_watermark')[0].files[0];
	var leftimage = $('#political_left')[0].files[0];
	var rightimage = $('#political_right')[0].files[0];
	data = new FormData();
        data.append('party_logo', thumb);
        data.append('watermark', watermark);
        data.append('left_image', leftimage);
        data.append('right_image', rightimage);
		data.append('id', $('#political_business_id').val());
		data.append('name', $('#political_business_name').val());
		data.append('designation', $('#political_business_designation').val());
		data.append('mobile', $('#political_business_mobile').val());
        data.append('category', $('#political_list').val());
        data.append('user_id', $('#user_id').val());
    
		data.append('facebook', $('#fb_url').val());
		data.append('twitter', $('#twitter_url').val());
		data.append('instagram', $('#instagram_url').val());
		data.append('linkedin', $('#linkedin_url').val());
        data.append('youtube', $('#youtube_url').val());
    
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});
    
    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/user/updatePoliticalBusiness",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
				alert(data.data);
				$('.loader-custom').css('display','none');
				$('#editPoliticalBusiness').css('display','none');
				$('#viewDetail').show();
                getUsersPoliticalBusinessList();
    		}
    	});
}

function showPoliticalBusiness() {
    $('#viewDetail').hide()
	$('#editPoliticalBusiness').show()

	$('#viewDetail').css('display','none');
	$('#editBusinessName').text('Add Political Business');
	$('#viewUserlist').hide();
}

function backToPoliticalList() {
    $('#viewDetail').show()
	$('#editPoliticalBusiness').hide()

	$('#viewDetail').css('display','block');
	$('#editBusinessName').text('Update Political Business');
	$('#viewUserlist').show();
}
getPoliticalCategory();
function getPoliticalCategory() {
    $("#political_list").html('');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $('.loader-custom').css('display','block');
    
    $.ajax({
        type:'POST',
        url:APP_URL+"/user/political-categoty-list",
        success: function(respose)
        {
            let data = respose.data;
            var list = $("#political_list");
            list.append('<option value="" selected="selected" disabled>Select Paln</option>');
            $.each(data, function(index, item) {
            list.append(new Option(item.pc_name, item.pc_id));
            });

            $('.loader-custom').css('display','none');
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
				url:APP_URL+"/user/approve-political-business",
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
				url:APP_URL+"/user/decline-political-business",
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

function getPoliticalBusinessList() {
	alert('d');
    // $("#businessid").html('')
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // user_id = $('#user_id').val();
    // $.ajax({
    //     type:'POST',
    //     url: APP_URL + "/user/political-user-business-frame-list",
    //     data:{user_id : user_id },
    //     success: function(respose)
    //     {
    //         let data = respose.data;
    //         var list = $("#businessid");
    //         $.each(data, function(index, item) {
    //         list.append(new Option(item.pb_name, item.pb_id));
    //         });

    //         $('.loader-custom').css('display', 'none');
    //     }
    // });
}

$("#business_type").change(function () {
	let btype = this.value
	$("#businessid").html('')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    user_id = $('#user_id').val();
    $.ajax({
        type:'POST',
        url: APP_URL + "/user/get-business-list-type-wise",
        data:{user_id : user_id, b_type:this.value },
        success: function(respose)
        {
            let data = respose.business_list;
            var list = $("#businessid");
			$.each(data, function (index, item) {
				if (btype === '1' || btype === 1) {
					console.log(item.busi_name);
					list.append(new Option(item.busi_name, item.busi_id));
				} else {
					list.append(new Option(item.pb_name, item.pb_id));
				}
            });

            $('.loader-custom').css('display', 'none');
        }
    });
});

function removeBusinessPolitical(id, userId) 
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
                url:APP_URL+"/user/remove-business-political",
                data: {"id":id,user_id:userId},
                success: function (data)
                {
                    if (data.status)
                    {
                        //location.reload();
                        alert(data.message);
                        getUsersPoliticalBusinessList();
                        getPoliticalBusinessFrameList();
                        PoliticalPalnListsID();
                      
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