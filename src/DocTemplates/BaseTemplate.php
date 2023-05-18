<?php

namespace Yyk\Eqbao\DocTemplates;

class BaseTemplate
{
    protected $appid;
    protected $secret;
    protected $host;

    public function __construct(string $host, string $appid, string $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
    }

}