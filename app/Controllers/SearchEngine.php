<?php

namespace App\Controllers;

use App\Models\SearchEngineModel;

class SearchEngine extends BaseController
{
    protected SearchEngineModel $searchEngineModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->searchEngineModel = new SearchEngineModel();
        $this->checkRole('SEO-Staff', 'Administrator', 'Editor');
    }

    public function find_pressrelease(): string
    {
        return view('search-engine/search-pr');
    }

    public function search_archive_pressrelease(): string
    {
        $response['post'] = $this->searchEngineModel->search_archive_post($this->request->getPost('post_name'));
        return view('search-engine/search-pr', $response);
    }

    public function edit_pressrelease($ID = 1231): string
    {
        $response['post'] = $this->searchEngineModel->edit_archive_post($ID);
        if ($response['post']) {
            return view('search-engine/edit-pr', $response);
        }

        return view('search-engine/search-pr');
    }

    public function update_archive_pressrelease($ID)
    {
        $rules = [
            'post_title' => 'required',
            'post_content' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('search-engine/find-pressrelease'));
        }

        $update_data = [
            'post_title' => $this->request->getPost('post_title'),
            'post_content' => $this->request->getPost('post_content'),
        ];

        $meta_data = [
            'seo_meta_title' => $this->request->getPost('meta_title'),
            'seo_meta_description' => $this->request->getPost('meta_description'),
        ];

        $response = $this->searchEngineModel->update_pressrelease_archive_data($update_data, $ID, $meta_data);

        if ($response['status']) {
            session()->setFlashdata('success-message', $response['message']);
        } else {
            session()->setFlashdata('error-message', $response['message']);
        }

        return redirect()->to(base_url('search-engine/find-pressrelease'));
    }

    public function delete_archive_pr($ID)
    {
        $response = $this->searchEngineModel->delete_archive_post($ID);
        session()->setFlashdata('success-message', $response['message']);
        return redirect()->to(base_url('search-engine/find-pressrelease'));
    }
}
