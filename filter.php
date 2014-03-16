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
require_once(dirname(__FILE__) . '/lib.php');

/**
 * Automatic X-SAMPA / IPA filter class.
 *
 * @package    filter_ipa
 * @copyright  2014 onwards Kevin Wiliarty {@link http://kevinwiliarty.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_ipa extends moodle_text_filter {

    /** @var array Correspondences between X-SAMPA and unicode */
    protected $mappings;

    /**
     * Load the mappings from the local library.
     */
    public function __construct() {
        $mappings = new filter_ipa_mappings();
        $this->mappings = $mappings->filter_ipa_return_mappings();
    }

    /**
     * Replace each character within the X-SAMPA markup with its corresponding unicode IPA.
     *
     * @see filter()
     * @uses self::$mappings
     * @param string $markup An X-SAMPA string to be converted to unicode IPA.
     * @return string Unicode IPA
     */
    public function ipa_replace_chars($markup) {
        $mappings = $this->mappings;
        $asciis = array_keys($mappings);
        $utf8s = array_values($mappings);
        $ipatext = str_replace($asciis, $utf8s, $markup);
        return $ipatext;
    }

    /**
     * Returns the X-SAMPA / IPA mappings in JSON format for use by other modules
     *
     * @uses self::$mappings
     * @return string JSON representation of the X-SAMPA / IPA mappings
     */
    public function return_ipa_json() {
        $mappings = $this->mappings;
        return json_encode($mappings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }

    /**
     * Filter content, rendering strings between '-{' and '}-' enclosures as unicode IPA
     *
     * @uses ipa_replace_chars()
     * @param string $text The content to be filtered whether it includes X-SAMPA stretches or not
     * @param array $options Options to pass to the filter
     * @return string The filtered content
     */
    public function filter($text, array $options = array()) {
        $ipastart = preg_quote(FILTER_IPA_START);
        $ipaend = preg_quote(FILTER_IPA_END);
        $needle = $ipastart . '(.*?)' . $ipaend;
        preg_match_all("/$needle/", $text, $ipas);
        foreach ($ipas[1] as $key => $markup) {
            $display = $this->ipa_replace_chars($markup);
            $span = html_writer::tag('span', $display, array('class' => 'filter-ipa'));
            $text = str_replace($ipas[0][$key], $span, $text);
        }
        return $text;
    }
}
