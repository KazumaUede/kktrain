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
			// $('tr').remove();
			$('.routes').remove();
			var appendhtml;
			console.log(response);
			var station_name;
			appendhtml = '<div class="routes">'  + response + '</div>';
			$('.result').append(appendhtml)
			//駅データ確認用
			// appendhtml ="<tr><th>id</th><th>name</th><th>local</th><th>a_express</th><th>l_express</th><th>kl_express</th><th>ak_express</th></tr>";
			// $.each(response,function(key,data){
			// 	appendhtml += "<tr><th>" + data.id +"</th><th>" + data.name +"</th><th>" + data.local +  "</th><th>" + data.a_express + "</th><th>" + data.l_express + "</th><th>" + data.kl_express + "</th><th>" + data.ak_express +  "</th></tr>"
				
            //     // console.log(data.name);
			// })
			// $('.result').append(appendhtml);
		}).fail(function() {
			alert("通信エラー");
		});
	});

});