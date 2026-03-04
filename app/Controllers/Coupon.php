<?php

namespace App\Controllers;

use App\Models\CouponModel;

class Coupon extends BaseController
{
    protected CouponModel $couponModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->couponModel = new CouponModel();
    }

    public function icn_coupons(): string
    {
        check_user_role(6);

        $today = date('Y-m-d');
        $response['coupons'] = $this->couponModel->load_icn_coupons($today);
        return view('coupon/active-coupons', $response);
    }

    public function view_coupon($coupon_id): string
    {
        check_user_role(6);
        $response = $this->couponModel->view_coupon_data($coupon_id);
        return view('coupon/view-coupon', $response);
    }

    public function edit_coupon($coupon_id): string
    {
        check_user_role(8);
        $response['coupon'] = $this->couponModel->edit_coupon_data($coupon_id);
        return view('coupon/edit-coupon', $response);
    }

    public function update_coupon($coupon_id)
    {
        check_user_role(8);

        $rules = [
            'date_expire' => 'required',
            'discount_price' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('coupon/edit_coupon/' . $coupon_id));
        }

        $coupon_limit = ($this->request->getPost('coupon_counter') == 0 ? 'no' : 'yes');
        $update_data = [
            'discount_price' => $this->request->getPost('discount_price'),
            'discount_type' => $this->request->getPost('discount_type'),
            'date_expire' => $this->request->getPost('date_expire'),
            'kiosk_instance' => $this->request->getPost('kiosk_instance'),
            'pack_id' => $this->request->getPost('pack_id'),
            'one_time_per_user' => $this->request->getPost('one_time_per_user'),
            'coupon_counter' => $this->request->getPost('coupon_counter'),
            'coupon_emails' => $this->request->getPost('coupon_emails'),
            'limit_coupon' => $coupon_limit,
            'edited_by' => $this->currentUserLogin(),
            'ip_address' => $this->request->getIPAddress(),
            'transaction_id' => $this->request->getPost('transaction_id'),
            'payment_status' => $this->request->getPost('payment_status'),
            'amount' => $this->request->getPost('amount'),
        ];

        $response = $this->couponModel->update_coupon_data($update_data, $coupon_id);
        if ($response['status']) {
            $update_coupon_history_data = [
                'counter' => $this->request->getPost('coupon_counter'),
                'coupon_price' => $this->request->getPost('discount_price'),
                'coupon_type' => $this->request->getPost('discount_type'),
                'coupon_id' => $coupon_id,
                'ip_address' => $this->request->getIPAddress(),
                'updated_by' => $this->currentUserLogin(),
                'action' => 'updated',
            ];
            $this->create_coupon_history($update_coupon_history_data);

            session()->setFlashdata('success-message', $response['message']);
            return redirect()->to(base_url('coupon/view_coupon/' . $coupon_id));
        }

        session()->setFlashdata('error-message', $response['message']);
        return redirect()->to(base_url('coupon/view_coupon/' . $coupon_id));
    }

    public function add_coupon(): string
    {
        check_user_role(8);
        return view('coupon/add-coupon');
    }

    public function create_coupon()
    {
        check_user_role(8);

        $rules = [
            'coupon_code' => 'required',
            'discount_price' => 'required',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('coupon/icn-coupons'));
        }

        $coupon_limit = ($this->request->getPost('coupon_counter') == 0 ? 'no' : 'yes');
        $insert_data = [
            'coupon_code' => $this->request->getPost('coupon_code'),
            'discount_price' => $this->request->getPost('discount_price'),
            'discount_type' => $this->request->getPost('discount_type'),
            'date_expire' => $this->request->getPost('date_expire'),
            'kiosk_instance' => $this->request->getPost('kiosk_instance'),
            'pack_id' => $this->request->getPost('pack_id'),
            'one_time_per_user' => $this->request->getPost('one_time_per_user'),
            'coupon_counter' => $this->request->getPost('coupon_counter'),
            'coupon_emails' => $this->request->getPost('coupon_emails'),
            'limit_coupon' => $coupon_limit,
            'date_added' => date('Y-m-d h:i:s'),
            'wp_post_id' => 0,
            'created_by' => $this->currentUserLogin(),
            'ip_address' => $this->request->getIPAddress(),
            'transaction_id' => $this->request->getPost('transaction_id'),
            'payment_status' => $this->request->getPost('payment_status'),
            'amount' => $this->request->getPost('amount'),
        ];

        $response = $this->couponModel->create_new_coupon($insert_data, $this->request->getPost('pack_id'));
        if ($response['status']) {
            $update_coupon_history_data = [
                'counter' => $this->request->getPost('coupon_counter'),
                'coupon_price' => $this->request->getPost('discount_price'),
                'coupon_type' => $this->request->getPost('discount_type'),
                'coupon_id' => $response['coupon_id'],
                'ip_address' => $this->request->getIPAddress(),
                'updated_by' => $this->currentUserLogin(),
                'action' => 'created',
            ];
            $this->create_coupon_history($update_coupon_history_data);
            session()->setFlashdata('success-message', $response['message']);
            return redirect()->to(base_url('coupon/view-coupon/' . $response['coupon_id']));
        }

        session()->setFlashdata('error-message', $response['message']);
        return redirect()->to(base_url('coupon/icn-coupons/'));
    }

    public function expired_coupons(): string
    {
        check_user_role(6);

        $today = date('Y-m-d');
        $response['coupons'] = $this->couponModel->load_icn_expired_coupons($today);
        return view('coupon/expired-coupons', $response);
    }

    public function check_coupon_code()
    {
        check_user_role(6);
        $coupon_code = $this->request->getPost('coupon_code');
        $response = $this->couponModel->check_coupon_code_data($coupon_code);
        return $this->response->setBody($response == 1 ? 'false' : 'true');
    }

    public function expire_coupon($coupon_id)
    {
        check_user_role(8);

        $date = date('Y-m-d', strtotime('yesterday'));
        $update_data = [
            'date_expire' => $date,
        ];
        $response = $this->couponModel->expire_coupon_data($update_data, $coupon_id);

        if ($response['status']) {
            session()->setFlashdata('success-message', $response['message']);
        } else {
            session()->setFlashdata('error-message', $response['message']);
        }

        return redirect()->to(base_url('coupon/view_coupon/' . $coupon_id));
    }

    public function coupon_filters()
    {
        check_user_role(6);

        $rules = ['coupon_code' => 'required'];
        if (! $this->validate($rules)) {
            session()->setFlashdata('validation_failed', strip_tags(implode("\n", $this->validator->getErrors())));
            return redirect()->to(base_url('coupon/icn-coupons'));
        }

        $coupon_code = $this->request->getPost('coupon_code');
        $response['coupons'] = $this->couponModel->get_coupon_filter($coupon_code);
        return view('coupon/active-coupons', $response);
    }

    public function create_coupon_history($data)
    {
        $this->couponModel->update_coupon_history_data($data);
    }

    public function transaction_details(): string
    {
        check_user_role(6);
        return view('coupon/trans-details');
    }

    public function get_transaction_details()
    {
        $post_id = (int) $this->request->getPost('post_id');
        $response = $this->couponModel->get_tans_details($post_id);

        if ($response) {
            $return_str = <<<EOD
                        <table class="table m-0">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Cost</th>
                                <th>Transaction ID</th>
                                <th>Payer Email</th>
                                <th>Payer Name</th>
                                <th>Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>$response->user_id</td>
                                <td>$response->payment_type</td>
                                <td>$response->status</td>
                                <td>$response->cost</td>
                                <td>$response->transaction_id</td>
                                <td>$response->payer_email</td>
                                <td>$response->payer_first_name $response->payer_last_name</td>
                                <td>$response->created</td>
                            </tr>
                        </tbody>
                    </table>
                    EOD;
        } else {
            $return_str = '<div><span class="trans-not-found">No Record Found</span></div>';
        }

        return $this->response->setBody($return_str);
    }

    protected function currentUserLogin(): ?string
    {
        $userSession = session()->get('user_session');
        return is_object($userSession)
            ? ($userSession->user_login ?? null)
            : ($userSession['user_login'] ?? null);
    }
}
