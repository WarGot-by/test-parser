<?php
class News {
    private $url_hash;
    private $content;
    private $img_url;
    private $url;
    private $title;

    const PREV_SYMBOLS = 200;

    public function __construct(array $fields = [])
    {
        foreach ($fields as $field => $value){
            if (property_exists($this, $field)){
                $this->$field = $value;
            }
        }
    }
    /**
     * @return mixed
     */
    public function getUrlHash()
    {
        return $this->url_hash;
    }

    /**
     * @param mixed $hash
     */
    public function setUrlHash($hash)
    {
        $this->url_hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPreview()
    {
        $str = substr($this->content, 0, self::PREV_SYMBOLS);
        $str = explode(' ', $str);
        unset($str[count($str) -1]);
        return implode(' ', $str).'...';
    }

    /**
     * @param mixed $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->img_url;
    }

    /**
     * @param mixed $img_url
     */
    public function setImgUrl($img_url)
    {
        $this->img_url = $img_url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}