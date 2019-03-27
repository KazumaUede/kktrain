$(function(){
	$(document).on('#button1',function(){
		$('p').remove();
		var error_flg = false;
		if ($("input[name='name']").val().length < 2) {

			// alert('名前は２文字以上必要です。');
			$('#name').append('<p>名前は２文字以上必要です。</p>')
			error_flg = true;
		}
		if ($("input[name='name']").val().length > 30) {
			// alert('名前の上限は３０文字です。');
			$('#name').append("<p>名前の上限は３０文字です。</p>")
			error_flg = true;
		}
		if ($("input[name='password']").val().length < 6) {
			// alert('おまじないは6文字以上必要です。');
			$('#password').append("<p>おまじないは6文字以上必要です。</p>")
			error_flg = true;
		}
		if ($("input[name='password']").val().length > 30) {
			// alert('おまじないの上限は３０文字です。');
			$('#password').append("<p>おまじないの上限は３０文字です。</p>")
			error_flg = true;
		}
		if(!error_flg){
			// alert('成功しました');
			$("#sample-form").submit();





















			
		}
		else {
			// alert('失敗しました');
			return false;
		}
	});
	$(document).on('#button2',function(){});
	$(document).on('#button3',function(){
		error_flg = $("input[name='name']").val().length < 2 ||
					$("input[name='name']").val().length > 30 ||
					$("input[name='password']").val().length < 6 ||
					$("input[name='password']").val().length > 30 ? true : false;
		if(!error_flg){
			// alert('成功しました');
			$("#button3").submit();
		}
		else {
			// alert('失敗しました');
			return false;
		}
	});
});