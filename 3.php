<?php 
		$input = 'Jakarta adalah ibukota negara Republik Indonesia';
		$unigram = implode(", ", preg_split("/[\s]+/", $input));

		echo $unigram;
		$bigram = preg_replace('/(\w+ \w+)( )/', '$1, ', $input);
		echo $bigram;
?>