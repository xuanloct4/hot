<?php

namespace Src\Controller;

abstract class Controller
{
    public $urlPattern;
    protected $uriComponents;
    protected $requestHeaders;
    protected $requestMethod;
    protected $requestParams;
    protected $requestBody;

    public function __construct()
    {
        // $this->init();
    }

    //         public function __construct($uriComponents, $requestHeaders, $requestMethod, $requestParams ,$requestBody)
    //         {
    // $this->uriComponents = $uriComponents;
    // $this->requestHeaders =$requestHeaders;
    //             $this->requestMethod = $requestMethod;
    // $this->requestParams = $requestParams;
    //             $this->requestBody = $requestBody;
    // $this->init();
    //         }

    public function setURLPattern($urlPattern)
    {
        $this->urlPattern = $urlPattern;
    }

    public function setURIComponents($uriComponents)
    {
        $this->uriComponents = $uriComponents;
    }

    public function setRequestHeaders($requestHeaders)
    {
        $this->requestHeaders = $requestHeaders;
    }

    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function setRequestParams($requestParams)
    {
        $this->requestParams = $requestParams;
    }

    public function setRequestBody($requestBody)
    {
        $this->requestBody = $requestBody;
    }
    
    public function isMatchURLPattern()
    {
        // return true;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->processGETRequest();
                break;
            case 'POST':
                $response = $this->processPOSTRequest();
                break;
            case 'PUT':
                $response = $this->processPUTRequest();
                break;
            case 'DELETE':
                $response = $this->processDELETERequest();
                break;
            default:
                $response = $this::notFoundResponse();
                break;
        }
        Controller::respond($response);
    }

    public static function respond($response)
    {
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public static function respondUnprocessableEntity()
    {
        Controller::respond(Controller::unprocessableEntityResponse());
    }

    public static function respondNotFoundResponse()
    {
        Controller::respond(Controller::notFoundResponse());
    }

    public static function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    public static function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    abstract public function init();

    abstract protected function processGETRequest();

    abstract protected function processPOSTRequest();

    abstract protected function processPUTRequest();

    abstract protected function processDELETERequest();
}