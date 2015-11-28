<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *  IPA filtering
 *
 *  This filter will replace X-SAMPA markup between '-{' and '}-' with unicode IPA
 *  For best results it is a good idea also to load an IPA fully-capable font
 *
 * @package    filter_ipa
 * @copyright  2014 onwards Kevin Wiliarty {@link http://kevinwiliarty.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

define('FILTER_IPA_START', '-{');
define('FILTER_IPA_END', '}-');

/**
 * X-SAMPA / IPA mappings.
 *
 * This class provides the specific 1-to-1 mappings of X-SAMPA strings to unicode IPA
 *
 * @link X-SAMPA documentation {https://en.wikipedia.org/wiki/X-SAMPA}
 * @package    filter_ipa
 * @copyright  2014 onwards Kevin Wiliarty {@link http://kevinwiliarty.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_ipa_mappings {

    /** @var array The list of specific mappings from X-SAMPA to unicode IPA */
    protected $filteripamappings = array(
        /* four character strings */
        'G\\_<' => 'ʛ',
        'J\\_<' => 'ʄ',
        '|\\|\\' => 'ǁ',
        '_B_L' => ' ᷅',
        '_H_T' => ' ᷄',
        '_R_F' => ' ᷈',
        /* three character strings */
        'b_<' => 'ɓ',
        'd_<' => 'ɗ',
        'g_<' => 'ɠ',
        'r\\`' => 'ɻ',
        '_?\\' => 'ˤ',
        '<F>' => '↘',
        '<R>' => '↗',
        /* two character strings */
        'd`' => 'ɖ',
        'h\\' => 'ɦ',
        'j\\' => 'ʝ',
        'l\\' => 'ɺ',
        'p\\' => 'ɸ',
        'l`' => 'ɭ',
        'n`' => 'ɳ',
        'r`' => 'ɽ',
        'r\\' => 'ɹ',
        's\\' => 'ɕ',
        's`' => 'ʂ',
        't`' => 'ʈ',
        'v\\' => 'ʋ',
        'x\\' => 'ɧ',
        'z\\' => 'ʑ',
        'z`' => 'ʐ',
        'B\\' => 'ʙ',
        'G\\' => 'ɢ',
        'H\\' => 'ʜ',
        'I\\' => 'ᵻ',
        'J\\' => 'ɟ',
        'K\\' => 'ɮ',
        'L\\' => 'ʟ',
        'M\\' => 'ɰ',
        'N\\' => 'ɴ',
        'O\\' => 'ʘ',
        'R\\' => 'ʀ',
        'U\\' => 'ᵿ',
        'X\\' => 'ħ',
        ':\\' => 'ˑ',
        '@\\' => 'ɘ',
        '3\\' => 'ɞ',
        '?\\' => 'ʕ',
        '<\\' => 'ʢ',
        '>\\' => 'ʡ',
        '!\\' => 'ǃ',
        '|\\' => 'ǀ',
        '=\\' => 'ǂ',
        '-\\' => '‿',
        '||' => '‖',
        '_j' => 'ʲ',
        '_+' => ' ̟',
        '_"' => ' ̈',
        '_+' => ' ̟',
        '_-' => ' ̠',
        '_/' => ' ̌',
        '_0' => ' ̥',
        '_=' => ' ̩',
        '_>' => 'ʼ',
        '_\\' => ' ̂',
        '_^' => ' ̯',
        '_}' => ' ̚',
        '_~' => ' ̃',
        '_A' => ' ̘',
        '_a' => ' ̺',
        '_B' => ' ̏',
        '_c' => ' ̜',
        '_d' => ' ̪',
        '_e' => ' ̴',
        '_F' => ' ̂',
        '_G' => 'ˠ',
        '_H' => ' ́',
        '_h' => 'ʰ',
        '_k' => ' ̰',
        '_L' => ' ̀',
        '_l' => 'ˡ',
        '_M' => ' ̄',
        '_m' => ' ̻',
        '_N' => ' ̼',
        '_n' => 'ⁿ',
        '_O' => ' ̹',
        '_o' => ' ̞',
        '_q' => ' ̙',
        '_R' => ' ̌',
        '_r' => ' ̝',
        '_T' => ' ̋',
        '_t' => ' ̤',
        '_v' => ' ̬',
        '_w' => 'ʷ',
        '_X' => ' ̆',
        '_x' => ' ̽',
        '@`' => 'ɚ',
        /* one character strings */
        'a' => 'a',
        'b' => 'b',
        'c' => 'c',
        'd' => 'd',
        'e' => 'e',
        'f' => 'f',
        'g' => 'ɡ',
        'h' => 'h',
        'i' => 'i',
        'j' => 'j',
        'k' => 'k',
        'l' => 'l',
        'm' => 'm',
        'n' => 'n',
        'o' => 'o',
        'p' => 'p',
        'q' => 'q',
        'r' => 'r',
        's' => 's',
        't' => 't',
        'u' => 'u',
        'v' => 'v',
        'P' => 'ʋ',
        'w' => 'w',
        'x' => 'x',
        'y' => 'y',
        'z' => 'z',
        'A' => 'ɑ',
        'B' => 'β',
        'C' => 'ç',
        'D' => 'ð',
        'E' => 'ɛ',
        'F' => 'ɱ',
        'G' => 'ɣ',
        'H' => 'ɥ',
        'I' => 'ɪ',
        'J' => 'ɲ',
        'K' => 'ɬ',
        'L' => 'ʎ',
        'M' => 'ɯ',
        'N' => 'ŋ',
        'O' => 'ɔ',
        'Q' => 'ɒ',
        'R' => 'ʁ',
        'S' => 'ʃ',
        'T' => 'θ',
        'U' => 'ʊ',
        'V' => 'ʌ',
        'W' => 'ʍ',
        'X' => 'χ',
        'Y' => 'ʏ',
        'Z' => 'ʒ',
        '.' => '.',
        '"' => 'ˈ',
        '%' => 'ˌ',
        '\'' => 'ʲ',
        ':' => 'ː',
        '-' => '',
        '@' => 'ə',
        '{' => 'æ',
        '}' => 'ʉ',
        '1' => 'ɨ',
        '2' => 'ø',
        '3' => 'ɜ',
        '4' => 'ɾ',
        '5' => 'ɫ',
        '6' => 'ɐ',
        '7' => 'ɤ',
        '8' => 'ɵ',
        '9' => 'œ',
        '&' => 'ɶ',
        '?' => 'ʔ',
        '^' => 'ꜛ',
        '!' => 'ꜜ',
        '|' => '|',
        '=' => ' ̩',
        '`' => '˞',
        '~' => ' ̃',
    );

    /**
     * Return the X-SAMPA / IPA mappings
     *
     * This is the getter for the class.
     * This process is slightly complicated by the possible presence of a blank character
     * in combination with a combining mark. It's hard to work with combining marks that are
     * not attached to some 'host' character, but when you apply the filter, you want the
     * combining mark to attach itself to the previous character in the string. The preg_prelace()
     * removes the blank space so that the mapping is directly to the combining mark.
     *
     * @uses this::$filteripamappings
     * @return array All the mappings
     */
    public function filter_ipa_return_mappings() {
        $mappings = $this->filteripamappings;
        foreach ($mappings as $key => $mapping) {
            $mappings[$key] = preg_replace('/\x{0020}/', '', $mapping);
        }
        return $mappings;
    }
}

