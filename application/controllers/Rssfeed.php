<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Rssfeed
 */
class Rssfeed extends CI_Controller
{

	/**
	 * read_rss_feed
	 *
	 * @return void
	 */
	public function read_rss_feed()
	{
		header('Content-Type: text/html; charset=utf-8');
		ini_set('max_execution_time', 300); //120 seconds = 2 minutes
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		date_default_timezone_set("UTC");

		require_once APPPATH . "/third_party/FeedParser/helper.php";

		require_once APPPATH . "/third_party/FeedParser/FeedParser.php";


		$context = stream_context_create(
			array(
				'ssl' => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
				),
			)
		);
	
		$response = $this->rssfeed_model->get_rss_feed_links();

		foreach ($response as $feed_item) {

			$get_feed_content = getHtml($feed_item->rss_link);

			if ($get_feed_content) {
				$feed_counter = 0;
				$feed_content = new FeedParser($get_feed_content);
				$items = $feed_content->getItems();


				foreach ($items as $item) {

					if ($feed_counter > COUNTER_LIMIT) {
						break;
					}

					$link = (is_empty($item->getLink())) ? "" : $item->getLink();
					$pr_id = (is_empty($item->getId())) ? $item->getPostId() : $item->getId();
					$pr_title = (is_empty($item->getTitle())) ? "" : $item->getTitle();
					$pr_name = (is_empty($item->getPostName())) ? "" : $item->getPostName();
					$guid = (is_empty($item->getGuid())) ? $link : $item->getGuid();
					$author = (is_empty($item->getAuthor())) ? "iCrowdNewswire" : $item->getAuthor();
					$pubDate = (is_empty($item->getPubDate())) ? "" : $item->getPubDate();
					$publish_time = strtotime($pubDate);
					$pr_publish_time = date('Y-m-d H:i:s', $publish_time);
					$issue_date = (is_empty($pubDate)) ? "" : date("Y-m-d H:i:s", strtotime($pubDate));

					if(is_empty($pr_id)){
						$parts = parse_url($item->getGuid());
						parse_str($parts['query'], $query);
						$pr_id = $query['p'];
					}
					if(!is_empty($pr_name)){
												
						$pr_name = url_title(convert_accented_characters($pr_title), 'dash', true);
					}
					$feed_data=[
						'pr_id'=>$pr_id,
						'channel_name'=>$feed_item->rss_name,
						'date'=>$pr_publish_time
					];
		
					if ($this->rssfeed_model->isnew_pr_check($feed_data) == false) {

						$insert_data = [
							'pr_id' => $pr_id,
							'pr_name' => $pr_name,
							'pr_title' => $pr_title,
							'pr_publish_time' => $pr_publish_time,						
							'post_author' => $author						
						];

						$this->rssfeed_model->insert_rss_feed_link($insert_data,$feed_data);

						$feed_counter++;
					}
				}
			}
		}
	} // feed function ends


}//class end
