<?php

// Home page
$router->get('/', 'HomeController@index');

$router->get('/dashboard', 'DashboardController@index');
$router->get('/export', 'DashboardController@exportExcel');

// Authentication routes
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');
$router->get('/logout', 'AuthController@logout');

// Books
$router->get('/books', 'BooksController@index');
$router->post('/books', 'BooksController@insert');
$router->post('/books/{id}', 'BooksController@update');
$router->get('/books/delete/{id}', 'BooksController@delete');
$router->get('/books/find-by-id', 'BooksController@findById');
$router->get('/books/check-available', 'BooksController@checkAvailable');
$router->get('/books/export-excel', 'BooksController@exportExcelBooks');

// Authors
$router->get('/authors', 'AuthorsController@index');
$router->post('/authors', 'AuthorsController@insert');
$router->post('/authors/{id}', 'AuthorsController@update');
$router->get('/authors/delete/{id}', 'AuthorsController@delete');
$router->get('/authors/export-excel', 'AuthorsController@exportExcel');

// Categories
$router->get('/categories', 'CategoriesController@index');
$router->post('/categories', 'CategoriesController@insert');
$router->post('/categories/{id}', 'CategoriesController@update');
$router->get('/categories/delete/{id}', 'CategoriesController@delete');
$router->get('/categories/export-excel', 'CategoriesController@exportExcel');

// Readers
$router->get('/readers', 'ReadersController@index');
$router->post('/readers', 'ReadersController@insert');
$router->post('/readers/{id}', 'ReadersController@update');
$router->get('/readers/delete/{id}', 'ReadersController@delete');
$router->get('/readers/find-by-phone', 'ReadersController@findByPhone');
$router->get('/readers/export-excel', 'ReadersController@exportExcel');

// Borrow Slips
$router->get('/borrowslips', 'BorrowSlipsController@index');
$router->post('/borrowslips', 'BorrowSlipsController@insert');
$router->post('/borrowslips/{id}', 'BorrowSlipsController@update');
$router->get('/borrowslips/delete/{id}', 'BorrowSlipsController@delete');
$router->get('/borrowslips/submit/{id}', 'BorrowSlipsController@submit');
$router->get('/borrowslips/details/{id}', 'BorrowSlipsController@details');
$router->post('/borrowslips/submit-book/{id}', 'BorrowSlipsController@submitBook');
$router->post('/borrowslips/submit-all/{id}', 'BorrowSlipsController@submitAllBooks');
$router->get('/borrow_slips/export-excel', 'BorrowSlipsController@exportExcelBorrowslip');


// Admin Logs
$router->get('/adminlogs', 'AdminLogsController@index');
$router->get('/adminlogs/show/{id}', 'AdminLogsController@show');
$router->get('/adminlogs/filter', 'AdminLogsController@filter');
$router->get('/adminlogs/statistics', 'AdminLogsController@statistics');
$router->get('/adminlogs/export', 'AdminLogsController@export');

