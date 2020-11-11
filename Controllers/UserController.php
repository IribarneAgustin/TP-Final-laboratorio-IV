<?php

namespace Controllers;

use DAO\UserDAO;
use Models\User;
use \Exception as Exception;
use Facebook\Facebook as Facebook;

class UserController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function login($username, $password)
    {
        try{
            if (!isset($_SESSION)) {
                session_start();    
            }
            else{
                session_unset();
            }
        }catch (Exception $ex) {
            throw $ex;
        }
        $user = $this->userDAO->getByUsername($username);
        if ($user!=null){
            if($user->getPassword() === $password) {
                $_SESSION['user'] = $user;
            }
        }
        else{
            $this->showLoginView("Username or password are incorrect");
        }
       
        $this->index();
    }

    public function showLoginView($message = "")
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function showSignupView($message = "")
    {
        require_once(VIEWS_PATH . "user-signup.php");
    }

    public function signup($username, $email, $password)
    {
        if ($this->userDAO->existsUser($username, $email) == false){

            $newUser = new User();
            $newUser->setUsername($username);
            $newUser->setEmail($email);
            $newUser->setPassword($password);
            $newUser->setRole("user");
            $this->userDAO->add($newUser);
            $this->showLoginView($message = "User registered succesfully. Log in to proceed.");
            
        } else {
            $this->showSignupView($message = "Username or email are already in use");
        }
    }

    public function logout(){

        try{
            if (!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION)) {
                session_destroy();
                session_unset();
            }
        }catch (Exception $ex) {
            throw $ex;
        }
        $this->message("Logged out", FRONT_ROOT."index.php");
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            require(VIEWS_PATH . 'userHome.php');
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function message($message,$location){
        require_once(VIEWS_PATH."message.php");
    }



    public function FBCallback(){
        $fb = new Facebook([
            'app_id' => '2070276426438697', // Replace {app-id} with your app id
            'app_secret' => '0932f4ef5e1651d943eb28cd3c82e7f7',
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        }catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        /*echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());*/

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        /*echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);*/

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('2070276426438697'); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        //Geting User Info
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);
        $response = $fb->get('/me?locale=en_US&fields=first_name,last_name,email,username');
        $userNode = $response->getGraphUser();

        /*echo '<br>';
        echo $userNode["email"]." ".$userNode["last_name"]." ".$userNode["first_name"];
        echo '<br>';*/

        $user=$this->userDAO->existsUser($userNode["username"], $userNode["email"]);
        $loggedUser=NULL;
        if($user!=NULL){
            $loggedUser= $user;
        }else{       
            $this->userDAO->AddFacebook($userNode["email"],$userNode["first_name"],$userNode["last_name"],$userNode["username"]);
            $user=$this->userDAO->existsUser($userNode["username"], $userNode["email"]);
            $loggedUser=$user;
        }
        $_SESSION["user"]=$loggedUser;
        $this->Message("Logged in with Facebook", FRONT_ROOT."index.php");

        // User is logged in with a long-lived access token.
        // You can redirect them to a members-only page.
        //header('Location: https://example.com/members.php');
    }

}