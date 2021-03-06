<?php
/**
 * This file is part of MySQLDumper released under the GNU/GPL 2 license
 * http://www.mysqldumper.net
 *
 * @package         MySQLDumper
 * @subpackage      Users
 * @version         SVN: $Rev$
 * @author          $Author$
 */
/**
 * Class for user login and logout actions.
 *
 * @package         MySQLDumper
 * @subpackage      Users
 */
class Msd_User
{
    /**
     * The executed process was successfully completed.
     *
     * @var int
     */
    const SUCCESS = 0x00;

    /**
     * There is no file with user identities and credentials.
     *
     * @var int
     */
    const NO_USER_FILE = 0x01;

    /**
     * The user file doesn't contain any valid user logins.
     *
     * @var int
     */
    const NO_VALID_USER = 0x02;

    /**
     * The user file doesn't contain any valid user logins.
     *
     * @var int
     */
    const NOT_ACTIVE = 0x04;

    /**
     * The given identity is unknown or the password is wrong.
     *
     * @var int
     */
    const UNKNOWN_IDENTITY = 0x03;

    /**
     * An unknown error occured.
     *
     * @var int
     */
    const GENERAL_FAILURE = 0xFF;

    /**
     * Instance to authentication storage.
     *
     * @var Zend_Auth_Storage_Session
     */
    private $_authStorage = null;

    /**
     * Id of currently loggedin user.
     *
     * @var int
     */
    private $_userId = null;

    /**
     * Name of currently loggedin user.
     *
     * @var string
     */
    private $_userName = null;

    /**
     * Current login status.
     *
     * @var boolean
     */
    private $_isLoggedIn = false;

    /**
     * Messages from Zend_Auth_Result.
     *
     * @var array
     */
    private $_authMessages = array();

    /**
     * Constructor
     *
     * @return Msd_User
     */
    public function __construct()
    {
        $this->_authStorage = new Zend_Auth_Storage_Session();
        $auth               = $this->_authStorage->read();
        if (!empty($auth)) {
            if (isset($auth['name'])) {
                $this->_userName = $auth['name'];
            }
            if (isset($auth['id'])) {
                $this->_userId = $auth['id'];
            }
            if ($this->_userName !== null && $this->_userId !== null) {
                $this->_isLoggedIn = true;
            }
        } else {
            $this->_loginByCookie();
        }
    }

    /**
     * Returns the messages which comes from Zend_Auth_Result.
     *
     * @return array
     */
    public function getAuthMessages()
    {
        return $this->_authMessages;
    }

    /**
     * Return the loggedin status.
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    /**
     * Login the user with the given identity and credentials.
     * Set cookie if automatic login is wanted.
     *
     * Returns true if login was successful, otherwise false.
     *
     * @param string  $username  Identity for login process.
     * @param string  $password  Credentials for login procress.
     * @param bool    $autoLogin Set cookie for automatic login?
     *
     * @return int
     */
    public function login($username, $password, $autoLogin = false)
    {
        $authAdapter = new Msd_Auth_Adapter_Db();
        $authAdapter->setUsername($username);
        $authAdapter->setPassword($password);
        $auth                = Zend_Auth::getInstance();
        $authResult          = $auth->authenticate($authAdapter);
        $this->_authMessages = $authResult->getMessages();
        $this->_isLoggedIn   = false;
        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            if ($identity['active'] != "1") {
                return self::NOT_ACTIVE;
            }
            $this->_isLoggedIn = true;
            if ($autoLogin) {
                Zend_Session::regenerateId();
                $this->setLoginCookie($username, $password);
            }
            $this->setDefaultConfiguration();

            return self::SUCCESS;
        }

        return self::UNKNOWN_IDENTITY;
    }

    /**
     * Sets the cookie for automatic login.
     *
     * @param string $username Loginname of the user.
     * @param string $password Password of the user.
     *
     * @return null
     */
    public function setLoginCookie($username, $password)
    {
        $crypt    = new Msd_Crypt('oTranCe');
        $identity = $crypt->encrypt(
            $username . ':' . $password
        );
        setcookie(
            'oTranCe_autologin',
            $identity . ':' . md5($identity),
            time() + 365 * 24 * 60 * 60,
            '/'
        );
    }

    /**
     * Check auto log in cookie
     *
     * Logs in user if auto log in cookie is valid.
     *
     *
     * @return void
     */
    private function _loginByCookie()
    {
        /**
         * @var Zend_Controller_Request_Http $request
         */
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $cookie  = $request->getCookie('oTranCe_autologin');
        if ($cookie === null || $cookie == '') {
            // no cookie found
            return;
        }
        list($authInfo, $checksum) = explode(':', $cookie);
        if (md5($authInfo) != $checksum) {
            // autologin not valid - return
            return;
        }

        $crypt = new Msd_Crypt('oTranCe');
        list($username, $pass) = explode(':', $crypt->decrypt($authInfo));
        // Try to log in the user and refresh the cookie. Because you want
        // to stay logged in until you logout.
        $this->login($username, $pass, true);
    }

    /**
     * Clear the user identity and logout the user.
     *
     * @return void
     */
    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_isLoggedIn = false;
        $this->setDefaultConfiguration();
    }

    /**
     * Force loading of default configuration file
     *
     * @return void
     */
    public function setDefaultConfiguration()
    {
        Msd_Registry::getConfig()->load('config.ini');
    }
}
