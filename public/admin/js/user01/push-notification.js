var table = "";
var table1 = "";

$(document).ready(function() {
    $('.select2').select2();
    getPendingNotification();
    getCompletedNotification();
})

function getPendingNotification() {
    table = $('#pending-notification-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/user/getPendingNotification',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
            {data: 'user_type', name: 'user_type', orderable: false},
            {data: 'notification_type', name: 'notification_type', orderable: false},
            {data: 'notification_for', name: 'notification_for', orderable: false},
            {data: 'title', name: 'title', orderable: false},
            {data: 'message', name: 'message', orderable: false},
            {data: 'image', name: 'image', orderable: false},
            {data: 'is_scheduled', name: 'is_scheduled', orderable: false},
            {data: 'scheduled_date', name: 'scheduled_date', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getCompletedNotification() {
    table1 = $('#completed-notification-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/user/getCompletedNotification',
        columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false},
            {data: 'user_type', name: 'user_type', orderable: false},
            {data: 'notification_type', name: 'notification_type', orderable: false},
            {data: 'notification_for', name: 'notification_for', orderable: false},
            {data: 'title', name: 'title', orderable: false},
            {data: 'message', name: 'message', orderable: false},
            {data: 'image', name: 'image', orderable: false},
            {data: 'is_scheduled', name: 'is_scheduled', orderable: false},
            {data: 'scheduled_date', name: 'scheduled_date', orderable: false},
        ]
    });
}

$('#add-notification').click(function() {
    $('#addPushNotificationModal').modal('show');
    resetAddForm();
})

$('input[type=radio][name=is_scheduled]').change(function() {
    if (this.value == '1') {
        $('.date_wrapper').show();
    }
    else {
        $('.date_wrapper').hide();
    }
});

$('input[type=radio][name=edit_is_scheduled]').change(function() {
    if (this.value == '1') {
        $('.date_edit_wrapper').show();
    }
    else {
        $('.date_edit_wrapper').hide();
    }
});


$('#notification_type').change(function() {
    var notification_type = $(this).val();
    change_notification_type(notification_type);
})

function change_notification_type(notification_type) {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('.loader-custom').css('display','block');
    $.ajax({
        type:'post',
        url:APP_URL+"/user/changeNotificationType",
        data: {
            "notification_type":notification_type,
        },
        success: function (response)
        {
            var data = response.data;
            console.log(data);
            var options = "";
            $.each(data, function(index, value) 
            {
                if(notification_type == 1) {
                    options += "<option value='"+value.name+"'>"+value.name+"</option>";
                }
                if(notification_type == 2) {
                    options += "<option value='"+value.pc_id+"'>"+value.pc_name+"</option>";
                }
                if(notification_type == 3) {
                    options += "<option value='"+value.fest_id+"'>"+value.fest_name+"</option>";
                }
                if(notification_type == 4) {
                    options += "<option value='"+value.custom_cateogry_id+"'>"+value.name+"</option>";
                }
                if(notification_type == 5) {
                    options += "<option value='"+value+"'>"+value+"</option>";
                }
            });
            $('#notification_for').html(options);
            $('.loader-custom').css('display','none');
        }
    });
}

$('#edit_notification_type').change(function() {
    var notification_type = $(this).val();
    change_notification_type_edit(notification_type);
})

function change_notification_type_edit(notification_type) {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('.loader-custom').css('display','block');
    $.ajax({
        type:'post',
        url:APP_URL+"/user/changeNotificationType",
        data: {
            "notification_type":notification_type,
        },
        success: function (response)
        {
            var data = response.data;
            console.log(data);
            var options = "";
            $.each(data, function(index, value) 
            {
                if(notification_type == 1) {
                    options += "<option value='"+value.name+"'>"+value.name+"</option>";
                }
                if(notification_type == 2) {
                    options += "<option value='"+value.pc_id+"'>"+value.pc_name+"</option>";
                }
                if(notification_type == 3) {
                    options += "<option value='"+value.fest_id+"'>"+value.fest_name+"</option>";
                }
                if(notification_type == 4) {
                    options += "<option value='"+value.custom_cateogry_id+"'>"+value.name+"</option>";
                }
                if(notification_type == 5) {
                    options += "<option value='"+value+"'>"+value+"</option>";
                }
            });
            $('#edit_notification_for').html(options);
            $('.loader-custom').css('display','none');
        }
    });
}

function schedule_notification() {
    $('span.alerts').remove();

    var form = document.addPushNotificationForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/user/schedule_notification',
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
            if(data.status == 1) {
                $('#addPushNotificationModal').modal('hide');
                resetAddForm();
                table.ajax.reload();
                table1.ajax.reload();
            }
        }
    });
}

function editNotification(ele) {
    resetEditForm();
    var id = $(ele).data('id');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('.loader-custom').css('display','block');
    $.ajax({
        type:'post',
        url:APP_URL+"/user/editPushNotification",
        data: {
            "id":id,
        },
        success: function (response)
        {
            $('#edit_notification_type').val(response.data.notification_type).trigger("change.select2");
            var notification_for_options = "";
            $.each(response.notification_for, function(index, value) 
            {
                if(response.data.notification_type == 1) {
                    notification_for_options += "<option value='"+value.name+"'>"+value.name+"</option>";
                }
                if(response.data.notification_type == 2) {
                    notification_for_options += "<option value='"+value.pc_id+"'>"+value.pc_name+"</option>";
                }
                if(response.data.notification_type == 3) {
                    notification_for_options += "<option value='"+value.fest_id+"'>"+value.fest_name+"</option>";
                }
                if(response.data.notification_type == 4) {
                    notification_for_options += "<option value='"+value.custom_cateogry_id+"'>"+value.name+"</option>";
                }
                if(response.data.notification_type == 5) {
                    notification_for_options += "<option value='"+value+"'>"+value+"</option>";
                }
            });
            $('#edit_notification_for').html(notification_for_options);
            $('#edit_notification_for').val(response.data.notification_for);


            $('#edit_id').val(response.data.id);  
            $('#edit_user_type').val(response.data.user_type).trigger("change.select2");  
            $('#edit_notification_for').val(response.data.notification_for).trigger("change.select2"); 
            $('#edit_title').val(response.data.title);  
            $('#edit_message').val(response.data.message);
            if(response.data.is_scheduled) {
                $('.date_edit_wrapper').show();
                $('#edit_is_scheduled_false').removeAttr('checked')
                $('#edit_is_scheduled_true').attr('checked', 'checked')
            }
            else {
                $('#edit_is_scheduled_true').removeAttr('checked')
                $('#edit_is_scheduled_false').attr('checked', 'checked')
                $('.date_edit_wrapper').hide();
            }
            $('#edit_scheduled_date').val(response.data.scheduled_date);
            $('#editPushNotificationModal').modal('show');
            $('.loader-custom').css('display','none');
        }
    });
}

function schedule_notification_update() {
    $('span.alerts').remove();

    var form = document.editPushNotificationForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/user/updatePushNotification',
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
            if(data.status == 1) {
                $('#editPushNotificationModal').modal('hide');
                resetEditForm();
                table.ajax.reload();
                table1.ajax.reload();
            }
        }
    });
}

function deleteNotification(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this notification",
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
    }).then((result) => {
        if (result) {
            $('.loader-custom').css('display','block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                type:'POST',
                url:APP_URL+"/user/deletePushNotification",
                data: {"id":id},
                success: function (data)
                {
                    alert(data.message);
                    table.ajax.reload();
                    table1.ajax.reload();
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });
}

function resetAddForm() {
    $('#user_type').val('All');  
    $('#notification_type').val('');  
    $('#notification_for').val('');  
    $('#title').val('');  
    $('#message').val('');  
    $('#scheduled_date').val('');
    $('#image').val('');
}

function resetEditForm() {
    $('#edit_user_type').val('All');  
    $('#edit_notification_type').val('');  
    $('#edit_notification_for').val('');  
    $('#edit_title').val('');  
    $('#edit_message').val('');  
    $('#edit_scheduled_date').val('');
    $('#edit_image').val('');
}