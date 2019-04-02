$(function(){
	var appendhtml = "";
	$(document).on('click','#button',function(){
		event.preventDefault();
		$.ajax({
			url:"signin.php",
			data: {
				csrf_token: $("input[name='csrf_token']").val(),
				name: $("input[name='name']").val(),
				password: $("input[name='password']").val(),
				send: $("input[name='send']").val()
			},
			type: "POST"
		}).done(function(response) {
			if (response === "ok"){
			}else{
				alert(response);
				location.reload();
				return false;
			}
		}).fail(function() {
			alert("通信エラー");
		});
	});

});