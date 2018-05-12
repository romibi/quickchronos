// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt). 
function login() {
	let username = $('input[name="username"]').val();
	$.ajax({ 
		type: "GET",
		contentType : 'application/json',
		dataType: "json",
		url: "/api/user/"+username,
		success: function(data){
			$.cookie("user", data.id,{ expires : 30000, path: "/" });
		},
		error: function(xhr, textStatus, thrownError) {
			console.log("error: "+xhr+", "+textStatus+", "+thrownError);
		}
	});
}