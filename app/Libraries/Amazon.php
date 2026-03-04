<?php

namespace App\Libraries;

use Aws\S3\S3Client;

class Amazon
{
    protected S3Client $s3;
    protected string $bucket;

    public function __construct()
    {
        $this->bucket = env('AWS_BUCKET', 'icnimage');
        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => env('AWS_REGION', 'us-west-2'),
            'credentials' => [
                'key'    => env('AWS_KEY'),
                'secret' => env('AWS_SECRET'),
            ],
        ]);
    }

    public function amazon_s3_upload(string $key, string $source): string
    {
        $result = $this->s3->putObject([
            'Bucket'     => $this->bucket,
            'Key'        => $key,
            'SourceFile' => $source,
            'ACL'        => 'public-read',
        ]);

        return (string) $result->get('ObjectURL');
    }
}
