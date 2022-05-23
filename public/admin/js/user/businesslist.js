var search_data = '';
var search = '';
//viewDetail();
var oTable;

function DataTable()
{
	search = $('input[type="search"]').val();

	oTable = $('#business-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url:APP_URL+'/user/view-business-list',
			type: "GET",
			dataType: "json",
			data:{ search : search, filter:search_data },
		},
		deferRender: false,
		columns: [
			{data: 'DT_RowIndex', name: 'business.busi_id'},
			{data: 'busi_name', name: 'busi_name'},
			{data: 'busi_email', name: 'busi_email'},
			{data: 'busi_mobile', name: 'busi_mobile'},
			// {data: 'busi_website', name: 'busi_website'},
			// {data: 'busi_address', name: 'busi_address'},
			{data: 'busi_logo', name: 'busi_logo'},
			{data: 'watermark_image', name: 'watermark_image'},
			// {data: 'source', name: 'source'},
			{data: 'PurchaseDate', name: 'PurchaseDate'},
			{data: 'PurchasePlan', name: 'PurchasePlan'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],

	});
}

DataTable();

$('#carrier-drpdwn').on('change', function() {
	var textSelected = $('#carrier-drpdwn option:selected').val();
	if(textSelected != ''){
		//oTable.columns(6).search(textSelected).draw(); // note columns(0) here
		search_data = textSelected;
		oTable.destroy();
		DataTable();
	} else {
		/*$('#business-table').DataTable().clear().destroy();
		$('#business-table tbody').html(row);
		oTable = $('#business-table').DataTable();*/
		location.reload();
	}
  });

var row = '';
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


function viewDetail(){

// 	$('#business-table').DataTable({
//       "destroy": true, //use for reinitialize datatable
//     });
$('#business-table tbody').html('');
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

    $('.loader-custom').css('display','block');

	$.ajax({
		type:'GET',
		url:APP_URL+"/user/view-business-list",
		success: function (respose)
		{
		    $('.loader-custom').css('display','none');

			var business_detail = respose.business_detail;

			if(business_detail.length != 0){
				row = '';
			    for (var i = 0; i <= business_detail.length - 1 ; i++) {
                  	let cur_id = i + 1;
    			    var purchaseornotstring;
    			    if(business_detail[i].purc_plan_id == 1 || business_detail[i].purc_plan_id == 3){
    			        purchaseornotstring = '<button class="btn btn-primary" onclick="purchaseplan('+business_detail[i].busi_id+')">Purchase</button>';
    			    } else {
						purchaseornotstring = "Purchased";
						purchaseornotstring += '<br><button class="btn btn-danger" onclick="cancelplan('+business_detail[i].busi_id+')">Cencal</button>';
                    }
                    var imge = '';
                    if(business_detail[i].busi_logo != ''){
                        imge = '<img src="'+SPACE_STORE_URL+''+business_detail[i].busi_logo+'" height="100" width="100">';
					}

					let source = '';

					if(business_detail[i].purc_order_id != '' && business_detail[i].purc_order_id != 'FromAdmin' && business_detail[i].purc_plan_id == '2'){
						source = 'By User';
					}

					if(business_detail[i].purc_order_id == 'FromAdmin' && business_detail[i].purc_plan_id == '2'){
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


    				row += '<tr>'+
    					 '<td>'+cur_id+'</td>'+
    					 '<td>'+business_detail[i].busi_name+'</td>'+
    					 '<td>'+business_detail[i].busi_email+'</td>'+
    					 '<td>'+business_detail[i].busi_mobile+second_mobile+'</td>'+
    					 '<td>'+business_detail[i].busi_website+'</td>'+
    					 '<td>'+business_detail[i].busi_address+'</td>'+
						 '<td>'+imge+'</td>'+
						 '<td>'+source+'</td>'+
						'<td>'+purchaseornotstring+'</td>'+
						'<td><button class="btn btn-primary" onclick="EditBusiness('+business_detail[i].busi_id+')"><i class="flaticon-pencil"></i></button></td>'+
    					'</tr>';

    				// $('#business-table tbody').html(row);
			//$('#business-table').DataTable().draw();
				}
				$('#business-table tbody').html(row);

				oTable = $('#business-table').DataTable();

			} else {
			    $('#business-table tbody').html('<tr><td colspan="8">No data available in table</td></tr>');
			    $('#business-table').DataTable();
			}

			$('.loader-custom').css('display','none');
		//	$('#business-table').DataTable();

		}
	});
}



function purchaseplan(id){
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
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    location.reload();

					}
                    else {
                        alert(data.message);
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

function cancelplan(id){
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
				console.log(business_detail);
				$('#business_name').val(business_detail.busi_name);
				$('#business_email').val(business_detail.busi_email);
				$('#business_mobile').val(business_detail.busi_mobile);
				$('#business_mobile_second').val(business_detail.busi_mobile_second);
				$('#business_website').val(business_detail.busi_website);
				$('#business_address').val(business_detail.busi_address);
				$('#bcategory_list').val(business_detail.business_category);
				$('#business_id').val(id);
				$('#logoimg').attr('src',SPACE_STORE_URL+''+business_detail.busi_logo);
				$('#watermarkimg').attr('src',SPACE_STORE_URL+''+business_detail.watermark_image);

				$('.loader-custom').css('display','none');
				$('#viewDetail').css('display','none');
				$('#editBusiness').css('display','block');
				$('#logoimg').css('display','block');
				$('#watermarkimg').css('display','block');

			}
		});
}

$("#logo").change(function() {
	readURL(this);
});

$("#watermark").change(function() {
	readURLwatermark(this);
});

function readURL(input) {
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
    else {
		$('#logoimg').css('display','none');
    }
}

function readURLwatermark(input) {
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
    else {
		$('#watermarkimg').css('display','none');
    }
}

function back(){
	$('#viewDetail').css('display','block');
	$('#editBusiness').css('display','none');
}

function UpdateBusiness(){
	$('.loader-custom').css('display','block');
	var thumb = $('#logo')[0].files[0];
	var watermark = $('#watermark')[0].files[0];
	data = new FormData();
        data.append('logo', thumb);
        data.append('watermark', watermark);
		data.append('business_id', $('#business_id').val());
		data.append('business_name', $('#business_name').val());
		data.append('business_email', $('#business_email').val());
		data.append('business_mobile', $('#business_mobile').val());
		data.append('business_mobile_second', $('#business_mobile_second').val());
		data.append('business_website', $('#business_website').val());
		data.append('business_address', $('#business_address').val());
		data.append('business_category', $('#business_category').val());
    	$.ajaxSetup({
    	headers: {
    	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}});

    	$.ajax({
    		type:'POST',
    		url:APP_URL+"/user/updateBusiness",
    		data: data,
    		contentType: false,
    		processData : false,
    		success: function (data)
    		{
				alert(data.message);
				$('.loader-custom').css('display','none');
				//location.reload();
    		}
    	});
}
