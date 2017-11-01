<?php

namespace kdaviesnz\bucketlist;

interface IBucketlist
{
    public function fetch(string $bucket, callable $filter = null):string;
}