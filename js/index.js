$(function(){
	var appendhtml = "";
	$(document).on('click','#button',function(){
		event.preventDefault();
		$.ajax({
			url:"index.php",
			data: {
				d_station: $("select[name='d_station']").val(),
				a_station: $("select[name='a_station']").val(),
					 send: $("input[name='send']").val(),
			},
			type: "POST"
		}).done(function(response) {
			if (response === "検索できます"){
				alert(response);
			}else{
				alert(response);
				// location.reload();
				return false;
			}
		}).fail(function() {
			alert("通信エラー");
		});
	});

});