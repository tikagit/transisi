<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		$nilai = [72,65,73,78,75,74,90,81,87,65,55,69,72,78,79,91,100,40,67,77,86];
		echo array_sum($nilai)/count($nilai);

		$jml = count($nilai);
		for($i=0; $i<= 3; $i++)
		 {
		  $a = $i+1 ;
		  if($nilai[$i]>=$nilai[$a])
		   {
		   $a = $nilai[$a]; 
		   } else {
		   	$temp=$nilai[$a];
		   	if($nilai[a]>=$temp)
		    {
		     $maksimal=$nilai[$a];
		    } else {
		     $maksimal=$temp;
		    }
		   }
		 }

		echo $maksimal;
	?>
</body>
</html>
