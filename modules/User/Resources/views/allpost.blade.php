@extends('admin.layouts.app')
@section('title', 'Posts')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="page-header">
    <h4 class="page-title">Posts</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Posts</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12" id="viewPostlist">
        <select class="d-none" id="telecaller_list">
            <option disabled selected>Select Telecaller</option>
            @foreach($telecallers as $telecaller)
                <option value="{{$telecaller->id}}">{{$telecaller->name}}</option>
            @endforeach
        </select>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Posts
                <!-- <button class="btn btn-info btn-sm pull-right" id="add-country"><i class="fas fa-plus"></i></button> -->
                 <div class="form-group  pull-right ">
                    <input type="text" name="daterange" class="form-control pull-right" value="" placeholder="Select Date" autocomplete="off" />
                </div>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="allpost-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>Mobile</th>
                                <th>Total</th>
                                <th>Image</th>
                                <th>Telecaller</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assigneTelecallerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Assigne Telecaller</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form name="assigneTelecallerForm" id="assigneTelecallerForm">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group err_telecaller_id">
                                <label for="telecaller_id">Select Telecaller</label><br>
                                <select name='telecaller_id' id="telecaller_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group err_follow_up_date">
                                <label>Follow-Up Date</label><br>
                                <input type="date" class="form-control" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-success"  onclick="assigneTelecallerAdd()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/user.js?v='.rand()) }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        function assigneTelecaller(ele) {
            user_id = $(ele).data('id');
            $('#user_id').val(user_id);
            $('#telecaller_id').html('');
            $('#telecaller_id').val('');
            $('#follow_up_date').val(null);
            var telecallerList = $('#telecaller_list').html();
            $('#telecaller_id').html(telecallerList);
            $('#assigneTelecallerModal').modal('show');
        }

        function assigneTelecallerAdd() {
            $('span.alerts').remove();

            var form = document.assigneTelecallerForm;

            var formData = new FormData(form);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

            $.ajax({
                type: 'POST',
                url: APP_URL + '/user/allpostassigneTelecallerAdd',
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
                        $('#user_id').html("");
                        $('#telecaller_id').html('');
                        $('#telecaller_id').val('');
                        $('#follow_up_date').val(null);
                        $('#assigneTelecallerModal').modal('hide');
                        getAllpost();
                    }
                }
            });
        }

        function previewimg(thisele){
            var src = $(thisele).attr("src");
            $(".img-model").fadeIn();
            $(".img-show img").attr("src", src);
        }
        
        $("span, .overlay").click(function () {
            $(".img-model").fadeOut();
        });

        $(function() {


            $('input[name="daterange"]').daterangepicker({
                  autoUpdateInput: false,
                  opens: 'left',
                  format: 'DD-MM-YYYY',
                  locale: {
                      cancelLabel: 'Clear'
                  }
                }, function(start, end, label) {
            });


          $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
              from = picker.startDate.format('DD-MM-YYYY');
              to = picker.endDate.format('DD-MM-YYYY');
              DeletePhotos();
          });

          $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
              
            });

        });
    </script>
@endsection