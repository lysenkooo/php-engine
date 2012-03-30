<?php
/**
 * AboutController class file
 *
 * @author Denis Lysenko
 */
namespace Core;
/**
 * About controller is bunch of simple info pages
 */
class AboutController extends \FW\AbstractController
{
    public function indexAction()
    {
        $this->_view->assign('_title', 'crashcube\'s site - О сайте');
        $this->_view->render('lite', array('content' => 'about_index'));
    }
}