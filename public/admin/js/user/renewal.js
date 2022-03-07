var table = "";

$(document).ready(function() {
    getRenewalPlanList();
})

function getRenewalPlanList() {
    if(table != "") {
        table.destroy();
    }
    var type = $('#type').val();
    var status = $('#filter_status').val();
    var follow_up_date = $('#filter_follow_up_date').val();
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    table = $('#renewal-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL+'/renewal/list',
            type: "POST",
            data: {type, status, follow_up_date}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'purc_id'},
            {data: 'name', name: 'users.name'},
            {data: 'mobile', name: 'users.mobile'},
            {data: 'business_type', name: 'business_type', orderable: false, searchable: false},
            {data: 'business_name', name: 'business_name', orderable: false, searchable: false},
            {data: 'plan_name', name: 'plan.plan_name'},
            {data: 'start_date', name: 'purchase_plan.purc_start_date'},
            {data: 'end_date', name: 'purchase_plan.purc_end_date'},
            {data: 'telecaller', name: 'telecaller', orderable: false, searchable: false},
            {data: 'telecaller_status', name: 'telecaller_status', orderable: false, searchable: false},
            {data: 'follow_up_date', name: 'follow_up_date', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}