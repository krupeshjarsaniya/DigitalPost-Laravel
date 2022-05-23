var field =
    '<div class="row">\
				<div class="col-md-8">\
					<div class="form-group">\
						<input type="text" class="form-control information" placeholder="Add Information">\
					</div>\
				</div>\
				<div class="col-md-2 form-group">\
					<button type="button" onclick="addbox()" class="btn btn-primary"><i class="fa fa-plus"></i></button>\
					<button type="button" onclick="removebox(this)" class="btn btn-primary"><i class="fa fa-minus"></i></button>\
				</div>\
			</div>';

function show() {
    $('span.alerts').remove();
    $("#updateplan").show();
    $("#viewplans").hide();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#blah").attr("src", e.target.result).width(150).height(200);
        };
        $("#blah").css("display", "block");
        reader.readAsDataURL(input.files[0]);
    }
}

function resetForm() {
    $("#planid").val("");
    $("#planname").val("");
    $("#validity").val("");
    $("#price").val("");
    $("#orderno").val("");
    $("#bg_credit").val("");
    $("#plantype").val(1);
    $("#new_or_renewal").val("new");
    $("#blah").attr("src", "#");
}

function addbox() {
    $("#addinformation").append(field);
}

function cencelediting() {
    $("#updateplan").hide();
    $("#viewplans").show();
    resetForm();
}

function removebox(curr) {
    $(curr).closest(".row").remove();
}

function getdataforupdateplan(id) {
    $('span.alerts').remove();
    $(".loader-custom").css("display", "block");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: APP_URL + "/plan/getdetailforedit",
        data: { id: id },
        success: function (data) {
            $("#planname").val(data.plan_or_name);
            $("#planid").val(data.plan_id);

            $("#validity").val(data.plan_validity);
            $("#validitytime").val(data.plan_validity_type);
            $("#bg_credit").val(data.bg_credit);
            $("#plantype").val(data.plan_type);
            $("#new_or_renewal").val(data.new_or_renewal);

            $("#price").val(data.plan_actual_price);
            $("#orderno").val(data.order_no);
            $("#blah").attr("src", SPACE_STORE_URL + data.image);

            $("#updateplan").show();
            $("#viewplans").hide();
            $(".loader-custom").css("display", "none");
        },
    });
}

function updateplan() {
    $('span.alerts').remove();
    var form = document.getElementById("plandata");
    var formData = new FormData(form);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: APP_URL + "/plan/updateplan",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $(".loader-custom").css("display", "none");
            if (data.status == 401) {
                $.each(data.error1, function (index, value) {
                    if (value.length != 0) {
                        $(".err_" + index).append(
                            '<span class="alerts">' + value + "</span>"
                        );
                    }
                });
            }
            if (data.status == 1) {
                location.reload();
            }
        },
    });
}

function blockUser(id) {
    swal({
        title: "Are you sure?",
        text: "Block this plan",
        type: "warning",
        buttons: {
            confirm: {
                text: "Yes, Bolck it!",
                className: "btn btn-success",
            },
            cancel: {
                visible: true,
                className: "btn btn-danger",
            },
        },
    }).then((block) => {
        if (block) {
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
                url: APP_URL + "/plan/block-plan",
                data: { id: id },
                success: function (data) {
                    if (data.status == 1) {
                        location.reload();
                    }
                    $(".loader-custom").css("display", "none");
                },
            });
        } else {
            swal.close();
        }
    });
}

function unblockUser(id) {
    swal({
        title: "Are you sure?",
        text: "UnBlock this paln",
        type: "warning",
        buttons: {
            confirm: {
                text: "Yes, Bolck it!",
                className: "btn btn-success",
            },
            cancel: {
                visible: true,
                className: "btn btn-danger",
            },
        },
    }).then((block) => {
        if (block) {
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
                url: APP_URL + "/plan/unblock-plan",
                data: { id: id },
                success: function (data) {
                    if (data.status == 1) {
                        location.reload();
                    }
                    $(".loader-custom").css("display", "none");
                },
            });
        } else {
            swal.close();
        }
    });
}
