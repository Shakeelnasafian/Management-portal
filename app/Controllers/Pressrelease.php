<?php

namespace App\Controllers;

use App\Models\PressreleaseModel;

class Pressrelease extends BaseController
{
    protected PressreleaseModel $pressreleaseModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->pressreleaseModel = new PressreleaseModel();
        $this->checkRole('Operations-Staff', 'Administrator');
    }

    public function verified_prs(): string
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->pressreleaseModel->verified_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('pressrelease/verified_prs'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['posts'] = $this->pressreleaseModel->get_all_verified_prs($perPage, $offset);
        $data['pager'] = $pager;
        return view('pressrelease/verified_prs', $data);
    }

    public function none_verified_prs(): string
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->pressreleaseModel->none_verified_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('pressrelease/none_verified_prs'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['posts'] = $this->pressreleaseModel->get_all_none_verified_prs($perPage, $offset);
        $data['pager'] = $pager;
        return view('pressrelease/none_verified_prs', $data);
    }

    public function verify_pressrelease()
    {
        if (! $this->validate(['payment_type' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('pressrelease/none_verified_prs'));
        }

        $userSession = session()->get('user_session');
        $userLogin = is_object($userSession)
            ? ($userSession->user_login ?? null)
            : ($userSession['user_login'] ?? null);

        $update_data = [
            'transaction_id' => $this->request->getPost('transaction_id'),
            'payment_type' => $this->request->getPost('payment_type'),
            'coupon_code' => $this->request->getPost('coupon_code'),
            'verified_by' => $userLogin,
            'additional_comments' => $this->request->getPost('additional_comments'),
            'post_status' => 1,
        ];

        $response = $this->pressreleaseModel->verify_pressrelease($update_data, $this->request->getPost('pr_id'));
        return $this->response->setBody($response['message']);
    }

    public function pr_filters(): string
    {
        $pr_title = trim((string) $this->request->getPost('pr_title')) . '%';
        $post_author = trim((string) $this->request->getPost('posts_author'));

        $data['posts'] = $this->pressreleaseModel->get_filter_none_verified_prs($post_author, $pr_title);
        return view('pressrelease/none_verified_prs', $data);
    }

    public function get_pr_subscription_id()
    {
        $post_id = $this->request->getPost('pr_id');
        $response = $this->pressreleaseModel->get_post_subsription_id($post_id);

        if ($response) {
            $return_array = [
                'subscription_id' => $response['kiosk_data']->subscription_id,
                'coupon_code' => $response['coupon']->coupon_code,
            ];
            return $this->response->setJSON($return_array);
        }

        return $this->response->setJSON([]);
    }
}
