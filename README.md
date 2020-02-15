# topphp-testing

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

> 单元测试组件,除了具备phpunit的功能外,又集成了guzzlehttp,可以进行http请求的
> 支持 get,post,delete,put,patch 等等操作

## Structure
> 组件结构

```
bin/        
build/
docs/
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require topphp/topphp-testing
```

## Usage

``` php
<?php

declare(strict_types=1);

namespace Topphp\Test;

use Topphp\TopphpTesting\HttpTestCase;

class ExampleTest extends HttpTestCase
{
    public function testHttpRequest()
    {
        echo $res = $this->create([
            'base_uri' => '127.0.0.1:9501'
        ])->get('/', [

        ])->getBody();
        $this->assertEquals($res, '{"a":"abcdef"}');
    }
}

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sleep@kaituocn.com instead of using the issue tracker.

## Credits

- [topphp][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/topphp/topphp-testing.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/topphp/topphp-testing/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/topphp/topphp-testing.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/topphp/topphp-testing.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/topphp/topphp-testing.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/topphp/topphp-testing
[link-travis]: https://travis-ci.org/topphp/topphp-testing
[link-scrutinizer]: https://scrutinizer-ci.com/g/topphp/topphp-testing/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/topphp/topphp-testing
[link-downloads]: https://packagist.org/packages/topphp/topphp-testing
[link-author]: https://github.com/topphp
[link-contributors]: ../../contributors
