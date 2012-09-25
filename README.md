# php-router
****

Simple RESTful php router inpired by Slim framework

# Files
* .htaccess - Redirect everything to the app
* input.php - The HTTP headers and start the app
* API/api.php - The API with all the routes
* API/router.php - Router class
* API/route.php - Route class

To add features to the app, you only have to edit the `api` file.

# Add a route
	router = new router();
	router->addRoute(@method, @pattern, [@optional_functions], @function);
	router->run();
	
## Method
The method is a string.
It should be GET, POST, PUT, DELETE

## Pattern
You can do simple things like getting a page :

	$router->addRoute('GET', '/', function() {
    	header('Location: index.html');
	});

You can use arguments : 

	$router->addRoute('GET', '/info/:day/:month/:year', function($day,$month,$year) {
    	echo "Infos for $day/$month/$year";
   	});
   	
## Optional functions
You can add optional function, to check authentication for exemple.

	function hello() { echo "Hello "; } 
    function world() { echo "world "; } 
    $router->addRoute('GET', '/helloworld' , hello(), world(), function() {
    	echo "!";
    }); 

# Main function
You can do basic stuff as showned before. You can also use objects:

	$router->addRoute('GET', '/datas', function() use ($db, $message, $session) {
    	$entries = $db->lastestEntries($session->getUserid());
    	$message->setData($entries);
    	$message->send();
	});
