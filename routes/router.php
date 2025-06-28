<?php

// Home page
$router->get('/', 'HomeController@index');

// Authentication routes
$router->get('/login', 'UserAuthController@showLogin');
$router->post('/login', 'UserAuthController@login');
$router->get('/register', 'UserAuthController@showRegister');
$router->post('/register', 'UserAuthController@register');
$router->post('/logout', 'UserAuthController@logout');

// Books
$router->get('/books', 'BookController@index');
$router->get('/books/add', 'BookController@addView');
$router->post('/books', 'BookController@add');
$router->get('/books/edit/{id}', 'BookController@editView');
$router->post('/books/{id}', 'BookController@edit');
$router->get('/books/delete/{id}', 'BookController@delete');

// Authors
$router->get('/authors', 'AuthorController@index');
$router->get('/authors/add', 'AuthorController@addView');
$router->post('/authors', 'AuthorController@add');
$router->get('/authors/edit/{id}', 'AuthorController@editView');
$router->post('/authors/{id}', 'AuthorController@edit');
$router->get('/authors/delete/{id}', 'AuthorController@delete');

// Categories
$router->get('/categories', 'CategoryController@index');
$router->get('/categories/add', 'CategoryController@addView');
$router->post('/categories', 'CategoryController@add');
$router->get('/categories/edit/{id}', 'CategoryController@editView');
$router->post('/categories/{id}', 'CategoryController@edit');
$router->get('/categories/delete/{id}', 'CategoryController@delete');

// Readers
$router->get('/readers', 'ReaderController@index');
$router->get('/readers/add', 'ReaderController@addView');
$router->post('/readers', 'ReaderController@add');
$router->get('/readers/edit/{id}', 'ReaderController@editView');
$router->post('/readers/{id}', 'ReaderController@edit');
$router->get('/readers/delete/{id}', 'ReaderController@delete');

// Borrow Slips
$router->get('/borrowslips', 'BorrowSlipController@index');
$router->get('/borrowslips/add', 'BorrowSlipController@addView');
$router->post('/borrowslips', 'BorrowSlipController@add');
$router->get('/borrowslips/edit/{id}', 'BorrowSlipController@editView');
$router->post('/borrowslips/{id}', 'BorrowSlipController@edit');
$router->get('/borrowslips/delete/{id}', 'BorrowSlipController@delete');

// Return Slips
$router->get('/returnslips', 'ReturnSlipController@index');
$router->get('/returnslips/add', 'ReturnSlipController@addView');
$router->post('/returnslips', 'ReturnSlipController@add');
$router->get('/returnslips/edit/{id}', 'ReturnSlipController@editView');
$router->post('/returnslips/{id}', 'ReturnSlipController@edit');
$router->get('/returnslips/delete/{id}', 'ReturnSlipController@delete');

// Statistics
$router->get('/dashboard', 'DashboardController@index');
$router->get('/dashboard/export', 'DashboardController@exportExcel');
