<?php

namespace App\Controllers;

use App\Models\SalesModel;

class Sales extends BaseController
{
    protected SalesModel $salesModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->salesModel = new SalesModel();
    }

    public function pressreleases(): string
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->salesModel->pressrelease_dashboard_pagination()->post_id ?? 0;

        $pager = service('pager');
        $pager->setPath(base_url('sales/pressreleases'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['posts'] = $this->salesModel->get_icn_published_posts($perPage, $offset);
        $data['total_rows'] = $totalRows;
        $data['pager'] = $pager;

        return view('sales/pressreleases', $data);
    }

    public function sales_filters(): string
    {
        $post_title = $this->request->getPost('post_title');
        $author_id = $this->request->getPost('author_id');
        $publish_date = $this->request->getPost('publish_date');
        $day_start = date('Y-m-d 00:00:00', strtotime($publish_date));
        $day_end = date('Y-m-d 23:59:59', strtotime($publish_date));

        if ($post_title) {
            $search_query = "post_title LIKE '%$post_title%'";
            session()->set(['sales_search' => $search_query]);
        } elseif ($author_id) {
            $search_query = "post_author = '$author_id'";
            session()->set(['sales_search' => $search_query]);
        } elseif ($publish_date) {
            $search_query = "post_date  >= '$day_start' AND post_date <= '$day_end'";
            session()->set(['sales_search' => $search_query]);
        } else {
            $search_query = session()->get('sales_search');
        }

        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->salesModel->sale_post_filter_pagination($search_query)->post_id ?? 0;
        $pager = service('pager');
        $pager->setPath(base_url('sales/sales-filters'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['posts'] = $this->salesModel->get_sales_filters($perPage, $offset, $search_query);
        $data['total_rows'] = $totalRows;
        $data['pager'] = $pager;

        return view('sales/pressreleases', $data);
    }

    public function active_coupons(): string
    {
        $today = date('Y-m-d');
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->salesModel->active_coupon_pagination($today)->coupons ?? 0;
        $pager = service('pager');
        $pager->setPath(base_url('sales/active-coupons'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $response['coupons'] = $this->salesModel->load_icn_coupons($today, $perPage, $offset);
        $response['pager'] = $pager;

        return view('sales/coupons', $response);
    }

    public function sales_coupon_filters()
    {
        if (! $this->validate(['coupon_code' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('sales/active-coupons'));
        }

        $coupon_code = $this->request->getPost('coupon_code');
        $response['coupons'] = $this->salesModel->get_coupon_filter($coupon_code);

        return view('sales/coupons', $response);
    }

    public function coupon_usage_details()
    {
        $coupon_id = $this->request->getPost('coupon_id');
        $response = $this->salesModel->get_coupon_usage_details($coupon_id);

        if ($response) {
            $return_array = [
                'coupon_used' => $response->coupon_used != '' ? $response->coupon_used : 0,
                'coupon_applied' => $response->coupon_applied != '' ? $response->coupon_applied : 0,
            ];
            return $this->response->setJSON($return_array);
        }

        return $this->response->setJSON([]);
    }

    public function expired_coupons(): string
    {
        $today = date('Y-m-d');
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->salesModel->expired_coupon_pagination($today)->coupons ?? 0;
        $pager = service('pager');
        $pager->setPath(base_url('sales/expired-coupons'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $response['coupons'] = $this->salesModel->load_icn_expired_coupons($today, $perPage, $offset);
        $response['pager'] = $pager;

        return view('sales/coupons', $response);
    }

    public function users_credits(): string
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->salesModel->get_users_all_credits_pagination()->credits ?? 0;
        $pager = service('pager');
        $pager->setPath(base_url('sales/users-credits'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['credits'] = $this->salesModel->get_users_all_credits($perPage, $offset);
        $data['total_rows'] = $totalRows;
        $data['pager'] = $pager;

        return view('sales/user-credits', $data);
    }

    public function credits_filters(): string
    {
        if (! $this->validate(['user_email' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('sales/users-credits'));
        }

        $user_email = $this->request->getPost('user_email');

        $response['credits'] = $this->salesModel->get_user_credits_filter($user_email);
        $response['total_rows'] = count((array) $response['credits']);
        return view('sales/user-credits', $response);
    }
}
