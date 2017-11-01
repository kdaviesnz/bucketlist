<?php
declare(strict_types=1); // must be first line

namespace kdaviesnz\bucketlist;

use Aws\S3\S3Client;
use PHPUnit\Runner\Exception;

/**
 * Class Bucketlist
 * @package kdaviesnz\bucketlist
 */
class Bucketlist implements IBucketlist
{

    /**
     * @var S3Client object
     */
    private $s3;

    /**
     * Bucketlist constructor.
     * @param string $region
     * @param string $key
     * @param string $secret
     */
    public function __construct(string $region, string $key, string $secret)
    {
        try {
            $this->s3 = new S3Client([
                'version' => 'latest',
                'region' => $region,
                'credentials' => [
                    'key' => $key,
                    'secret' => $secret,
                ],
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Fetch buckets and bucket items from Amazon S3.
     * @param string $bucket if empty returns all buckets otherwise returns list of bucket items.
     * @param callable|null $filter filter function.
     * @return string
     */
    public function fetch(string $bucket, callable $filter = null):string
    {
        // http://docs.aws.amazon.com/aws-sdk-php/v2/guide/service-s3.html
        // http://docs.aws.amazon.com/AmazonS3/latest/dev/ListingObjectKeysUsingPHP.html
        if (empty($bucket)) {
            $result = $this->s3->listBuckets();
            $buckets = array();
            foreach ($result['Buckets'] as $bucket) {
                $buckets[] = $bucket;
            }
            if (!empty($filter)) {
                $buckets = $filter($buckets);
            }
            return json_encode($buckets);
        } else {
            $objectGenerator = $this->s3->getIterator('ListObjects', array('Bucket' => $bucket));
            $objects = array();
            foreach ($objectGenerator as $object) {
                $objects[] = $object;
            }
            if (!empty($filter)) {
                $objects = $filter($objects);
            }
            return json_encode(array($bucket=>$objects));
        }
    }
}
