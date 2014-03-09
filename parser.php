<?php	
function readItemsFrom($source, $output)
{	
	$tag = "";
	$c = "";
	$ch;
	$dch;

	while(!feof($source))
	{
		$c = fgetc($source); //Read a character
		if($c == "<") //If Tag beginning
		{
			//Generic tag Scanner Loop
			$tag = $c;
			while($c!= ">")
			{
				$c = fgetc($source);
				$tag .= $c;
			}
			//Item tag Identifier
			if($tag == "<item>")
			{
				fwrite($output,$tag);
				//Killer Item writer loop
				while(1)
				{
					$c = fgetc($source);
					if($c == "<")
					{
						//Closing tag scanner
						$tag = ""; //Nullification
						$tag .= $c; //Copy '<' into ch[0]
						for($i=1;$i<=6;$i++)
						{
							$ch[$i] = fgetc($source);
							$tag .= $ch[$i];
						}
						//Closing tag identifier
						if($tag == "</item>")
						{
							fwrite($output,$tag."\n\t"); //Write closing tag and look for next <item>
							break;
						}
						else
						{
							fwrite($output,$tag); //Write other tag
						}
					}
					else
					{
						fwrite($output,$c); //Write a normal char
					}
				}
			}
		}
	}
}

function headerWriter($fprss,$chtitle,$chlink,$desc)
{
$fprss = fopen($fprss,"w");

fwrite($fprss, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
fwrite($fprss, "<?xml-stylesheet type=\"text/xsl\" href=\"newStyle.xsl\"?>\n");
fwrite($fprss,"<rdf:RDF
  xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
  xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
  xmlns:admin=\"http://webns.net/mvcb/\"
  xmlns:cc=\"http://web.resource.org/cc/\"
  xmlns=\"http://purl.org/rss/1.0/\"
  xmlns:annotate=\"http://purl.org/rss/1.0/modules/annotate/\"
  xmlns:dcterms=\"http://purl.org/dc/terms/\"
  xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n");

$date = date("D M j G:i:s T Y");
fwrite($fprss,"<channel>
		<title>$chtitle</title>
		<link>$chlink</link>
		<description>$desc</description>
		<language>en-us</language>
		<pubDate>$date</pubDate>
		<lastBuildDate>$date</lastBuildDate>
		<generator>Devji Chhanga</generator>
		<webMaster>dev.chh@gmail.com</webMaster>
</channel>\n\t");

fclose($fprss);
}
function footerWriter($fprss)
{
	$fprss = fopen($fprss,"a");
	fwrite($fprss, "</rdf:RDF>");
	fclose($fprss);
}

function MreadItemsFrom($source, $output)
{	
	$tag = "";
	$c = "";
	$ch;

	while(!feof($source))
	{
		$c = fgetc($source); //Read a character
		if($c == "<") //If Tag beginning
		{
			//Generic tag Scanner Loop
			$tag = $c;
			while($c!= ">")
			{
				$c = fgetc($source);
				$tag .= $c;
			}
			//Item tag Identifier
			if($tag == "<item>")
			{
				fwrite($output,$tag);
				//Killer Item writer loop
				while(1)
				{
					$c = fgetc($source);
					if($c == "<")
					{
						//Closing tag scanner
						$tag = ""; //Nullification
						$tag .= $c; //Copy '<' into ch[0]
						for($i=1;$i<=6;$i++)
						{
							$ch[$i] = fgetc($source);
							$tag .= $ch[$i];
						}
						//Closing tag identifier
						if($tag == "</item>")
						{
							fwrite($output,$tag."\n\t"); //Write closing tag and look for next <item>
							break;
						}
						else
						{
							$desc = "";
							$desc .= $tag;
							for($i=1;$i<=6;$i++)
							{
								$dch[$i] = fgetc($source);
								$desc .= $dch[$i];
							}
							if($desc == "<description>")
							{
								while($c!=">")
								{
									$c=fgetc($source);
								}
							}
							else
							{
								fwrite($output,$tag);
								for($i=1;$i<=6;$i++)
								{
									fwrite($output,$dch[$i]);
								}
							}
						}
						//else
						//{
							//fwrite($output,$tag); //Write other tag
						//}
					}
					else
					{
						fwrite($output,$c); //Write a normal char
					}
				}
			}
		}
	}
}
function xslWriter($file, $file2, $width, $bgcolor, $font)
{
	$fpxsl = fopen($file,"r");
	$fpnewxsl = fopen($file2,"w");
	$tagCount = 0;
	while(!feof($fpxsl))
	{
		$c = fgetc($fpxsl);
		if($c == "/")
		{
			$c1=fgetc($fpxsl);
			if($c1 == "/")
			{
				$c2=fgetc($fpxsl);
				if($c2 == "*")
				{
					$tagCount++;
					if($tagCount == 1) //font-family
					{
						while($c!=":") //Skip Item name
						{
							$c = fgetc($fpxsl);
							fwrite($fpnewxsl,$c);
						}
						fwrite($fpnewxsl,$font); //Write user-sp font
						
						for($i=1;$i<=34;$i++) //Skip Item value
						{
							$c = fgetc($fpxsl);
						}
					}
					elseif($tagCount == 2) //Background Body
					{
						while($c!=":") //Skip Item name
						{
							$c = fgetc($fpxsl);
							fwrite($fpnewxsl,$c);
						}
						fwrite($fpnewxsl,$bgcolor); //Write user-sp bg
						
						for($i=1;$i<=7;$i++) //Skip Item value
						{
							$c = fgetc($fpxsl);
						}
					}
					elseif($tagCount == 3) //Width
					{
						while($c!=":") //Skip Item name
						{
							$c = fgetc($fpxsl);
							fwrite($fpnewxsl,$c);
						}
						fwrite($fpnewxsl,$width); //Write user-sp font
						
						for($i=1;$i<=3;$i++) //Skip Item value
						{
							$c = fgetc($fpxsl);
						}
					}
					elseif($tagCount == 4) //Background Item
					{
						while($c!=":") //Skip Item name
						{
							$c = fgetc($fpxsl);
							fwrite($fpnewxsl,$c);
						}
						fwrite($fpnewxsl,$bgcolor); //Write user-sp width
						
						for($i=1;$i<=7;$i++) //Skip Item value
						{
							$c = fgetc($fpxsl);
						}
					}
					elseif($tagCount == 5) //Background Item
					{
						while($c!=":") //Skip Item name
						{
							$c = fgetc($fpxsl);
							fwrite($fpnewxsl,$c);
						}
						fwrite($fpnewxsl,$font); //Write user-sp font
						
						for($i=1;$i<=7;$i++) //Skip Item value
						{
							$c = fgetc($fpxsl);
						}
					}
					
				}
				else
				{
					fwrite($fpnewxsl, $c);
					fwrite($fpnewxsl, $c1);
					fwrite($fpnewxsl, $c2);
				}
			}
			else
			{
				fwrite($fpnewxsl, $c);
				fwrite($fpnewxsl, $c1);
			}
		}	
		else
		{
			fwrite($fpnewxsl, $c);
		}
	}
	fclose($fpxsl);
	fclose($fpnewxsl);
}
?>
