<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected UsersModel $usersModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->usersModel = new UsersModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('management'));
        }

        $data['title'] = 'Login';

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('users/login', $data);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $response = $this->usersModel->login($username);

        if ($response && check_wp_password($password, $response->user_pass)) {
            session()->set([
                'user_session' => $response,
                'logged_in' => false,
            ]);
            return redirect()->to(base_url('users/send-sms-code'));
        }

        session()->setFlashdata('login_failed', 'Please login with Correct username & Password');
        return redirect()->to(base_url('users/login'));
    }

    public function send_sms_code()
    {
        $userSession = session()->get('user_session');
        if (! $userSession) {
            return redirect()->to(base_url('users/login'));
        }

        $random = generate_random_string(4, true);
        $text = "Your Icrowd Management verification code is : {$random}";

        $mobile_number = is_object($userSession)
            ? ($userSession->cell_phone ?? null)
            : ($userSession['cell_phone'] ?? null);

        if ($mobile_number) {
            send_message($mobile_number, $text);
            session()->setFlashdata('sms_sent', ' We have sent One Time PIN to your registered Mobile Number:' . $mobile_number . ' Please enter the received PIN to continue.');
            session()->set('sms_verification', $random);
        } else {
            session()->setFlashdata('sms_sent', 'Kindly Provide US a Cell Number so that we can Authenticate you by Sending Code Thanks');
        }

        $data['mobile_number'] = $mobile_number;
        return view('users/sms-verification', $data);
    }

    public function verify_code()
    {
        $code = $this->request->getPost('verify_code');
        if (session()->get('sms_verification') == $code) {
            $userSession = session()->get('user_session');
            if (is_object($userSession)) {
                $userSession->logged_in = true;
            } elseif (is_array($userSession)) {
                $userSession['logged_in'] = true;
            }

            session()->set([
                'logged_in' => true,
                'user_session' => $userSession,
            ]);
            session()->remove('sms_verification');
            return redirect()->to(base_url());
        }

        session()->setFlashdata('sms_verfication_failed', 'You have entered an invalid code click the link to recive another code <a href="' . base_url('users/send-sms-code/') . '">Click</a>');
        return view('users/sms-verification');
    }

    public function add_user()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('users/login'));
        }

        $this->checkRole('Administrator');
        return view('users/add-user');
    }

    public function edit_profile($ID)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('users/login'));
        }

        $response['user'] = $this->usersModel->get_profile($ID);
        return view('users/profile', $response);
    }

    public function update_profile($ID)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('users/login'));
        }

        $rules = [
            'new_pass' => 'required',
            'confirm_pass' => 'required',
            'cell_phone' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('users/edit-profile/' . $ID));
        }

        $password = wp_hash_password($this->request->getPost('new_pass'));

        $image_url = '';
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid()) {
            $key = round(microtime(true)) . $file->getName();
            $image_url = service('amazon')->amazon_s3_upload($key, $file->getTempName());
        }

        $update_data = [
            'user_pass' => $password,
            'cell_phone' => $this->request->getPost('cell_phone'),
            'profile_image' => $image_url,
        ];

        $response = $this->usersModel->update_user_profile($update_data, $ID);
        if ($response['status']) {
            session()->setFlashdata('success-message', $response['message']);
        } else {
            session()->setFlashdata('error-message', $response['message']);
        }

        return redirect()->to(base_url('users/edit-profile/' . $ID));
    }

    public function create_new_user()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('users/login'));
        }

        $this->checkRole('Administrator');

        $rules = [
            'user_login' => 'required',
            'user_email' => 'required',
            'user_pass' => 'required',
            'cell_phone' => 'required',
            'icn_role' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('users/add-user'));
        }

        $password = wp_hash_password($this->request->getPost('user_pass'));

        $insert_data = [
            'user_login' => $this->request->getPost('user_login'),
            'user_pass' => $password,
            'user_email' => $this->request->getPost('user_email'),
            'user_registered' => date('Y-m-d H:i:s'),
            'cell_phone' => $this->request->getPost('cell_phone'),
            'icn_role' => $this->request->getPost('icn_role'),
        ];

        $response = $this->usersModel->create_new_user_data($insert_data);
        if ($response['status']) {
            session()->setFlashdata('success-message', $response['message']);
        } else {
            session()->setFlashdata('error-message', $response['message']);
        }

        return redirect()->to(base_url('users/add-user'));
    }

    public function check_user_login_ajax()
    {
        $user_login = $this->request->getPost('user_login');
        $response = $this->usersModel->check_user_login_ajax_data($user_login);
        return $this->response->setBody($response == 1 ? 'false' : 'true');
    }

    public function check_user_email_ajax()
    {
        $user_email = $this->request->getPost('user_email');
        $response = $this->usersModel->check_user_email_ajax_data($user_email);
        return $this->response->setBody($response == 1 ? 'false' : 'true');
    }

    public function forgot_password()
    {
        return view('users/forgot-password');
    }

    public function check_user()
    {
        if (! $this->validate(['email' => 'required|valid_email'])) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            session()->setFlashdata('email_failed', 'Please enter the email');
            return redirect()->to(base_url('users/forgot-password'));
        }

        $user_email = $this->request->getPost('email');
        $response = $this->usersModel->check_user_forgot_password($user_email);
        if ($response) {
            $verfication_code = generate_random_string(6, true);
            $verify_code = $response->ID . $verfication_code;

            $data['verification_link'] = base_url('users/reset-password/' . encryptor($verify_code));
            $data['full_name'] = $response->user_login;
            $template = 'email_templates/verification_link';
            $subject = 'Password rest link';
            $recipient = $response->user_email;
            send_email($template, $recipient, $subject, $data);

            $this->usersModel->save_user_verify_code($response->ID, $verfication_code);

            session()->setFlashdata('email_sent', 'Verification Email has been sent to you registerd account please click on the link to verify account.');
            return redirect()->to(base_url('users/forgot-password'));
        }

        session()->setFlashdata('email_failed', 'We are sorry! we did not find any account associated with your email, Please try with valide email.');
        return redirect()->to(base_url('users/forgot-password'));
    }

    public function reset_password($string_data)
    {
        $string = decryptor($string_data);
        $user_id = substr($string, 0, -6);
        $verify_code = substr($string, -6);

        $response = $this->usersModel->user_verification($user_id);

        if (! empty($response) && $response->verify_code == $verify_code) {
            $data['user'] = $response;
            $data['secret_string'] = $string_data;
            return view('users/change-password', $data);
        }

        session()->setFlashdata('email_failed', 'Unfortunately, there appears to be a problem in your request.');
        return redirect()->to(base_url('users/forgot-password'));
    }

    public function update_password()
    {
        if (! $this->validate(['password' => 'required'])) {
            session()->setFlashdata('password_error', 'Unfortunately, there appears to be a problem in your request.');
            return redirect()->to(base_url('users/reset-password/' . $this->request->getPost('user_token')));
        }

        $string = decryptor($this->request->getPost('user_token'));

        $user_id = substr($string, 0, -6);
        $verify_code = substr($string, -6);

        $response = $this->usersModel->user_verification($user_id);

        if (! empty($response) && $response->verify_code == $verify_code) {
            $password = wp_hash_password($this->request->getPost('password'));

            $data = [
                'user_pass' => $password,
            ];

            $this->usersModel->update_user_password($response->ID, $data);

            session()->setFlashdata('password_changed', 'Your password has been updated.<br>Please login with your new password. ');
            return redirect()->to(base_url('users/reset-password/' . $this->request->getPost('user_token')));
        }

        session()->setFlashdata('password_error', 'Unfortunately, there appears to be a problem in your request. ');
        return redirect()->to(base_url('users/reset-password/' . $this->request->getPost('user_token')));
    }

    public function logout()
    {
        $session = session();
        $session->remove(['logged_in', 'user_session', 'sms_verification']);
        $session->setFlashdata('user_loggedout', 'You are now logged out');
        return redirect()->to(base_url('users/login'));
    }
}
