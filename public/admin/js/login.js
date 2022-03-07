function login()
{
    $('span.alerts').remove();

    var form = document.loginForm;

    var formData = new FormData(form);
    
    $.ajax({
        type: 'POST',
        url: APP_URL + '/login',
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

            if (data.status == 1)
            {
                window.location.href = data.redirect;
            }
        }
    });
}
