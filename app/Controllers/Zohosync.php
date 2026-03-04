<?php

namespace App\Controllers;

use App\Models\ZohosyncModel;

class Zohosync extends BaseController
{
    protected ZohosyncModel $zohosyncModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->zohosyncModel = new ZohosyncModel();
    }

    public function sync_icrowd_users_zoho($zoho_string)
    {
        if (ZOHO_NUM == decryptor($zoho_string)) {
            $icrowd_array = [];
            $kiosk_array = [];
            $today = date('Y-m-d 00:00:00');
            $response = $this->zohosyncModel->load_icrowd_users($today);
            $response1 = $this->zohosyncModel->load_kiosk_users($today);

            if ($response) {
                foreach ($response as $user) {
                    $icrowd_array[] = [
                        'username' => $user->user_login,
                        'email' => $user->user_email,
                        'name' => $user->display_name,
                        'registerd_on' => $user->user_registered,
                    ];
                }
            }

            if ($response1) {
                foreach ($response1 as $user) {
                    $kiosk_array[] = [
                        'username' => $user->username,
                        'email' => $user->email,
                        'name' => trim($user->first_name . ' ' . $user->last_name),
                        'registerd_on' => $user->registration_date,
                    ];
                }
            }

            $json_array = array_merge($icrowd_array, $kiosk_array);
        } else {
            $json_array = [
                'data' => null,
                'response' => 503,
                'request' => 'Bad Gateway',
            ];
        }

        return $this->response->setJSON($json_array);
    }
}
