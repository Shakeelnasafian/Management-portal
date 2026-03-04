<?php

namespace App\Controllers;

use App\Models\CampaignModel;

class Campaign extends BaseController
{
    protected CampaignModel $campaignModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->campaignModel = new CampaignModel();
    }

    public function index(): string
    {
        $data['campaigns'] = $this->campaignModel->get_campaign_dashboard(15, 0);
        return view('campaign/dashboard', $data);
    }

    public function active_campaigns(): string
    {
        $data['campaigns'] = $this->campaignModel->get_active_dashboard(15, 0);
        return view('campaign/active-campaign', $data);
    }

    public function completed_campaigns(): string
    {
        $data['campaigns'] = $this->campaignModel->get_completed_dashboard(15, 0);
        return view('campaign/dashboard', $data);
    }

    public function socialmedia_dashboard(): string
    {
        $data['campaigns'] = $this->campaignModel->get_socialmedia_dashboard(15, 0);
        return view('campaign/socialmedia-dashboard', $data);
    }

    public function operations_dashboard(): string
    {
        $data['campaigns'] = $this->campaignModel->get_operations_dashboard(15, 0);
        return view('campaign/opertaions-dashboard', $data);
    }

    public function graphics_dashboard(): string
    {
        $data['campaigns'] = $this->campaignModel->get_graphics_dashboard(15, 0);
        return view('campaign/graphics-dashboard', $data);
    }

    public function add_campaign(): string
    {
        return view('campaign/add-campaign');
    }

    public function get_pressrelease_details()
    {
        $post_id = $this->request->getPost('post_id');

        $response = $this->campaignModel->get_pressrelease_details_db($post_id);

        $start_date = date('Y-m-d', strtotime($response->post_date));
        $end_date = date('Y-m-d', strtotime('+9 day', strtotime($response->post_date)));
        $product_name = get_product_name($response->kiosk_id);

        $return_array = [
            'post_title' => $response->post_title,
            'post_name' => $response->post_name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'pr_package' => $response->pr_package,
            'product_name' => $product_name,
        ];

        return $this->response->setJSON($return_array);
    }

    public function create_campaign()
    {
        $rules = [
            'post_id' => 'required',
            'post_title' => 'required',
            'post_name' => 'required',
            'pr_package' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'department' => 'required',
            'campaign_status' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('campaign/add-campaign'));
        }

        $insert_data = [
            'post_id' => $this->request->getPost('post_id'),
            'post_title' => $this->request->getPost('post_title'),
            'post_name' => $this->request->getPost('post_name'),
            'pr_package' => $this->request->getPost('pr_package'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'department' => $this->request->getPost('department'),
            'campaign_status' => $this->request->getPost('campaign_status'),
            'client_name' => $this->request->getPost('client_name'),
            'product_name' => $this->request->getPost('product_name'),
        ];

        $response = $this->campaignModel->create_new_campaign($insert_data);
        if ($response['status']) {
            session()->setFlashdata('campaign-success', $response['message']);
        } else {
            session()->setFlashdata('campaign-error', $response['message']);
        }

        return redirect()->to(base_url('campaign/add-campaign'));
    }

    public function add_mockups($post_id = 1231): string
    {
        $data['campaign'] = $this->campaignModel->get_campaign_details($post_id);
        return view('campaign/add-mockups', $data);
    }

    public function upload_pr_mockups()
    {
        $file = $this->request->getFile('mockups');
        if (! $file || ! $file->isValid()) {
            return $this->response->setJSON('Nope');
        }

        $key = round(microtime(true)) . $file->getName();
        $zip_file = service('amazon')->amazon_s3_upload($key, $file->getTempName());

        $campaign_id = $this->request->getPost('campaign_id');
        $department = $this->request->getPost('department');
        $campaign_status = $this->request->getPost('campaign_status');

        $update_data = [
            'campaign_status' => $campaign_status,
            'department' => $department,
            'pr_mockup_link' => $zip_file,
        ];

        $response = $this->campaignModel->save_pr_mockups($campaign_id, $update_data);
        return $this->response->setBody($response['message']);
    }

    public function check_existing_campaign()
    {
        $post_id = $this->request->getPost('post_id');
        $response = $this->campaignModel->check_existing_campaign_ajax($post_id);
        return $this->response->setBody($response == 1 ? 'false' : 'true');
    }

    public function update_campaign_status()
    {
        $rules = [
            'department' => 'required',
            'campaign_status' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('pressrelease/none_verified_prs'));
        }

        $update_data = [
            'department' => $this->request->getPost('department'),
            'campaign_status' => $this->request->getPost('campaign_status'),
        ];

        $response = $this->campaignModel->update_campaign_status_ajax($update_data, $this->request->getPost('campaign_id'));
        return $this->response->setBody($response['message']);
    }
}
