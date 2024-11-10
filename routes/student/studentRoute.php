<?php

namespace App\Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StudentRoute{
    public function register(App $app){
        
        $app->group('/students', function (App $student){

            $student->get('', function (Request $request, Response $response){
                $result = json_encode([
                    "success" => "true",
                    "data" => "student"
                ]);
                $response->getBody()->write($result);
                $response->withHeader('Content-Type', 'application/json');
                return $response;
            });
        });
    }

}