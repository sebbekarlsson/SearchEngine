<?php



?>





<center>

<html>
<link rel="stylesheet" type="text/css" href="style.scss">		
<header>
<div align="left">
	<a href="shareinfo.php"><input type="button" name="shareinfo" value="Provide"/></a>
</div>
<br>
<br>
<br>
<br>
</header>
	
<body>
	
	
	

	
<?php

	

	echo "<form method='post'>
		<input type='text' size='100px' name='field'/>
		<input type='submit' name='search' value='Search'/>
		
		
	</form>";
	

if(isset($_POST["search"])){

	
	$text = $_POST["field"];
	$page = "pages/$text";
	$info = "$page/info.txt";
	
	
	$old = file_get_contents("searches.txt");
	$new = "$old"."\r\n"."$text<br>";
	file_put_contents("searches.txt", $new);
	
		
		
		




	$path = "pages";
	$index = 0;
	$names;

	if ($handle = opendir($path)) {
    	while (false !== ($file = readdir($handle))) {
        	if ('.' === $file) continue;
        	if ('..' === $file) continue;

		$similar = string_compare(strtolower($text), strtolower($file));
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
			
			showResult($file,$infotext,$imgurl,$upvotes,$similar,$index,$names);	
		}else{
		
			if($similar >= 0.98 ){
		
				$index += 1;
				$names[$index] = $file;
		
				showResult($file,$infotext,$imgurl,$upvotes,$similar,$index,$names);
		
		
			}
		
			if (substr_count($infotext, $text) > 0){
				$index += 1;
				$names[$index] = $file;
		
				showResult($file,$infotext,$imgurl,$upvotes,$similar,$index,$names);
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
	
	



	function showResult($file,$infotext,$imgurl,$upvotes,$similar,$index,$names){
		
		
		
		echo"<div align='left' class='boxed'>

		<form method='post'>
		";
		
		echo "<div class='boxedtext'><font size='5' face='verdana'>$file</font></div><div align='right' class='topbar'><input type='image' src='images/downvote.png' width=16px height=16px name='downvote' value='Downvote'/>";
		echo "<input type='image' src='images/upvote.png' width=16px height=16px name='upvote' value='Upvote'/> $upvotes</div><hr>";
		echo "<div class='boxedtext'><font size='2' face='verdana'>$infotext</font></div><br><hr>";
		$similar = ceil($similar * 100);
		echo"<div align='right' class='topbar'>Similar to search: $similar%</div>";
		
		
		echo"<div align='left' class='bar'>";
		
		echo "<p>";
		
		
		if(strlen($imgurl)>3){echo "<a href='$imgurl'><img src='images/camera.png' with=16px height=16px /></a>Images";}
		echo "<a href='#'><img src='images/info.png' with=32px height=16px /></a>Info";
		echo "<a href='#'><img src='images/add.png' with=32px height=16px /></a>Add";
		
		echo"</div>";
		
		
		
		echo "<input type ='hidden' name='ID' value='$index'/>";
		echo "<input type ='hidden' name='NAME' value='$names[$index]'/>";
		echo "
		</form>
		
		
		</div><br>";
	}




function string_compare($str_a, $str_b) 
{
    $length = strlen($str_a);
    $length_b = strlen($str_b);

    $i = 0;
    $segmentcount = 0;
    $segmentsinfo = array();
    $segment = '';
    while ($i < $length) 
    {
        $char = substr($str_a, $i, 1);
        if (strpos($str_b, $char) !== FALSE) 
        {               
            $segment = $segment.$char;
            if (strpos($str_b, $segment) !== FALSE) 
            {
                $segmentpos_a = $i - strlen($segment) + 1;
                $segmentpos_b = strpos($str_b, $segment);
                $positiondiff = abs($segmentpos_a - $segmentpos_b);
                $posfactor = ($length - $positiondiff) / $length_b; // <-- ?
                $lengthfactor = strlen($segment)/$length;
                $segmentsinfo[$segmentcount] = array( 'segment' => $segment, 'score' => ($posfactor * $lengthfactor));
            } 
            else 
            {
                $segment = '';
                $i--;
                $segmentcount++;
            } 
        } 
        else 
        {
            $segment = '';
            $segmentcount++;
        }
        $i++;
    }   

    // PHP 5.3 lambda in array_map      
    $totalscore = array_sum(array_map(function($v) { return $v['score'];  }, $segmentsinfo));
    return $totalscore;     
}

?>
	
</body>
	
	
	
	
	
</html>

</center>
