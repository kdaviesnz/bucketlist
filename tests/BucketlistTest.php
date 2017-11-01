<?php

require_once ("vendor/autoload.php");
require_once("src/IBucketlist.php");
require_once("src/Bucketlist.php");

class BucketlistTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testFetch()
    {
        $region = '*******'; // eg 'ap-southeast-2'
        $key = '*******'; // your amazon credential key
        $secret = '********'; // your amazon credential secret.

        $bucketlist = new \kdaviesnz\bucketlist\Bucketlist($region, $key, $secret);

        // Fetch buckets
        $result = $bucketlist->fetch('');

        // Fetch buckets using a filter
        $filter = function(array $objects) {
            return array_filter(
                $objects,
                function($object) {
                    return $object['Name'][0] == "a";
                }
            );
        };
        $result = $bucketlist->fetch('', $filter);

        // Fetch objects from a bucket
        $result = $bucketlist->fetch("yourbucketname");

        // Fetch objects from a bucket using a filter
        $filter = function(array $objects) {
            return $movies = array_filter(
                $objects,
                function($object){
                    $temp = explode(".", trim($object['Key']));
                    return $temp[count($temp)-1] == "mp4";
                });
        };
        $result = $bucketlist->fetch("yourbucketname", $filter);

    }

}
