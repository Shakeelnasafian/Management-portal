<?php

namespace App\Controllers;

use App\Models\OperationsModel;

ini_set('memory_limit', '-1');

class Operations extends BaseController
{
    protected OperationsModel $operationsModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->operationsModel = new OperationsModel();
        $this->checkRole('Editor', 'Administrator');
    }

	public function create_pressrelease()
	{
		return view('operations/create_pressrelease');
	}//function ends


	public function create_pr_preview()
	{
		$rules = [
			'post_title' => 'required',
			'post_content' => 'required',
			'post_date' => 'required',
		];

		if (! $this->validate($rules)) {
			session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
			return redirect()->to(base_url('operations'));
		} else {

			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->request->getPost('post_date'))));
			
			
			$insert_data = [
				'post_title'     => $this->request->getPost('post_title'),
				'post_content'   => $this->request->getPost('post_content'),
				'post_date'      => $this->request->getPost('post_date'),
				'post_date_gmt'  => $post_date_gmt,
				'post_modified'  => $this->request->getPost('post_date'),
				'post_modified_gmt'=> $post_date_gmt,
				'post_status'    =>'pending',
				'post_type'      => 'post',
				'post_author'    => 4395,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				
				
				
			];

			$insert_meta = [
				'cf_campaign_link' => $this->request->getPost('cf_campaign_link'),
				'cf_cont_info' => $this->request->getPost('cf_cont_info'),
				'cf_keywords' => $this->request->getPost('cf_keywords'),
				'pr_created_by' => $this->currentUserLogin(),
			];

			$response = $this->operationsModel->create_pressrelease($insert_data,$insert_meta);

			

			return redirect()->to(base_url('operations/edit-pending-pressrelease/' . $response['post_id']));
			
		}

	}//function ends



	/**
	 * pending_pressreleases
	 *
	 * @return void
	 */
	public function pending_pressreleases()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->operationsModel->pending_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('operations/pending-pressreleases'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->operationsModel->get_icn_pending_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('operations/pending_dashboard', $data);
	} //function end


	/**
	 * schedule_pressreleases
	 *
	 * @return void
	 */
	public function schedule_pressreleases()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->operationsModel->scheduled_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('operations/schedule-pressreleases'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->operationsModel->get_icn_schedule_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('operations/schedule_dashboard', $data);
	} //function end


	/**
	 * published_pressreleases
	 *
	 * @return void
	 */
	public function published_pressreleases()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->operationsModel->published_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('operations/published-pressreleases'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->operationsModel->get_icn_published_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('operations/published_dashboard', $data);
	} //function end


	/**
	 * trashed_pressreleases
	 *
	 * @return void
	 */
	public function trashed_pressreleases()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->operationsModel->trashed_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('operations/trashed-pressreleases'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->operationsModel->get_icn_trashed_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('operations/trashed_dashboard', $data);
	} //function end


	/**
	 * draft_pressreleases
	 *
	 * @return void
	 */
	public function draft_pressreleases()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->operationsModel->draft_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('operations/draft-pressreleases'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->operationsModel->get_icn_draft_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('operations/draft_dashboard', $data);

	}//function ends


	public function view_pressrelease($post_id = 1231)
	{
		$data['post'] = $this->operationsModel->get_pr_view_screen($post_id);
		return view('operations/view_pressrelease', $data);
	} //function ends



	/**
	 * get_pr_details_ajax
	 *
	 * @return void
	 */
	public function get_pr_details_ajax()
	{
		$post_id  = $this->request->getPost('pr_id');
		$response = $this->operationsModel->get_pr_view_screen($post_id);

		$return_array = array(

			'post_id' => $response->ID,
			'post_title'  => $response->post_title,
			'post_content' => $response->post_content,
			'post_name'  => $response->post_name,
			'post_status' => $response->post_status,
			'post_date'  => $response->post_date,
			'user_login' => $response->user_login,
			'user_email'  => $response->user_email,

		);

		return $this->response->setJSON($return_array);
	} //function ends


	/**
	 * approve_pressrelease
	 *
	 * @return void
	 */
	public function approve_pressrelease()
	{
		$post_id = $this->request->getPost('post_id');
		$update_data = [
			'post_status' => 'future'
		];
		$response = $this->operationsModel->get_approve_pressrelease($post_id, $update_data);

		return $this->response->setBody((string) $response['message']);
	} //function ends


	/**
	 * reject_pressrelease
	 *
	 * @return void
	 */
	public function reject_pressrelease()
	{
		$post_id = $this->request->getPost('post_id');
		$update_data = [
			'post_status' => 'trash'
		];
		$response = $this->operationsModel->get_reject_pressrelease($post_id, $update_data);

		return $this->response->setBody((string) $response['message']);
	} //function ends


	/**
	 * edit_pressrelease
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function edit_pressrelease($post_id)
	{
		$response = $this->operationsModel->get_edit_pressrelease($post_id);
		return view('operations/edit_pressrelease', $response);
	} //function ends


	public function edit_pending_pressrelease($post_id)
	{
		$response = $this->operationsModel->get_edit_pressrelease($post_id);
		return view('operations/edit_pending_pressrelease', $response);
	} //function ends



	/**
	 * update_pressrelease
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function update_pressrelease()
	{

		$rules = [
			'post_title' => 'required',
			'post_content' => 'required',
			'post_date' => 'required',
		];

		if (! $this->validate($rules)) {
			session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
			return redirect()->to(base_url('operations'));
		} else {

			$post_id = $this->request->getPost('post_id');
			$post_date = $this->request->getPost('post_date');
			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->request->getPost('post_date'))));
			
			
			$post_update = [
				'post_title' => $this->request->getPost('post_title'),
				'post_content' => $this->request->getPost('post_content'),
				'post_date' => $post_date,
				'post_date_gmt' => $post_date_gmt,
				'post_status' => $this->request->getPost('post_status')
			];

			$postmeta_update = [
				'cf_campaign_link' => $this->request->getPost('cf_campaign_link'),
				'cf_cont_info' => $this->request->getPost('cf_cont_info'),
				'cf_keywords' => $this->request->getPost('cf_keywords'),
			];


			$response = $this->operationsModel->edit_icn_pressrelease($post_update, $postmeta_update, $post_id);

			return $this->response->setBody((string) $response['message']);
		}

	} //function ends

	
	/**
	 * update_pending_pressrelease
	 *
	 * @return void
	 */
	public function update_pending_pressrelease()
	{
		$rules = [
			'post_title' => 'required',
			'post_content' => 'required',
			'post_date' => 'required',
		];

		if (! $this->validate($rules)) {
			session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
			return redirect()->to(base_url('operations'));
		} else {

			$post_id = $this->request->getPost('post_id');
			$post_date = $this->request->getPost('post_date');
			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->request->getPost('post_date'))));
			$current_date = date("Y-m-d H:i:s");

			if($post_date >= $current_date){
				$post_status = "future";
			}else{
				$post_status = "publish";
			}

			$post_update = [
				'post_title' => $this->request->getPost('post_title'),
				'post_content' => $this->request->getPost('post_content'),
				'post_name' => $this->request->getPost('post_name'),
				'post_date' => $post_date,
				'post_date_gmt' => $post_date_gmt,
				'post_status' => $post_status
			];

			$postmeta_update = [
				'cf_campaign_link' => $this->request->getPost('cf_campaign_link'),
				'cf_cont_info' => $this->request->getPost('cf_cont_info'),
				'cf_keywords' => $this->request->getPost('cf_keywords'),
			];


			$response = $this->operationsModel->edit_icn_pressrelease($post_update, $postmeta_update, $post_id);

			return $this->response->setBody((string) $response['message']);
		}
	}//function ends

	
	/**
	 * add_categories
	 *
	 * @return void
	 */
	public function add_categories()
	{
		$categories = $this->request->getPost('categories');
		$post_id = $this->request->getPost('pr_id');
		$insert_data = array();

		foreach($categories as $cate){
			$add_data = [ 
				'object_id'=> $post_id,
				'term_taxonomy_id'=> $cate
			];
			array_push($insert_data, $add_data);	
		}
		$response = $this->operationsModel->add_new_categories($insert_data);
		if($response){

			$return_array = array(
				'li_ids' => $categories,
				'message'  => $response['message'],
			);

		}else{

			$return_array = array(
				'message'  => $response['message'],
			);	
		}

		return $this->response->setJSON($return_array);
		
	}//function ends

		
	/**
	 * remove_categories
	 *
	 * @return void
	 */
	public function remove_categories()
	{
		$categories = $this->request->getPost('categories');
		$post_id = $this->request->getPost('pr_id');
		
		$response = $this->operationsModel->delete_categories($categories,$post_id);
		if($response){

			$return_array = array(
				'li_ids' => $categories,
				'message'  => $response['message'],
			);

		}else{
			$return_array = array(
				'message'  => $response['message'],
			);

		}

		return $this->response->setJSON($return_array);

	}//function ends

		
	/**
	 * operations_filters
	 *
	 * @return void
	 */
	public function operations_filters()
	{

		$post_title = $this->request->getPost('post_title');
		$author_id = $this->request->getPost('author_id');
		$publish_date = $this->request->getPost('publish_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($publish_date));
		$day_end = date('Y-m-d 23:59:59', strtotime($publish_date));
		
		if ($post_title){

			$serach_query = "post_title LIKE '%$post_title%'";

		} elseif($author_id){

			$serach_query = "post_author = '$author_id'";

		}else{

			$serach_query = "post_date  >= '$day_start' AND post_date <= '$day_end'";

		}


		// $config = [
		// 	'base_url' => BASE_URL . 'operations/operations-filters/',
		// 	'per_page' => 20,
		// 	'total_rows' => 50,
		// 	'first_link' => false,
		// 	'last_link'  => false,
		// 	'prev_link' => '<i class="fa fa-caret-left"></i>',
		// 	'next_link' => '<i class="fa fa-caret-right"></i>',
		// 	'num_links' => 2,
		// 	'uri_segment' => 3,
		// 	'use_page_numbers' => FALSE,
		// ];


		// $this->pagination->initialize($config);

		$data['posts'] = $this->operationsModel->get_operations_filters(40, $serach_query);

		return view('operations/filters_dashboard', $data);

	}//function ends

		
	/**
	 * move_trash_pending
	 *
	 * @return void
	 */
	public function move_trash_pending()
	{
		$post_id = $this->request->getPost('post_id');
		$update_data = [
			'post_status' => 'pending'
		];
		$response = $this->operationsModel->move_trash_pressrelease_pending($post_id, $update_data);

		return $this->response->setBody((string) $response['message']);
	}//function ends

	
	/**
	 * check_unique_slug
	 *
	 * @return void
	 */
	public function check_unique_slug()
	{
		$post_name = $this->request->getPost('post_name');
        $response = $this->operationsModel->check_unique_slug_data($post_name);
        if ($response == 1) {
            return $this->response->setBody('false');
        }

        return $this->response->setBody('true');

	}//function ends

	
	/**
	 * show_client_information
	 *
	 * @return void
	 */
	public function show_client_information()
	{
		//echo ;
		$post_id     = $this->request->getPost('post_id');
		$kiosk_id    = $this->request->getPost('kiosk_id');
		$post_author = $this->request->getPost('post_author');

		if($kiosk_id == 19 OR $kiosk_id == ''){

			$response = $this->operationsModel->get_wordpress_user($post_author);
			$return_array = array(

				'full_name' => $response->user_nicename,
				'username' => $response->user_login,
				'email'  => $response->user_email,
			);
	
		}else{

			$response = $this->operationsModel->get_kiosk_user($post_id);
			$return_array = array(

				'full_name' => $response->first_name.''.$response->last_name,
				'username' => $response->username,
				'email'  => $response->email,
			);
			
		}

		return $this->response->setJSON($return_array);


	}//fucntion ends

	protected function currentUserLogin(): ?string
	{
		$userSession = session()->get('user_session');
		return is_object($userSession)
			? ($userSession->user_login ?? null)
			: ($userSession['user_login'] ?? null);
	}


		



}//class ends


