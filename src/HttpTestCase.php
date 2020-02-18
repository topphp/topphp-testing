<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-testing
 * Date: 2020/2/10 20:00
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace Topphp\TopphpTesting;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\parse_header;

class HttpTestCase extends TestCase
{
    protected static $client;
    protected static $timeout = 300;//默认请求超时时间 300s
    protected static $testError;

    /**
     * 初始化
     *
     * @param $base_uri
     * @param $options
     * @param bool $https
     * @return Client|null
     * @author bai
     */
    private static function init($base_uri, $options, $https = false)
    {
        if (empty($base_uri)) {
            return null;
        }
        // $options 配置参数
        if (empty($options)) {
            $options = [
                'timeout' => self::$timeout,
            ];
        }
        $options['base_uri'] = $base_uri;
        $options['verify']   = $https;//默认不开启验证https 如果需要https验证，则传入证书路径 例如：/full/path/to/cert.pem

        return new Client($options);
    }

    /**
     * 自定义错误处理
     *
     * @param $errorMsg
     * @return string
     * @throws \Exception
     * @author bai
     */
    private static function Error($errorMsg)
    {
        self::$testError = 'TEST Error: ' . $errorMsg;
        throw new \Exception(self::$testError);
    }

    /**
     * 数组转XML
     *
     * @param $arr
     * @return string
     * @author bai
     */
    private static function ArrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 是否是json数据
     *
     * @param $str
     * @return bool
     * @author bai
     */
    private static function IsJsonStr($str)
    {
        return !is_null(json_decode($str));
    }

    /**
     * 返回数据与http请求状态
     *
     * @param array $data
     * @param int $httpCode
     * @return array
     * @author bai
     */
    private static function ReturnData($data = [], $httpCode = 200)
    {
        return [
            "http_code" => $httpCode,
            "data"      => $data
        ];
    }

    /**
     * POST 请求
     *
     * @param $base_uri
     * @param $api
     * @param array $post_data
     * @param string $type
     * @param array $headers
     * @param string $cookie
     * @param bool $https
     * @param array $options
     * @return array|string
     * @throws \Exception
     * @author bai
     */
    public static function post(
        $base_uri,
        $api,
        $post_data = [],
        $type = 'json',
        $headers = [],
        $cookie = '',
        $https = false,
        $options = []
    ) {
        $client = self::init($base_uri, $options, $https);
        if ($client === null) {
            return self::Error("Guzzle-Client create fail!");
        }
        $requestTime = time();
        try {
            if (empty($headers)) {
                switch ($type) {
                    case "json" :
                        $headers = [
                            "Content-Type" => "application/json;charset=utf-8"
                        ];
                        break;
                    case "body":
                        $post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);
                        $headers   = [
                            "Content-Type" => "application/json;charset=utf-8"
                        ];
                        break;
                    case "form_params":
                        $headers = [
                            "Content-Type" => "application/x-www-form-urlencoded;charset=utf-8"
                        ];
                        break;
                    case "multipart":
                        $headers = [
                            "Content-Type" => "multipart/form-data;charset=utf-8"
                        ];
                        break;
                    case "xml":
                        $post_data = self::ArrayToXml($post_data);
                        $headers   = [
                            "Content-Type" => "application/xml;charset=utf-8"
                        ];
                        array_push($headers, sprintf("Content-Length: %d", strlen($post_data)));
                        break;
                }
            }
            $data = [
                'headers' => $headers,
                $type     => $post_data,
                'cookies' => $cookie,
            ];

            $response = $client->post($api, $data);
            //$response_headers = $response->getHeaders();//获取响应头信息
            $response_code = $response->getStatusCode();//获取响应状态码 如 200
            //$response_phrase = $response->getReasonPhrase();//获取响应 原因短语（reason phrase）如 OK
            //校验返回值编码类型并编码为utf-8
            $type          = $response->getHeader('content-type');
            $parsed        = parse_header($type);
            $original_body = (string)$response->getBody()->getContents();
            $utf8_body     = mb_convert_encoding($original_body, 'UTF-8', $parsed[0]['charset'] ?? 'UTF-8');
            if (self::IsJsonStr($utf8_body)) {
                $ret = \GuzzleHttp\json_decode($utf8_body, true);
            } else {
                $ret = $utf8_body;
            }
            return self::ReturnData($ret, $response_code);
        } catch (\Exception $e) {
            if (is_array($e->getMessage())) {
                $err = json_encode($e->getMessage());
            } else {
                $err = $e->getMessage();
            }
            if (time() > $requestTime + self::$timeout) {
                return self::Error("Guzzle 请求超时");
            }
            return self::Error("Guzzle 调用异常--" . $err);
        }
    }

    /**
     * GET 请求
     *
     * @param $base_uri
     * @param $api
     * @param array $headers
     * @param bool $https
     * @param array $options
     * @return array|string
     * @throws \Exception
     * @author bai
     */
    public static function get($base_uri, $api, $headers = [], $https = false, $options = [])
    {
        $client = self::init($base_uri, $options, $https);
        if ($client === null) {
            return self::Error("Guzzle-Client create fail!");
        }
        $requestTime = time();
        try {
            $data     = [
                "headers" => $headers
            ];
            $response = $client->get($api, $data);
            //$response_headers = $response->getHeaders();//获取响应头信息
            $response_code = $response->getStatusCode();//获取响应状态码 如 200
            //$response_phrase = $response->getReasonPhrase();//获取响应 原因短语（reason phrase）如 OK
            //校验返回值编码类型并编码为utf-8
            $type          = $response->getHeader('content-type');
            $parsed        = parse_header($type);
            $original_body = (string)$response->getBody()->getContents();
            $utf8_body     = mb_convert_encoding($original_body, 'UTF-8', $parsed[0]['charset'] ?? 'UTF-8');
            if (self::IsJsonStr($utf8_body)) {
                $ret = \GuzzleHttp\json_decode($utf8_body, true);
            } else {
                $ret = $utf8_body;
            }
            return self::ReturnData($ret, $response_code);
        } catch (\Exception $e) {
            if (is_array($e->getMessage())) {
                $err = json_encode($e->getMessage());
            } else {
                $err = $e->getMessage();
            }
            if (time() > $requestTime + self::$timeout) {
                return self::Error("Guzzle 请求超时");
            }
            return self::Error("Guzzle 调用异常--" . $err);
        }
    }

}
