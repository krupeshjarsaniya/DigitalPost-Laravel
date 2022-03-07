var table = "";
var table1 = "";

$(document).ready(function() {
    getStickerCategory();
})

function getStickerCategory() {
    table = $('#sticker-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/sticker/getStickerCategory',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-sticker-category').click(function() {
    $('#addStickerCategoryModal').modal('show');
    $('#name').val('');
    $('#order_number').val(null);
})

function addStickerCategory() {
    $('span.alerts').remove();

    var form = document.addStickerCategoryForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/sticker/addStickerCategory',
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
                $('#addStickerCategoryModal').modal('hide');
                $('#name').val('');
                $('#order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function deleteStickerCategory(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this sticker",
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
                url:APP_URL+"/sticker/deleteStickerCategory",
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

function editStickerCategory(ele) {
    $('span.alerts').remove();
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/sticker/editStickerCategory",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#edit_id').val(data.data.id);
                $('#edit_name').val(data.data.name);
                $('#edit_order_number').val(data.data.order_number);
                $('#editStickerModal').modal('show');
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateStickerCategory() {
    $('span.alerts').remove();

    var form = document.editStickerForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/sticker/updateStickerCategory',
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
                $('#editStickerModal').modal('hide');
                $('#edit_name').val('');
                $('#edit_order_number').val(null);
                table.ajax.reload();
            }
        }
    });
}

function getStickers(ele) {
    if(table1) {
        table1.destroy();
    }
    $('#addStickerModal').modal('show');
    var id = $(ele).data('id');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    $('#category_id').val(id);
    table1 = $('#sticker-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/sticker/getStickers',
            type: "POST",
            data: {id}
        },
        columns: [
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}


function addSticker() {
    $('span.alerts').remove();

    var form = document.addStickerForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/sticker/addSticker',
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

function deleteSticker(ele) {
    var id = $(ele).data('id');
    swal({
        title: 'Are you sure?',
        text: "Remove this sticker",
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
                url:APP_URL+"/sticker/deleteSticker",
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