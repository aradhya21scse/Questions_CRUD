<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->add('questions', 'Questions::index');
$routes->add('questions', 'Questions::index');
$routes->add('questions/create', 'Questions::create');
$routes->add('questions/store', 'Questions::store');
$routes->add('questions/edit/(:num)', 'Questions::edit/$1');
$routes->add('questions/update/(:num)', 'Questions::update/$1');
$routes->add('questions/delete/(:num)', 'Questions::delete/$1');




//add