<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('test/{feature?}', function($feature = 'db')
{
    switch ($feature) {
        case 'db':

	        // Get the mongoDB name from env (heroku config)
		    // SOURCE: https://gist.github.com/pedro/1288447
	        // @todo: Use https://github.com/jenssegers/laravel-mongodb or altenative
		    $mongoUri   = parse_url(getenv('MONGOLAB_URI'));
		    $dbName     = str_replace('/', '', $mongoUri['path']);
		    // Connect to mongoDB instance and access the access collection
		    $mongo      = new Mongo(getenv('MONGOLAB_URI'));
		    $database   = $mongo->$dbName;
		    $collection = $database->access;
		    // Insert a document into the access collection
		    $visit = array('ip' => $_SERVER['HTTP_X_FORWARDED_FOR']);
		    $collection->insert($visit);
		    // Print all the existing documents
		    $views = $collection->find();

		    dd($views);

		    // Close / Disconnect the MongoDB connection
		    $mongo->close();

            return View::make('tests.db', array('views' => $views));

            break;

        default:
            return View::make('hello');    
    }    
});
