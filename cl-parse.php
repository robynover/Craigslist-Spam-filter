<?php
/*
 * This script takes any craigslist RSS link and filters out the obnoxious all-caps posts.
 * You can find the RSS link at the bottom of your search results on any Craigslist page.
 *
*/

/*
 * Craigslist URL:
 * Replace the URL inside the quotes with the URL to the RSS feed for your search
*/
$craigslist_url = 'http://newyork.craigslist.org/search/roo?query=-furnished&addTwo=purrr&minAsk=500&maxAsk=1000&srchType=A&format=rss';

/*
	Use these variables to control how much all-caps shouting is too much:
	$max_caps_percent_title: The maximum percentage of caps to lowercase letters in the title
	$max_caps_percent_desc: The maximum percentage of caps to lowercase letters in the description

	$min_body_chars: The minimum number of characters in the body for the post to qualify as valid
*/

$max_caps_percent_title = 25;
$max_caps_percent_desc = 20;
$min_body_chars = 300;



$rss = file_get_contents($craigslist_url);
$cl = new SimpleXMLElement($rss,LIBXML_NOCDATA);
foreach ($cl->item as $item){
	$main_desc = getMainBody($item->description);
	if (percentUpper($item->title) < $max_caps_percent_title && percentUpper($main_desc) < $max_caps_percent_desc && strlen($main_desc) > $min_body_chars){
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