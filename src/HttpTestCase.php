<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-testing
 * Date: 2020/2/10 20:00
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);
/**
 * Class HttpTestCase
 *
 * @package self::$httpClient
 * @method mixed get(string $url, array $headers = []) static 发送 GET 请求
 * @method mixed post(string $url, array $data, string $type = 'json', array $headers = []) static 发送 POST 请求
 * @method mixed put(string $url, array $data) static 发送 PUT 请求
 * @method mixed patch(string $url, array $data) static 发送 PATCH 请求
 * @method mixed delete(string $url, array $data) static 发送 DELETE 请求
 * @method mixed handler() static 返回http客户端Guzzle原始句柄，可调用更多高级方法
 */

namespace Topphp\TopphpTesting;

class HttpTestCase extends TestCase
{

    /**
     * 错误信息
     * @var $testError
     */
    protected static $testError;

    /**
     * 获取错误信息
     * @return mixed
     * @author bai
     */
    public static function getErrorMsg()
    {
        return self::$testError;
    }

}
