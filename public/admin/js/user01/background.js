var table = "";
var table1 = "";

$(document).ready(function() {
    getBackgroundCategory();
})

function getBackgroundCategory() {
    table = $('#background-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/background/getBackgroundCategory',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-background-category').click(function() {
    $('#addBackgroundCategoryModal').modal('show');
    $('#name').val('');
    $('#order_number').val(null);
})

function addBackgroundCategory() {
    $('span.alerts').remove();

    var form = document.addBackgroundCategoryForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/background/addBackgroundCategory',
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
                $('#addBackgroundCategoryModal').modal('hide');
                $('#name').val('');
                $('#order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function deleteBackgroundCategory(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this background",
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
                url:APP_URL+"/background/deleteBackgroundCategory",
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

function editBackgroundCategory(ele) {
    $('span.alerts').remove();
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/background/editBackgroundCategory",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#edit_id').val(data.data.id);
                $('#edit_name').val(data.data.name);
                $('#edit_order_number').val(null);
                $('#editBackgroundModal').modal('show');
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateBackgroundCategory() {
    $('span.alerts').remove();

    var form = document.editBackgroundForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/background/updateBackgroundCategory',
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
                $('#editBackgroundModal').modal('hide');
                $('#edit_name').val('');
                $('#edit_order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function getBackgrounds(ele) {
    if(table1) {
        table1.destroy();
    }
    $('#addBackgroundModal').modal('show');
    var id = $(ele).data('id');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('#category_id').val(id);
    table1 = $('#background-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/background/getBackgrounds',
            type: "POST",
            data: {id}
        },
        columns: [
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function addBackground() {
    $('span.alerts').remove();

    var form = document.addBackgroundForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/background/addBackground',
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
                $('#files').val('');
                table1.ajax.reload();
            }
        }
    });
}

function deleteBackground(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this background",
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
                url:APP_URL+"/background/deleteBackground",
                data: {"id":id},
                success: function (data)
                {
                    alert(data.message);
                    table1.ajax.reload();
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });
}