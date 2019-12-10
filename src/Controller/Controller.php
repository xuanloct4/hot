<?php

namespace Src\Controller;

interface iController
{
    public function init();

    public function processRequest();

    function processGETRequest();

    function processPOSTRequest();

    function processPUTRequest();

    function processDELETERequest();
}

abstract class Controller implements iController
{
    public $urlPattern;
    protected $uriComponents;
    protected $requestHeaders;
    protected $requestMethod;
    protected $requestParams;
    protected $requestBody;

    protected $interceptData;
    protected $chanelId;
    protected $scopes;
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

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @return mixed
     */
    public function getInterceptData()
    {
        return $this->interceptData;
    }

    /**
     * @param mixed $interceptData
     */
    public function setInterceptData($interceptData)
    {
        $this->interceptData = $interceptData;
    }

    /**
     * @return mixed
     */
    public function getChanelId()
    {
        return $this->chanelId;
    }

    /**
     * @param mixed $chanelId
     */
    public function setChanelId($chanelId)
    {
        $this->chanelId = $chanelId;
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
        $response['body'] = json_encode([
            'code' => '404',
            'message' => 'Not found'
        ]);
        return $response;
    }

    public static function jsonEncodedResponse($bodyObject, $statusCodeHeader=null)
    {
        if ($statusCodeHeader==null) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
        } else {
            $response['status_code_header'] = $statusCodeHeader;
        }
        $response['body'] = json_encode($bodyObject);
        return $response;
    }


}
