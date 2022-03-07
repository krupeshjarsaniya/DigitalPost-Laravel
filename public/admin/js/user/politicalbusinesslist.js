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
			url:APP_URL+'/user/view-political-business-list',
			type: "GET",
			dataType: "json",
			data:{ search : search, filter:search_data },
		},
		deferRender: false,
		columns: [
			{data: 'DT_RowIndex', name: 'political_business.pb_id'},
			{data: 'pb_name', name: 'pb_name'},
			{data: 'pb_mobile', name: 'pb_mobile'},
			{data: 'pb_designation', name: 'pb_designation'},
			// {data: 'busi_website', name: 'busi_website'},
			// {data: 'busi_address', name: 'busi_address'},
			{data: 'pb_party_logo', name: 'pb_party_logo'},
			{data: 'pb_watermark', name: 'pb_watermark'},
			{data: 'pb_left_image', name: 'pb_left_image'},
			{data: 'pb_right_image', name: 'pb_right_image'},
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

PalnListsID();
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
        url:APP_URL+"/user/political-plan-list",
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

function purchaseplanspolitical(id) 
{
    $("#pur_id").val(id);
    $('#myPlan').modal('show');
}

function purchaseplanpolitical(){

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
				url:APP_URL+"/user/purchasePoliticalPlan",
				data: {"id":id,'plan_id':plan_id,'business_type' : 2},
				success: function (data)
				{
					if (data.status)
					{
					    //location.reload();
					    $('#myPlan').modal('hide');
                        $("#pr_"+id).attr('onclick', 'cancelplan(this,'+id+')');
                        $("#pr_"+id).text('cancel');
                        $("#pr_"+id).removeClass('btn-primary');
                        $("#pr_"+id).addClass('btn-danger');
					  
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
				$('#business_name').val(business_detail.pb_name);
				$('#business_mobile').val(business_detail.pb_mobile);
				$('#business_designation').val(business_detail.pb_designation);
				
				$('#bcategory_list').val(business_detail.pb_pc_id);
                $('#business_id').val(id);

                $('#twitter_url').val(business_detail.pb_twitter);
                $('#instagram_url').val(business_detail.pb_instagram);
                $('#linkedin_url').val(business_detail.pb_linkedin);
                $('#youtube_url').val(business_detail.pb_youtube);
                $('#fb_url').val(business_detail.pb_facebook);
                
                $('#logoimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_party_logo);
                $('#watermarkimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_watermark);
                $('#leftimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_left_image);
                $('#rightimg').attr('src', SPACE_STORE_URL + '' + business_detail.pb_right_image);
                

				$('.loader-custom').css('display','none');
				$('#viewDetail').css('display','none');
				$('#editBusiness').css('display','block');
				$('#logoimg').css('display','block');
				$('#watermarkimg').css('display','block');
				$('#leftimg').css('display','block');
				$('#rightimg').css('display','block');
	
			}
		});
}

$("#logo").change(function() {
	readURL(this,'logoimg');
});
$("#watermark").change(function() {
	readURL(this,'watermarkimg');
});
$("#left").change(function() {
	readURL(this,'leftimg');
});
$("#right").change(function() {
	readURL(this,'rightimg');
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

function back(){
	$('#viewDetail').css('display','block');
	$('#editBusiness').css('display','none');
}

function UpdateBusiness(){
	$('.loader-custom').css('display','block');
	var thumb = $('#logo')[0].files[0];
	var watermark = $('#watermark')[0].files[0];
	var leftimage = $('#left')[0].files[0];
	var rightimage = $('#right')[0].files[0];
	data = new FormData();
        data.append('party_logo', thumb);
        data.append('watermark', watermark);
        data.append('left_image', leftimage);
        data.append('right_image', rightimage);
		data.append('id', $('#business_id').val());
		data.append('name', $('#business_name').val());
		data.append('designation', $('#business_designation').val());
		data.append('mobile', $('#business_mobile').val());
        data.append('category', $('#bcategory_list').val());
    
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
				//location.reload();
    		}
    	});
}
