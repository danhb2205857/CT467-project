<?php

// Home page
$router->get('/', 'DashboardController@index');
$router->get('/export', 'DashboardController@exportExcel');

// Authentication routes
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');
$router->get('/logout', 'AuthController@logout');

// Books
$router->get('/books', 'BooksController@index');
$router->get('/books/add', 'BooksController@addView');
$router->post('/books', 'BooksController@add');
$router->get('/books/edit/{id}', 'BooksController@editView');
$router->post('/books/{id}', 'BooksController@edit');
$router->get('/books/delete/{id}', 'BooksController@delete');

// Authors
$router->get('/authors', 'AuthorsController@index');
$router->post('/authors', 'AuthorsController@insert');
$router->post('/authors/{id}', 'AuthorsController@update');
$router->get('/authors/delete/{id}', 'AuthorsController@delete');

// Categories
$router->get('/categories', 'CategoriesController@index');
$router->get('/categories/add', 'CategoriesController@addView');
$router->post('/categories', 'CategoriesController@add');
$router->get('/categories/edit/{id}', 'CategoriesController@editView');
$router->post('/categories/{id}', 'CategoriesController@edit');
$router->get('/categories/delete/{id}', 'CategoriesController@delete');

// Readers
$router->get('/readers', 'ReadersController@index');
$router->get('/readers/add', 'ReadersController@addView');
$router->post('/readers', 'ReadersController@add');
$router->get('/readers/edit/{id}', 'ReadersController@editView');
$router->post('/readers/{id}', 'ReadersController@edit');
$router->get('/readers/delete/{id}', 'ReadersController@delete');

// Borrow Slips
$router->get('/borrowslips', 'BorrowSlipsController@index');
$router->get('/borrowslips/add', 'BorrowSlipsController@addView');
$router->post('/borrowslips', 'BorrowSlipsController@add');
$router->get('/borrowslips/edit/{id}', 'BorrowSlipsController@editView');
$router->post('/borrowslips/{id}', 'BorrowSlipsController@edit');
$router->get('/borrowslips/delete/{id}', 'BorrowSlipsController@delete');

// Return Slips
$router->get('/returnslips', 'ReturnSlipsController@index');
$router->get('/returnslips/add', 'ReturnSlipsController@addView');
$router->post('/returnslips', 'ReturnSlipsController@add');
$router->get('/returnslips/edit/{id}', 'ReturnSlipsController@editView');
$router->post('/returnslips/{id}', 'ReturnSlipsController@edit');
$router->get('/returnslips/delete/{id}', 'ReturnSlipsController@delete');

