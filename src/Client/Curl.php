<?php


class CurlClient{
    /**
     * @var false|resource
     */
    private $curl;

    /**
     * @var array|null
     */
    protected $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        // CURLOPT_SSLVERSION => 3,
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
        CURLOPT_SSL_CIPHER_LIST => 'TLSv1',
    ];

    /**
     * CurlClient constructor.
     * @param array|null $options
     * @param bool $rewrite
     */
    public function __construct(array $options = null, bool $rewrite = false)
    {
        $this->curl = curl_init();
        switch (true){
            case is_null($options):
                break;
            case !is_null($options) && true === $rewrite:
                $this->options = $options;
                break;
            case !is_null($options) && false === $rewrite:
                $this->options = array_merge($options, $this->options);
                break;
        }
        curl_setopt_array($this->curl, $this->options);
    }

    /**
     * @param string $url
     * @return string
     */
    public function get(string $url) : string
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $data = curl_exec($this->curl);

        if(curl_errno($this->curl)){
            echo 'Curl error: ' . curl_error($this->curl);
        }
        //curl_close($this->curl);
        return $data;
    }
}
