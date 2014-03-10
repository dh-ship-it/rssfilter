<?php 
$hosts=array();

$hosts[1]="https://news.google.com/?output=rss";
$hosts[2]="http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml";
$hosts[3]="http://feeds.washingtonpost.com/rss/rss_soccer-insider";
$hosts[4]="http://rss.cnn.com/rss/cnn_topstories.rss";
$hosts[5]="http://feeds.nature.com/nature/rss/current";

$type=$_REQUEST['type'];

if(!empty($_REQUEST['type'])){
	
	
	$data=($hosts[$_REQUEST['type']]);


	$datad = html_entity_decode($data); 
	$datas = ereg_replace('/<(img)[^>]+>/i', "", $datad); 
	$object = new DOMDocument();
	$object->load($data);
	$items=$object->getElementsByTagName('item');
	
	
	$feeds=array();
	$final=array();
	$i=0;
	foreach($items as $item){
		foreach($item->childNodes as $child)
        {	
			 $value = $child->nodeValue;
		     $value = (strip_tags($value));
			 $feeds[$i][$child->nodeName] = $value;
		}
		$i++;
	}
	
	
	if(!empty($_REQUEST['keyword'])){
		$keyword=$_REQUEST['keyword'];
		//look for keyword in title and description only
		for($j=0;$j<count($feeds);$j++){
			if(stripos($feeds[$j]['title'],$keyword)!== false || stripos($feeds[$j]['description'],$keyword)!== false){
			   $final[]=$feeds[$j];
			}
		}
	}
	else{
		$final=$feeds;
	}
	
	$str = json_encode($final);	
	echo $str;
}
else{
	$final[0]["title"]="Error";
	$final[0]["description"]="No parameters provided";
	$final[0]["link"]="no link";
	$str = json_encode($final);	
	echo $str;
}
?>