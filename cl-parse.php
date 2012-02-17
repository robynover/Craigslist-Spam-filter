<?php
$rss = file_get_contents('http://newyork.craigslist.org/search/roo?query=-furnished&addTwo=purrr&minAsk=500&maxAsk=1000&srchType=A&format=rss');
$cl = new SimpleXMLElement($rss,LIBXML_NOCDATA);
foreach ($cl->item as $item){
	$main_desc = getMainBody($item->description);
	if (percentUpper($item->title) < 25 && percentUpper($main_desc) < 20 && strlen($main_desc) > 300){
		echo '<h2>'.$item->title.'</h2>';
		echo '<h3><a href="'.$item->link.'">'.$item->link.'</a></h3>';
		echo $item->description;
		echo "<hr>\n";
	}
	
}

function percentUpper($string) {
	$total_chars = strlen($string); //24
    $upper_chars= preg_match_all('/[A-Z]/', $string,$m); //6
	$percent = ($upper_chars/$total_chars) * 100;
	return $percent;	
}

function getMainBody($desc){
	$array = explode('<!-- START CLTAGS -->',$desc);
	return $array[0];
}