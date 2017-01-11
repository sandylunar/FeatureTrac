<?php
 
class IndexAction extends Action {
    
    public function index(){

    	$file = file_get_contents('E:\\iscas\\code\\phd\\FeatureTrac\\collect_data\\issues.info.5400');
		$issues = json_decode($file);
		$num = 0;
    	foreach ($issues as $item) {
    		
    		# code...
    		foreach($item as $key=>$value)
			{
				$num++;
				echo "$num=>".$value->info->issue_key."<br/>";
				$issuObj = M('issue');
				$issue = array();
	    	 	$issue['issue_title'] 			=  $value->info->issue_title;
	    	 	$issue['issue_key'] 			=  $value->info->issue_key;
	    	 	$issue['issue_type'] 			=  $value->info->issue_type;
	    	 	$issue['issue_status'] 			=  $value->info->issue_status;
	    	 	$issue['issue_priority'] 		=  $value->info->issue_priority;
	    	 	$issue['issue_resolution'] 		=  $value->info->issue_resolution;
	    	 	$issue['issue_affects_version'] =  $value->info->issue_affects_version;
	    	 	$issue['issue_fix_version'] 	=  $value->info->issue_fix_version;
	    	 	$issue['issue_component'] 		=  $value->info->issue_component;
	    	 	$issue['issue_labels'] 			=  $value->info->issue_labels;
	    	 	$issue['issue_from_url'] 		=  $value->info->issue_from_url;
	    	 	$issue['issue_description'] 	=  $value->info->issue_description;
	    	  	
	    	  	$issue['id']  =  $issuObj->add($issue);
	    	 	echo  "->success<br/>";
		    	foreach ($value->comments as $item) {
		    		$commentObj = M('comment');
		    		 $comment = array();
		    		 { 
		    			$comment['issue_comment_id']  		= $item->commnet_id;
		    			$comment['issue_comment_date']  	= $item->commnet_date;
		    			$comment['issue_comment_user']  	= $item->commnet_user;
		    			$comment['issue_comment_info']  	= $item->commnet_info;
		    			$comment['issue_key']  				= $value->info->issue_key;
		    			$comment['issue_id']  				= $issue['id'];
						$commentObj->add($comment); 
 					}
		    	}
			}
    	}
    	$this->display('index');
	}
}