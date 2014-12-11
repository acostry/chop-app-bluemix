<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bluemix-PHP</title>
<style type="text/css">
<!--
body, td, th {
	font-size: 12px;
	background-color: #FFF3E3;
	color: #373737;
}

.main {
	width: 510px;
	height: 310px;
	background-image: url(images/bg.png);
	background-repeat: no-repeat;
	margin-left: auto;
	margin-right: auto;
	margin-top: 100px;
	position: relative;
}

.main .memo {
	position: absolute;
	top: 65px;
	left: 20px;
}

.main .flag {
	position: absolute;
	top: 88px;
	left: 20px;
}

input {
	border: #373737 solid 1px;
	height: 20px;
	width: 200px;
	padding-left: 3px;
	border-left: #373737 solid 5px;
}

.main .btn {
	position: absolute;
	top: 65px;
	left: 229px;
	width: 65px;
	height: 47px;
	background-color: #393939;
	color: #ddd;
	cursor: pointer;
}

.main .imags {
	position: absolute;
	top: 135px;
	left: 40px;
}
-->
</style>
</head>
<body>
	<div class="main">
		<div class="memo">
			<input name="memo" type="text" id="memo" />
		</div>

		<input type="button" value="Generate" onclick="makeImg()" class="btn" />
		
		<div class="imags">
			<img id="cachet" name="cachet" src="cachet.php" />
		</div>
		
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
function makeImg(){
  var memo = $("#memo").val();
	
	$("#cachet").attr("src", "cachet.php?s="+memo);
}


</script>
</body>
</html>
