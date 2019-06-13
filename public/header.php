<?php date_default_timezone_set('Europe/London');

// check to see if the session has been set and if not start it
if(!isset($_SESSION))
{
    session_start();
}
//if session login is set and if session with login is set save the username to a 
//php variable called $Username
if(isset($_SESSION['login']))
{
    if(isset($_SESSION['Username'])){
        $Username = $_SESSION['Username'];
    }
}


?> 
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Room booking application</title>
        <link href="public/soft165.css" rel="stylesheet"  type="text/css">
</head>
<body class="bg-primary">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="row" >
    <li><h2>Room booking application<span class='sr-only'>(current)</span></h2></li>
            
	</div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
        <script>

        </script>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="nav navbar-nav navbar-center">
           <!-- remove this comment for the title to be centered <li><h2>Room booking application<span class='sr-only'>(current)</span></h2></li> -->
	</ul>		
	</div>
        <div>
            <ul class="nav navbar-nav navbar-right">
            <li class="nav-item active">
                 <!-- adding in the login box on the right hand sideof nav bar -->
				 <?php
				 //checks if username is set and if so output the following
                    if(isset($Username))
                    {
                        echo 'welcome '.$Username;
                        echo '<br><br>';
                        echo "<a href='public/logout.php' class ='btn btn-danger'>logout</a>";
                        
                        
					}
					// else ask for login and show the login form
                    else{
                        echo 'Hello please login';
                        require_once 'public/login.php';
                        echo "<a href='public/passReset.php''>Forgotten password</a>";
					}
				?>
                
            </li>
        </ul>
        </div>
    </nav>
