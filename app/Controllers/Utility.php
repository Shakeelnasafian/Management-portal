<?php

namespace App\Controllers;

use App\Models\UtilityModel;

class Utility extends BaseController
{
    protected UtilityModel $utilityModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->utilityModel = new UtilityModel();
    }

    public function pr_media_sites_links()
    {
        return view('utility/media_sites_links');
    }

    public function add_marketplace_sites_links()
    {
        check_user_role(8);
        return view('utility/add_marketplace');
    }

    public function search_marketplace_sites_links()
    {
        check_user_role(6);
        $rss_channel_id = 35;

        $perPage = 10;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->utilityModel->marketplace_pagination($rss_channel_id)->post_id ?? 0;
        $pager = service('pager');
        $pager->setPath(base_url('utility/search-marketplace-sites-links'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['marketplace_data'] = $this->utilityModel->marketplace_posts_data($rss_channel_id, $perPage, $offset);
        $data['pager'] = $pager;

        return view('utility/marketplace_search', $data);
    }

    public function create_marketplace()
    {
        check_user_role(8);
        $rss_channel_id = 35;

        $rules = [
            'post_id' => 'required',
            'market_place_url' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('utility/add-marketplace-sites-links'));
        }

        $insert_data = [
            'rss_name' => 'MarketPlace',
            'post_id' => preg_replace('#[^0-9]#', '', (string) $this->request->getPost('post_id')),
            'post_link' => $this->request->getPost('market_place_url'),
            'fetch_date' => date('Y-m-d H:i:s'),
            'rss_channel_id' => $rss_channel_id,
        ];

        $response = $this->utilityModel->create_new_marketplace($insert_data);

        if ($response['status']) {
            session()->setFlashdata('success-message', $response['message']);
            $rssId = $response['rss_id'] ?? null;
            $redirect = $rssId ? 'utility/add-marketplace-sites-links/' . $rssId : 'utility/add-marketplace-sites-links';
            return redirect()->to(base_url($redirect));
        }

        session()->setFlashdata('error-message', $response['message']);
        return redirect()->to(base_url('utility/add-marketplace-sites-links'));
    }

    public function marketplace_posts_filters()
    {
        check_user_role(6);
        $rss_channel_id = 35;

        if (! $this->validate(['post_id' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('utility/search-marketplace-sites-links'));
        }

        $post_id = preg_replace('#[^0-9]#', '', (string) $this->request->getPost('post_id'));
        $response['marketplace_data'] = $this->utilityModel->check_marketplace_post_id($post_id, $rss_channel_id);
        return view('utility/marketplace_search', $response);
    }

    public function search_frankly_links()
    {
        $response = $this->utilityModel->search_frankly_data($this->request->getPost('post_id'));
        if ($response) {
            $item = 1;
            $html = '';
            foreach ($response as $link) {
                $html .= "<tr><td> {$item} </td><td> {$link->post_link} </td></tr>";
                $item++;
            }
            return $this->response->setBody($html);
        }

        return $this->response->setBody("<tr><td> </td><td> No Frankly Link Found </td></tr>");
    }

    public function search_bignews_links()
    {
        $id = $this->request->getPost('post_id');
        $bigpond = "http://example-reporting.mwrn.net/reporting?post_id={$id}";

        $big_pond_data = @file_get_contents($bigpond);
        $raw_data = json_decode((string) $big_pond_data, true);
        if ($raw_data) {
            $item = 1;
            $html = '';
            foreach ($raw_data['items'] as $links) {
                $html .= '<tr><td>' . $item . ' </td><td>' . $links['link'] . '</td></tr>';
                $item++;
            }
            return $this->response->setBody($html);
        }

        return $this->response->setBody("<tr><td> </td><td> No Bignews Link Found </td></tr>");
    }

    public function languages_sites()
    {
        return view('utility/languages_lins');
    }

    public function search_languages_links()
    {
        $response = $this->utilityModel->search_languages_sites_link($this->request->getPost('post_id'));
        if ($response) {
            $item = 1;
            $html = '';
            foreach ($response as $link) {
                $html .= "<tr><td> {$item} </td><td> {$link->post_link} </td><td> {$link->post_language} </td></tr>";
                $item++;
            }
            return $this->response->setBody($html);
        }

        return $this->response->setBody("<tr><td> </td><td> No Languages Link Found </td><td> </td></tr>");
    }

    public function renew_session()
    {
        session()->set('last_activity', time());
        return $this->response->setBody('Ping successful');
    }

    public function verify_transaction_id_paypal()
    {
        $transaction_id = $this->request->getPost('transaction_id');
        $result = get_payment_verification($transaction_id);

        if ($result && $result->status) {
            $return_array = [
                'payment_status' => $result->status,
                'amount' => $result->amount->value ?? null,
            ];
        } else {
            $return_array = [
                'payment_status' => 'Null',
            ];
        }

        return $this->response->setJSON($return_array);
    }
}
