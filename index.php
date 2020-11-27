<?php
header('Content-type: text/html; charset=UTF-8');
// curl
require_once ('./src/Client/Curl.php');
require_once ('./src/Parser/Parser.php');
require_once ('./src/Struct/News.php');
require_once ('./src/NewsService.php');




class app
{
    const URL = 'https://www.rbc.ru/';
    private $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService([
            'host' => 'mariadb',
            'user' => 'root',
            'password' => 'pass',
            'db' => 'rbc_parser',
        ]);
    }
    public function start()
    {
        $client = new CurlClient();
        $parser = new Parser();

        $data = $client->get(self::URL);
        $feed = $parser->parseFeed($data);

        foreach ($feed as $news) {
            if (false == $this->newsService->isSaved($news->getUrlHash())) {
                $parser->parseNews(
                    $news,
                    $client->get($news->getUrl())
                );
                $news = $this->newsService->save($news);
            }
            $news = $this->newsService->get($news->getUrlHash());
            echo '<strong>'.$news->getTitle().'</strong>';
            echo '<br />';
            echo $news->getPreview();
            echo "<a href = '?hash={$news->getUrlHash()}'>подробнее</a>";
            echo '<hr />';
        }
    }

    public function page($hash)
    {
        $news = $this->newsService->get($hash);
        echo '<strong>'.$news->getTitle().'</strong>';
        echo '<br />';
        if ($news->getImgUrl()) {
            echo "<img src = '{$news->getImgUrl()}' height='50%' width='50%' /><br />";
        }
        echo $news->getContent();
    }
}


$app = new app();

$_GET['hash'] ? $app->page($_GET['hash']) : $app->start();
