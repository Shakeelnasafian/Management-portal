<?php

namespace App\Controllers;

use App\Models\ManagementModel;

class Management extends BaseController
{
    protected ManagementModel $managementModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->managementModel = new ManagementModel();
    }

    public function index(): string
    {
        $day_start = date('Y-m-d');
        $day_end = date('Y-m-d 23:59:59');

        $data = $this->managementModel->get_icn_management_dashboard_data($day_start, $day_end);

        return view('management/dashboard', $data);
    }

    public function date_searching(): string
    {
        return view('management/date_search');
    }

    public function total_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_total_day_count($day_start, $day_end);
        return 'Total Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
    }

    public function verified_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_day_verified_count($day_start, $day_end);
        return 'Verified Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
    }

    public function none_verified_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_day_unverified_count($day_start, $day_end);
        return 'None Verified Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
    }

    public function frankly_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_day_frankly_count($day_start, $day_end);
        return 'Press Releases Sent to Frankly on ' . $post_data . ' are ' . $response . '<br>';
    }

    public function bignews_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_day_bignews_count($day_start, $day_end);
        return 'Press Releases Sent to BigNews on ' . $post_data . ' are ' . $response . '<br>';
    }

    public function financial_pressrelease_search_ajax(): string
    {
        $post_data = $this->request->getPost('select_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($post_data));
        $day_end = date('Y-m-d 23:59:59', strtotime($post_data));

        $response = $this->managementModel->get_day_financial_count($day_start, $day_end);
        return 'Press Releases Sent to Financial Content on ' . $post_data . ' are ' . $response . '<br>';
    }
}
