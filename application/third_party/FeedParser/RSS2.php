<?php

class FeedParserRSS2 extends FeedParser implements IFeed
{

    public $xpath;

    /**
     * When performing XPath queries we will use this prefix 
     */
    private $xpathPrefix = '//';
    private $feedType = 'RSS 2.0';

	/**
	 * Contains array of items
	 */
	public $items;
	
	
	protected $namespaces = array(
		'dc' => 'http://purl.org/rss/1.0/modules/dc/',
        'content' => 'http://purl.org/rss/1.0/modules/content/');
	
	
    /**
     * Our constructor does nothing more than its parent.
     * 
	 * @param $xml
	 *     A DOM object representing the feed
	 * @param $strict
	 *     (optional) Whether or not to validate this feed
     */
	function __construct(DOMDocument $xml, $strict = false)
    {
        $this->model = $xml;

		if ($strict)
			if (! $this->relaxNGValidate())
				throw new Exception('Failed required validation');


        $this->xpath = new DOMXPath($this->model);
		foreach ($this->namespaces as $key => $value)
            $this->xpath->registerNamespace($key, $value);
    }

	/**
	 * Return link that holds link to website where feed came from
	 *
	 * @return 
	 *     String with link
	 */
	public function getLink()
	{

		$items = $this->xpath->evaluate("/rss/channel/link");
		
		// If we have more than one top-level <title> then notify
		if($items->length > 1)
			echo 'Strange feed link';

		// Even if we have more than 1 <link> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getId()
	{

		$items = $this->xpath->evaluate("/rss/channel/id");
		
		// If we have more than one top-level <title> then notify
		if($items->length > 1)
			echo 'Strange feed link';

		// Even if we have more than 1 <link> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getPostId()
	{

		$items = $this->xpath->evaluate("/rss/channel/post_id");
		
		// If we have more than one top-level <title> then notify
		if($items->length > 1)
			echo 'Strange feed link';

		// Even if we have more than 1 <link> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getFeedLink()
	{
		return '';
	}

	public function getTitle()
	{
		// Evaluate XPath query over DOMDocument.
		// We basicaly look for top-level <title>.
		$items = $this->xpath->evaluate('/rss/channel/title');

		// If we have more than one top-level <title> then notify
		if($items->length > 1)
			echo 'Strange feed title';

		// Even if we have more than 1 <title> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getPostName()
	{
		// Evaluate XPath query over DOMDocument.
		// We basicaly look for top-level <title>.
		$items = $this->xpath->evaluate('/rss/channel/eId');

		// If we have more than one top-level <title> then notify
		if($items->length > 1)
			echo 'Strange feed title';

		// Even if we have more than 1 <title> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getDescription()
	{
		// Evaluate XPath query over DOMDocument.
		// We basicaly look for top-level <description>.
		$items = $this->xpath->evaluate('/rss/channel/description');

		// If we have more than one top-level <description> then notify
		if($items->length > 1)
			echo 'Strange feed description';

		// Even if we have more than 1 <description> we will return content of first
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getFeedType()
	{
		return $this->feedType;
	}
	
	public function getItems()
	{
		// Evaluate XPath query over DOMDocument.
		// We look for top level link with 'rel=self' attribute
		$entries = $this->xpath->evaluate("//item");

		$items = array();
		foreach($entries as $entry)
		{
			// We should make DOMDocument object from DOMNode object to pass it 
			// to FeedParserRSS2Element constructor (otherwise there will be 
			// fatal error despite DOMDocument extends from DOMNode)
			$doc = new DOMDocument;
			$doc->appendChild($doc->importNode($entry, TRUE));
			
			// Add to array new object representing entry
			$items[] = new FeedParserRSS2Element($doc);
		}

		return $items;
	}

}	


class FeedParserRSS2Element implements IItem
{
	public $model;

	protected $namespaces = array(
		'dc' => 'http://purl.org/rss/1.0/modules/dc/',
		'wfw' => 'http://wellformedweb.org/CommentAPI/',
		'slash' => 'http://purl.org/rss/1.0/modules/dc/',
        'content' => 'http://purl.org/rss/1.0/modules/content/');
	
	function __construct(DOMDocument $xml, $strict = false)
	{
        $this->model = $xml;
		
		if ($strict)
			if (! $this->relaxNGValidate())
				throw new Exception('Failed required validation');
		
		$this->xpath = new DOMXPath($this->model);
		foreach ($this->namespaces as $key => $value)
            $this->xpath->registerNamespace($key, $value);
	}	

	public function getTitle()
	{
		$items = $this->xpath->evaluate('//title'); 

		if($items->length > 1)
			echo 'Strange entry title';

		if(empty($items->item(0)->nodeValue))
			return " ";

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getPostName()
	{
		$items = $this->xpath->evaluate('//eId'); 

		if($items->length > 1)
			echo 'Strange entry title';

		if(empty($items->item(0)->nodeValue))
			return " ";

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}


	public function getContent()
	{
		$items = $this->xpath->evaluate('//content:encoded');
		if(empty($items->item(0)->nodeValue)) // If it's empty
		{
			//We look for <content>
			$items = $this->xpath->evaluate('//content');
		}

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getDescription()
	{
		$items = $this->xpath->evaluate('//description');

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getGuid()
	{
		$items = $this->xpath->evaluate('//guid');

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getPubDate()
	{
		$items = $this->xpath->evaluate('//pubDate');

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getDate($param)
	{
		$items = $this->xpath->evaluate('//' . $param);

		if ($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getLink()
	{
		$items = $this->xpath->evaluate('//link');


		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getId()
	{
		$items = $this->xpath->evaluate('//id');


		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getPostId()
	{
		$items = $this->xpath->evaluate('//post_id');


		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getComments()
	{
		$items = $this->xpath->evaluate('//comments');

		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function getCategory()
	{
		$items = $this->xpath->evaluate('//category');
		if($items->length === 0)
			return '';
			
		foreach ($items as $key => $value) {
			$category[] = $value->nodeValue;
		}
		$category = implode(", ",$category);
		return $category;
	}

	public function getAuthor()
	{
		$items = $this->xpath->evaluate('//dc:creator');
		if(empty($items->item(0)->nodeValue)) // If it's empty
		{
			$items = $this->xpath->evaluate('//author');
		}
		if($items->length === 0)
			return '';
		return $items->item(0)->nodeValue;
	}

	public function wfwCommentRss()
	{
		$items = $this->xpath->evaluate('//wfw:commentRss');
		if(empty($items->item(0)->nodeValue)) // If it's empty
		{
			return '';
		}	
		return $items->item(0)->nodeValue;
	}

	public function slashComments()
	{
		$items = $this->xpath->evaluate('//slash:comments');
		if(empty($items->item(0)->nodeValue)) // If it's empty
		{
			return '';
		}	
		return $items->item(0)->nodeValue;
	}
	
}	

