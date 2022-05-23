var table = "";

$(document).ready(function() {
    getMusic();
});

function getMusic() {
    var id = $('#category_id').val();
    table = $('#music-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/music/getMusicByCategory/' + id,
        columns: [
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'audio', name: 'audio'},
            {data: 'language_id', name: 'language_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-music').click(function() {
    clearAddMusicForm();
    $('#add-music-modal').modal('show');
});

function clearAddMusicForm() {
    $('span.alerts').remove();
    $('#name').val("");
    $('#language_id').val("");
    $('#image').val("");
    $('#audio').val("");
}

function clearEditMusicForm() {
    $('span.alerts').remove();
    $('#edit_id').val("");
    $('#edit_name').val("");
    $('#edit_language_id').val("");
    $('#edit_image').val("");
    $('#edit_audio').val("");
}

function addMusic() {

    $('span.alerts').remove();
    var form = document.addMusicForm;
    var formData = new FormData(form);

    $('.loader-custom').css('display','block');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        url: APP_URL + '/music/addMusic',
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
                table.ajax.reload();
                clearAddMusicForm();
                $('#add-music-modal').modal('hide');
                return false;
            }
            alert(response.message);function addMusicCategory() {
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
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    })
}

function editMusic(ele) {
    clearEditMusicForm();
    var id = $(ele).data('id');

    $('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + '/music/getMusicById',
        type: 'POST',
        data: {id},
        dataType: 'json',
        success: function(response) {
            $('.loader-custom').css('display','none');
            if(response.status) {
                const data = response.data;
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_language_id').val(data.language_id);
                $('#edit-music-modal').modal('show');
            }
            else {
                alert(response.message);
            }
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    })
}

function updateMusic() {
    $('span.alerts').remove();
    var form = document.editMusicForm;
    var formData = new FormData(form);

    $('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + '/music/updateMusic',
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
                $('#edit-music-modal').modal('hide');
                table.ajax.reload();
                clearEditMusicForm();
                return false;
            }
            alert(response.message);
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    })
}

function deleteMusic(ele) {
    var id = $(ele).attr('data-id');
    swal({
        title: 'Are you sure?',
        text: "Remove this music!",
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
                url: APP_URL+'/music/deleteMusic',
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
