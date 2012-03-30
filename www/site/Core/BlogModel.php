<?php
/**
 * BlogModel class file
 *
 * @author Denis Lysenko
 */
namespace Core;
/**
 * Blog model provides interface for blog entries access
 */
class BlogModel
{
    /**
     * @var \PDO database instance
     */
    private $_db;
    /**
     * @var \FW\Auth auth instance
     */
    private $_auth;
    /**
     * Constructor just get database instance
     */
    public function __construct()
    {
        $this->db = \FW\Database::getInstance();
    }
    /**
     * Get article from database
     *
     * @param int $id entry id
     * @return mixed
     */
    public function getArticle($id)
    {
        $row = $this->db->query("SELECT * FROM ce_blog WHERE id=$id")->fetch();
        if (strpos($row['text'], '<cut>') !== false) {
            $row['text'] = str_replace('<cut>', '<!--<cut>-->', $row['text']);
        }

        return $row;
    }
    /**
     * Get multiple articles from database
     *
     * @param int $count number of articles will be returned
     * @return array
     */
    public function getLastArticles($count = 10)
    {
        $articles = array();

        foreach ($this->db->query("SELECT * FROM ce_blog ORDER BY id DESC") as $row) {
            if (($pos = strpos($row['text'], '<cut>')) !== false) {
                $row['text'] = substr($row['text'], 0, $pos);
            }
            $articles[] = $row;
        }

        return $articles;
    }
    /**
     * Try to add article to database
     *
     * @param string $title name of article
     * @param string $text article content
     * @return \PDOStatement
     */
    public function addArticle($title, $text)
    {
        return $this->db->query("INSERT INTO ce_blog (title, text) VALUES ('$title', '$text')");
    }
    /**
     * Update article
     *
     * @param int $id number of article
     * @param string $title new name of article
     * @param string $text new article content
     * @return bool
     */
    public function updateArticle($id, $title, $text)
    {
        $sth = $this->db->prepare('UPDATE ce_blog SET title = ? , text = ? WHERE id = ?');
        return $sth->execute(array($title, $text, $id));
    }
    /**
     * Delete article
     *
     * @param int $id number of article
     * @return bool
     */
    public function deleteArticle($id)
    {
        $sth = $this->db->prepare('DELETE FROM ce_blog WHERE id = ?');
        return $sth->execute(array($id));
    }
}