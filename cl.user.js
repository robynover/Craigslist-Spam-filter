//greasemonkey script for CL
// ==UserScript==
// @name          CL Spam Filter

// @description	  Hides spammy craigslist posts
// @include       http://*.craigslist.org/*

// ==/UserScript==


window.addEventListener("load", function(e) {
   //alert('greasmonkey script loaded');
	var links = document.getElementsByTagName('a');
	count = 0;
	for (i=0;i<links.length;i++){	
		title = links[i].innerHTML;
		total_chars = title.length;
		caps = title.match(/[A-Z]/g);
		if (caps){	
			num_caps = caps.length;
			percent_caps = num_caps/total_chars * 100;
			if (percent_caps > 25){
				//remove this listing
				p = links[i].parentNode;
				p.parentNode.removeChild(p);
				//console.log (title + ' : removed');
				count++;
			}
		}
	}
	//console.log(count+' spammy posts zapped!');
}, false);