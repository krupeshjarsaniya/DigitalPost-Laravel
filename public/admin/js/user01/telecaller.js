var table = "";
var table1 = "";
var change_status = "";
var search = '';
var user_id;

$(document).ready(function() {
    getTelecallerList();
})

function getTelecallerList() {
    table = $('#telecaller-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/telecaller/list',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'assigned_users', name: 'id', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}


function getAssignedUser(id) {
    if(table1) {
        table1.destroy();
    }
    search = $('input[type="search"]').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    table1 = $('#assigne-user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/telecaller/getAssignedUser',
            type: "POST",
            data: {id,change_status,search}
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'status', name: 'status'},
        ]
    });
}

function changeStatus(ele)
{
    change_status = $(ele).val();
    getAssignedUser(user_id);
}

function assigneUser(ele) {
    user_id = $(ele).data('id');
    $('#telecaller_id').val(user_id);
    getAssignedUser(user_id);
    $('#assigneUserModal').modal('show');
}

function getUserByDate(ele) {
    var date = $(ele).val();
    if(date) {
        $.ajax({
            type:'POST',
            url: APP_URL + "/telecaller/getUserByDate",
            data:{date},
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
                var option = "";
                for (var i = 0; i <= data.users.length - 1 ; i++) {
                    option += "<option value='"+data.users[i].id+"''>"+data.users[i].name+"</option>"
                }
                $('#users').html(option);
            }
        });
    }
    else {
        $('#users').html('');
    }
}

function assigneUserAdd() {
    $('span.alerts').remove();

    var form = document.assigneUserForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/telecaller/assigneUserAdd',
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
            if(data.status == 0) {
                alert(data.message);
            }
            if(data.status == 1) {
                $('#users').html('');
                $('#date').val(null);
                table1.ajax.reload();
            }
        }
    });
}