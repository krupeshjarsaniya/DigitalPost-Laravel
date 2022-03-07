var allpost = $('#video-post-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: APP_URL+'/festival/allvideopostlist',
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		{data: 'date', name: 'date'},
		{data: 'color', name: 'color'},
		{data: 'thumbnail', name: 'thumbnail'},
		{data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});

$('#festivaldate').datetimepicker({
    format: 'YYYY-MM-DD',
});
function showinsertform(){
	$('#addVideo').show();
	$('#viewVideosList').hide();
}

function showfestivallist(){
	$('#addVideo').hide();
	$('#viewVideosList').show();
	resetForm();
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function resetForm() {

	$('#video_post_id').val('');
	$('#video_thumbnail').val('');
	$('#festivaldate').val('');
	$('#color').val('');
	$('#video_file').val('');
	$('#blah').attr('src', '#');
	$("span.pip").remove();
	$('#festival-btn').attr('onclick', 'addFestival()');
	
}

function removeVideo(id){
	swal({
		title: 'Are you sure?',
		text: "Remove this video",
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
	}).then((block) => {
		if (block)
		{
		    $('.loader-custom').css('display','block');
			$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/festival/remove-video",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
					    location.reload();
					  
					}
					$('.loader-custom').css('display','none');
				}
			});
		}
		else
		{
			swal.close();
		}
	});
}

function editVideoPost(id){
	$('.loader-custom').css('display','block');
			$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});

			$.ajax({
				type:'POST',
				url:APP_URL+"/festival/get-video-post-edit",
				data: {"id":id},
				success: function (data)
				{
					if (data.status)
					{
						console.log(data.data);
						$('#video_post_id').val(id);
						$('#festivaldate').val(data.data.date);
						$('#color').val(data.data.color);
						$('#blah').attr('src', data.data.thumbnail);
						$('#blah').css('display','block');
						showinsertform();
					}
					$('.loader-custom').css('display','none');
				}
			});
}

// $('#categotyform').submit(function () {


// 	var content = $.trim($('#festivaldate').val());
// 	var vidFileLength = $("#video_thumbnail")[0].files.length;
// 	var video_file = $("#video_file")[0].files.length;

// 	if (content  === '' || vidFileLength == 0 || video_file == 0) {
// 		alert('Video, Thumbnail and date should not be empty');
// 		return false;
// 	}

//   });

