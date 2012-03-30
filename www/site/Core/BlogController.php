<?php
/**
 * BlogController class file
 *
 * @author Denis Lysenko
 */
namespace Core;
/**
 * Blog controller shows entries from database
 */
class BlogController extends \FW\AbstractController
{
    /**
     * Custom route method make it possible to use only numbers in parameters
     *
     * Shows entry if first parameter that specify action is number
     */
    public function route()
    {
        $params = explode('/', $this->_params, 2);
        if (isset($params[1])) $this->_params = $params[1];
        $params[0] = isset($params[0]) ? $params[0] : '';

        $action = is_numeric($params[0]) ? 'showAction' : $params[0] . 'Action';

        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->indexAction();
        }
    }
    /**
     * Index action shows last entries from database
     */
    public function indexAction()
    {
        $model = new BlogModel();

        $this->_view->assign('_title', 'crashcube\'s site');
        $this->_view->assign('articles', $model->getLastArticles(10));
        $this->_view->render('lite', array('content' => 'blog_index'));
    }
    /**
     * Show action displays article on own page
     *
     * @throws \Exception
     */
    public function showAction()
    {
        list($id) = explode('/', $this->_params);

        $model = new BlogModel();
        if ($article = $model->getArticle($id)) {
            $this->_view->assign('_title', $article['title']);
            $this->_view->assign('article', $article);
        } else {
            throw new \Exception('Article not found');
        }

        $this->_view->render('lite', array('content' => 'blog_show'));
    }
    /**
     * Add action perform adding article to database
     */
    public function addAction()
    {
        $this->_view->assign('_title', 'Добавить пост');

        $auth = new AuthModel;
        if ($auth->isUser()) {
            if (isset($_POST['title']) && isset($_POST['text'])) {
                $model = new BlogModel;
                if ($model->addArticle($_POST['title'], $_POST['text'])) {
                    $template = 'blog_added';
                } else {
                    $this->_view->assign('title', $_POST['email']);
                    $this->_view->assign('title', $_POST['title']);
                    $this->_view->assign('text', $_POST['text']);
                    $template = 'blog_add';
                }
            } else {
                $this->_view->assign('email', '');
                $this->_view->assign('title', '');
                $this->_view->assign('text', '');
                $template = 'blog_add';
            }
        } else {
            $template = 'auth_error';
        }

        $this->_view->render('lite', array('content' => $template));
    }
    /**
     * Edit action shows form with article for editing
     */
    public function editAction()
    {
        $this->_view->assign('_title', 'Редактировать пост');

        if ($this->_auth->isUser()) {

            $id = (int) $this->_params;
            $model = new BlogModel;

            if (isset($_POST['title']) && isset($_POST['text'])) {
                if ($model->updateArticle($id, $_POST['title'], $_POST['text'])) {
                    $template = 'blog_added';
                } else {
                    $this->_view->assign('title', $_POST['title']);
                    $this->_view->assign('text', $_POST['text']);
                    $template = 'blog_add';
                }
            } else {

                $article = $model->getArticle($id);
                $this->_view->assign('title', $article['title']);
                $this->_view->assign('text', $article['text']);
                $template = 'blog_add';
            }
        } else {
            $template = 'auth_error';
        }

        $this->_view->render('lite', array('content' => $template));
    }
    /**
     * Delete action try to delete article from database
     */
    public function deleteAction()
    {
        $this->_view->assign('_title', 'Удаление поста');

        if ($this->_auth->isUser()) {
            $id = (int) $this->_params;
            $model = new BlogModel;
            if ($model->deleteArticle($id)) {
                $template = 'blog_deleted';
            } else {
                $template = 'blog_error';
            }
        } else {
            $template = 'auth_error';
        }

        $this->_view->render('lite', array('content' => $template));
    }
}