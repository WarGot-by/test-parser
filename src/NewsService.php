<?php

class NewsService
{
    protected $mysqli;
    protected $pdo;

    /**
     * NewsService constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        /*
        $this->mysqli = new mysqli($params['host'], $params['user'], $params['password'], $params['db'], 3306);
        $this->mysqli->set_charset("utf8");
        if ($this->mysqli->connect_errno) {
            echo "Problems with MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        */
        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['db']};charset=utf8";
            $this->pdo = new PDO($dsn, $params['user'], $params['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $e) {
            die('Problems with' . $e->getMessage());
        }
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function isSaved(string $hash): bool
    {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $stmt = $this->pdo->prepare("SELECT id FROM news WHERE url_hash = :hash LIMIT 0,1");
            $stmt->bindParam('hash', $hash);

            $stmt->execute();
        } catch (PDOException $e) {
            die('Problems with' . $e->getMessage());
        }

        return $stmt->rowCount() > 0;
    }

    /**
     * @param News $news
     */
    public function save(News $news): News
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $stmt = $this->pdo->prepare("INSERT INTO news (url_hash, content, img_url, title) VALUES (:url_hash, :content, :img_url, :title)");

            $stmt->bindParam(':url_hash', $news->getUrlHash(), PDO::PARAM_STR);
            $stmt->bindParam(':content', $news->getContent());
            $stmt->bindParam(':img_url', $news->getImgUrl(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $news->getTitle(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            die('Problems with' . $e->getMessage());
        }
        return $news;
    }

    /**
     * @param string $hash
     * @return News
     */
    public function get(string $hash) : News
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt = $this->pdo->prepare("SELECT * FROM news WHERE url_hash = :hash LIMIT 0,1");
        $stmt->bindParam('hash', $hash);

        $stmt->execute();
        $row  = $stmt->fetch();
        return new News($row);
    }
}