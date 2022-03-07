<div class="table-responsive">
    <table class="display table table-striped table-hover text-center" id="view-business-comment-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($business_comments as $business_comment)
            <tr>
                <td>
                    {{$business_comment->id}}
                </td>
                <td>
                    {{$business_comment->comment}}
                </td>
                <td>
                    {{\Carbon\Carbon::parse($business_comment->created_at)->format('Y-m-d H:i')}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $('#view-business-comment-list').DataTable({
      "ordering": false
    });
</script>