# Stream Sampler

Get N random characters from a large unknown stream

### Requirements

- PHP 7.0+

### Installation

```sh
$ composer install
```

### How to use

```sh
$ dd if=/dev/urandom count=100 bs=1MB | base64 | php stream-sampler.php 5
```


### Testing
```sh
$ ./vendor/bin/phpunit
```
