<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-testing
 * Date: 2020/2/10 20:00
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace Topphp\TopphpTesting;

use Topphp\TopphpClient\Client;
use Topphp\TopphpClient\guzzle\GuzzleClient;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $app;
    protected static $config;
    /** @var GuzzleClient */
    protected static $httpClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        if (class_exists(\think\App::class)) {
            $this->app            = new \think\App();
            $http                 = $this->app->http;
            $response             = $http->run();
            self::$config['Http'] = $this->app->config->get("topphpClientHttp");
        }
        if (empty(self::$config['Http'])) {
            $configDir            = dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR;
            self::$config['Http'] = include $configDir . "topphpClientHttp.php";
        }
        parent::__construct($name, $data, $dataName);
        if (extension_loaded('swoole')) {
            \Swoole\Runtime::enableCoroutine(self::$config['Http']['Http']['is_coroutine']);
        }
        self::$httpClient = Client::getInstance(self::$config['Http'])->cli("http");
    }
}
