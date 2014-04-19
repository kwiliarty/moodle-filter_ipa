<?php

class filter_ipa extends moodle_text_filter {

    public static $filteripadefaults = array(
        '\super h' => 'ʰ',
        '\ae'      => 'æ',
        '\:B'      => 'ʙ',
        '\!o'      => 'ʘ',
        '""'       => 'ˌ',
        'F'        => 'ɸ',
        'B'        => 'β',
        'M'        => 'ɱ',
        'N'        => 'ŋ',
        'T'        => 'θ',
        'D'        => 'ð',
        'S'        => 'ʃ',
        'Z'        => 'ʒ',
        'g'        => 'ɡ',
        'P'        => 'ʔ',
        'I'        => 'ɪ',
        'E'        => 'ɛ',
        'A'        => 'ɑ',
        'U'        => 'ʊ',
        '2'        => 'ʌ',
        'O'        => 'ɔ',
        '@'        => 'ə',
        '"'        => 'ˈ',
        ':'        => 'ː'
    );

    public static $filteripadiacritics = array(
        '\s{.}'    => '&#x0329;',
        '\r*.'     => '&#x0325;',
        '\|[.'     => '&#x032A;'
    );

    public static $escapees = array(
        '*' => '\*',
        '|' => '\|',
        '[' => '\['
    );

    public static function ipa_replace_diacritics($rawtext) {
        $mappings = self::$filteripadiacritics;
        $specials = array_keys(self::$escapees);
        $escapes  = array_values(self::$escapees);
        foreach ($mappings as $ascii => $htmlent) {
            $frames = explode('.', $ascii);
            if (!array_key_exists('1', $frames)) {
                $frames[1] = '';
            }
            $frames[0] = str_replace($specials, $escapes, $frames[0]);
            preg_match_all("/\\$frames[0](.)$frames[1]/", $rawtext, $targets, PREG_SET_ORDER);
            foreach ($targets as $target) {
                if (array_key_exists('1', $target)) {
                    $utf8 = mb_convert_encoding($htmlent, 'UTF-8', 'HTML-ENTITIES');
                    $rawtext = str_replace($target[0], $target[1].$utf8, $rawtext);
                }
            }
        }
        return $rawtext;
    }

    public static function ipa_replace_chars($rawtext) {
        $mappings = self::$filteripadefaults;
        $asciis = array_keys($mappings);
        $utf8s = array_values($mappings);
        $ipatext = str_replace($asciis, $utf8s, $rawtext);
        return $ipatext;
    }

    public static function return_ipa_json() {
        $diacritics = self::$filteripadiacritics;
        $defaults = self::$filteripadefaults;
        $fullset = $diacritics + $defaults;
        return json_encode($fullset, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }

    public function filter($text, array $options = array()) {
        preg_match_all('|ipa{(.*?)}ipa|', $text, $ipas);
        foreach ($ipas[1] as $key => $markup) {
            $firstpass = self::ipa_replace_diacritics($markup);
            $display = self::ipa_replace_chars($firstpass);
            $span = html_writer::tag('span', $display, array('class'=>'filter-ipa'));
            $text = str_replace($ipas[0][$key], $span, $text);
        }
        return $text;
    }
}
