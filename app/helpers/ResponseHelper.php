<?php
namespace Helper;
use Phalcon\Http\Response;

class ResponseHelper
{
    public static function generateResponse($code, $response, $message, $result = null)
    {
      $data = [
        "status" => [
            "code"     => $code,
            "response" => $response,
            "message"  => $message
        ],
        "result" => $result
      ];
      $response = new Response();
      $response->setStatusCode($code);
      $response->setJsonContent($data);

      return $response;
    }
}