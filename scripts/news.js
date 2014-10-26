NewsScript = {}

$(document).ready(function() {
	
	$(".deleteLink").click(function(e) {		
		return confirm("Are you sure you wish to delete this news post?");
	});
});