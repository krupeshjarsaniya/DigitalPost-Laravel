var oTable = "";
var search = '';


$(document).ready(function() {
	$('#privacypolicy').trumbowyg();
	$('#termconditions').trumbowyg();
	$('#referralpolicy').trumbowyg();
	getPurchaseTable();
});

$('#type').change(function() {
	getPurchaseTable();
})

$('#image').change(function() {
	var input = document.getElementById('image');
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#view_image').attr('src', e.target.result)
        };

        reader.readAsDataURL(input.files[0]);
    }
    else {
    	$('#view_image').attr('src', $('#view_image').data('old'));
    }
})

$('#referralimage').change(function() {
	var input = document.getElementById('referralimage');
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#view_referral_image').attr('src', e.target.result)
        };

        reader.readAsDataURL(input.files[0]);
    }
    else {
    	$('#view_referral_image').attr('src', $('#view_referral_image').data('old'));
    }
})

function getPurchaseTable() {
	if(oTable != "") {
		$("#userpurchase-table").dataTable().fnDestroy();
	}
	search = $('input[type="search"]').val();
	var type = $('#type').val();
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});
	oTable = $('#userpurchase-table').DataTable({
	    processing: true,
	    serverSide: true,
	    //ajax: APP_URL+'/userpurchase-table',
		ajax: {
			url:APP_URL+'/userpurchase-table',
			type: "POST",
			dataType: "json",
			data:{ search, type},
		},
		deferRender: false,
	    columns: [
	        {data: 'DT_RowIndex', name: 'purchase_plan.purc_id'},
			{data: 'name', name: 'name'},
			{data: 'mobile', name: 'mobile'},
			{data: 'busi_name', name: 'busi_name'},
			{data: 'plan_name', name: 'plan_name'},
			{data: 'purc_start_date', name: 'purc_start_date'},
			
	    ]
	});
}

function creditupdate(id) {

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	var amount = $('#credit').val();
	if(amount != ''){
	    $('.loader-custom').css('display','block');
		$.ajax({
			type:'POST',
			url:APP_URL+"/dashboard/update-credit",
			data: {
				"id":id,
				"amount":amount,
			},
			success: function (data)
			{
				if (data.status)
				{
				    location.reload();
				  
				}
				$('.loader-custom').css('display','none');
			}
		});
	} else {
		alert('Fill the credit');
	}
	
}

function daysUpdate() {
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	var days = $('#days').val();
	var image = $('#image').val();

	var form = document.daysForm;

    var formData = new FormData(form);

	$('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/update-days",
		processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
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

function Whatsappupdate(id) {

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	var whatsapp = $('#whatsapp').val();

	$('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/update-whatsapp",
		data: {
			"id":id,
			"whatsapp":whatsapp,
		},
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

function saveprivacy() {

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});
	var privacy = $('#privacypolicy').trumbowyg('html');

    $('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/saveprivacy",
		data: {"privacy":privacy},
		success: function (response){

			$('.loader-custom').css('display','none');
			alert(response.message);
			
		}
	});
}


function savetermconditions() {

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});
	var termconditions = $('#termconditions').trumbowyg('html');
    $('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/saveterms",
		data: {"termconditions":termconditions},
		success: function (response){
		    $('.loader-custom').css('display','none');
			alert(response.message);
		}
	});
}

function savereferralpolicy() {

	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});
	var referral_policy = $('#referralpolicy').trumbowyg('html');
    $('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/savereferralpolicy",
		data: {"referral_policy":referral_policy},
		success: function (response){
		    $('.loader-custom').css('display','none');
			alert(response.message);
		}
	});
}

function referralUpdate() {
	$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

	var form = document.referralForm;

    var formData = new FormData(form);

	$('.loader-custom').css('display','block');
	$.ajax({
		type:'POST',
		url:APP_URL+"/dashboard/update-referral-image",
		processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
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

// function viewprivacy() {

// 	alert(document.location.origin);
	
// 	// window.location.href = document.location.origin+'/privacypolicy';
// }

// function viewtermconditions() {
	

// 	window.location.href = document.location.origin+'/termsandcondition';
// }