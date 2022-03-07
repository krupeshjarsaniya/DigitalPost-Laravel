var table = $('#expiredplan-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/user/getexpiredplanlist',
    deferRender: false,
    columns: [
        {data: 'DT_RowIndex', name: 'users.id'},
		{data: 'name', name: 'name'},
		{data: 'mobile', name: 'mobile'},
		{data: 'busi_name', name: 'busi_name'},
		{data: 'plan_or_name', name: 'plan_or_name'},
		{data: 'purc_start_date', name: 'purc_start_date'},
		{data: 'purc_end_date', name: 'purc_end_date'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});

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
                data: {"id":id,'plan_id':plan_id,'from':'expire_plan_list'},
                success: function (data)
                {
                    if (data.status)
                    {
                        location.reload();
                        $('#myPlan').modal('hide');
                        // $("#pr_"+id).attr('onclick', 'cancelplan(this,'+id+')');
                        // $("#pr_"+id).text('cancel');
                        // $("#pr_"+id).removeClass('btn-primary');
                        // $("#pr_"+id).addClass('btn-danger');
                      
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
				data: {"id":id,'from':'expire_plan_list'},
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



// function viewDetail(id) 
// {
// 	$('.loader-custom').css('display','block');
// 	$.ajaxSetup({
// 	headers: {
// 	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 	}});

// 	$.ajax({
// 		type:'post',
// 		url:APP_URL+"/user/edit",
// 		data: {
// 			"id":id,
// 		},
// 		success: function (response)
// 		{	
// 			//getcountries();
//             showinsertform();
//             $('#fullname').val(response.data['name']);
// 			$('#email').val(response.data['email']);
// 			/*$('#userphone').val(response.data['mobile']);*/
// 			$('#userid').val(response.data['id']);
// 			$('#userpassword').attr('disabled', 'disabled');
// 			$('#con_password').attr('disabled', 'disabled');
            
//             $('.loader-custom').css('display','none');
// 		}
// 	});
// }