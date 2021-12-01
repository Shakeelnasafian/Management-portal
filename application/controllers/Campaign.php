<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Campaign
 */

class Campaign extends CI_Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_session')->logged_in) {

            redirect(BASE_URL . 'users/login');
        }
       

    } //end function 
    

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data['campaigns'] = $this->campaign_model->get_campaign_dashboard(15, 0);
        
        $this->load->view('campaign/dashboard',$data);
    }//function ends

    
    /**
     * in_progress
     *
     * @return void
     */
    public function active_campaigns()
    {
        $data['campaigns'] = $this->campaign_model->get_active_dashboard(15, 0);
        
        $this->load->view('campaign/active-campaign',$data);
    }//function ends

    
    /**
     * completed_campaigns
     *
     * @return void
     */
    public function completed_campaigns()
    {
        $data['campaigns'] = $this->campaign_model->get_completed_dashboard(15, 0);
        
        $this->load->view('campaign/dashboard',$data);
    }//function ends
    

    /**
     * socialmedia_dashboard
     *
     * @return void
     */
    public function socialmedia_dashboard()
    {

        $data['campaigns'] = $this->campaign_model->get_socialmedia_dashboard(15, 0);
        
        $this->load->view('campaign/socialmedia-dashboard',$data);
        
    }//function ends

    
    /**
     * operation_dashboard
     *
     * @return void
     */
    public function operations_dashboard()
    {

        $data['campaigns'] = $this->campaign_model->get_operations_dashboard(15, 0);
        
        $this->load->view('campaign/opertaions-dashboard',$data);

    }//function ends


    /**
     * gharphics_dashboard
     *
     * @return void
     */
    public function graphics_dashboard()
    {

        $data['campaigns'] = $this->campaign_model->get_graphics_dashboard(15, 0);
        
        $this->load->view('campaign/graphics-dashboard',$data);

    }//function ends


    /**
     * add_campaign
     *
     * @return void
     */
    public function add_campaign()
    {
        $this->load->view('campaign/add-campaign');
    }//function ends

        
    /**
     * get_pressrelease_details
     *
     * @return void
     */
    public function get_pressrelease_details()
    {
        $post_id = $this->input->post('post_id');

        $response = $this->campaign_model->get_pressrelease_details_db($post_id);

        $start_date = date("Y-m-d", strtotime($response->post_date));
       
        $end_date = date("Y-m-d", strtotime("+9 day",strtotime($response->post_date)));

        $product_name = get_product_name($response->kiosk_id);

        $return_array = array(

            'post_title' => $response->post_title,
            'post_name'  => $response->post_name,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'pr_package' => $response->pr_package,
            'product_name'=>$product_name
        );

        echo json_encode($return_array);
        
    }//function ends

    
    /**
     * create_campaign
     *
     * @return void
     */
    public function create_campaign()
    {
        $this->form_validation->set_rules('post_id', 'PR ID', 'required');
        $this->form_validation->set_rules('post_title', 'Post Title', 'required');
        $this->form_validation->set_rules('post_name', 'Post Name', 'required');
        $this->form_validation->set_rules('pr_package', 'Package', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('campaign_status', 'Campaign Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'campaign/add-campaign');
        } else {

            $insert_data = [
                'post_id' => $this->input->post('post_id'),
                'post_title' => $this->input->post('post_title'),
                'post_name' => $this->input->post('post_name'),
                'pr_package' => $this->input->post('pr_package'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'department' => $this->input->post('department'),
                'campaign_status' => $this->input->post('campaign_status'),
                'client_name' => $this->input->post('client_name'),
                'product_name' => $this->input->post('product_name')
            ];

            $response = $this->campaign_model->create_new_campaign($insert_data);
            if ($response['status']) {
                $this->session->set_flashdata('campaign-success', $response['message']);
                redirect(BASE_URL . 'campaign/add_campaign/');
            } else {
                $this->session->set_flashdata('campaign-error', $response['message']);
                redirect(BASE_URL . 'campaign/add_campaign/');
            }
        }

    }//function ends

    
    /**
     * add_mockups
     *
     * @param  mixed $post_id
     * @return void
     */
    public function add_mockups($post_id=1231)
    {
        $data['campaign'] = $this->campaign_model->get_campaign_details($post_id);
        $this->load->view('campaign/add-mockups', $data);

    }//function ends

    
    /**
     * upload_pr_mockups
     *
     * @return void
     */
    public function upload_pr_mockups()
    {

        require  FCPATH . '/vendor/autoload.php';

        $argv[1] = 'icnimage';
        $bucket = $argv[1];
        $key = round(microtime(true)) . $_FILES["mockups"]["name"];
        $file_Path = file_get_contents($_FILES["mockups"]['tmp_name']);

        try {
            //Create a S3Client
            $s3 = new Aws\S3\S3Client([
                'region'  => 'us-west-2',
                'version' => 'latest',
                'scheme'    => 'https',
                'credentials' => [
                    'key'    => "AKIAJ3PIT5AXJPCL667A",
                    'secret' => "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",
                ]
            ]);

            $result = $s3->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'SourceFile' => $source,
                'Body'   => $file_Path,
                'ACL'    => 'public-read',
                //'SourceFile' => 'c:\samplefile.png' -- use this if you want to upload a file from a local location
            ]);
        } catch (Exception $e) {
            echo json_encode('Nope');
            exit;
        }

        if ($result['ObjectURL']) {
            $zip_file = $result['ObjectURL'];
        }
        $post_id = $this->input->post('post_id');
        $campaign_id = $this->input->post('campaign_id');
        $department = $this->input->post('department');
        $campaign_status = $this->input->post('campaign_status');
        
        
    
        $update_data = [
            'campaign_status' =>$campaign_status,
            'department' => $department,
            'mockups' => $zip_file
        ];
        
        $response = $this->campaign_model->save_pr_mockups($campaign_id,$update_data);
        echo $response['message'];

    }//function ends
    
    /**
     * check_existing_campaign
     *
     * @return void
     */
    public function check_existing_campaign()
    {
        $post_id = $this->input->post('post_id');
        $response = $this->campaign_model->check_existing_campaign_ajax($post_id);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }

    }//fucntion ends

    
    /**
     * update_campaign_status
     *
     * @return void
     */
    public function update_campaign_status()
    {

        $this->form_validation->set_rules('department', 'department', 'required');
		$this->form_validation->set_rules('campaign_status', 'campaign_status', 'required');

		if ($this->form_validation->run() === FALSE) {

			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
			redirect(BASE_URL . 'pressrelease/none_verified_prs');
        
        } else {

			$update_data = [
				'department' => $this->input->post('department'),
				'campaign_status' => $this->input->post('campaign_status'),
			];

			$response = $this->campaign_model->update_campaign_status_ajax($update_data, $this->input->post('campaign_id'));
			echo  $response['message'];
		}

    }//fucntion ends

    



}//class ends
