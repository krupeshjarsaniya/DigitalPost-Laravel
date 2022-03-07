var table = "";
var table1 = "";

$(document).ready(function() {
    getGraphicCategory();
})

function getGraphicCategory() {
    table = $('#graphic-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/graphic/getGraphicCategory',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-graphic-category').click(function() {
    $('#addGraphicCategoryModal').modal('show');
    $('#name').val('');
    $('#order_number').val(null);
})

function addGraphicCategory() {
    $('span.alerts').remove();

    var form = document.addGraphicCategoryForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/graphic/addGraphicCategory',
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
                $('#addGraphicCategoryModal').modal('hide');
                $('#name').val('');
                $('#order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function deleteGraphicCategory(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this graphic",
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
                url:APP_URL+"/graphic/deleteGraphicCategory",
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

function editGraphicCategory(ele) {
    $('span.alerts').remove();
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/graphic/editGraphicCategory",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#edit_id').val(data.data.id);
                $('#edit_name').val(data.data.name);
                $('#edit_order_number').val(null);
                $('#editGraphicModal').modal('show');
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateGraphicCategory() {
    $('span.alerts').remove();

    var form = document.editGraphicForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/graphic/updateGraphicCategory',
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
                $('#editGraphicModal').modal('hide');
                $('#edit_name').val('');
                $('#edit_order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function getGraphics(ele) {

    if(table1) {
        table1.destroy();
    }
    $('#addGraphicModal').modal('show');
    var id = $(ele).data('id');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('#graphic_id').val(id);
    table1 = $('#graphic-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/graphic/getGraphics',
            type: "POST",
            data: {id}
        },
        columns: [
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function addGraphic() {
    $('span.alerts').remove();

    var form = document.addGraphicForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/graphic/addGraphic',
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

function deleteGraphic(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this graphic",
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
                url:APP_URL+"/graphic/deleteGraphic",
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
