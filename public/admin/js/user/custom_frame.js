$(document).ready(function() {

	$('#imgposition').on("cut copy paste",function(e) {
		e.preventDefault();
	 });
    getCustomFrameData();
    getCustomFrameDataPolitical();
    getCustomFrameCompletedData();
    getCustomFrameCompletedDataPolitical();
});

var table = "";
var table1 = "";

function getCustomFrameData(){
	if(table != "") {
		$("#custom-frame-table").dataTable().fnDestroy();
	}
    table = $('#custom-frame-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/custom_frame/getCustomFrameData',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
			{data: 'user', name: 'user', orderable: false},
			{data: 'business', name: 'business', orderable: false},
			{data: 'quantity', name: 'quantity', orderable: false},
			{data: 'completed', name: 'completed', orderable: false},
			{data: 'remark', name: 'remark', orderable: false},
			{data: 'priority', name: 'priority', orderable: false},
			{data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getCustomFrameDataPolitical(){
    if(table != "") {
        $("#custom-frame-political-table").dataTable().fnDestroy();
    }
    table = $('#custom-frame-political-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/custom_frame/getCustomFrameDataPolitical',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
            {data: 'user', name: 'user', orderable: false},
            {data: 'business', name: 'business', orderable: false},
            {data: 'quantity', name: 'quantity', orderable: false},
            {data: 'completed', name: 'completed', orderable: false},
            {data: 'remark', name: 'remark', orderable: false},
            {data: 'priority', name: 'priority', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getCustomFrameCompletedData(){
	if(table1 != "") {
		$("#custom-frame-completed-table").dataTable().fnDestroy();
	}
    table1 = $('#custom-frame-completed-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/custom_frame/getCustomFrameCompletedData',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
			{data: 'user', name: 'user', orderable: false},
			{data: 'business', name: 'business', orderable: false},
			{data: 'quantity', name: 'quantity', orderable: false},
			{data: 'completed', name: 'completed', orderable: false},
			{data: 'remark', name: 'remark', orderable: false},
			{data: 'priority', name: 'priority', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getCustomFrameCompletedDataPolitical(){
    if(table1 != "") {
        $("#custom-frame-completed-political-table").dataTable().fnDestroy();
    }
    table1 = $('#custom-frame-completed-political-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/custom_frame/getCustomFrameCompletedDataPolitical',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
            {data: 'user', name: 'user', orderable: false},
            {data: 'business', name: 'business', orderable: false},
            {data: 'quantity', name: 'quantity', orderable: false},
            {data: 'completed', name: 'completed', orderable: false},
            {data: 'remark', name: 'remark', orderable: false},
            {data: 'priority', name: 'priority', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function addFrame(ele, id) {
	var business_id = $(ele).data('id');
	var business_type = $(ele).data('type');
	$('#business_type').val(business_type);
	$('#business_id').val(business_id);
	$('#id').val(id);
    $("#files").val('');
    getFrames(business_id,business_type);

	$('#addFrame').modal('show');
}

function getFrames(business_id,business_type) {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $.ajax({
        type: 'POST',
        url: APP_URL + '/custom_frame/getCustomFrames',
        dataType: 'json',
        data: {business_id:business_id,business_type:business_type},
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },
        success: function (data)
        {
            $('#viewFrames').html(data.frames);
        }
    })
}

function addCustomFrame() {
	$('span.alerts').remove();

    var form = document.addCustomFrameForm;

    var formData = new FormData(form);

    $.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/custom_frame/add_custom_frame',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },
        success: function (data)
        {
            if (data.status == 401)
            {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
            }

            if (data.status == 1)
            {
				// $('#addFrame').modal('hide');
                $("#files").val('');
                getCustomFrameData();
                getCustomFrameDataPolitical();
                getCustomFrameCompletedData();
                getCustomFrameCompletedDataPolitical();
                var business_type = $('#business_type').val();
                var business_id = $('#business_id').val();
                getFrames(business_id,business_type);
            }
        }
    });
}

function viewBusinessDetail(ele, id) {
    $('span.alerts').remove();
    var business_id = $(ele).data('id');
    var business_type = $(ele).data('type');
    $("#logo").val('');
    $("#watermark").val('');
    $("#leftimage").val('');
    $("#rightimage").val('');
    if(business_type == 2) {
        $('.err_leftimage').show();
        $('.err_rightimage').show();
    }
    else {
        $('.err_leftimage').hide();
        $('.err_rightimage').hide();
    }

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/custom_frame/get_business',
        dataType: 'json',
        data: {business_id:business_id, business_type: business_type},
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },
        success: function (data)
        {
            if (data.status == 401)
            {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
            }
            if (data.status)
            {
                $('#viewBusinessDetailModal').modal('show');
                if(business_type == 1) {
                    $('#edit_business_id').val(data.data.busi_id);
                    $('#edit_business_type').val(business_type);
                    $('#business_name').text(data.data.busi_name);
                    $('#business_email').text(data.data.busi_email);
                    $('#business_mobile').text(data.data.busi_mobile);
                    $('#business_designation').text('');
                    $('#business_website').text(data.data.busi_website);
                    $('#business_address').text(data.data.busi_address);
                    $('#business_facebook').text('');
                    $('#business_twitter').text('');
                    $('#business_instgram').text('');
                    $('#business_linkedin').text('');
                    $('#business_youtube').text('');
                    $('#business_plan').text(data.data.plan);
                    $('#business_logo').attr('src',SPACE_STORE_URL+''+data.data.busi_logo);
                    $('#business_watermark').attr('src',SPACE_STORE_URL+''+data.data.watermark_image);
                }
                else {
                    $('#edit_business_id').val(data.data.pb_id);
                    $('#edit_business_type').val(business_type);
                    $('#business_name').text(data.data.pb_name);
                    $('#business_email').text('');
                    $('#business_mobile').text(data.data.pb_mobile);
                    $('#business_designation').text(data.data.pb_designation);
                    $('#business_website').text('');
                    $('#business_address').text('');
                    $('#business_facebook').text(data.data.busi_address);
                    $('#business_twitter').text(data.data.busi_address);
                    $('#business_instgram').text(data.data.busi_address);
                    $('#business_linkedin').text(data.data.busi_address);
                    $('#business_youtube').text(data.data.busi_address);
                    $('#business_plan').text(data.data.plan);
                    $('#business_logo').attr('src',SPACE_STORE_URL+''+data.data.pb_party_logo);
                    $('#business_watermark').attr('src',SPACE_STORE_URL+''+data.data.pb_watermark);
                    $('#business_leftimage').attr('src',SPACE_STORE_URL+''+data.data.pb_left_image);
                    $('#business_rightimage').attr('src',SPACE_STORE_URL+''+data.data.pb_right_image);
                }
            }
        }
    });
}

function editBusiness() {

    $('span.alerts').remove();

    var form = document.editBusinessForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/custom_frame/editBusinessFromFrame',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function ()
        {
            $('.loader-custom').css('display','block');
        },
        complete: function (data, status)
        {
            $('.loader-custom').css('display','none');
        },
        success: function (data)
        {
            if (data.status == 401)
            {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
            }

            if (data.status == 1)
            {
                $('#edit_business_type').val("");
                $('#edit_business_id').val("");
                $('#viewBusinessDetailModal').modal('hide');
                $("#logo").val('');
                $("#watermark").val('');
                $("#leftimage").val('');
                $("#rightimage").val('');
                alert(data.message);
            }
        }
    });
    
}

function removeFrame(ele, id){
    var business_id = $(ele).data('id');
    var business_type = $(ele).data('type');
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
                    getFrames(business_id,business_type)
                }
            });

        } else {
            swal.close();
        }
    });
}