$(function(){
	// $('#id1').load('data/bannerlist.txt',function(){
	// 	$(this).append('test');
	// });

	$.ajax({
		url: 'data/bannerlist.txt',
		cache: false
	}).done(function(msg){
		var data_array = msg.split('\n');
		var len = data_array.length;
		var count = 1;
		var appendhtml ='<table><tr><th>バナー名</th><th>色</th></tr>';
		var sample = Array();
		sample[sample.length] = '<table><tr><th>バナー名</th><th>色</th></tr>';
		for(var i = 0; i < len; i++){
			if(data_array[i] !== ""){
				var data = data_array[i].split('\t');
				if(typeof data[1] != "undefined") {
					appendhtml += '<tr><td>' + data[0] + '</td><td>' + data[1] + '</td></tr>';
					sample[sample.length] = '<tr><td>';
					sample[sample.length] = data[0];
					sample[sample.length] = '</td><td>';
					sample[sample.length] = data[1];
					sample[sample.length] = '</td></tr>';
				}
			}
		}
		appendhtml += '</table>';
		sample[sample.length] = '</table>';
		//$('#id1').append(appendhtml);
		$('#id1').append(sample.join(''));
	}).fail(function(){

	}).always(function(){

	});

});