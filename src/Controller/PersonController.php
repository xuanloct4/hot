<?php
namespace Src\Controller;
use Src\Service\PersonService;

class PersonController extends Controller
{
    private $userId;

    private $personService;

    public function init()
    {
        if (sizeof($this->uriComponents) > 5) {
            $this->userId = $this->uriComponents[5];
        }
        $this->personService = new PersonService();
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function processGETRequest()
    {
        if ($this->userId) {
            $response = $this->getUser($this->userId);
        } else {
            $response = $this->getAllUsers();
        };

        return $response;
    }

    public function processPOSTRequest()
    {
        $response = $this->createUserFromRequest();
        return $response;
    }

    public function processPUTRequest()
    {
        $response = $this->updateUserFromRequest($this->userId);
        return $response;
    }

    public function processDELETERequest()
    {
        $response = $this->deleteUser($this->userId);
        return $response;
    }

    private function getAllUsers()
    {
        $result = $this->personService->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->personService->find($id);
        if (!$result) {
            return $this::notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUserFromRequest()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
		if (!$this->validatePerson($input)) {
            return $this::unprocessableEntityResponse();
        }
        $this->personService->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateUserFromRequest($id)
    {
        $result = $this->personService->find($id);
        if (!$result) {
            return $this::notFoundResponse();
        }
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validatePerson($input)) {
            return $this::unprocessableEntityResponse();
        }
        $this->personService->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->personService->find($id);
        if (!$result) {
            return $this::notFoundResponse();
        }
        $this->personService->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validatePerson($input)
    {
        if (!isset($input['firstname'])) {
            return false;
        }
        if (!isset($input['lastname'])) {
            return false;
        }
        return true;
    }


}
