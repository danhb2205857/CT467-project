<?php

// Home page
$router->get('/', 'HomeController@index');

// Authentication routes
$router->get('/login', 'UserAuthController@showLogin');
$router->post('/login', 'UserAuthController@login');
$router->get('/register', 'UserAuthController@showRegister');
$router->post('/register', 'UserAuthController@register');
$router->post('/logout', 'UserAuthController@logout');

// Category routes (Public)
$router->get('/categories', 'CategoryController@index');
$router->get('/categories/{id}', 'CategoryController@show');

// Story routes (Public)
$router->get('/stories', 'StoryController@index');
$router->get('/stories/{id}', 'StoryController@show');
$router->get('/comic-detail/{id}', 'StoryController@show'); // Backward compatibility

// Chapter routes (Public)
$router->get('/chapters/{id}', 'ChapterController@show');
$router->get('/chapter-detail/{id}', 'ChapterController@show');

// User pages
$router->get('/contact', 'PageController@contact');
$router->get('/history', 'PageController@history');
$router->get('/favorites', 'PageController@favorites');

// ======================================== ADMIN ROUTES ========================================

// Admin Authentication
$router->get('/admin', 'AdminController@index');
$router->get('/admin/login', 'AdminController@showLogin');
$router->post('/admin/login', 'AdminController@login');
$router->get('/admin/logout', 'AdminController@logout');

// Admin Authors
$router->get('/admin/authors', 'AdminAuthorController@index');
$router->get('/admin/authors/add', 'AdminAuthorController@insertView');
$router->post('/admin/authors', 'AdminAuthorController@insert');
$router->get('/admin/authors/edit/{id}', 'AdminAuthorController@edit');
$router->post('/admin/authors/{id}', 'AdminAuthorController@update');
$router->delete('/admin/authors/{id}', 'AdminAuthorController@delete');

// Admin Categories  
$router->get('/admin/categories', 'AdminCategoryController@index');
$router->get('/admin/categories/add', 'AdminCategoryController@insertView');
$router->post('/admin/categories', 'AdminCategoryController@insert');
$router->get('/admin/categories/edit/{id}', 'AdminCategoryController@edit');
$router->post('/admin/categories/{id}', 'AdminCategoryController@update');
$router->delete('/admin/categories/{id}', 'AdminCategoryController@delete');

// Admin Stories
$router->get('/admin/stories', 'AdminStoryController@index');
$router->get('/admin/stories/add', 'AdminStoryController@insertView');
$router->post('/admin/stories', 'AdminStoryController@insert');
$router->get('/admin/stories/edit/{id}', 'AdminStoryController@edit');
$router->post('/admin/stories/{id}', 'AdminStoryController@update');
$router->delete('/admin/stories/{id}', 'AdminStoryController@delete');

// Admin Chapters
$router->get('/admin/chapters', 'ChapterController@adminIndex');
$router->get('/admin/chapters/create', 'ChapterController@create');
$router->post('/admin/chapters', 'ChapterController@store');
$router->get('/admin/chapters/{id}/edit', 'ChapterController@edit');
$router->post('/admin/chapters/{id}', 'ChapterController@update');
$router->delete('/admin/chapters/{id}', 'ChapterController@delete');
