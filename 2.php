<?php 
	$input = 'TranSISI';
	// echo ($input);
	$lower = strtolower($input);
	$upper = strtoupper($input);
	$lowerDiff = similar_text($input, $lower);
	$upperDiff = similar_text($input, $upper);

	echo (strlen($input) - $upperDiff); 
?>