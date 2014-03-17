<?php

class filter_ipa extends moodle_text_filter {

    public static $filteripadefaults = array(
        'N'   => 'ŋ',
        'T'   => 'θ',
        'D'   => 'ð',
        'S'   => 'ʃ',
        'Z'   => 'ʒ',
        'g'   => 'ɡ',
        'P'   => 'ʔ',
        'I'   => 'ɪ',
        'E'   => 'ɛ',
        '\ae' => 'æ',
        'A'   => 'ɑ',
        'U'   => 'ʊ',
        '2'   => 'ʌ',
        '0'   => 'ɔ',
        '@'   => 'ə',
        '""'  => 'ˌ',
        '"'   => 'ˈ',
        ':'   => 'ː'
    );

    public function filter($text, array $options = array()) {
        $replacements = filter_ipa::$filteripadefaults;
        preg_match_all('|ipa{[^}]*}|', $text, $ipas);
        foreach ($ipas[0] as $ipa) {
            $transcription = $ipa;
            $transcription = substr($ipa, 4, -1);
            foreach ($replacements as $key => $value) {
                $transcription = str_replace($key, $value, $transcription);
            }
            $text = str_replace($ipa, $transcription, $text);
        }
        return $text;
    }
}
