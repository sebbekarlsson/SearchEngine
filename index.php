<?php



?>





<center>

<html>
<link rel="stylesheet" type="text/css" href="style.css">		
<header>

</header>
	
<body>
	
	

	
<?php

	

	echo "<form method='post'>
		<input type='text' name='field'/>
		<input type='submit' name='search' value='Search'/>
		<a href='shareinfo.php'> <input type='button' name='provide' value='provide'/></a>
		
	</form>";
	

if(isset($_POST["search"])){

	
	$text = $_POST["field"];
	$page = "pages/$text";
	$info = "$page/info.txt";
	
	
	$old = file_get_contents("searches.txt");
	$new = "$old"."\r\n"."$text";
	file_put_contents("searches.txt", $new);
	
		
		
		




	$path = "pages";
	$index = 0;
	$names;

	if ($handle = opendir($path)) {
    	while (false !== ($file = readdir($handle))) {
        	if ('.' === $file) continue;
        	if ('..' === $file) continue;

		$similar = similar_text($text, $file);
		$infotext = file_get_contents("$path/$file/info.txt");
		$imgurl = "";
		$upvotes = 0;
		if(file_exists("pages/$file/upvotes.txt")){
			$upvotes = file_get_contents("pages/$file/upvotes.txt");
		}
		
		if(file_exists("pages/$file/imgurl.txt")){
			$imgurl = file_get_contents("pages/$file/imgurl.txt");
		}	
		
		if($text == "ALL"){
			$index += 1;
			$names[$index] = $file;
			
			showResult($file,$infotext,$imgurl,$upvotes,$index,$names);	
		}else{
		
		if($similar > 3){
		
		$index += 1;
		$names[$index] = $file;
		
		showResult($file,$infotext,$imgurl,$upvotes,$index,$names);
		
		
		}
		}
    	}
    	closedir($handle);
	}
	
	if($index < 1){
			echo "No results were found.";
	}
	
		
		
	}


	
	if(isset($_POST['upvote'])){
		$name = $_POST['NAME'];
		$oldcontent = 0;
		if(file_exists("pages/$name/upvotes.txt")){
			$oldcontent = file_get_contents("pages/$name/upvotes.txt");
		}
		
		$newupvotes = $oldcontent + 1;
		file_put_contents("pages/$name/upvotes.txt", $newupvotes);
		
		echo "You upvoted the section about $name !</br>";
		echo '<img src="images/upvote.png"/>';
	}
	
	if(isset($_POST['downvote'])){
		$name = $_POST['NAME'];
		$oldcontent = 0;
		if(file_exists("pages/$name/upvotes.txt")){
			$oldcontent = file_get_contents("pages/$name/upvotes.txt");
		}
		
		$newupvotes = $oldcontent - 1;
		file_put_contents("pages/$name/upvotes.txt", $newupvotes);
		
		echo "You downvoted the section about $name !</br>";
		echo '<img src="images/downvote.png"/>';
	}
	
	



	function showResult($file,$infotext,$imgurl,$upvotes,$index,$names){
		echo"<div align='left' class='boxed'>

		<form method='post'>
		";
		
		echo "<h1><font face='verdana'>$file</font></h1> <div align='right'><input type='image' src='images/downvote.png' width=16px height=16px name='downvote' value='Downvote'/>";
		echo "<input type='image' src='images/upvote.png' width=16px height=16px name='upvote' value='Upvote'/> $upvotes</div><hr>";
		echo "<font face='verdana'>$infotext</font><br>";
		echo"<div align = left>";
		if(strlen($imgurl)>3){echo "<a href='$imgurl'><img src='images/camera.png' with=16px height=16px /></a>";}
		echo "<a href='#'><img src='images/info.png' with=16px height=16px /></a>";
		echo "<a href='#'><img src='images/add.png' with=16px height=16px /></a>";
		echo"</div>";
		
		echo "<input type ='hidden' name='ID' value='$index'/>";
		echo "<input type ='hidden' name='NAME' value='$names[$index]'/>";
		echo "
		</form>
		
		
		</div><br>";
	}



?>
	
</body>
	
	
	
	
	
</html>

</center>
