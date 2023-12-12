<?php
declare(strict_types=1);
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Helper\ResponseHelper;

class PatientsController extends Controller
{
    public function indexAction()
    {
        $response = new Response();
        $patients = Patients::find();
        $helper = $this->getDI()->get('helper');
        return $helper->generateResponse(201, "success", "Get all patients", $patients);
    }

    public function getAction($id)
    {
        $patient = Patients::findFirstById($id);
        $helper = $this->getDI()->get('helper');
        if(!$patient) {
            return $helper->generateResponse(404, "error", "Patient not found", null);
        }
        return $helper->generateResponse(200, "success", "Get patient success", $patient);
    }

    public function createAction()
    {
        $patient = new Patients();
        $data = $this->request->getJsonRawBody(true);
        $patient->name     = $data['name'];
        $patient->sex      = $data['sex'];
        $patient->religion = $data['religion'];
        $patient->phone    = $data['phone'];
        $patient->address   = $data['address'];
        $patient->nik      = $data['nik'];

        $helper = $this->getDI()->get('helper');
        if($patient->validation() === false) {
            $this->response->setStatusCode(400);
            $messages = array();
            foreach ($patient->getMessages() as $message) {
                array_push($messages, $message);
                // array_push($messages, $message->getMessage());
            }
            return  $helper->generateResponse(400, "error", "Validation error", $messages);
        }

        if($patient->save() === false) {
            return $helper->generateResponse(500, "error", "something went wrong", null);
        }
        return $helper->generateResponse(201, "success", "Patient created successfully", $patient);
    }

    public function updateAction($id)
    {
        // $patient = new Patients();
        $patient = Patients::findFirstById($id);
        $helper = $this->getDI()->get('helper');
        if(!$patient) {
            return $helper->generateResponse(404, "error", "Patient not found", null);
        }

        $data = $this->request->getJsonRawBody(true);
        $patient->name     = $data['name'];
        $patient->sex      = $data['sex'];
        $patient->religion = $data['religion'];
        $patient->phone    = $data['phone'];
        $patient->address  = $data['address'];
        $patient->nik      = $data['nik'];

        if($patient->validation() === false) {
            $this->response->setStatusCode(400);
            $messages = array();
            foreach ($patient->getMessages() as $message) {
                array_push($messages, $message);
                // array_push($messages, $message->getMessage());
            }
            return $helper->generateResponse(400, "error", "Validation error", $messages);
        }

        if($patient->save() === false) {
            return $helper->generateResponse(500, "error", "something went wrong", null);
        }
        return $helper->generateResponse(200, "success", "Patient updated successfully", $patient);
    }

    public function deleteAction($id)
    {
        $helper = $this->getDI()->get('helper');
        $patient = Patients::findFirstById($id);
        if(!$patient) {
            return $helper->generateResponse(404, "error", "No data or already deleted", null);
        }
        if($patient->delete() === false) {
            return $helper->generateResponse(500, "error", "Something went wrong", null);
        }
        return $helper->generateResponse(200, "success", "Patient deleted successfully", null);
    }

}

