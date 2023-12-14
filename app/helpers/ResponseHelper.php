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
      $response->setHeader('Access-Control-Allow-Origin', '*');
      $response->setHeader("Content-Type", "application/json");
      $response->setHeader("Accept", "application/json");
      $response->setStatusCode($code);
      $response->setJsonContent($data);
      return $response;
    }
}