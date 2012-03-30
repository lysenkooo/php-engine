<?php
/**
 * AbstractController class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * AbstractController provides skeleton of controller
 */
abstract class AbstractController
{
    /**
     * @var string contains input parameters, that usually gets from URL
     */
    protected $_params;
    /**
     * @var View instance of view component
     */
    protected $_view;
    /**
     * @var Auth instance of auth component
     */
    protected $_auth;
    /**
     * Controller constructor perform parsing input controller parameters
     *
     * It will be called if used controller doesn't have specified route method
     *
     * @param string $inputParams contains controller parameters
     */
    public function __construct($inputParams)
    {
        $this->_params = $inputParams;

        $this->_view = new View;
        $this->_view->assign('_path', Registry::get('site_path'));

        $this->_auth = new Auth;
        $this->_view->assign('_user', $this->_auth->isUser());

        if (method_exists($this, 'route')) {
            $this->route();
        } else {
            $params = explode('/', $this->_params, 2);
            $params[0] = isset($params[0]) ? $params[0] : '';
            $action = $params[0] . 'Action';
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                $this->indexAction();
            }
        }
    }
    /**
     * Controller index action is a default action of controller
     *
     * This action will be called if there is no input parameters
     * Every controller must have this action
     *
     * @abstract
     * @return void
     */
    abstract public function indexAction();
}