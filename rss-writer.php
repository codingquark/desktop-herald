<?php
	$chtitle = "Desktop Herald RSS";
	$chlink = "http://www.feedrunner.co.cc";
	$desc = "";
	
	//Newspapers
	$timesOfIndia = "http://timesofindia.indiatimes.com/rssfeeds/1221656.cms";
	$expressIndia = "http://www.expressindia.com/syndications/ei.xml";
	$theHindu = "http://beta.thehindu.com/news/?service=rss";

	//TV Channels
	$zeeNews = "http://www.zeenews.com/rss/india-national-news.xml";
	$cnnWorld = "http://rss.cnn.com/rss/cnn_world.rss";
	
	
	$feed1 = rand(1, 3);
	$feed2 = rand(1, 2);
	
	//Newspaper
	if($feed1 == 1)
		$feed1 = $timesOfIndia;
		
	elseif($feed1 == 2)
		$feed1 = $expressIndia;
		
	else
		$feed1 = $theHindu;
		
	//TV Channel
	if($feed2 == 2)
		$feed2 = $cnnWorld;
		
	else
		$feed2 = $zeeNews;
	
	
	$width = $_GET['width'];
	$maxitems = $_GET['maxitems'];
	$bgcolor = $_GET['bgcolor'];
	$bgcolor = "#".$bgcolor;
	$font = $_GET['font'];

	require("parser.php");

	
	$source1 = fopen($feed1,"r");
	$source2 = fopen($feed2,"r");
	$output = fopen("DHeraldNewsRss.xml","a");
	
	headerWriter("DHeraldNewsRss.xml",$chtitle,$chlink,$desc);
	readItemsFrom($source1, $output);
	readItemsFrom($source2, $output);
	footerWriter("DHeraldNewsRss.xml");
	fclose($source1);
	fclose($source2);
	fclose($output);

	xslWriter("style.xsl","newStyle.xml",$width,$bgcolor,$font);

	header("Location: DHeraldNewsRss.xml");
	echo "If you are not automatically redirected, <A HReF='DHeraldNewsRss.xml' />Click here</A>...";
?>
