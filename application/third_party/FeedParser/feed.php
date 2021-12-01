<?php

require_once('FeedParser.php');

$xml = file_get_contents('http://lyd.org/feed/');//Libertad y Desarrollo,  Chile  [Atlas]
$xml = file_get_contents('http://www.libertadyprogresonline.org/feed/');//Libertad y Progreso,  Argentina  [Atlas]
$xml = file_get_contents('http://www.cari.org.ar/rss/agenda_cari.xml');//Consejo Argentino para las Relaciones Internacionales  (CARI),  Argentina
$xml = file_get_contents('http://mcn.org.gt/feed/'); //Vision Republica/ Movimiento Civico Nacional,  Guatemala
$xml = file_get_contents('http://fundar.org.mx/feed'); //Fundar - Centro de Analisis e Investigacion,  Mexico.
$xml = file_get_contents('http://iee.com.br/feed/'); //Instituto de Estudios Empresariais - IEE
$xml = file_get_contents('http://www.capp.org.do/feed/');//Centro de Analisis Para Politicas Publicas - CAPP
$xml = file_get_contents('http://www.iplperu.org/feed');//Instituto Politico para la Libertad
$xml = file_get_contents('http://fundacionfil.org/feed/');//Fundacion Internacional para la Libertad
$xml = file_get_contents('http://cedice.org.ve/feed/');//Centro de Divulgacion del Conocimiento Economico para la Libertad - - CEDICE
$xml = file_get_contents('http://primeinstitute.org/feed/');//Policy Research Institute of Market Economy
$feed = new FeedParser($xml);

//Because we have interface for feeds, we invoke interface methods
// echo '<b>Type:</b>'.$feed->getFeedType()."<br/>";
// echo '<b>Title:</b>'.$feed->getTitle()."<br/>";
// echo '<b>Description:</b>'.$feed->getDescription()."<br/>";
// echo '<b>Feed link:</b>'.$feed->getFeedLink()."<br/>";
// echo '<b>Link:</b>'.$feed->getLink()."<br/>";

$items = $feed->getItems();

foreach($items as $item)
{
	echo "<br>".$link = (is_empty($item->getLink()))? "": $item->getLink();
	echo "<br>".$title = (is_empty($item->getTitle()))? "": $item->getTitle();
	// echo "<br>".$pubDate = (is_empty($item->getPubDate()))? "": $item->getPubDate();
	echo "<br>".$description = (is_empty($item->getDescription()))? "": $item->getDescription();
	// echo "<br>".$content = (is_empty($item->getContent()))? "": $item->getContent();
	// echo "<br>".$category = (is_empty($item->getCategory()))? "": $item->getCategory();
	// echo "<br>".$guid = (is_empty($item->getGuid()))? "": $item->getGuid();
	// echo "<br>".$author = (is_empty($item->getAuthor()))? "": $item->getAuthor();
	// echo "<br>".$wfwCommentRss = (is_empty($item->wfwCommentRss()))? "": $item->wfwCommentRss();
	// echo "<br>".$slashComments = (is_empty($item->slashComments()))? "0": $item->slashComments();
	// echo "<br>".$comments = (is_empty($item->getComments()))? "0": $item->getComments();
	echo "<hr>";
}

?>
