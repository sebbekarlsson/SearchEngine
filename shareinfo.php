<center>
<html>
	
<header>
	<font size="32">Share your information</font>
</header>

<body>
	
	
	<form method="POST" action="infopublisher.php">
	<h1>Title</h1><br>
	<input type="text" name="title" onkeyup="textCounter(this,'counter',52);"/>
	
	<h1>Information</h1><br>
	<textarea onkeyup="textCounter(this,'counter',140);" name="info" rows="4" cols="50"></textarea>
	
	<h1>Image url (optional)</h1><br>
	<input type="text" name="imgurl"/>
	
	<script>
	function textCounter(field,field2,maxlimit)
	{
	
 	var countfield = document.getElementById(field2);
 	if ( field.value.length > maxlimit ) {
  	field.value = field.value.substring( 0, maxlimit );
  	window.alert("The text is too long!");
  	return false;
 	} else {
 	
  	countfield.value = maxlimit - field.value.length;
 	}
	}
	
</script>
	
	<p>
	<input type="submit" name="send" value="Send"/>
	
	</form>
	
</body>
	
	
</html>
</center>