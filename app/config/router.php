<?php
$router = $di->getRouter();

// Define your routes here
$router->addGet('/patients', 'Patients::index');
$router->addGet('/patients/{id:[0-9]+}', 'Patients::get');
$router->addPost('/patients', 'Patients::create');
$router->addPut('/patients/{id:[0-9]+}', 'Patients::update');
$router->addDelete('/patients/{id:[0-9]+}', 'Patients::delete');

$router->handle($_SERVER['REQUEST_URI']);
