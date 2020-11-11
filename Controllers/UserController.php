<?php

namespace Controllers;

use Facebook\Facebook;
use Facebook\FacebookRequest;
use DAO\UserDAO;
use Models\User;
use \Exception as Exception;

class UserController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        try {
            session_start();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function login($username, $password)
    {
        try {
            if (!isset($_SESSION)) {
                session_start();
            } else {
                session_unset();
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        $user = $this->userDAO->getByUsername($username);
        if ($user != null) {
            if ($user->getPassword() === $password) {
                $_SESSION['user'] = $user;
            }
        } else {
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
        if ($this->userDAO->existsUser($username, $email) == false) {

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
    public function callback()
    {

        if (!session_id()) {
            session_start();
        }

        require_once 'Facebook/autoload.php';

        $fb = new Facebook([
            'app_id' => '848571982564560',
            'app_secret' => '46e67bc24db949c26f17b9e38a06acdc',
            'default_graph_version' => 'v2.4',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Cuando Graph devuelve un error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Cuando la validación falla 
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        

        if (!isset($accessToken)) {
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

        // Login directo 
        echo '<h3>Acceso Token</h3>';
        var_dump($accessToken->getValue());

        // Controlador de cliente de OAuth 2.0, para gestionar los accesos
        $oAuth2Client = $fb->getOAuth2Client();

        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);


        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Cambiando uno de corta duración a una de larga duración
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>";
                exit;
            }
            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
    }

    public function logout()
    {

        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION)) {
                session_destroy();
                session_unset();
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        $this->message("Logged out", FRONT_ROOT . "index.php");
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            require(VIEWS_PATH . 'userHome.php');
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }

    public function message($message, $location)
    {
        require_once(VIEWS_PATH . "message.php");
    }
}
