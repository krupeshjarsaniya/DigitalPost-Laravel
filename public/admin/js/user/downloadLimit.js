function updateLimit() {
    $('span.alerts').remove();
    var form = document.downloadLimitForm;
    var formData = new FormData(form);

    $('.loader-custom').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: APP_URL + '/download-limit/update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
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
            alert(response.message);
        },
        error: function(error) {
            $('.loader-custom').css('display','none');
        }
    });
}
