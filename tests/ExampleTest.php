<?php

declare(strict_types=1);

namespace Topphp\Test;

use Topphp\TopphpTesting\HttpTestCase;

class ExampleTest extends HttpTestCase
{

    /**
     * 测试 GET 请求
     * @return array|bool
     * @author bai
     */
    public function testHttpGetRequest()
    {
        $errorMsg   = null;
        $requestUrl = "http://www.baidu.com";
        $headers    = [];
        $res        = self::$httpClient->get($requestUrl, $headers);
        if ($res === false) {
            // 错误信息通过这种方式获取
            $errorMsg = self::$httpClient->getErrorMsg();
        }
        $this->assertTrue($errorMsg === null);
        return $res;
    }

    /**
     * 测试 POST 请求
     * @return array|bool
     * @author bai
     */
    public function testHttpPostRequest()
    {
        $errorMsg   = null;
        $requestUrl = "http://www.baidu.com";
        $param      = [
            "id" => 1
        ];
        $headers    = [];
        $res        = self::$httpClient->post($requestUrl, $param, 'json', $headers);
        if ($res === false) {
            // 错误信息通过这种方式获取
            $errorMsg = self::$httpClient->getErrorMsg();
        }
        $this->assertTrue($errorMsg === null);
        return $res;
    }

    /**
     * 测试 PUT 请求
     * @return array|bool
     * @author bai
     */
    public function testHttpPutRequest()
    {
        $errorMsg   = null;
        $requestUrl = "http://www.baidu.com";
        $param      = [
            "id" => 1
        ];
        $res        = self::$httpClient->put($requestUrl, $param);
        if ($res === false) {
            // 错误信息通过这种方式获取
            $errorMsg = self::$httpClient->getErrorMsg();
        }
        $this->assertTrue($errorMsg === null);
        return $res;
    }

    /**
     * 测试 PATCH 请求
     * @return array|bool
     * @author bai
     */
    public function testHttpPatchRequest()
    {
        $errorMsg   = null;
        $requestUrl = "http://www.baidu.com";
        $param      = [
            "id" => 1
        ];
        $res        = self::$httpClient->patch($requestUrl, $param);
        if ($res === false) {
            // 错误信息通过这种方式获取
            $errorMsg = self::$httpClient->getErrorMsg();
        }
        $this->assertTrue($errorMsg === null);
        return $res;
    }

    /**
     * 测试 DELETE 请求
     * @return array|bool
     * @author bai
     */
    public function testHttpDeleteRequest()
    {
        $errorMsg   = null;
        $requestUrl = "http://www.baidu.com";
        $param      = [
            "id" => 1
        ];
        $res        = self::$httpClient->get($requestUrl, $param);
        if ($res === false) {
            // 错误信息通过这种方式获取
            $errorMsg = self::$httpClient->getErrorMsg();
        }
        $this->assertTrue($errorMsg === null);
        return $res;
    }
}
