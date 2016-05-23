<?php
/**
 * Routing Filters - all standard Routing Filters are defined here.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

use Routing\Route;
use Helpers\Csrf;

use Support\Facades\Auth;
use Support\Facades\Redirect;
use Support\Facades\Response;


/** Define Route Filters. */

// A Testing Filter which dump the matched Route.
Route::filter('test', function($route) {
    echo '<pre>' .var_export($route, true) .'</pre>';
});

// A simple CSRF Filter.
Route::filter('csrf', function($route) {
    if (($route->method() == 'POST') && ! Csrf::isTokenValid()) {
        // When CSRF Token is invalid, respond with Error 400 Page (Bad Request)
        return Response::error(400);
    }
});

// Authentication Filters.
Route::filter('auth', function($route) {
    if (! Auth::check()) {
         // User is not logged in, respond with a Redirect code 401 (Unauthorized)
         return Redirect::to('login');
    }
});

Route::filter('guest', function($route) {
    if (! Auth::guest()) {
        // User is authenticated, respond with a Redirect code 401 (Unauthorized)
        return Redirect::to('dashboard');
    }
});
