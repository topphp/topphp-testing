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

class HttpTestCase extends TestCase
{
    protected $client;

    /**
     * @param array $config
     * @return Client
     * @author sleep
     */
    protected function create(array $config = []): Client
    {
        return $this->client = new Client($config);
    }

}
