<?php

class filter_ipa extends moodle_text_filter {
    public function filter($text, array $options = array()) {
        $replacements = array(
            'S' => 'ʃ',
            'I' => 'ɪ'
        );
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
