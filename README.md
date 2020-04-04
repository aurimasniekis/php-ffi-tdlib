# FfiTdLib

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

[![Email][ico-email]][link-email]

A PHP FFI integration with TdLib via JSON interface

## Install

Via Composer

```bash
$ composer require aurimasniekis/ffi-tdlib
```

## Reference

```php
<?php

namespace AurimasNiekis\FFI;

class TdLib
{
    /**
     * @param string|null $libFile An optional file path/name to `libtdjson.so` library
     */
    public function __construct(string $libFile = null)
    {
    }

    /**
     * Synchronously executes TDLib request.
     * Only a few requests can be executed synchronously.
     *
     * @param array|\JsonSerializable $request
     *
     * @return array
     */
    public static function execute($request): array
    {
    }

    /**
     * Receives incoming updates and request responses from the TDLib client.
     *
     * @param float $timeout The maximum number of seconds allowed for this function to wait for new data.
     *
     * @return array
     */
    public function receive(float $timeout): array
    {
    }

    /**
     * Sends request to the TDLib client.
     *
     * @param array|\JsonSerializable $request
     */
    public function send($request): void
    {
    }
}
```

## Testing

Run test cases

Run PHP style checker

```bash
$ composer cs-check
```

Run PHP style fixer

```bash
$ composer cs-fix
```

Run all continuous integration tests

```bash
$ composer ci-run
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/thruster/ffi-td-lib.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/com/ThrusterIO/ffi-td-lib/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ThrusterIO/ffi-td-lib.svg?style=flat-square
[ico-email]: https://img.shields.io/badge/email-aurimas@niekis.lt-blue.svg?style=flat-square

[link-travis]: https://travis-ci.com/ThrusterIO/ffi-td-lib
[link-packagist]: https://packagist.org/packages/thruster/ffi-td-lib
[link-downloads]: https://packagist.org/packages/thruster/ffi-td-lib/stats
[link-email]: mailto:aurimas@niekis.lt
