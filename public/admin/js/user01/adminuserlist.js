
var newusertable = $('#adminuser-tablelist').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/userlist/viewuserslist',
    columns: [
        {data: 'DT_RowIndex', name: 'users.id'},
		{data: 'name', name: 'name'},
		{data: 'email', name: 'email'},
		{data: 'mobile', name: 'mobile'},
        {data: 'commentlist', name: 'commentlist'},
        {data: 'follow_up_date', name: 'follow_up_date'},
        {data: 'userlist', name: 'userlist'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});


var holdusertable = $('#holdadminuser-tablelist').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/userlist/hold-viewuserslist',
    columns: [
        {data: 'DT_RowIndex', name: 'users.id'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'mobile', name: 'mobile'},
        {data: 'commentlist', name: 'commentlist'},
        {data: 'follow_up_date', name: 'follow_up_date'},
        {data: 'userlist', name: 'userlist'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});

var completeusertable = $('#completeadminuser-tablelist').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/userlist/complete-viewuserslist',
    columns: [
        {data: 'DT_RowIndex', name: 'users.id'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'mobile', name: 'mobile'},
        {data: 'commentlist', name: 'commentlist'},
        {data: 'follow_up_date', name: 'follow_up_date'},
        {data: 'userlist', name: 'userlist'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});
var current_userid = 0;

function PalnListsID() 
{
    $("#planlist").html('');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    // $('.loader-custom').css('display','block');
    
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

            // $('.loader-custom').css('display','none');
        }
    });
}


function showinsertform(){
    $('#viewUser').hide();
    $('#CommentList').show();
    $('#edituser').show();
}
function backuser() 
{
    $('#viewUser').show();
    $('#CommentList').hide();
    $('#edituser').hide();
}
function back() {
    $('#viewUser').hide();
    $('#editBusiness').hide();
    $('#CommentList').show();
    $('#edituser').show();
    $('#editBusinessName').text('Edit Business');
    restBusinessForm();
}

$('#pills-normal-tab').on('click', () => viewDetail($('#user_id').val()));
function viewDetail(id) 
{
    current_userid = id;
    PalnListsID();
    $('#business-table tbody').html('');
    $('#bcategory_list').html('');
    $('#business-table').DataTable().clear().destroy();
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
            $('#comment-table').DataTable().clear().destroy();
            getUserComment(id);
            showinsertform();

            $('#user_id').val(id);
            var user_detail = respose.user_detail;

            

            $('#uname').text(user_detail['name']);
            $('#uemail').text(user_detail['email']);
            $('#umobile').html(user_detail['mobile']);

            if(user_detail['status'] == '0'){
                $('#ustatus').text('Unblock');
            } else {
                $('#ustatus').text('Blocked');
            }
            $('#tel_status').attr('data-id', user_detail['id']);
            $('#tel_status').val(user_detail['tel_status']);
            $('#insert_comment').attr('data-id', user_detail['id']);
            
            $('#ref_userlistbtn').html('<button class="btn btn-info" onclick="viewRefUser('+user_detail['id']+')">View</button>');

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
                    if (respose.auth == 1) 
                    {
                        if(business_detail[i].purc_plan_id == 1 || business_detail[i].purc_plan_id == 3){
                            purchaseornotstring = '<button class="btn btn-primary" id="pr_'+business_detail[i].busi_id+'" onclick="purchaseplans('+business_detail[i].busi_id+')" >Purchase</button>';
                        } else {
                            purchaseornotstring = "Purchased";
                            purchaseornotstring += '<br><button class="btn btn-danger" onclick="cancelplan(this,'+business_detail[i].busi_id+')">Cencal</button>';
                        }
                    }
                    else
                    {
                        purchaseornotstring = "";
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

                    var edit_buss;
                    var remove_buss;
                    var plan_name_end_date;
                    if (respose.auth == 1) 
                    {
                        edit_buss = '<button class="btn btn-primary" onclick="EditBusiness('+business_detail[i].busi_id+')"><i class="flaticon-pencil"></i></button>';
                        remove_buss = '<button class="btn btn-danger btn-sm" id="removeBusiness" onclick="removeBusiness('+business_detail[i].busi_id+','+id+')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    }
                    else
                    {
                        edit_buss = "";
                        remove_buss = "";
                        //plan_name_end_date = "";
                    }

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
                             '<td>'+source+'</td>'+
                             '<td>'+plan_name_end_date+'</td>'+
                            '<td>'+purchaseornotstring+'</td>'+
                            '<td>'+edit_buss+'</td>'+
                            '<td>'+remove_buss+'</td>'+
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
                             '<td>'+source+'</td>'+
                             '<td>'+plan_name_end_date+'</td>'+
                            '<td>'+purchaseornotstring+'</td>'+
                            '<td>'+edit_buss+'</td>'+
                            '<td>'+remove_buss+'</td>'+
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
        //  $('#business-table').DataTable();
        
        
        
        }
    });
}

function ChangeStatus(ele) 
{
    var id = $(ele).attr('data-id');
    var tel_status = $("#tel_status").val();
    if (tel_status == "") 
    {
        alert('Please Select Status');
    }
    else
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $('.loader-custom').css('display','block');
        
        $.ajax({
            type:'POST',
            url:APP_URL+"/userlist/changeStatus",
            data: {tel_status:tel_status,id:id},
            success: function (respose)
            {
                $('.loader-custom').css('display','none');
               $('#adminuser-tablelist').DataTable().draw();
               $('#holdadminuser-tablelist').DataTable().draw();
               $('#completeadminuser-tablelist').DataTable().draw();
            }
        });
    }
}

function ChangeUser(ele) 
{
    var id = $(ele).attr('data-id');
    var tel_user1 = $(ele).val();
    
    if (tel_user1 == 0) 
    {
        alert('Please Select User');
    }
    else
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
            
            //$('.loader-custom').css('display','block');
            
            var tel_user = $(ele).val();
        $.ajax({
            type:'POST',
            url:APP_URL+"/userlist/changeUser",
            data: {tel_user:tel_user,id:id},
            success: function (respose)
            {
                $('.loader-custom').css('display','none');
               $('#adminuser-tablelist').DataTable().draw();
               $('#holdadminuser-tablelist').DataTable().draw();
               $('#completeadminuser-tablelist').DataTable().draw();
            }
        });
    }
}


function insertcommentvalue(ele) 
{
    var id = $(ele).attr('data-id');
    var comment = $("#comment").val();
    var date = $("#date").val();
    if (comment == "") 
    {
        alert('Please Enter Comment');
    }
    else
    {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $('.loader-custom').css('display','block');
        
        $.ajax({
            type:'POST',
            url:APP_URL+"/userlist/addUserComment",
            data: {comment:comment,id:id,date:date},
            success: function (respose)
            {
                $('.loader-custom').css('display','none');
                $("#comment").val("");
                $('#comment-table').DataTable().draw();
                $('#adminuser-tablelist').DataTable().draw();
                $('#holdadminuser-tablelist').DataTable().draw();
                $('#completeadminuser-tablelist').DataTable().draw();
            }
        });
    }
}

function getUserComment(id) 
{
    var comment = $('#comment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/userlist/getcomment/'+id,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'comment', name: 'comment'},
            {data: 'date', name: 'date'},
        ]
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
                url:APP_URL+"/user/block-user",
                data: {"id":id},
                success: function (data)
                {
                    if (data.status==1)
                    {
                        /*$('#adminuser-tablelist').DataTable().draw();
                        $('#holdadminuser-tablelist').DataTable().draw();
                        $('#completeadminuser-tablelist').DataTable().draw();*/
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
                        /*$('#adminuser-tablelist').DataTable().draw();
                        $('#holdadminuser-tablelist').DataTable().draw();
                        $('#completeadminuser-tablelist').DataTable().draw();*/
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
function AddFrame(){
    $('.loader-custom').css('display','block');
    var thumb = $('#frame')[0].files[0];
    data = new FormData();
        data.append('frame', thumb);
        data.append('user_id', current_userid);
        data.append('business_type',$('#business_type').val());
        data.append('business_id', $('#businessid').val());
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

$("#logo").change(function() {
    readURL1(this);
});

$("#frame").change(function() {
    readURL(this);
});

$("#watermar").change(function() {
    readURL1Watermark(this);
});

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
function UpdateBusiness(){
    $('.loader-custom').css('display','block');
    var thumb = $('#logo')[0].files[0];
    var watermark = $('#watermark')[0].files[0];
    data = new FormData();
        data.append('logo', thumb);
        data.append('watermark', watermark);
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
                $('#business_mobile_second').val(business_detail.business_mobile_second);
                $('#business_website').val(business_detail.busi_website);
                $('#business_address').val(business_detail.busi_address);
                $('#business_id').val(id);
                $('#bcategory_list').val(business_detail.business_category);
                $('#logoimg').attr('src',SPACE_STORE_URL+''+business_detail.busi_logo);
                $('#watermarkimg').attr('src',SPACE_STORE_URL+''+business_detail.watermark_image);

                

                $('.loader-custom').css('display','none');
                $('#editBusiness').css('display','block');
                $('#logoimg').css('display','block');
                $('#watermarkimg').css('display','block');
                $('#viewUserlist').hide();
                $('#viewUser').hide();
                $('#CommentList').hide();
                $('#edituser').hide();
    
            }
        });
}

function showBusiness() 
{
    $('#editBusiness').css('display','block');
    $('#logoimg').css('display','block');
    $('#watermarkimg').css('display','block');
    $('#viewUserlist').hide();
    $('#viewUser').hide();
    $('#CommentList').hide();
    $('#edituser').hide();
    $('#editBusinessName').text('Add Business');
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
                      $(ele).attr('onclick', 'purchaseplans('+id+')');
                      $(ele).attr('id', 'pr_'+id);
                      $(ele).text('Purchase');
                      $(ele).removeClass('btn-danger');
                      $(ele).addClass('btn-primary');
                      
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

function restBusinessForm() 
{
    $('#business_id').val('');
    $('#business_name').val('');
    $('#business_email').val('');
    $('#business_mobile').val('');
    $('#business_mobile_second').val('');
    $('#business_website').val('');
    $('#business_address').val('');

    $("#logoimg").attr('src', '#');
    $("#watermarkimg").attr('src', '#');
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