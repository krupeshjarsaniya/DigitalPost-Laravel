$(document).ready(function() {

	$('#imgposition').on("cut copy paste",function(e) {
		e.preventDefault();
	 });
    getPendingRequest();
    getCompletedRequest();
});

var table = "";
var table1 = "";

function getPendingRequest(){
	if(table != "") {
		$("#pending-request-table").dataTable().fnDestroy();
	}
    table = $('#pending-request-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/withdraw-request/getPendingRequest',
        columns: [
            {data: 'DT_RowIndex', name: 'withdraw_request.id'},
            {data: 'user.name', name: 'user.name'},
			{data: 'user.mobile', name: 'user.mobile'},
			{data: 'amount', name: 'withdraw_request.amount'},
			{data: 'created_at', name: 'withdraw_request.created_at'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getCompletedRequest(){
    if(table1 != "") {
        $("#completed-request-table").dataTable().fnDestroy();
    }
    table1 = $('#completed-request-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/withdraw-request/getCompletedRequest',
        columns: [
            {data: 'DT_RowIndex', name: 'withdraw_request.id'},
            {data: 'user.name', name: 'user.name'},
            {data: 'user.mobile', name: 'user.mobile'},
            {data: 'amount', name: 'withdraw_request.amount'},
            {data: 'created_at', name: 'withdraw_request.created_at'},
        ]
    });
}
function completePayment(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Make Payment",
        type: 'warning',
        buttons:{
            confirm: {
                text : 'Yes, Make Payment!',
                className : 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((response) => {
        if (response)
        {
            $('.loader-custom').css('display','block');
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

            $.ajax({
                type:'POST',
                url:APP_URL+"/withdraw-request/completePayment",
                data: {"id":id},
                success: function (data)
                {
                    if (data.status)
                    {
                        table.ajax.reload();
                        table1.ajax.reload();
                      
                    }
                    alert(data.message);
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