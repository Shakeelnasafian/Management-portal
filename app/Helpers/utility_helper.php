<?php

if (!function_exists('dd')) {
    /**
     * dd
     *
     * @param  mixed $data
     * @param  mixed $array
     * @return void
     */
    function dd($data, $array = true)
    {
        echo "<pre>";
        if ($array) {
            print_r($data);
        } else {
            echo $data;
        }
        exit;
    }
} //end function



if (!function_exists('getHtml')) {
    /**
     * getHtml
     *
     * @param  mixed $link
     * @return void
     */
    function getHtml($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $execute = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            print_r("CURL Error: " . $error);
        } else {
            return $execute;
        }
    }
} //function ends


if (!function_exists("show_kiosks_name_view")) {

    /**
     * show_kiosks_name_view
     *
     * @param  mixed $id
     * @return void
     */
    function show_kiosks_name_view($id = 123)
    {
        $db = db_connect();
        $row = $db->table('kiosks_list')
            ->select('title')
            ->where('kiosk_id', $id)
            ->get()
            ->getRowArray();

        return $row['title'] ?? '';
    }
} //function ends


if (!function_exists("show_kiosks_name_edit")) {

    /**
     * show_kiosks_name_edit
     *
     * @param  mixed $id
     * @return void
     */
    function show_kiosks_name_edit($id = false)
    {
        $selected = '';
        $selection = '';

        $db = db_connect();
        $response = $db->table('kiosks_list')
            ->select('kiosk_id,title')
            ->where('status', 1)
            ->orderBy('name', 'desc')
            ->get()
            ->getResultArray();

        foreach ($response as $item) {
            if ($item['kiosk_id'] == $id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $selection .= "<option $selected value='{$item['kiosk_id']}' >{$item['title']}</option>";
        }

        return $selection;
    }
} //function ends

if (!function_exists("show_products_name_view")) {

    /**
     * show_kiosks_name_view
     *
     * @param  mixed $id
     * @return void
     */
    function show_products_name_view($id = 123)
    {
        $kiosk_name = '';

        $array = array(
            '19' => 'Example Live',
            '56' => 'Example.RealEstate',
            '47' => 'Example Newswire',
            '55' => 'Example.com',
            '58' => 'Example Marketing',
            '60' => 'Example America'
        );

        foreach ($array as $key => $value) {
            if ($key == $id) {
                $kiosk_name = $value;
            }
        }
        return $kiosk_name;
    }
} //fun

if (!function_exists("show_products_name_edit")) {

    /**
     * show_kiosks_name_edit
     *
     * @param  mixed $id
     * @return void
     */
    function show_products_name_edit($id = false)
    {
        $selected = '';
        $selection = '';

        $array = array(
            '19' => 'Example Live',
            '56' => 'Example.RealEstate',
            '47' => 'Example Newswire',
            '55' => 'Example.com',
            '58' => 'Example Marketing',
            '60' => 'Example America'
        );
        foreach ($array as $index => $value) {
            if ($index == $id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $selection .= "<option value=" . $index . " $selected>$value</option>";
        }

        return $selection;
    }
} //function ends

if (!function_exists("get_subcription_package")) {

    /**
     * get_subcription_package
     *
     * @param  mixed $id
     * @return void
     */
    function get_subcription_package($id = false)
    {
        $db = db_connect();
        $row = $db->table('icn_posts')
            ->select('post_title')
            ->where('ID', $id)
            ->where('post_status', 'publish')
            ->get()
            ->getRowArray();

        return $row['post_title'] ?? '';
    }
} //function ends

if (!function_exists("get_package_name")) {

    /**
     * get_package_name
     *
     * @param  mixed $id
     * @return void
     */
    function get_package_name($id = false, $kiosk)
    {
        $product_name = '';
        $path = "assets/json/result.json";
        $string = file_get_contents($path);
        $result = json_decode($string, true);
        foreach ($result[$kiosk] as $item) {
            if ($item['id'] == $id) {
                $product_name = $item['name'];
            }
        }
        return $product_name;
    }
} //function ends


if (!function_exists("show_subcription_package")) {

    /**
     * show_subcription_package
     *
     * @param  mixed $id
     * @return void
     */
    function show_subcription_package($id = false)
    {
        $selected = '';
        $selection = '';

        $db = db_connect();
        $response = $db->table('icn_posts')
            ->select('ID, post_title')
            ->where('post_type', 'wpuf_subscription')
            ->where('post_status', 'publish')
            ->get()
            ->getResultArray();

        foreach ($response as $item) {
            if ($item['ID'] == $id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $selection .= "<option $selected value='{$item['ID']}' >{$item['post_title']}</option>";
        }
        return $selection;
    }
} //function ends

if (!function_exists("show_package_name")) {

    /**
     * show_package_name
     *
     * @param  mixed $id
     * @return void
     */
    function show_package_name($id = false, $kiosk)
    {
        //  dd($id);
        $selected = '';
        $selection = '';
        $path = "assets/json/result.json";
        $string = file_get_contents($path);
        $result = json_decode($string, true);
        //   dd($$result[$kiosk]);

        foreach ($result[$kiosk] as $item) {
            if ($item['id'] == $id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $selection .= "<option $selected value=" . $item['id'] . ">" . $item['name'] . "</option>";
        }
        return $selection;
    }
} //function ends


if (!function_exists('upload_image')) {

    /**
     * upload_image
     *
     * @param  mixed $key
     * @param  mixed $source
     * @return void
     */
    function upload_image($key, $source)
    {
        return service('amazon')->amazon_s3_upload($key, $source);
    }
} //function ends

if (!function_exists('get_latest_authors')) {
    /**
     * get_latest_authors
     *
     * @param  mixed $authors
     * @return void
     */
    function get_latest_authors($authors)
    {
        if ($authors) {
            foreach ($authors as $author) {
                echo "<option value='$author->post_author'>$author->post_author</option>";
            }
        }
    }
} //function end

if (!function_exists('check_wp_password')) {

    /**
     * check_wp_password
     *
     * @param  mixed $user_pass
     * @param  mixed $db_hash_pass
     * @return void
     */
    function check_wp_password($user_pass, $db_hash_pass)
    {
        $wp_hasher = new \App\Libraries\PasswordHash(8, true);
        return $wp_hasher->CheckPassword($user_pass, $db_hash_pass);
    }
} //function end



if (!function_exists('generate_random_string')) {

    /**
     * generate_random_string
     *
     * @param  mixed $length
     * @param  mixed $numeric
     * @return void
     */
    function generate_random_string($length, $numeric = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($numeric) {
            $characters = '0123456789';
        }
        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
} //function end


if (!function_exists('send_message')) {

    /**
     * send_message
     *
     * @param  mixed $mobile_number
     * @param  mixed $text
     * @return void
     */
    function send_message($mobile_number, $text)
    {
        service('twilio')->send_message($mobile_number, $text);
    }
} //function ends


if (!function_exists('filter_array_value')) {

    /**
     * filter_array_value
     *
     * @param  mixed $array
     * @return void
     */
    function filter_array_value($array)
    {

        $posts_id_array = array();

        if (!empty($array)) {

            foreach ($array as $post_id) {
                array_push($posts_id_array, $post_id->user_id);
            }
        }
        return $posts_id_array;
    }
} //function ends


if (!function_exists("get_access_token")) {
    /**
     * get_access_token
     *
     * @return void
     */
    function get_access_token()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT . ":" . PAYPAL_SECRET);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($ch);
        $accessToken = null;
        if (empty($result))
            die('invalid access token');
        else {
            $json = json_decode($result);
            $accessToken = $json->access_token;
        }
        curl_close($ch);
        return $accessToken;
    }
}

if (!function_exists("get_payment_verification")) {
    /**
     * get_payment_verification
     *
     * @param  mixed $transction_id
     * @return void
     */
    function get_payment_verification($transction_id = '12312312')
    {
        $curl = curl_init("https://api.paypal.com/v2/payments/captures/$transction_id");
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . get_access_token(),
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        $response = curl_exec($curl);
        $result = json_decode($response);
        return $result;
        // echo "<pre>";
        // print_r($result);
    }
}


if (!function_exists("check_report_kiosk_id")) {
    /**
     * check_report_kiosk_id
     *
     * @param  mixed $kiosk_id
     * @param  mixed $post_id
     * @return void
     */
    function check_report_kiosk_id($kiosk_id = '123', $post_id = '123')
    {
        switch ($kiosk_id) {
            case 19:
                echo 'https://Example.com/report/?id=' . $post_id;
                break;
            case 47:
                echo 'https://www.Example.com/legalnewswire/reporting.php?id=' . $post_id;
                break;
            case 55:
                echo 'https://Example.com/reporting.php?id=' . $post_id;
                break;
            case 56:
                echo 'https://Example.realestate/reporting.php?id=' . $post_id;
                break;
            case 58:
                echo 'http://Example.us/reporting.php?id=' . $post_id;
                break;
            default:
                echo 'https://Example.com/report/?id=' . $post_id;
        }
    }
}

if (!function_exists("get_post_title_reporting")) {
    /**
     * get_post_title_reporting
     *
     * @param  mixed $post_id
     * @return void
     */
    function get_post_title_reporting($post_id = '123')
    {
        $db = db_connect();
        $row = $db->table('icn_posts')
            ->select('post_title')
            ->where('ID', $post_id)
            ->get()
            ->getRowArray();

        return $row['post_title'] ?? '';
    }
}



if (!function_exists("get_product_name")) {

    /**
     * get_product_name
     *
     * @param  mixed $product_id
     * @return void
     */
    function get_product_name($product_id = '123')
    {
        $product = '';
        switch ($product_id) {
            case 19:
                $product = "Example";
                break;
            case 47:
                $product = "Example NewsWire";
                break;
            case 55:
                $product = "Example Marketing";
                break;
            case 56:
                $product = "Example.RealEstate";
                break;
            case 58:
                $product = "Example Marketing";
                break;
            default:
                $product = "Example";
        }
        return $product;
    }
} //function ends


if (!function_exists("pressrelease_categories")) {


    /**
     * pressrelease_categories
     *
     * @return void
     */
    function pressrelease_categories($cates)
    {
        $cates_array = explode(',', $cates);
        $db = db_connect();
        $response = $db->table('icn_term_taxonomy')
            ->select('icn_term_taxonomy.*, icn_terms.name, icn_terms.slug')
            ->join('icn_terms', 'icn_terms.term_id = icn_term_taxonomy.term_id', 'left')
            ->where('icn_term_taxonomy.taxonomy', 'category')
            ->orderBy('icn_term_taxonomy.term_taxonomy_id', 'desc')
            ->get()
            ->getResultArray();

        foreach ($response as $category) {

            if (!in_array($category['term_taxonomy_id'], $cates_array)) {

                echo '<li id=' . $category['term_taxonomy_id'] . ' ><label class="checkbox-cate"><input type="checkbox" class="cate-check" name="categories[]" value="' . $category['term_taxonomy_id'] . '">' . $category['name'] . '</label></li>';
            }
        }
        //return $response;
    }
} //function ends

if (!function_exists("selected_pressrelease_categories")) {



    function selected_pressrelease_categories($cates)
    {
        $cates_array = explode(',', $cates);
        $db = db_connect();
        $response = $db->table('icn_term_taxonomy')
            ->select('icn_term_taxonomy.*, icn_terms.name, icn_terms.slug')
            ->join('icn_terms', 'icn_terms.term_id = icn_term_taxonomy.term_id', 'left')
            ->where('icn_term_taxonomy.taxonomy', 'category')
            ->orderBy('icn_term_taxonomy.term_taxonomy_id', 'desc')
            ->get()
            ->getResultArray();


        foreach ($response as $category) {

            if (in_array($category['term_taxonomy_id'], $cates_array)) {

                echo '<li id=' . $category['term_taxonomy_id'] . '><label class="checkbox-cate"><input type="checkbox" class="cate-check" name="categories[]" value="' . $category['term_taxonomy_id'] . '">' . $category['name'] . '</label></li>';
            }
        }
    }
} //function ends

if (!function_exists("slugify")) {

    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
} //function ends


if (!function_exists("get_status")) {

    function get_status($post_status)
    {
        switch ($post_status) {

            case "future":
                echo '<span class="badge badge-primary">Schedule</span>';
                break;
            case "publish":
                echo '<span class="badge badge-success">Published</span>';
                break;
            case "pending":
                echo '<span class="badge badge-info">Pending</span>';
                break;
            case "trash":
                echo '<span class="badge badge-danger">Trashed</span>';
                break;
            case "draft":
                echo '<span class="badge badge-secondary">Draft</span>';
                break;
            default:
                echo '<span class="badge badge-success">Published</span>';
        }
    }
} //function ends


if (!function_exists("coupon_product_name")) {

    /**
     * get_product_name
     *
     * @param  mixed $product_id
     * @return void
     */
    function coupon_product_name($product_id = '123')
    {
        $product = '';
        switch ($product_id) {
            case 19:
                $product = "Example";
                break;
            case 47:
                $product = "Example.com";
                break;
            case 55:
                $product = "Example";
                break;
            case 56:
                $product = "Example.RealEstate";
                break;
            case 58:
                $product = "Example Marketing";
                break;
            case 'All':
                $product = "ALL";
                break;
            default:
                $product = "ALL";
        }
        return $product;
    }
} //function ends



if (!function_exists("encryptor")) {

    /**
     * encryptor
     *
     * @param  mixed $string
     * @return void
     */
    function encryptor($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'Example';
        $secret_iv = 'Example';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        //do the encyption given text/string/number
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
} //function end


if (!function_exists("decryptor")) {

    /**
     * decryptor
     *
     * @param  mixed $string
     * @return void
     */
    function decryptor($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'Example';
        $secret_iv = 'Example';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
} //function end

if (!function_exists('aws_upload_image')) {

    function aws_upload_image($image)
    {
        $key = round(microtime(true)) . $image['name'];
        return service('amazon')->amazon_s3_upload($key, $image['tmp_name']);
    }
} //function ends


if (!function_exists('send_email')) {
    /**
     * send_email
     *
     * @param  mixed $template
     * @param  mixed $recipient
     * @param  mixed $subject
     * @param  mixed $data
     * @return void
     */
    function send_email($template, $recipient, $subject, $data)
    {
        $email = \Config\Services::email();
        $email->setTo($recipient);
        $email->setSubject($subject);

        $message = view($template, $data);
        $email->setMessage($message);
        $email->setMailType('html');

        $email->send();
    }
} //function end

if (!function_exists('check_user_role')) {

    /**
     * check_user_role
     *
     * @param  mixed $roll
     * @return void
     */
    function check_user_role($roll)
    {
        $userSession = session()->get('user_session');
        $userRole = is_object($userSession)
            ? ($userSession->user_role ?? null)
            : ($userSession['user_role'] ?? null);

        if ($userRole === null) {
            $icnRole = is_object($userSession)
                ? ($userSession->icn_role ?? null)
                : ($userSession['icn_role'] ?? null);

            $roleMap = [
                'Administrator' => 10,
                'Editor' => 8,
                'Operations-Staff' => 8,
                'SocialMedia-Staff' => 7,
                'SEO-Staff' => 6,
                'Sales' => 6,
                'Stake Holders' => 6,
            ];
            $userRole = $roleMap[$icnRole] ?? 0;
        }

        if ($userRole < $roll) {
            echo 'You have no permission to access';
            die();
        }
    }
} //function end


if (!function_exists('wp_hash_password')) {

    /**
     * wp_hash_password
     *
     * @param  mixed $password
     * @return void
     */
    function wp_hash_password($password)
    {
        $wp_hasher = new \App\Libraries\PasswordHash(8, true);
        return $wp_hasher->HashPassword($password);
    }
} //function end
