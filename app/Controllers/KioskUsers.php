<?php

namespace App\Controllers;

use App\Models\KioskUsersModel;

class KioskUsers extends BaseController
{
    protected KioskUsersModel $kioskUsersModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->kioskUsersModel = new KioskUsersModel();
        $this->checkRole('Stake Holders', 'Administrator', 'Editor');
    }

    public function search_user()
    {
        return view('kiosk-users/search-user');

    }//function ends


    public function find_user()
    {
        if (! $this->validate(['client_email' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('kiosk-users/search-user'));
        }

        $data['user'] = $this->kioskUsersModel->find_icn_user($this->request->getPost("client_email"));

        if ($data['user']) {
            return view('kiosk-users/update-user-credits', $data);
        }

        return redirect()->to(base_url('kiosk-users/search-user'));

    }//function ends

    public function update_user_credits()
    {
        if (! $this->validate(['new_credits' => 'required'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('kiosk-users/search-user'));
        }

        $update_array = array(
            "total_credit" =>  $this->request->getPost("new_credits"),
            "status"   =>   1,
            "current_credit" =>  0,
            "subscription_date" =>  date("Y-m-d h:i:s")
        ); 
    
        $this->kioskUsersModel->update_bulk_user_credits($this->request->getPost("user_id"),$update_array);

        return redirect()->to(base_url('kiosk-users/search-user'));

    }


    /**
     * pressrelease_users
     *
     * @return void
     */
    public function pressrelease_users()
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->kioskUsersModel->pressrelease_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('kiosk-users/pressrelease-users'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['pressrelease_users'] = $this->kioskUsersModel->get_pressrelease_users($perPage, $offset);

        $data['user_posts'] = filter_array_value($data['pressrelease_users']['posts']);
        $data['pager'] = $pager;
        return view('kiosk-users/icn-users', $data);
    } //function ends


    /**
     * get_pressrelease_user_details_ajax
     *
     * @return void
     */
    public function get_pressrelease_user_details_ajax()
    {
        $user_id  = $this->request->getPost("user_id");
        $response = $this->kioskUsersModel->get_pressrelease_user_details($user_id);

        $html = '';
        $html .= "<p><b class='heading'>ID </b> $response->ID </p>";
        $html .= "<p><b class='heading'>First Name </b> $response->first_name </p>";
        $html .= "<p><b class='heading'>Last Name </b> $response->last_name </p>";
        $html .= "<p><b class='heading'>Username </b> $response->user_login </p>";
        $html .= "<p><b class='heading'>Email </b> $response->user_email </p>";
        $html .= "<p><b class='heading'>Nickname </b> $response->user_nicename </p>";
        $html .= "<p><b class='heading'>Cell Phone </b> $response->cell_phone </p>";
        $html .= "<p><b class='heading'>Corporate Address </b> $response->corporate_address </p>";
        $html .= "<p><b class='heading'>City </b> $response->city </p>";
        $html .= "<p><b class='heading'>Country </b> $response->country </p>";

        return $this->response->setBody($html);
    } //function ends


    /**
     * legal_users
     *
     * @return void
     */
    public function legal_users()
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->kioskUsersModel->legal_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('kiosk-users/legal-users'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['legal_users'] = $this->kioskUsersModel->get_legal_users($perPage, $offset);

        $data['user_posts'] = filter_array_value(@$data['legal_users']['posts']);
        $data['pager'] = $pager;
        return view('kiosk-users/legal-users', $data);
    } //function ends


    /**
     * content_users
     *
     * @return void
     */
    public function content_users()
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->kioskUsersModel->content_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('kiosk-users/content-users'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['content_users'] = $this->kioskUsersModel->get_content_users($perPage, $offset);

        $data['user_posts'] = filter_array_value(@$data['content_users']['posts']);
        $data['pager'] = $pager;
        return view('kiosk-users/content-users', $data);
    } //function ends


    /**
     * realestate_users
     *
     * @return void
     */
    public function realestate_users()
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->kioskUsersModel->realestate_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('kiosk-users/realestate-users'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['realestate_users'] = $this->kioskUsersModel->get_realestate_users($perPage, $offset);

        $data['user_posts'] = filter_array_value(@$data['realestate_users']['posts']);
        $data['pager'] = $pager;
        return view('kiosk-users/wire-users', $data);
    } //function ends


    /**
     * get_kiosk_user_details_ajax
     *
     * @return void
     */
    public function get_kiosk_user_details_ajax()
    {

        $user_id  = $this->request->getPost("user_id");
        $response = $this->kioskUsersModel->get_kiosk_user_details($user_id);

        $html = '';
        $html .= "<p><b class='heading'>ID </b> $response->user_id </p>";
        $html .= "<p><b class='heading'>First Name </b> $response->first_name </p>";
        $html .= "<p><b class='heading'>Last Name </b> $response->last_name </p>";
        $html .= "<p><b class='heading'>Username </b> $response->username </p>";
        $html .= "<p><b class='heading'>Email </b> $response->email </p>";
        $html .= "<p><b class='heading'>Nickname </b> $response->username </p>";
        $html .= "<p><b class='heading'>Cell Phone </b> $response->cellphone </p>";
        $html .= "<p><b class='heading'>Corporate Address </b> $response->corporateAddress </p>";
        $html .= "<p><b class='heading'>City </b> $response->city </p>";
        $html .= "<p><b class='heading'>Country </b> $response->country </p>";

        return $this->response->setBody($html);
    } //function ends
    
    
    /**
     * add_nexis_account
     *
     * @return void
     */
    public function add_nexis_account()
    {
        $verfication_code = generate_random_string(6, true);
        $random_pass = empty($this->request->getPost("user_pass")) ? 'AryMCVPZ' : $this->request->getPost("user_pass");
        $password = wp_hash_password($random_pass);

        $insert_data = array(
            'user_login' => $this->request->getPost('user_login'),
            'user_pass' => $password,
            'user_nicename' => $this->request->getPost('client_name'),
            'user_email' => $this->request->getPost('user_email'),
            'user_registered' => date("Y-m-d H:i:s"),
            'display_name' => $this->request->getPost('client_name')
        );

        $meta_data = array(
            'icn_user_level' => '0',
            'emailVerificationCode' => $verfication_code,
            'emailVerificationStatus' => '1',
            'skipsmsauth' => '1',
            'corporate_address' => '',
            'icn_capabilities' => 'a:1:{s:10:"subscriber";b:1;}',
            'country' => $this->request->getPost('client_country'),
            'company' => $this->request->getPost('client_company'),
            'nexis_sqa_email' => $this->request->getPost('nexis_sqa_email'),
            'nexis_am_email' => $this->request->getPost('nexis_am_email'),
            'nexis_seller_email' => $this->request->getPost('nexis_seller_email'),
            'created_by' => $this->currentUserLogin()
        );

        $user_id = $this->kioskUsersModel->register_new_user($insert_data, $meta_data);

        if($user_id){
            $bulk_array = array( 
                "total_credit"      =>  $this->request->getPost("credit_request"),
                "enable_post_limit" =>  'no',
                "current_credit"    =>  0,
                "status"            =>  1,
                "user_id"           =>  $user_id,
                "package_selected"  =>  3,
                "subscription_date" =>  date("Y-m-d H:i:s") 
            );
            $status = array( 
                "user_id" => $user_id 
            );

            $this->kioskUsersModel->add_user_credits($bulk_array);
            $this->kioskUsersModel->mark_create_account_nexis($status,$this->request->getPost('user_id'));
            $result = true;
            
        }else{
            $result = false;
        }
    
        return redirect()->to(base_url('kiosk-users/nexisnewsire-users'));
    }

    
    /**
     * create_nexis_account
     *
     * @param  mixed $user_id
     * @return void
     */
    public function create_nexis_account($user_id)
    {
        $data['user'] = $this->kioskUsersModel->get_nexis_user($user_id);

        return view('kiosk-users/add-nexis-user', $data);

    }

        
    /**
     * nexisnewsire_users
     *
     * @return void
     */
    public function nexisnewsire_users()
    {
        $perPage = 20;
        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        $totalRows = $this->kioskUsersModel->nexisnewsire_pagination();
        $pager = service('pager');
        $pager->setPath(base_url('kiosk-users/nexisnewsire-users'));
        $pager->makeLinks($page, $perPage, $totalRows);

        $data['nexisnewsire_users'] = $this->kioskUsersModel->get_nexisnewsire_users($perPage, $offset);
        $data['pager'] = $pager;

        return view('kiosk-users/nexis-users', $data);

    }//function ends


    /**
     * check_user_email
     *
     * @return void
     */
    public function check_user_email()
    {
        $user_email = $this->request->getPost('user_email');
        $response = $this->kioskUsersModel->check_user_email($user_email);
        if ($response == 1) {
            return $this->response->setBody('false');
        }

        return $this->response->setBody('true');
    } //function end


    /**
     * check_user_login
     *
     * @return void
     */
    public function check_user_login()
    {
        $user_login = $this->request->getPost('user_login');
        $response = $this->kioskUsersModel->check_user_login($user_login);
        if ($response == 1) {
            return $this->response->setBody('false');
        }

        return $this->response->setBody('true');
    } //function end

    protected function currentUserLogin(): ?string
    {
        $userSession = session()->get('user_session');
        return is_object($userSession)
            ? ($userSession->user_login ?? null)
            : ($userSession['user_login'] ?? null);
    }


}//class end

