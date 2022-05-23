var table = "";

$(document).ready(function() {
    getMusicCategory();
});

function getMusicCategory() {

    table = $('#music-category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/musicCategory/getMusicCategory',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'order_number', name: 'order_number'},
            {data: 'is_active', name: 'is_active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-music-category').click(function() {
    $('span.alerts').remove();
    clearAddCategoryForm();
    $('#music-category-modal').modal('show');
});

function clearAddCategoryForm() {
    $('#category').val('');
    $('#order_number').val('');
    $('#is_active').val('');
}

function clearEditCategoryForm() {
    $('#edit_category').val("");
    $('#edit_id').val("");
    $('#edit_order_number').val("");
    $('#edit_is_active').val("");
}

function addMusicCategory() {
    $('span.alerts').remove();
    var form = document.musicCategoryForm;
    var formData = new FormData(form);
    $('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL+'/musicCategory/addMusicCategory',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            $('.loader-custom').css('display','none');
            if(data.status == 401) {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }

                });
                return false;
            }
            if(data.status) {
                $('#music-category-modal').modal('hide');
                table.ajax.reload();
                clearAddCategoryForm();
                return false;
            }
            alert(data.message);

        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    });
}

function editMusicCategory(ele) {
    $('span.alerts').remove();
    clearEditCategoryForm();
    var id = $(ele).data('id');
    $('.loader-custom').css('display','block');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        url: APP_URL + '/musicCategory/getMusicCategoryById',
        type: 'POST',
        data: {id},
        dataType: 'json',
        success: function(response) {
            if(!response.status) {
                alert(response.message);
                return false;
            }
            else {
                var data = response.data;
                $('#edit-music-category-modal').modal('show');
                $('#edit_id').val(data.id);
                $('#edit_order_number').val(data.order_number);
                $('#edit_category').val(data.name);
                $('#edit_is_active').val(data.is_active);
            }
            $('.loader-custom').css('display','none');
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    })
}

function updateMusicCategory() {
    $('span.alerts').remove();
    var form = document.editMusicCategoryForm;
    var formData = new FormData(form);

    $('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + '/musicCategory/updateMusicCategory',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $('.loader-custom').css('display','none');
            if(response.status == 401) {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $('.err_' + index).append('<span class="small alerts text-danger">' + value + '</span>');
                    }
                });
                return false;
            }
            if(response.status) {
                $('#edit-music-category-modal').modal('hide');
                table.ajax.reload();
                clearEditCategoryForm();
                return false;
            }
            alert(response.message);
        },
        error: function(error) {
            console.log(error);
            $('.loader-custom').css('display','none');
        }

    })


}

function deleteMusicCategory(ele) {
    var id = $(ele).attr('data-id');
    swal({
        title: 'Are you sure?',
        text: "Remove this category!",
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
        if(result) {
            $('.loader-custom').css('display','block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: APP_URL+'/musicCategory/deleteMusicCategory',
                type: 'POST',
                data: {id: id},
                success: function (data) {
                    if(data.status) {
                        table.ajax.reload();
                    }
                    else {
                        alert(data.message)
                    }
                    $('.loader-custom').css('display','none');
                }
            });
        }
        else {
            swal.close();
        }
    });


}

