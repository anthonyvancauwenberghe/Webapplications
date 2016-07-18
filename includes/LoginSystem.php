<?php
require_once('../libs/AutoLoader.php');

class LoginSystem
{
    private $core;
    private $data;

    public function __construct($rank)
    {
        $this->sec_session_start();

        if ($rank != null) {
            $this->processLoginCheck();

            if ($this->login_check()) {
                $this->redirectNoPermission($rank);
            }
            $this->processLogout();
        }

    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    public function ownerPermission()
    {
        if ($this->getRank() != 'OWNER') {
            echo 'You need to be Owner to get access to this page';
            die();
        }
    }

    public function redirectNoPermission($rank)
    {
        if (!$this->hasPermission($rank)) {
            echo $rank;
            echo $this->getRankName();
            echo $this->getRank();
            echo 'You do not have the necessary permissions to get access to this page';
            echo $_SESSION['user_id'];
            echo $_SESSION['username'];
            echo $_SESSION['login_string'];
            echo $_SESSION['rank'];
            die();
        }
    }

    public function hasPermission($rank)
    {
        if ($this->getRank()>= $rank && $rank!=null) {
            return true;
        } else {
            return false;
        }
    }

    public function processLogout()
    {
        if (isset($_GET['logout'])) {

            // Unset all session values
            $_SESSION = array();

            // get session parameters
            $params = session_get_cookie_params();

            // Delete the actual cookie.
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

            // Destroy session
            session_destroy();
            header("Location: ../index.php");
            exit();
        }

    }

    public function logout()
    {
        // Unset all session values
        $_SESSION = array();

        // get session parameters
        $params = session_get_cookie_params();

        // Delete the actual cookie.
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

        // Destroy session
        session_destroy();
        header("Location: ../index.php");
        exit();
    }

    public function sec_session_start()
    {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = false;

        // This stops JavaScript being able to access the session id.
        $httponly = true;

        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

        // Sets the session name to the one set above.
        session_name($session_name);

        session_start();            // Start the PHP session
        session_regenerate_id();    // regenerated the session, delete the old one.
    }

    public function esc_url($url)
    {

        if ('' == $url) {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string)$url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }

    public function processLoginCheck()
    {
        if (!$this->login_check()) {
            header("Location: ../login.php");
            die();
        }
    }

    public function processLoginCheckLoginPage()
    {
        if (!$this->login_check()) {
            if (isset($_POST['username']) && isset($_POST['p'])) {
                $this->processLogin($_POST['username'], $_POST['p']);
            }
        } else {
            header("Location: ../index.php");
            die();
        }
    }

    private function login_check()
    {

        if (!isset($this->data)) {
            $this->data = new Data();
        }

        // Check if all session variables are set
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SESSION['rank'])) {

            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
            $rank = $_SESSION['rank'];

            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            //$query = array('player-name' => new MongoRegex('/' . strtolower($username) . '/i'));
            if ($member = $this->data->findOne(Collection::CHARACTERS, array('_id' => new MongoDB\BSON\ObjectId($user_id)))) {

                $login_check = hash('sha512', $member['password']['hashed'] . $user_browser);

                if (hash_equals($login_check, $login_string)) {
                    // Logged In!!!!
                    return true;
                } else {

                    // Not logged in
                    return false;
                }

            } else {

                // Not logged in
                return false;
            }
        } else {

            return false;
        }
    }

    private function login($playerName, $password)
    {
        if (!isset($this->data)) {
            $this->data = new Data();
        }
        //new MongoRegex('/' . strtolower($playerName) . '/i')
        if ($member = $this->data->findOne(Collection::CHARACTERS, array('player-name' => $playerName))) {

            // If the user exists we check if the account is locked
            // from too many login attempts

            /*  if (checkbrute($member['_id'], $db) == true) {
                  // Account is locked
                  // Send an email to user saying their account is locked
                  return false;
              } else {*/
            // Check if the password in the database matches
            // the password the user submitted. We are using
            // the hahs_equals function to avoid timing attacks.

            if (hash_equals($member['password']['hashed'], hash('sha512', $member['password']['salt'] . $password))) {
                // Password is correct!
                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                $user_id = (string)$member['_id'];
                // XSS protection as we might print this value

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $playerName;
                $_SESSION['rank'] = $member['ranks']['highest-rank'];
                $_SESSION['login_string'] = hash('sha512', $member['password']['hashed'] . $user_browser);
                // Login successful.
                return true;
            } else {
                // Password is not correct
                // We record this attempt in the database
                $now = time();
                // $mysqli->query("INSERT INTO login_attempts(user_id, time)
                // VALUES ('$user_id', '$now')");
                return false;
            }
            //}

        } else {
            // No user exists.
            return false;
        }

    }

    public function processLogin($username, $password)
    {

        if (isset($username, $password)) {
            $username = $this->getCore()->filterRequest($username);
            $username = $this->getCore()->normalizeUsername($username);

            //$username = filter_input($username, 'username', FILTER_SANITIZE_EMAIL);
            //$username = strtolower($username);
            //$password = $_POST['p']; // The hashed password.

            if ($this->login($username, $password) == true) {
                // Login success
                header("Location: ../index.php");
                exit();
            } else {
                // Login failed

                header('Location: ../login.php?error=1');
                exit();
            }
        } else {
            // The correct POST variables were not sent to this page.
            header('Location: ../error.php?err=Could not process login');
            exit();
        }
    }

    public function checkBruteForceAttack($user_id, $collection)
    {
        return false;
    }

    public function getName()
    {
        return $_SESSION['username'];
    }

    public function getRank()
    {
        switch ($this->getRankName()) {
            case 'PLAYER':
                return Rank::PLAYER;
                break;
            case 'HERO':
                return Rank::HERO;
                break;
            case 'LEGEND':
                return Rank::LEGEND;
                break;
            case 'VETERAN':
                return Rank::VETERAN;
                break;
            case 'DONATOR':
                return Rank::DONATOR;
                break;
            case 'SUPER_DONATOR':
                return Rank::SUPER_DONATOR;
                break;
            case 'EXTREME_DONATOR':
                return Rank::EXTREME_DONATOR;
                break;
            case 'LEGENDARY_DONATOR':
                return Rank::LEGENDARY_DONATOR;
                break;
            case 'MYTHICAL_DONATOR':
                return Rank::MYTHICAL_DONATOR;
                break;
            case 'HELPER':
                return Rank::HELPER;
                break;
            case 'MODERATOR':
                return Rank::MODERATOR;
                break;
            case 'GLOBAL_MODERATOR':
                return Rank::GLOBAL_MODERATOR;
                break;
            case 'COMMUNITY_MANAGER':
                return Rank::COMMUNITY_MANAGER;
                break;
            case 'HEAD_MODERATOR':
                return Rank::HEAD_MODERATOR;
                break;
            case 'ADMINISTRATOR':
                return Rank::ADMINISTRATOR;
                break;
            case 'DEVELOPER':
                return Rank::DEVELOPER;
                break;
            case 'OWNER':
                return Rank::OWNER;
                break;
            case null:
                return Rank::PLAYER;
                break;
        }
    }

    public function getRankName()
    {
        if(isset($_SESSION['rank'])) {
            return $_SESSION['rank'];
        }
        else {
            return null;
        }
    }


}