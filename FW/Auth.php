<?php
/**
 * Auth class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * Auth component provides possibility to assign different access privileges for each user
 */
class Auth
{
    /**
     * @var resource contains database instance
     */
    private $_db;
    /**
     * @var array contains user information
     */
    private $_user;
    /**
     * @param mixed $email
     * @param mixed $password
     */
    public function __construct($email = false, $password = false)
    {
        $this->_db = \FW\Database::getInstance();

        if ($password) {
            $this->_assign($email, sha1($password));
        } else {
            $this->_recall();
        }
    }
    /**
     * Try to get data of exist user
     *
     * @param $email
     * @param $password
     */
    private function _assign($email, $password)
    {
        $sth = $this->_db->prepare('SELECT * FROM ce_users WHERE email = ? AND password = ?');
        $sth->execute(array($email, $password));
        $this->_user = $sth->fetch(\PDO::FETCH_ASSOC);
    }
    /**
     * Get user data from cookies and check one
     */
    private function _recall()
    {
        if (isset($_COOKIE['auth']) && strpos($_COOKIE['auth'], ':') !== false) {
            list($email, $password) = explode(':', $_COOKIE['auth'], 2);
            $this->_assign($email, $password);
        }
    }
    /**
     * Return true if user exists and false in a different way
     *
     * @return mixed
     */
    public function isUser()
    {
        if (is_array($this->_user)) {
            return $this->_user['email'];
        } else {
            return false;
        }
    }
    /**
     * Try to remember user by writing data in cookies
     */
    public function remember()
    {
        if (is_array($this->_user)) {
            $data = $this->_user['email'] . ':' . $this->_user['password'];
            setcookie('auth', $data, time()+86400, '/');
        }
    }
    /**
     * Logout method erases cookies and forgets user
     */
    public function logout() {
        setcookie('auth', '', time()-86400, '/');
    }
}