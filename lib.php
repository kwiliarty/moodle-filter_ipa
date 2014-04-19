<?php 

define('FILTER_IPA_START', '-{');
define('FILTER_IPA_END', '}-');

class filter_ipa_mappings {
    
    public $filteripadefaults = array(
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

    public $filteripadiacritics = array(
        '\s{.}'    => '&#x0329;',
        '\r*.'     => '&#x0325;',
        '\|[.'     => '&#x032A;'
    );

    public $escapees = array(
        '*' => '\*',
        '|' => '\|',
        '[' => '\['
    );

}

