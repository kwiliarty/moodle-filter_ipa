<?php

class filter_ipa extends moodle_text_filter {

    public static $filteripadefaults = array(
        '\super h' => 'ʰ',
        '\ae'      => 'æ',
        '""'       => 'ˌ',
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
    );

    public static function ipa_replace_diacritics($rawtext) {
        $mappings = self::$filteripadiacritics;
        foreach ($mappings as $ascii => $utf8) {
            $onset = "\s{";
            $peak = "m";
            $coda = "}";
            preg_match_all('/\\\s{m}/', $rawtext, $targets);
            echo "<pre>";
            print_r($targets);
            echo "</pre>";
        }
    }

    public static function ipa_replace_chars($rawtext) {
        $mappings = self::$filteripadefaults;
        $asciis = array_keys($mappings);
        $utf8s = array_values($mappings);
        $ipatext = str_replace($asciis, $utf8s, $rawtext);
        return $ipatext;
    }

    public static function return_ipa_json() {
        return json_encode(self::$filteripadefaults, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }

    public function filter($text, array $options = array()) {
        self::ipa_replace_diacritics($text);
        preg_match_all('|ipa{(.*?)}|', $text, $ipas);
        foreach ($ipas[1] as $key => $markup) {
            $display = self::ipa_replace_chars($markup);
            $span = html_writer::tag('span', $display, array('class'=>'filter-ipa'));
            $text = str_replace($ipas[0][$key], $span, $text);
        }
        return $text;
    }
}
