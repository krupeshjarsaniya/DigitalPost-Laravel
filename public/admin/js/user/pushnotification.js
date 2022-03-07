function validateForm() {

	var discription = document.forms["notificationForm"]["discription"].value;

	if (discription.trim() == "" ) {
	  alert("Discription Field is require");
	  return false;
	}

	return true;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        $('#image').attr('src', '');
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };
        $('#image').css('display', 'block');
        reader.readAsDataURL(input.files[0]);
    }
}

// $("form[name='notificationForm']").onsubmit(function(ev) {
//     ev.preventDefault(); // Prevent browser default submit.
//     alert('asasw');
//     if(validateForm()){

//         $('.loader-custom').css('display','block');
//         $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }});

       
          
//         var formData = new FormData(this);
            
//         $.ajax({
//             url: APP_URL+"/user/sendpushnotification",
//             type: "POST",
//             data: formData,
//             success: function (response) {
//             // $('#categoryname').val(response.data);
//                 console.log(response.data);
//             },
//             // cache: false,
//             // contentType: false,
//             // processData: false
//         });
              
       

//         // $.ajax({
//         //     type:'POST',
//         //     url:APP_URL+"/user/sendpushnotification",
//         //     data: {
//         //         "description":description,
//         //         "personType":personType,

//         //     },
//         //     success: function (response)
//         //     {	
//         //         $('#categoryname').val(response.data['name']);

//         //         $('#imageone').attr('src',response.data['image_one']);
//         //         $('#bannerimg').attr('src',response.data['banner_image']);
//         //         $('#imageone').css('display', 'block');
//         //         $('#bannerimg').css('display', 'block');
//         //         showinsertform();
//         //         $('.loader-custom').css('display','none');
//         //     }
//         // });
//     }
    
// });

