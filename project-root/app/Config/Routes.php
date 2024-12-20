<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes existing
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/signup', 'AuthController::signup');
$routes->post('/signup', 'AuthController::processSignup');
$routes->get('/logout', 'AuthController::logout');
$routes->post('auth/login', 'AuthController::login'); // Route untuk memproses login

$routes->get('/hero', 'AuthController::hero'); // Tanpa parameter
$routes->get('/hero/(:num)', 'AuthController::hero/$1'); // Dengan parameter

$routes->get('/furniture', 'FurnitureController::index');
$routes->get('/furniture/(:num)', 'FurnitureController::index/$1');

$routes->get('/cart', 'CartController::index');
$routes->get('/cart/(:num)', 'CartController::index/$1');
$routes->post('/cart/updateQuantity/(:num)', 'CartController::updateQuantity/$1'); //tombol tambah kurang cart


$routes->get('checkout/', 'CheckoutController::index'); 
$routes->get('checkout/(:num)', 'CheckoutController::index/$1'); // Jika checkout perlu user_id

$routes->get('cart/remove/(:num)', 'CartController::remove/$1');
$routes->post('cart/add', 'CartController::add');

$routes->post('place-order', 'OrderController::placeOrder');

$routes->get('orders', 'OrderController::index');
$routes->get('orders/(:num)', 'OrderController::index/$1');
$routes->get('orders/details/(:num)', 'OrderController::getOrderDetails/$1');//detail orders
$routes->get('orders/cancel/(:num)', 'OrderController::cancel/$1'); //cancel pesanan pas masi pending
$routes->get('orders/removeOrderHistory/(:num)', 'OrderController::removeOrderHistory/$1');//rute hapus riwayat order

$routes->get('/forgotpassword', 'AuthController::forgotPassword');
$routes->post('/forgotpassword', 'AuthController::processForgotPassword');
$routes->get('/reset_password', 'AuthController::resetPassword/$1');
$routes->post('/reset_password', 'AuthController::processResetPassword');

// Admin Routes
// Admin authentication routes

$routes->get('/adminIFA', 'AuthController::AdminLogin');
$routes->post('/admin/login', 'AuthController::processAdminLogin');
$routes->get('/admin/signup', 'AuthController::adminSignup');
$routes->post('/admin/signup', 'AuthController::processAdminSignup');
$routes->get('logout', 'AuthController::adminLogout');

// Admin site routes 

$routes->get('/admin/dashboard', 'AdminController::index'); // Dashboard Admin
$routes->get('admin/users', 'AdminController::manageUsers'); // Manage Users
$routes->get('admin/deleteUser/(:num)', 'AdminController::deleteUser/$1');
$routes->get('admin/orders', 'AdminController::manageOrders'); // Manage Orders
$routes->post('/admin/updateShipmentStatus/(:num)', 'AdminController::updateShipmentStatus/$1');
$routes->get('admin/order/delete/(:num)', 'AdminController::deleteOrder/$1'); // Untuk menghapus order
$routes->get('admin/furniture', 'AdminController::manageFurniture'); // Manage Furniture
$routes->post('admin/addFurniture', 'AdminController::addFurniture'); // Add Furniture
$routes->post('admin/updateStock/(:num)', 'AdminController::updateStock/$1'); // Update Stock
$routes->get('admin/furniture/delete/(:num)', 'AdminController::deleteFurniture/$1'); // Untuk menghapus furniture
$routes->get('/admin/dashboard', 'AdminController::index'); // Dashboard Admin
$routes->get('/admin/logout', 'AuthController::adminLogout'); //logout Admin

// Rute untuk Edit dan Update Furniture
$routes->get('/admin/furniture/edit/(:num)', 'AdminController::editFurniture/$1');
$routes->post('/admin/updateFurniture/(:num)', 'AdminController::updateFurniture/$1');










