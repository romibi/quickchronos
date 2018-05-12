// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt). 
function createProject() {
	let project = {};
	project.id = $('input[name="projectId"]').val();
	project.name = $('input[name="projectName"]').val();
	project.members = [{'id': $.cookie('user')}];
	console.log(project);
	$.ajax({ 
		type: "PUT",
		contentType : 'application/json',
		url: "/api/project/"+project.id,
		data: JSON.stringify(project),
		success: function(){
			window.location.reload();
		},
		error: logAjaxError
	});
}

function projectAction(action) {
	let projectId = $('input[name="projectId"]').val();
	let userId = $.cookie('user');
	$.ajax({
		type: "PUT",
		contentType: 'application/json',
		url: "/api/project/"+projectId+"/"+action,
		data: '{"user": {"id": "'+userId+'"}}',
		success: function(data) {
			window.location.href = "/project/"+projectId
		},
		error: logAjaxError
	});
}

function logAjaxError(xhr, textStatus, thrownError) {
	console.log("error: "+xhr.responseText+", "+textStatus+", "+thrownError);
}