var table = "";
var table2 = "";
var table3 = "";

$(document).ready(function() {
    if($('#frame-table').length) {
        getFrame();
    }
    if($('#components-table').length) {
        getComponents();
    }
    if($('#text-table').length) {
        getTexts();
    }
})

$('#image_for').on('change', function () {
    var image_for = $(this).val();
    if(image_for == "0") {
        $('#stkr_path_wrapper').show();
    } else {
        $('#stkr_path_wrapper').hide();
    }
});

$('#edit_image_for').on('change', function () {
    var image_for = $(this).val();
    if(image_for == "0") {
        $('#edit_stkr_path_wrapper').show();
    } else {
        $('#edit_stkr_path_wrapper').hide();
    }
});

function getFrame() {
    table = $('#frame-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/frame/getFrame',
        columns: [
            {data: 'frame_image', name: 'frame_image'},
            {data: 'frame_type', name: 'frame_type'},
            {data: 'is_active', name: 'is_active'},
            {data: 'display_order', name: 'display_order'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getComponents() {
    table2 = $('#components-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/frame/getComponents/' + $('#frame_id').val(),
        columns: [
            {data: 'field.field_value', name: 'field.field_value'},
            {data: 'stkr_path', name: 'stkr_path'},
            {data: 'pos_x', name: 'pos_x'},
            {data: 'pos_y', name: 'pos_y'},
            {data: 'height', name: 'height'},
            {data: 'width', name: 'width'},
            {data: 'order_', name: 'order_'},
            {data: 'field_three', name: 'field_three'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function getTexts() {
    table3 = $('#text-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/frame/getTexts/' + $('#frame_id').val(),
        columns: [
            {data: 'field.field_value', name: 'field.field_value'},
            {data: 'text_color', name: 'text_color'},
            {data: 'font_name', name: 'font_name'},
            {data: 'field_three', name: 'field_three'},
            {data: 'pos_x', name: 'pos_x'},
            {data: 'pos_y', name: 'pos_y'},
            {data: 'height', name: 'height'},
            {data: 'width', name: 'width'},
            {data: 'order_', name: 'order_'},
            {data: 'field_four', name: 'field_four'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-frame').click(function() {
    $('#addFrameModal').modal('show');
    $('#name').val('');
    $('#display_order').val('');
    $('#frame_image').val('');
    $('#thumbnail_image').val('');

})

function addFrame() {
    $('span.alerts').remove();

    var form = document.addFrameForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/addFrame',
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
                return false;
            }
            if(data.status == 0) {
                alert(data.message);
            }
            if(data.status == 1) {
                $('#addFrameModal').modal('hide');
                $('#name').val('');
                $('#order_number').val(null);
                $('#thumbnail_image').val('');
                table.ajax.reload();
            }
        }
    });
}

function editFrame(ele) {
    $('span.alerts').remove();
    $('#edit_display_order').val('');
    $('#edit_frame_image').val('');
    $('#edit_thumbnail_image').val('');
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/frame/editFrame",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#edit_id').val(data.data.id);
                $('#image_view').attr('src',data.data.frame_image);
                $('#thumb_image_view').attr('src',data.data.thumbnail_image);
                $('#edit_frame_type').val(data.data.frame_type);
                $('#edit_is_active').val(data.data.is_active);
                $('#edit_display_order').val(data.data.display_order);
                $('#editFrameModal').modal('show');
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateFrame() {
    $('span.alerts').remove();

    var form = document.editFrameForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/updateFrame',
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
                return false;
            }
            if(data.status == 0) {
                alert(data.message);
            }
            if(data.status == 1) {
                $('#editFrameModal').modal('hide');
                $('#edit_id').val('');
                $('#image_view').attr('src','');
                $('#edit_image_view').attr('src','');
                table.ajax.reload();
            }
        }
    });
}

$('#add-components').click(function() {
    clearAddComponentForm();
    $('#addComponentModal').modal('show');
})

function addComponent() {
    $('span.alerts').remove();
    var form = document.addComponentForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/addComponent',
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
                return false;
            }
            if(data.status) {
                table2.ajax.reload();
                $('#addComponentModal').modal('hide');
                clearAddComponentForm();
            }
            else {
                alert(data.message);
            }
        }
    });
}

function editComponent(ele) {
    clearEditComponentForm();
    $('span.alerts').remove();
    $('#image-edit-message').html('');
    var id = $(ele).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:APP_URL+"/frame/editComponent",
        data: {"id":id},
        success: function (data)
        {
            if(data.status) {
                $('#editComponentModal').modal('show');
                $('#edit_id').val(data.data.id);
                if(data.data.image_for == 0) {
                    $('#edit_stkr_path_img').attr('src',data.data.stkr_path);
                }
                else {
                    $('#edit_stkr_path_img').attr('src','');
                    $('#edit_stkr_path_wrapper').hide();
                }
                $('#edit_image_for').val(data.data.image_for);
                $('#edit_order_').val(data.data.order_);
                $('#edit_pos_y').val(data.data.pos_y);
                $('#edit_pos_x').val(data.data.pos_x);
                $('#edit_height').val(data.data.height);
                $('#edit_width').val(data.data.width);
                $('#edit_field_three').val(data.data.field_three);
            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateComponent() {
    $('span.alerts').remove();
    $('#image-edit-message').html('');

    var form = document.editComponentForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/updateComponent',
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
                return false;
            }
            if(data.status) {
                // $('#editComponentModal').modal('hide');
                // clearEditComponentForm();
                table2.ajax.reload();
                $('#image-edit-message').html('<span class="text-success">' + data.message + '</span>');
            }
            else {
                alert(data.message);
            }

        }
    });

}

function deleteComponent(ele) {
    var id = $(ele).data('id');


    swal({
        title: 'Are you sure?',
        text: "Remove this Component!",
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
                url:APP_URL+"/frame/deleteComponent",
                data: {"id":id},
                success: function (data)
                {
                    if(data.status) {
                        table2.ajax.reload();
                    }
                    else {
                        alert(data.message)
                    }
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });

}

function clearAddComponentForm() {
    $('span.alerts').remove();
    $('#image_for').val('0');
    $('#stkr_path_wrapper').show();
    $('#stkr_path').val('');
    $('#order_').val('');
    $('#pos_x').val('');
    $('#pos_y').val('');
    $('#width').val('');
    $('#height').val('');
    $('#field_three').val('unlocked');
}

function clearEditComponentForm() {
    $('span.alerts').remove();
    $('#edit_id').val('');
    $('#edit_stkr_path_wrapper').show();
    $('#edit_stkr_path_img').attr('src','');
    $('#edit_image_for').val('0');
    $('#edit_order_').val('');
    $('#edit_pos_x').val('');
    $('#edit_pos_y').val('');
    $('#edit_width').val('');
    $('#edit_height').val('');
    $('#edit_field_three').val('unlocked');
    $('#edit_stkr_path').val('');
}

$('#add-text').click(function() {
    clearAddTextForm();
    $('#addTextModal').modal('show');
})

function addText() {
    $('span.alerts').remove();
    var form = document.addTextForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/addText',
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
        }
        ,success: function (data)
        {
            if (data.status == 401)
            {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;

            }
            if(data.status) {
                $('#addTextModal').modal('hide');
                clearAddTextForm();
                table3.ajax.reload();
            }
            else {
                alert(data.message);
            }

        }
    });
}

function editText(ele) {
    clearEditTextForm();
    var id = $(ele).data('id');
    $('#text-edit-message').html('');

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/editText',
        data: {"id":id},
        success: function (data)
        {
            if (data.status)
            {
                $('#editTextModal').modal('show');
                $('#edit_text_id').val(data.data.id);
                $('#edit_text_for').val(data.data.text_for);
                $('#edit_text_color').val(data.data.text_color);
                $('#edit_text_order_').val(data.data.order_);
                $('#edit_text_pos_x').val(data.data.pos_x);
                $('#edit_text_pos_y').val(data.data.pos_y);
                $('#edit_text_width').val(data.data.width);
                $('#edit_text_height').val(data.data.height);
                $('#edit_text_field_four').val(data.data.field_four);
                $('#edit_text_field_three').val(data.data.field_three);
                $('#edit_text_font_name').val(data.data.font_name);

            }
            else {
                alert(data.message)
            }
        }
    });
}

function updateText() {
    $('span.alerts').remove();
    $('#text-edit-message').html('');
    var form = document.editTextForm;

    var formData = new FormData(form);

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});

    $.ajax({
        type: 'POST',
        url: APP_URL + '/frame/updateText',
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
        }
        ,success: function (data)
        {
            if (data.status == 401)
            {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {

                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;

            }
            if(data.status) {
                // $('#editTextModal').modal('hide');
                // clearEditTextForm();
                table3.ajax.reload();
                $('#text-edit-message').html('<span class="text-success">' + data.message + '</span>');
            }
            else {
                alert(data.message);
            }

        }
    });
}


function deleteText(ele) {
    var id = $(ele).data('id');

    swal({
        title: 'Are you sure?',
        text: "Remove this Text!",
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
                url:APP_URL+"/frame/deleteText",
                data: {"id":id},
                success: function (data)
                {
                    if(data.status) {
                        table3.ajax.reload();
                    }
                    else {
                        alert(data.message)
                    }
                    $('.loader-custom').css('display','none');
                }
            });
        } else {
            swal.close();
        }
    });
}

function clearAddTextForm() {
    $('span.alerts').remove();
    $('#text_for').val('');
    $('#text_order_').val('');
    $('#text_color').val('');
    $('#text_pos_x').val('');
    $('#text_pos_y').val('');
    $('#text_width').val('');
    $('#text_height').val('');
    $('#text_field_four').val('unlocked');
    $('#text_field_three').val('C');
    $('#text_font_name').val('en_roboto_regular.ttf');
}

function clearEditTextForm() {
    $('span.alerts').remove();
    $('#edit_text_id').val('');
    $('#edit_text_for').val('');
    $('#edit_text_color').val('');
    $('#edit_text_order_').val('');
    $('#edit_text_pos_x').val('');
    $('#edit_text_pos_y').val('');
    $('#edit_text_width').val('');
    $('#edit_text_height').val('');
    $('#edit_text_field_four').val('unlocked');
    $('#edit_text_field_three').val('C');
    $('#edit_text_font_name').val('en_roboto_regular.ttf');
}
