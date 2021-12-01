<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Search_engine
 */
class Search_engine extends CI_Controller {
    
    /**
     * __construct
     *
     * @return void
     */

    public function __construct()
    {
		parent::__construct();
		
		if(!($this->session->userdata('user_session')->logged_in && $this->session->userdata('user_session')->icn_role == 'SEO-Staff' OR $this->session->userdata('user_session')->icn_role == 'Administrator' OR $this->session->userdata('user_session')->icn_role == 'Editor')){

			redirect(BASE_URL.'users/login');
		}	
		
	
    } //end function 

    
    /**
     * find_pressrelease
     * 
     * this function only load the view for finding PR
     * 
     * @return void
     */

    public function find_pressrelease()
	{
		$this->load->view('search-engine/search-pr');
	} //function ends
	
	/**
	 * search_pressrelease_archive
	 * 
     * this function search the pressrelease in archive table and then load it to edit screen
	 * 
     * @return void
	 */
    
	public function search_archive_pressrelease()
	{

		$response['post'] = $this->search_engine_model->search_archive_post($this->input->post('post_name'));
		if ($response) {

			$this->load->view('search-engine/search-pr', $response);
		} else {

			$this->load->view('search-engine/search-pr');
		}
    } //function end
        
    /**
     * edit_pressrelease
     *
     * @param  mixed $ID
     * @return void
     */
    public function edit_pressrelease($ID = 1231)
    {
        $response['post'] = $this->search_engine_model->edit_archive_post($ID);
        if ($response) {

			$this->load->view('search-engine/edit-pr', $response);
		} else {

			$this->load->view('search-engine/search-pr');
		}
    }
	
	/**
	 * update_pressrelease_archive
	 *
	 * @param  mixed $ID
	 * @return void
	 */

	public function update_archive_pressrelease($ID)
	{
		$this->form_validation->set_rules('post_title', 'post_title', 'required');
		$this->form_validation->set_rules('post_content', 'post_content', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'search-engine/find-pressrelease');
            
		} else {

			$update_data = [
				'post_title' => $this->input->post('post_title'),
				'post_content' => $this->input->post('post_content'),

            ];
            
            $meta_data = [
				'seo_meta_title' => $this->input->post('meta_title'),
                'seo_meta_description' => $this->input->post('meta_description'),
			];

            $response = $this->search_engine_model->update_pressrelease_archive_data($update_data,$ID,$meta_data);
            
			if($response['status']){
				$this->session->set_flashdata('success-message', $response['message']);
				redirect(BASE_URL . 'search-engine/find-pressrelease');
			}else{
				$this->session->set_flashdata('error-message', $response['message']);
				redirect(BASE_URL . 'search-engine/find-pressrelease');
			}
		}
	} //function ends

	public function delete_archive_pr($ID)
	{

		$response = $this->search_engine_model->delete_archive_post($ID);

		$this->session->set_flashdata('success-message', $response['message']);
		redirect(BASE_URL . 'search-engine/find-pressrelease');

	}//function ends



}//class ends