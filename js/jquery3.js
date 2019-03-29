$(function(){
	var error_flg ;
	var beforecsrf_token;
	var aftercsrf_token;
	var inputname;
	var inputpassword;
	var appendhtml = "";

	//確認ボタン
	$(document).on('click','#button1',function(){
		event.preventDefault();
		$('p').remove();
		$.ajax({
			url:"jquery3.php",
			data: {
				csrf_token: $("input[name='csrf_token']").val(),
				name: $("input[name='name']").val(),
				password: $("input[name='password']").val()
			},
			type: "POST"
		}).done(function(response) {
			if (response === "ok"){
				inputname = $("input[name='name']").val();
				inputpassword = $("input[name='password']").val();
				maskpassword = '';
				for(i =0 ;i < inputpassword.length; i++){
					maskpassword += '*';
				}
				$('.inputswitch').remove();
				appendhtml = '<div class ="inputswitch"><h5><em>入力内容をご確認ください。</em></h5></div>';
				$('.title_container').append(appendhtml);
				appendhtml = '<div class ="inputswitch"><input type="hidden" name="name" value="' + inputname + '" /></div>';
				appendhtml += '<div class ="inputswitch"><div class="container_input">' + inputname + '</div></div>';
				$('.name_container').append(appendhtml);
				appendhtml = '<div class ="inputswitch"><input type="hidden" name="password" value="' + inputpassword + '" /></div>';
				appendhtml += '<div class ="inputswitch"><div class="container_input">' + maskpassword + '</div></div>';
				$('.password_container').append(appendhtml);
				appendhtml = '<div class ="inputswitch"><input id="button2" type="submit" value="修正"  name="button2"><input id="button3" type="submit" value="送信"  name="button3"></div>';
				$('.button_container').append(appendhtml);
				$('.error_msg').css({
					"border": "0px solid #dc143c"
				});
			}else{
				$('.error_msg').append(response).css({
					"border" : "1px solid #dc143c"
				});
			}

		}).fail(function() {
			alert("通信エラー");
		});
	});

	//修正ボタン
	$(document).on('click','#button2',function(){
		event.preventDefault();
		$('.inputswitch').remove();
		appendhtml = '<div class ="inputswitch"><input type="text" name="name" value="' + inputname + '" placeholder=" (例)佐藤太郎" required maxlength="30" /></div>'
		$('.name_container').append(appendhtml);
		appendhtml = '<div class ="inputswitch"><input  type="password" name="password" value="' + inputpassword + '" placeholder="(例)となりの４８はあ０１" required maxlength="30" /></div>'
		$('.password_container').append(appendhtml);
		appendhtml = '<div class ="inputswitch"><input id="button1" type="submit" value="確認"  name="button1"></div>';
		$('.button_container').append(appendhtml);
	});

	$(document).on('click','#button2',function(){
		event.preventDefault();
		$('.inputswitch').remove();
		appendhtml = '<div class ="inputswitch"><input type="text" name="name" value="' + inputname + '" placeholder=" (例)佐藤太郎" required maxlength="30" /></div>'
		$('.name_container').append(appendhtml);
		appendhtml = '<div class ="inputswitch"><input  type="password" name="password" value="' + inputpassword + '" placeholder="(例)となりの４８はあ０１" required maxlength="30" /></div>'
		$('.password_container').append(appendhtml);
		appendhtml = '<div class ="inputswitch"><input id="button1" type="submit" value="確認"  name="button1"></div>';
		$('.button_container').append(appendhtml);
	});

});