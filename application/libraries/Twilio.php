<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require  FCPATH.'/vendor/autoload.php';
use Twilio\Rest\Client;
class Twilio{
    public function __construct(){
    }

    public function send_message($phone_number,$text) {
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'Example';
        $token = 'Example';
        $twilio_from_number = "+1231312312";
        $client = new Client($sid, $token);
        try{
            $result = $client->messages->create(
                $phone_number,
                array(
                    "from" => $twilio_from_number,
                    'body' => $text
                )
            );
            $response = array(
                "error" => false,
                "result" => $result
            );
        }catch(Exception $e){
            $errorFound = $e->getMessage();
            $response = array(
                "error" => true,
                "message" => $errorFound
            ); 
        }
        return $response;
    }

    

    

    

    

    
    
}
?>