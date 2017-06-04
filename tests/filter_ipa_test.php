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
 * Unit test for the filter_ipa
 *
 * @package    filter_ipa
 * @category   test
 * @copyright  2014 onwards Kevin Wiliarty <kevin.wiliarty@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/ipa/filter.php'); // Include the code to test.

/**
 * PHPUnit tests for filter_ipa substitutions.
 *
 * @package    filter_ipa
 * @copyright  2014 onwards Kevin Wiliarty <kevin.wiliarty@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_ipa_testcase extends basic_testcase {

    /**
     * Transform an associative array into an array of arrays
     *
     * @param array $teststrings An array of strings with ascii keys and IPA values
     * @return array $data An array of arrays to be treated as input and output
     */
    private function _pack_teststrings($teststrings) {

        $data = array();
        foreach ($teststrings as $ascii => $ipa) {
            $data[] = array($ascii, $ipa);
        }
        return $data;
    }

    /**
     * Package actual test strings into a data array
     *
     * @return array $data A populated array of arrays to be treated as input and output for tests
     */
    public function get_filter_ipa_conversion_tests() {

        $teststrings = array(
            '-{D@}-'       => 'ðə',
            '-{Iz}-'       => 'ɪz',
            '-{O\}-'       => 'ʘ',
            '-{b_<arU}-'   => 'ɓarʊ',
            '-{hu:d`}-'    => 'huːɖ',
            '-{"v6r\`i}-'  => 'ˈvɐɻi',
            '-{G\_<a}-'    => 'ʛa',
            '-{G\_&lt;a}-' => 'ʛa',
            "-{t'}-"       => 'tʲ',
            '-{&lt}-'      => 'ɶlt',
            '-{t_j}-'      => 'tʲ',
            "-{t3\:l'}-"   => 'tɞːlʲ',
            '-{m_0}-'      => 'm̥',
            '-{m_0=}-'     => 'm̥̩',
        );

        $data = $this->_pack_teststrings($teststrings);
        return $data;
    }

    /**
     * Provides some input and output to test embedding of filtered content
     *
     * @return array $data An array of arrays structured as input and output for testing
     */
    public function get_filter_ipa_embedding_tests() {

        $teststrings = array(
            'The search -{Iz}- over.' => 'The search <span class="filter-ipa">ɪz</span> over.',
            '-{D@}- search -{Iz}- over.' => '<span class="filter-ipa">ðə</span> search <span class="filter-ipa">ɪz</span> over.',
        );

        $data = $this->_pack_teststrings($teststrings);
        return $data;;
    }

    /**
     * Test simple string conversions
     *
     * @dataProvider get_filter_ipa_conversion_tests
     * @param string $ascii An ASCII string
     * @param string $ipa The expected IPA string result of filter conversion
     */
    public function test_convert_ascii_to_ipa($ascii, $ipa) {
        $testfilter = new filter_ipa();
        $testipa = $testfilter->filter($ascii);
        $this->assertEquals("<span class=\"filter-ipa\">$ipa</span>", $testipa);
    }

    /**
     * Test embedded string conversions
     *
     * @dataProvider get_filter_ipa_embedding_tests
     * @param string $ascii Text containing ASCII strings to be filtered
     * @param string $ipa The expected text output containing IPA string results of filter conversion
     */
    public function test_embedding($ascii, $ipa) {
        $testfilter = new filter_ipa();
        $testipa = $testfilter->filter($ascii);
        $this->assertEquals($ipa, $testipa);
    }
}
