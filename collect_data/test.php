<?php

$file = file_get_contents('E:\\iscas\\code\\phd\\FeatureTrac\\collect_data\\issues.info.5400');
$issues = json_decode($file);
$num = 0;


foreach ($issues as $item) {
 
	foreach($item as $key=>$value)
	{



		$num ++; 
		$issue = array();
	 
		//if($issue->create()) 
		{ 
    	 	$issue['issue_title'] 			=  $value->info->issue_title;
    	 	$issue['issue_key']			=  $value->info->issue_key;
    	  
    	}
    	var_dump($issue);
    	 
    	foreach ($value->comments as $item) {
    		 var_dump($item);
    	}
    	if ($num > 10) {
    		# code...
    		die(0);
    	}
    	
	}
}

 