<?php 

namespace App\Services;

/**
 * AlexaRanking
 * GetGlobalRank([Url : 'URL', Rank : 'TEXT'])
 * GetCountryRank([Country name: 'NAME', Country Rank: 'RANK'])
 * rank()
 */
Class AlexaRanking
{

    private $output;

    private $api_url = 'http://data.alexa.com/data';

    /* public function __construct($url)
    {
        $this->output = $this->getRank($url);
    } */

    public function getRank($url)
    {
        $this->output = false;
        $xml = $this->request("http://data.alexa.com/data?cli=10&url=$url");
        if (empty($xml)) {
            return false;
        }

        libxml_use_internal_errors(true);
        $doc = simplexml_load_string($xml);

        if ($doc === false) {
            libxml_clear_errors();
            return false;
        }
        $this->output = $doc;

        return $this->rank();
    }

    function request($url, $post = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url ); // отправляем на
        curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);// таймаут4
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36");
        // curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
        // curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        // curl_setopt($ch, CURLOPT_POST, $post!==0 ); // использовать данные в post
        // if($post) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function GetGlobalRank()
    {
        $popularity = json_decode( json_encode( $this->output->SD->POPULARITY ), TRUE );
        $popularity_info = $popularity['@attributes'];

        return $popularity_info;
    }

    public function GetCountryRank()
    {
        $country = json_decode( json_encode( $this->output->SD->COUNTRY ), TRUE );
        $country_info = $country['@attributes'];

        return $country_info;
    }

    public function rank()
    {
        if (empty($this->output)) {
            return 0;
        }
        //Get popularity node
        $popularity = $this->output->xpath("//POPULARITY");
        if (empty($popularity)) {
            return 0;
        }
        //Get the Rank attribute
        if (empty($popularity[0]) || empty($popularity[0]['TEXT'])) {
            return 0;
        }
        $rank = (string)$popularity[0]['TEXT'];

        return $rank;
    }

    static public function get($url)
    {
        return new AlexaRanking($url);
    }

    public function getRaw()
    {
        return $this->output;
    }
}
