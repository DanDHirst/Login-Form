
<?php
//login section
//check session has been start else start session
if(!isset($_SESSION)){
    session_start();
}
//google captcha code snippet
$captcha;
if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
}
//if captacha doesnt equal anything break from the program
if(!$captcha){
    echo '<h2>Please check the the captcha form.</h2>';
    exit;
}
//send data to google recapture wiht secret key and the response from the catcha on the page
$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeWjYUUAAAAADPRPsbAtvgWaviEofVoK7tLDj9H&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
//if response fails break application and display you might be a bot
if($response['success'] == false){
    echo '<h2>You might be a bot</h2>';
    exit;
}
else{
    echo '<h2>Your are not a bot</h2>';
}


//if login session is set check the credentials using checkLogin() function with the return of either true or false

if(isset($_POST['login'])){
    $_SESSION['login'] = checkLogin($_POST['formUsername'], $_POST['formPassword']);
}
header("Location: ../index.php");
function checkLogin($username, $password)
{
    $login = false;

    //open file with read only mode
    $file = fopen("../login.txt", "r") or die("unable to open file!");;
    $trimmedUsername = trim($username);
    //santise the outputs for any html code
    $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
    
    //fgets reads file sequentially until reaches end of file or $login == true 
    while((! feof($file)) && ($login == false)) {
        //check username and password against the credentials provided
        $storedUsername = fgets($file);
        $storedPassword = fgets($file);
        $trimmedPassword = trim($password);
        $saltedPassword="p2AU7ntPWrwsWUFkv6748Vam".$trimmedPassword;
        $hashedSaltedPassword= hash( "sha512" , $saltedPassword);
        if(($filteredUser) == trim($storedUsername) && ($hashedSaltedPassword) == trim($storedPassword))
        {
            // set sesion var to username
            $login = true;
            $_SESSION["Username"] = $filteredUser;
        }
    }

    


    //close file so no corruption happens
    fclose($file);
    //return a bool
    return $login;

}
//register section of the program
if(isset($_POST['register'])){

    if((usernameInUse($_POST['formUsername']) == false)){
        $file = fopen("../login.txt", "a") or die("unable to open file!");
        $user = trim($_POST['formUsername']);
        $pass = trim($_POST['formPassword']); 
        $filteredUser = filter_var($user, FILTER_SANITIZE_STRING);
        
        //line break so the username and password aren't on the same line
        $Linebreak = "\n";
        fwrite($file,$Linebreak); // \n
        //writes username to file
        fwrite($file, $filteredUser);
        //writes password to file
        //hash and salt password using sha512 length 128 bits
        
        //salted with a 24 length number and letter salt
        $saltedPassword="p2AU7ntPWrwsWUFkv6748Vam".$pass;
        $saltedHashedPassword = hash( "sha512" , $saltedPassword);
        fwrite($file,$Linebreak);// \n
        fwrite($file, $saltedHashedPassword);
        
        fclose($file);
    }
    else{
        echo "Username is in use";
    }
}
//check if username is in use
function usernameInUse($User){
    $inUse = false;
    // santise user input to prevent XSS attack (removes any html elements)
    $filteredUser = filter_var($User, FILTER_SANITIZE_STRING);
    $file = fopen("../login.txt", "r") or die("unable to open file!");
    while((! feof($file)) && ($inUse == false)) {
        //check username against the credential provided
        $storedUsername = fgets($file);
        //read password line so it moves on to next username
        fgets($file);
        if((trim($filteredUser) == trim($storedUsername)))
        {
            // state the username is in use
            $inUse = true;
        }
    }
    fclose($file);
    return $inUse;
}


