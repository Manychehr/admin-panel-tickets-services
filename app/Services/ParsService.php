<?php 

namespace App\Services;

use Pdp\Rules;

class ParsService {

    public static function domain(string $str)
    {
        $re = '/(([\w+\d+\-]{1,63}\.)+[\w+\.]{2,6})/m';
        if (preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0)) {
            return self::validDomains($matches);
        }
        return [];
    }

    static function validDomains(array $domains, $key = 1, $result = [])
    {
        $rules = self::getDomainRules();
        foreach ($domains as $domain) {
            if (!empty($domain[$key])) {
                try {
                    $url = filter_var($domain[$key], FILTER_SANITIZE_URL);
                    $ICANNdomain = $rules->getICANNDomain($url);
                    if ($ICANNdomain->isKnown() || $ICANNdomain->isICANN() || $ICANNdomain->isPrivate()) {
                        $result[] = $ICANNdomain->getContent();
                    }
                } catch (\Exception $exception) {
                    //throw $exception;
                }
            }
        }
        return array_unique($result);
    }

    /**
     * @return \Pdp\Rules;
     */
    public static function getDomainRules($path_suffix = 'public_suffix_list/public_suffix_list.dat.txt')
    {
        return Rules::createFromPath(
            storage_path($path_suffix),
            null,
            IDNA_NONTRANSITIONAL_TO_ASCII,
            IDNA_NONTRANSITIONAL_TO_UNICODE
        );
    }

    public static function prohibitedSchemes(string $str)
    {
        if (preg_match('/(ssh|ftp|rdp|mysql|user|pass)\s*\:/mi', $str)) {
            return true;
        }
        return false;
    }

    public function url(string $str, $result = [])
    {
        $re = '/(?:(?:https?|ftp):\/\/|\b(?:[a-z\d]+\.))(?:(?:[^\s()<>]+|\((?:[^\s()<>]+|(?:\([^\s()<>]+\)))?\))+(?:\((?:[^\s()<>]+|(?:\(?:[^\s()<>]+\)))?\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))?/mi';
        if (preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0)) {
            foreach ($matches as $matche) {
                if (!empty($matche[0])) {
                    $url = filter_var($matche[0], FILTER_SANITIZE_URL);
                    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
                        $result[] = $url;
                    }
                }
            }
        }
        return array_unique($result);
    }

    public static function ip(string $str, $result = [])
    {
        $re = '/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/m';
        if (preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0)) {
            foreach ($matches as $matche) {
                if (!empty($matche[0])) {
                    $ip = filter_var($matche[0], FILTER_SANITIZE_URL);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
                        $result[] = $ip;
                    }
                }
            }
        }
        return array_unique($result);
    }
}