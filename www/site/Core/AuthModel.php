<?php

namespace Core;

class AuthModel
{
    private $_db;
    private $_user;

    public function __construct($email = false, $password = false)
    {
        $this->_db = \FW\Database::getInstance();

        if ($password) {
            $this->_assign($email, sha1($password));
        } else {
            $this->_recall();
        }
    }

    private function _assign($email, $password)
    {
        $sth = $this->_db->prepare('SELECT * FROM ce_users WHERE email = ? AND password = ?');
        $sth->execute(array($email, $password));
        $this->_user = $sth->fetch(\PDO::FETCH_ASSOC);
    }

    private function _recall()
    {
        if (isset($_COOKIE['auth']) && strpos($_COOKIE['auth'], ':') !== false) {
            list($email, $password) = explode(':', $_COOKIE['auth'], 2);
            $this->_assign($email, $password);
        }
    }

    public function isUser()
    {
        if (is_array($this->_user)) {
            return true;
        } else {
            return false;
        }
    }

    public function remember()
    {
        if (is_array($this->_user)) {
            $data = $this->_user['email'] . ':' . $this->_user['password'];
            setcookie('auth', $data, time()+86400, '/');
        }
    }

    public function logout() {
        setcookie('auth', '', time()-86400, '/');
    }

}