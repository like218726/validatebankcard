<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>根据信用卡/银行卡获取其信息</title>
<style type="text/css">
table{margin:20px auto; coll-spacing:0;border-collapse:collapse;border-top:1px solid #000;border-left:1px solid #000;}
td{border-bottom:1px solid #000;border-right:1px solid #000;}
</style>
<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<form method='post' class="card">
	<table>
		<tr>
			<td>信用卡/银行卡: </td>
			<td>
				<input type='text' name='bankcard' id="bankcard" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type='button' id='button' value='提交' />
			</td>
		</tr>
	</table>		
</form>
<div id="result"></div>
<script type="text/javascript">
$(function(){
	$("#button").click(function(){
		var bankcard = $("#bankcard").val();
		if (!bankcard) {
			alert('信用卡/银行卡不能为空');
			$("#bankcard").focus();
			return false;
		}
		var html = "<table>";
		$.post("formpost.php", $(".card").serialize(),function(data){
			if (data.code==200) {
				html += "<tr><td>原卡号: </td><td>"+data.data.bank_beati_card+"</td>";
				html += "<tr><td>系统卡号: </td><td>"+data.data.bank_card+"</td>";
				html += "<tr><td>银行代码: </td><td>"+data.data.bank_code+"</td>";
				html += "<tr><td>卡片名称: </td><td>"+data.data.bank_name+"</td>";
				html += "<tr><td>卡片类型: </td><td>"+data.data.bank_type+"</td>";
				html += "<tr><td>卡片logo: </td><td><img src='"+data.data.bank_img+"' /></td>";
				html += "</table>";
				$("#result").html(html);
			} else if (data.code==403){
				alert(data.msg);
			} else if (data.code==404){
				alert(data.msg);
			}	
	   }, "json");
	});	   
});
</script>
</body>
</html>