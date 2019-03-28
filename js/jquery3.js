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
		error_flg = false;
		beforecsrf_token = $("input[name='csrf_token']").val();
		inputname = $("input[name='name']").val();
		inputpassword = $("input[name='password']").val();
		maskpassword = '';
		for(i =0 ;i < inputpassword.length; i++){
			maskpassword += '*';
		}
		if (inputname.length < 2) {

			// alert('名前は２文字以上必要です。');
			$('#name').append('<p>名前は２文字以上必要です。</p>')
			error_flg = true;
		}
		if (inputname.length > 30) {
			// alert('名前の上限は３０文字です。');
			$('#name').append("<p>名前の上限は３０文字です。</p>")
			error_flg = true;
		}
		if (inputpassword.length < 6) {
			// alert('おまじないは6文字以上必要です。');
			$('#password').append("<p>おまじないは6文字以上必要です。</p>")
			error_flg = true;
		}
		if (inputpassword.length > 30) {
			// alert('おまじないの上限は３０文字です。');
			$('#password').append("<p>おまじないの上限は３０文字です。</p>")
			error_flg = true;
		}
		if(!error_flg){

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
		}
		else {
			return false;
		}
	});
	//修正ボタン
	$(document).on('click','#button2',function(){
		event.preventDefault();
		aftercsrf_token = $("input[name='csrf_token']").val();
		if (beforecsrf_token === aftercsrf_token){
			beforecsrf_token = aftercsrf_token;
			$('.inputswitch').remove();
			appendhtml = '<div class ="inputswitch"><h5>投稿フォーム</h5></div>';
			$('.title_container').append(appendhtml);
			appendhtml = '<div class ="inputswitch"><input type="text" name="name" value="' + inputname + '" placeholder=" (例)佐藤太郎" required maxlength="30" /></div>'
			$('.name_container').append(appendhtml);
			appendhtml = '<div class ="inputswitch"><input  type="password" name="password" value="' + inputpassword + '" placeholder="(例)となりの４８はあ０１" required maxlength="30" /></div>'
			$('.password_container').append(appendhtml);
			appendhtml = '<div class ="inputswitch"><input id="button1" type="submit" value="確認"  name="button1"></div>';
			$('.button_container').append(appendhtml);
		}else{
			alert('失敗しました');
			return false;
		}
	});
	//送信ボタン
	$(document).on('click','#button3',function(){
		event.preventDefault();
	});
});