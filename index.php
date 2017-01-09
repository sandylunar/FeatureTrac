<?php
require_once("simple_html_dom.php");

define("MAX_PAGE_NUM",1);
$issues = get_all_issue_keys();
$result = array();
foreach ($issues as $issue) {
	$res = array();
	$info = get_issue_info($issue);
	$comments = get_issue_comments($issue);
	$res[$issue['key']]['info'] = $info ;
	$res[$issue['key']]['comments'] = $comments ;
	$result[] = $res;
}
$myfile = fopen("result.txt", "w") or die("Unable to open file!");
fwrite($myfile, json_encode($result));
fclose($myfile);



function get_issue_comments($issue_obj)
{
	$content = file_get_contents('https://hibernate.atlassian.net/browse/'.$issue_obj['key']);
	$content = strstr($content, 'WRM._unparsedData["activity-panel-pipe-id"]');
	$content = substr($content,strpos($content, '=')+2);
	$end = strpos($content, 'if(window.WRM._dataArrived)window.WRM._dataArrived()');
	$content = substr($content,0,$end);
	$content = str_replace("\\u003e",">",$content);
	$content = str_replace("\\u003c","<",$content);
	$content = str_replace("\\\\/","/",$content);
	$content = str_replace("\\\\\\","",$content);
	$content = str_replace("\\\\","",$content);
	$content = str_replace("\\n","",$content);
	$content = str_replace("\\r","",$content);
	$content = str_replace("\\/","/",$content);
	$content = str_replace("\\","",$content);
	#echo $content;
	$html = str_get_html($content);
	$comments = array();
	foreach ($html->find(".issue-data-block") as $item) {
		# code...
		$comment = array();
		$comment['commnet_id'] = trim($item->id);
		$comment['commnet_date'] = trim($item->find("time.livestamp",0)->datetime);
		$comment['commnet_user'] = trim($item->find(".action-details a",0)->plaintext);
		$comment['commnet_info'] = trim($item->plaintext);
		echo $item->id."\r\n";
		echo $item->find("time.livestamp",0)->datetime."\r\n";
		echo $item->find(".action-details a",0)->plaintext."\r\n";
		echo $item->plaintext."\r\n";
		$comments[] = $comment;
	}
	return $comments;
}

/**
	get issue infomation
*/
function get_issue_info($issue_obj)
{
	$url = "https://hibernate.atlassian.net/browse/".$issue_obj['key']."?page=com.atlassian.jira.plugin.system.issuetabpanels%3Aall-tabpanel&_=1483937179653";
	$html = file_get_html($url);
	$issue = array();
	print_r($issue_obj);
	$issue['issue_title'] 			= $issue_obj['title'];
	$issue['issue_key'] 			= $issue_obj['key'];
	$issue['issue_type'] 			= trim($html->find("#issuedetails li span",0)->plaintext);
	$issue['issue_status'] 			= trim($html->find("#issuedetails li span",1)->plaintext);
	$issue['issue_priority'] 		= trim($html->find("#issuedetails li span",2)->plaintext);
	$issue['issue_resolution'] 		= trim($html->find("#issuedetails li span",3)->plaintext);
	$issue['issue_affects_version'] = trim($html->find("#issuedetails li span",4)->plaintext);
	$issue['issue_fix_version'] 	= trim($html->find("#issuedetails li span",5)->plaintext);
	$issue['issue_component'] 		= trim($html->find("#issuedetails li span",6)->plaintext);
	$issue['issue_labels']	 		= trim($html->find("#issuedetails li span",7)->plaintext);

	$desc_obj = $html->find("#descriptionmodule .user-content-block",0);
	if(isset($desc_obj) ){
		$issue['issue_description']	 	= trim($html->find("#descriptionmodule .user-content-block",0)->plaintext );
	} else {
		$issue['issue_description']	 	= '';
	}
	
	$issue['issue_from_url']	 	= $url ;
	return $issue;
}

/**
	get all issue keys
*/
function get_all_issue_keys()
{
	$start_index = 0;
	$end_index = 5351;
	$issues = array();
	for ($i=0; $i < MAX_PAGE_NUM; $i++) { 
		echo "start get  page ".($i+1)." \r\n";
		$start_index = $i * 50 + 1;
		$page_url = "https://hibernate.atlassian.net/issues/?filter=-4&jql=project+in+%28OGM%2C+HHH%2C+HSEARCH%2C+HBX%2C+HV%29+AND+issuetype+in+%28Improvement%2C+%22New+Feature%22%2C+%22Remove+Feature%22%29+order+by+created+DESC&startIndex=$start_index";
		$html = file_get_html($page_url);
		$page_index = $html->find('.pagination ');
		// Find all issues blocks
		foreach($html->find('.issue-list li') as $article) {
			$issue = array();
		    $issue['title'] = $article->getAttribute('title');
		    $issue['key'] 	= $article->getAttribute('data-key');
		    echo $article->title."\r\n";
		    echo $article->getAttribute('data-key')."\r\n";
		    $issues[] = $issue;
		}
		echo "end get  page  ".($i+1)."  \r\n";
	}
	return  $issues;
}


