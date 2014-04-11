<?php

class filter_ipa extends moodle_text_filter {

    public static $filteripadefaults = array(
        '\super h' => '<sup>h</sup>',
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
        '0'        => 'ɔ',
        '@'        => 'ə',
        '"'        => 'ˈ',
        ':'        => 'ː'
    );

    public function filter($text, array $options = array()) {
        $mappings = self::$filteripadefaults;
        $asciis = array_keys($mappings);
        $utf8s = array_values($mappings);
        preg_match_all('|ipa{(.*?)}|', $text, $ipas);
        foreach ($ipas[1] as $key => $markup) {
            $display = str_replace($asciis, $utf8s, $markup);
            $span = html_writer::tag('span', $display, array('class'=>'filter-ipa'));
            $text = str_replace($ipas[0][$key], $span, $text);
        }
        return $text;
    }
}
