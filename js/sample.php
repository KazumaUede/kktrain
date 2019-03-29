<?php
	if(isset($_GET["sample"])){
		echo "sample!!!".$_GET["sample"];
		echo "sample!!!".$_GET["sample2"];exit;
	}else{
	}
?><html>
	<head>
		<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
		<script>
			$(function(){
				$("button").on("click", function(){
					$.ajax({
						url:"sample.php",
						data: "sample=yaa" + "&sample2=bomb",
						type: "GET"
					}).done(function(msg){
						alert(msg);
						$('.test').append(msg);

					}).fail(function(msg){
						alert("失敗しました");

					});
				});
			});
		</script>
	</head>
	<body>
		<div class ="test"></div>
		<button>testbutton</button>
	</body>
</html>