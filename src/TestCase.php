<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-testing
 * Date: 2020/2/10 20:00
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace Topphp\TopphpTesting;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $app;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        if (class_exists(\think\App::class)) {
            $this->app = new \think\App();
            $http      = $this->app->http;
            $response  = $http->run();
        }
        parent::__construct($name, $data, $dataName);
        if (extension_loaded('swoole')) {
            \Swoole\Runtime::enableCoroutine(true);
        }
    }
}
