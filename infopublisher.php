<center>

<html>
	
<header>
	<?php
	
	echo "<a href='index.php'> click here to go back </a><p>";
	
	$maxTitle = 52;
	$maxInfo = 160;
	
	$title = $_POST['title'];
	$info = $_POST['info'];
	$imgurl = $_POST['imgurl'];
	
	if(strlen($title) > $maxTitle){
		echo "Your title is longer than $maxTitle ! ";
		return;
	}
	
	if(strlen($info) > $maxInfo){
		echo "Your information is longer than $maxInfo ! ";
		return;
	}
	
	if(strlen($title) < 3){
		echo "The title can't be less than 3 characters!";
		return;
	}
	
	if(strlen($info) < 16){
		echo "The information can't be less than 16 characters!";
		return;
	}
	
	if(substr_count($title, ">") > 0){
		echo "You used a character that is not OK!";
		return;
	}
	
	if(substr_count($info, ">") > 0){
		echo "You used a character that is not OK!";
		return;
	}
	
	
	
	mkdir("pages/$title");
	if(strlen($imgurl) > 3){
		file_put_contents("pages/$title/imgurl.txt", $imgurl);
	}
	file_put_contents("pages/$title/info.txt", $info);
	file_put_contents("pages/$title/upvotes.txt",0);
	
	echo "Information was succesfully published!";
	
	?>
</header>
	
</html>

</center>