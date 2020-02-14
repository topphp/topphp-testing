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
