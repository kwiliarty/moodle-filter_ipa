<?php

include_once(dirname(__FILE__) . '/lib.php');

class filter_ipa extends moodle_text_filter {

    public $defaults;
    public $diacritics;
    public $escapees;

    public function __construct() {
        $mappings = new filter_ipa_mappings();
        $this->defaults = $mappings->filteripadefaults;
        $this->diacritics = $mappings->filteripadiacritics;
        $this->escapees = $mappings->escapees;
    }

    public function ipa_replace_diacritics($rawtext) {
        $mappings = $this->diacritics;
        $specials = array_keys($this->escapees);
        $escapes  = array_values($this->escapees);
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

    public function ipa_replace_chars($rawtext) {
        $mappings = $this->defaults;
        $asciis = array_keys($mappings);
        $utf8s = array_values($mappings);
        $ipatext = str_replace($asciis, $utf8s, $rawtext);
        return $ipatext;
    }

    public function return_ipa_json() {
        $diacritics = $this->diacritics;
        $defaults = $this->defaults;
        foreach ($diacritics as &$diacritic) {
            $diacritic = mb_convert_encoding($diacritic, 'UTF-8', 'HTML-ENTITIES');
        }
        $fullset = array(
            'diacritics' => $diacritics,
            'defaults'   => $defaults
        );
        return json_encode($fullset, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }

    public function filter($text, array $options = array()) {
        $ipastart = preg_quote(FILTER_IPA_START);
        $ipaend = preg_quote(FILTER_IPA_END);
        $needle = $ipastart . '(.*?)' . $ipaend;
        preg_match_all("/$needle/", $text, $ipas);
        foreach ($ipas[1] as $key => $markup) {
            $firstpass = $this->ipa_replace_diacritics($markup);
            $display = $this->ipa_replace_chars($firstpass);
            $span = html_writer::tag('span', $display, array('class'=>'filter-ipa'));
            $text = str_replace($ipas[0][$key], $span, $text);
        }
        return $text;
    }
}
