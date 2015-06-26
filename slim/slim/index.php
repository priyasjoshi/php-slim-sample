<?php
echo'	
<html>
<head>
<title>
My first sample CRUD with slim 
</title>
</head>
<body>
<center><h3><u>Welcome to my Guest-book</h3></center></u>
<form method="post" action="/hello">
<fieldset>
<legend>Add to the guestbook</legend>
<table>
<tr>
<td>
Enter Email
</td>
<td>
<input type = "text" name="email" value="">
</td>
</tr>
<tr>
<td>
Enter Your Comment 
</td>
<td>
<textarea rows = "4" columns="50" name="comment"></textarea>
</td>
</tr>
<tr>
<td>
</td>
<td>
<input type = "submit" value="Insert">
</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>';
// Check connection


/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';


\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get('/hello/:id',function($id) use ($app)
{
	$server = 'localhost'; // this may be an ip address instead
	$user = 'root';
	$pass = '';
	$database = 'guestbook';
	$connection = new mysqli($server, $user, $pass, $database);
	$result = $connection->query('SELECT * FROM guestbook where id ='.$id );
	while ( $row = $result->fetch_assoc() ) {
		$data[] = $row;
	}
	echo '<table align ="center"><tr><th>ID</th><th> Email </th><th> Comment </th><th> Created </th></tr>';
	
	foreach ($data as $k=>$v)
	{
		echo '<tr><td>'.$v['id'].'</td><td>'.$v['email'].'</td><td>'.$v['comment'].'</td><td>'.$v['created'].'</td></tr>';
	}
	
	$connection->close();
	
});
$app->get('/',function() use ($app){
	$server = 'localhost'; // this may be an IP address instead
	$user = 'root';
	$pass = '';
	$database = 'guestbook';
	$connection = new mysqli($server, $user, $pass, $database);
	$result = $connection->query( 'SELECT * FROM guestbook;' );
	while ( $row = $result->fetch_assoc() ) {
		$data[] = $row;
	}
	echo '<table><tr><th> ID </th><th> Email </th><th> Comment </th><th> Created </th></tr>';
	foreach ($data as $k=>$v)
	{
		echo '<tr><td>'.$v['id'].'</td><td>'.$v['email'].'</td><td>'.$v['comment'].'</td><td>'.$v['created'].'</td></tr>';
	
	}
	$connection->close();
});
// POST route
$app->post('/hello',function () use ($app){
	$server = 'localhost'; // this may be an IP address instead
	$user = 'root';
	$pass = '';
	$database = 'guestbook';
	$connection = new mysqli($server, $user, $pass, $database);
	//var_dump($connection);
	//var_dump($_POST);
	//echo "got into it";
	$email = $_POST['email'];
	$comment = $_POST['comment'];
	//echo $email.'<br>'.$comment;
		if ($email!='' || $comment!='')
		{
			//echo "Got into insert query";
			$sql = "insert into guestbook (email,comment,created) values ('$email','$comment',Now())";
			if ($connection->query($sql) === TRUE) 
			{
			
			echo "New record created successfully";
			
			} 		
			else 
			{
			echo "Error: " . $sql . "<br>" . $connection->error;
			}
		}
		else
		{
			echo 'Error in variables';
		}
}
);

// PUT route
$app->put(
    '/hello/:id',
    function () {
	$server = 'localhost'; // this may be an IP address instead
	$user = 'root';
	$pass = '';
	$database = 'guestbook';
	$connection = new mysqli($server, $user, $pass, $database);
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
