<?php
class Parser{
    /**
     * Parser constructor.
     */
    public function __construct()
    {
        libxml_use_internal_errors(true);
    }

    /**
     * @param string $data
     * @return array
     */
    public function parseFeed(string $data) : array
    {
        $result = [];
        $doc = new DOMDocument();
        $doc->loadHTML($data);

        $xpath = new DOMXpath($doc);

        $feed = $xpath->query('//div[@class="js-news-feed-list"]/child::a[starts-with(@id, "id_newsfeed_")]');
        foreach ($feed as $i => $shortNews){
            $url = $shortNews->getAttribute('href');
            $hash = base64_encode($url);
            $child = $shortNews->getElementsByTagName('span');
            $title = $child->item(0)->nodeValue;

            $result[] = new News([
                'url_hash' => $hash,
                'url' => $url,
                'title' => trim($title),
            ]);
        }
        return $result;
    }

    /**
     * @param News $news
     * @param string $data
     * @return News
     */
    public function parseNews(News $news, string $data) : News
    {
        $content = [];
        $doc = new DOMDocument();
        $doc->loadHTML($data);

        $xpath = new DOMXpath($doc);

        $article = $xpath->query('//div[@class="article__text article__text_free"]//p');

        // @TODO We need added custom rules for other rbc subsites
        // hack 4 https://pro.rbc.ru/
        if ($article->length == 0){
            $article = $xpath->query('//div[@class="article__text"]');
        }
        foreach ($article as $paragraph){
            $content[] = trim($paragraph->nodeValue);
        }

        $img = $xpath->query('//div[@class="article__main-image__wrap"]//img');
        $imgUrl = !is_null($img->item(0)) ? $img->item(0)->getAttribute('src') : null;
        $news->setContent(implode('<br />', $content));
        $news->setImgUrl($imgUrl);

        return $news;
    }
}