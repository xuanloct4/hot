<?php

namespace Src\Router;


class InstantRouter extends Interceptor
{
    public $accessType;
    public function handleRequest($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody, $accessType) {

        $this->uriComponents = $uriComponents;
        $this->requestHeaders = $requestHeaders;
        $this->requestMethod = $requestMethod;
        $this->requestParams = $requestParams;
        $this->requestBody = $requestBody;
        $this->accessType = $accessType;


}
}
