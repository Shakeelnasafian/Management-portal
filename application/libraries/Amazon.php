<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require  FCPATH.'/vendor/autoload.php';


class Amazon{
    public function __construct(){
    }

    public function amazon_s3_upload()
    {
        $s3 = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'us-west-2',
            'scheme'    => 'http',
            'credentials' => [
                'key'    => "AKIAJ3PIT5AXJPCL667A",
                'secret' => "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",
            ]
        ]);

    }//function end
}