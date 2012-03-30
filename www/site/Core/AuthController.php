<?php
/**
 * AuthController class file
 *
 * @author Denis Lysenko
 */
namespace Core;
/**
 * AuthController provides GUI for Auth component
 */
class AuthController extends \FW\AbstractController
{
    /**
     * Index action now jumps to loginAction
     */
    public function indexAction()
    {
        $this->loginAction();
    }
    /**
     * Login action offer to type user data for login or shows account page
     */
    public function loginAction()
    {
        $this->_view->assign('_title', 'crashcube\'s site');

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $auth = new \FW\Auth($_POST['email'], $_POST['password']);
            $auth->remember();
        } else {
            $auth = new \FW\Auth;
        }
        if ($auth->isUser()) {
            $this->_view->render('lite', array('content' => 'auth_logged'));
        } else {
            $this->_view->render('lite', array('content' => 'auth_index'));
        }
    }
    /**
     * Logout action just forgets user
     */
    public function logoutAction()
    {
        $this->_view->assign('_title', 'crashcube\'s site');

        $auth = new \FW\Auth;

        if ($auth->isUser()) {
            $auth->logout();
            $this->_view->render('lite', array('content' => 'auth_unlogged'));
        } else {
            $this->_view->render('lite', array('content' => 'auth_error'));
        }
    }
}