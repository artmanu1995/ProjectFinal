<!DOCTYPE html>
<html>
<head>
	<script>
	function printContent(el){
	    var restorepage = document.body.innerHTML;
	    var printcontent = document.getElementById(el).innerHTML;
	    document.body.innerHTML = printcontent;
	    window.print();
	    document.body.innerHTML = restorepage;
	}
	</script>
</head> 
<body> 
	<h1>My page</h1>
	<div id="div1">DIV 1 content...</div>
	<button onclick="printContent('div1')">พิมพ์ใบเสร็จ</button>
	<div id="div2">DIV 2 content...</div>
	<button onclick="printContent('div2')">พิมพ์ใบเสร็จ</button>
	<p id="p1">Paragraph 1 content...</p>
	<button onclick="printContent('p1')">พิมพ์ใบเสร็จ</button>
</body> 
</html>