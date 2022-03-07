<div class="table-responsive">
    <table class="display table table-striped table-hover text-center" id="custom-frame-list">
        <thead>
            <tr>
                <th>Frame</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($frames as $frame)
            <tr>
                <td>
                    <img style="width: 100px;height:100px;" src="{{$frame->frame_url}}"/>
                </td>
                <td>
                    {{$frame->date_added}}
                    {{-- {{\Carbon\Carbon::parse($frame->date_added)->format('Y-m-d H:i')}} --}}
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" data-id="{{$frame->business_id}}" data-type="{{$frame->business_type}}" onclick="removeFrame(this,{{$frame->user_frames_id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $('#custom-frame-list').DataTable();
</script>