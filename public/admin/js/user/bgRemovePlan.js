var table = "";

$(document).ready(function() {
    getBGRemovePlan();
})

function getBGRemovePlan() {
    table = $('#bg-remove-plan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_URL+'/bg-remove-plan/getBGRemovePlanList',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'bg_credit', name: 'bg_credit'},
            {data: 'order_number', name: 'order_number'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#add-bg-remove-plan').click(function() {
    clearAddBGRemoveForm();
    $('#add-bg-remove-plan-modal').modal('show');
});

function addBGRemovePlanFun() {
    $('span.alerts').remove();
    var form = document.addBGRemovePlanForm;
    var formData = new FormData(form);

    $(".loader-custom").css("display", "block");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: APP_URL + '/bg-remove-plan/addBGRemovePlan',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            $(".loader-custom").css("display", "none");
            if (response.status == 401) {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $(".err_" + index).append(
                            '<span class="alerts">' + value + "</span>"
                        );
                    }
                });
                return false;
            }
            if(response.status) {
                $('#add-bg-remove-plan-modal').modal('hide');
                table.ajax.reload();
                clearAddBGRemoveForm();
                return false;
            }
            alert(response.message);
        },
        error: function (error) {
            $(".loader-custom").css("display", "none");
        }
    })
}

function editBGRemovePlan(ele) {
    clearEditBGRemoveForm();
    var id = $(ele).data('id');
    $(".loader-custom").css("display", "block");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: APP_URL + '/bg-remove-plan/getBGRemovePlanById',
        type: 'POST',
        data: {id},
        dataType: 'json',
        success: function(response) {
            $(".loader-custom").css("display", "none");
            if(response.status) {
                var data = response.data;
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_price').val(data.price);
                $('#edit_bg_credit').val(data.bg_credit);
                $('#edit_order_number').val(data.order_number);
                $('#edit-bg-remove-plan-modal').modal('show');
                return false;
            }
            alert(response.message);
        },
        error: function(error) {
            $(".loader-custom").css("display", "none");
        }
    })
}

function updateBGRemovePlanFun() {
    $('span.alerts').remove();
    var form = document.editBGRemovePlanForm;
    var formData = new FormData(form);

    $(".loader-custom").css("display", "block");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: APP_URL + '/bg-remove-plan/updateBGRemovePlan',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(response) {
            $(".loader-custom").css("display", "none");
            if (response.status == 401) {
                $.each(response.error1, function (index, value) {
                    if (value.length != 0) {
                        $(".err_" + index).append(
                            '<span class="alerts">' + value + "</span>"
                        );
                    }
                });
                return false;
            }
            if(response.status) {
                $('#edit-bg-remove-plan-modal').modal('hide');
                table.ajax.reload();
                clearEditBGRemoveForm();
                return false;
            }
            alert(response.message);
        },
        error: function(error) {
            $(".loader-custom").css("display", "none");
        }
    })
}

function changeStatusBGRemovePlan(ele) {
    var id = $(ele).data('id');
    var status = $(ele).data('status');

    swal({
        title: "Are you sure?",
        text: status + " this plan",
        type: "warning",
        buttons: {
            confirm: {
                text: "Yes, " + status + " it!",
                className: "btn btn-success",
            },
            cancel: {
                visible: true,
                className: "btn btn-danger",
            },
        },
    }).then((result) => {
        if (result) {
            $(".loader-custom").css("display", "block");
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                type: "POST",
                url: APP_URL + '/bg-remove-plan/updateStatusBGRemovePlan',
                data: { id, status },
                success: function (data) {
                    $(".loader-custom").css("display", "none");
                    if (data.status) {
                        table.ajax.reload();
                    }
                    else {
                        alert(data.message);
                    }
                },
                error: function(error) {
                    $(".loader-custom").css("display", "none");
                }
            });
        } else {
            swal.close();
        }
    });
}

function clearAddBGRemoveForm() {
    $('span.alerts').remove();
    $('#name').val("");
    $('#price').val("");
    $('#bg_credit').val("");
    $('#order_number').val("");
    $('#status').val("");
}

function clearEditBGRemoveForm() {
    $('span.alerts').remove();
    $('#edit_id').val("");
    $('#edit_name').val("");
    $('#edit_price').val("");
    $('#edit_bg_credit').val("");
    $('#edit_order_number').val("");
}
