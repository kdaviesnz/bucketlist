# bucketlist

## Install

Via Composer

``` bash
$ composer require kdaviesnz/bucketlist
```

## Usage

``` php
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

```

## Change log

Please see CHANGELOG.md for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see CONTRIBUTING.md and CODE_OF_CONDUCT.md for details.

## Security

If you discover any security related issues, please email kdaviesnz@gmail.com instead of using the issue tracker.

## Credits

- kdaviesnz@gmail.com

## License

The MIT License (MIT). Please see LICENSE.md for more information.

# bucketlist
