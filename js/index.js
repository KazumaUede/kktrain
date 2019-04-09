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
			//json形式
			dataType: 'json',
			type: "POST"
		}).done(function(response) {
			var appendhtml;
			console.log(response);
			$.each(response,function(key,data){
				appendhtml = '<li>' + data.name + '</li>'
				$('#result').append(appendhtml);
                // console.log(data.name);
            })
		}).fail(function() {
			alert("通信エラー");
		});
	});

});