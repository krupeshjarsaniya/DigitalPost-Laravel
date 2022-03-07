var table = "";

$(document).ready(function() {
    getPopup();
})

function getPopup() {
    table = $('#popup-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/popup/getPopup',
        columns: [
            {data: 'image', name: 'image'},
            {data: 'user_type', name: 'user_type'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-popup').click(function() {
    $('#addPopupModal').modal('show');
})

function addPopup() {
    $('span.alerts').remove();

    var form = document.addPopupForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/popup/addPopup',
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
                $('#addPopupModal').modal('hide');
                table.ajax.reload();
            }
        }
    });
}

function deletePopup(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this popup",
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
                url:APP_URL+"/popup/deletePopup",
                data: {"id":id},
                success: function (data)
                {
                    alert(data.message);
                    table.ajax.reload();
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });
}

function editPopup(ele) {
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/popup/editPopup",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#image_view').attr('src', data.data.image);
                $('#edit_id').val(data.data.id);
                $('#edit_user_type').val(data.data.user_type);
                $('#edit_start_date').val(data.data.start_date);
                $('#edit_end_date').val(data.data.end_date);
                $('#editPopupModal').modal('show');
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updatePopup() {
    $('span.alerts').remove();

    var form = document.editPopupForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/popup/updatePopup',
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
                $('#editPopupModal').modal('hide');
                table.ajax.reload();
            }
        }
    });
}