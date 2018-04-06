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
 * This file explains this plugins status in relation to the GDPR.
 *
 * @package    filter_ipa
 * @copyright  2018 Kevin Wiliarty
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace filter_ipa\privacy;

defined('MOODLE_INTERNAL') || die;

/**
 * A provider class to address GDPR
 *
 * @package    filter_ipa
 * @copyright  2018 CLAMP
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\metadata\null_provider {

    /**
     * Get the language string identifier from the component's language
     * file to explain why this plugin stores no data.
     *
     * @return string
     */
    public static function get_reason() {
        return 'privacy:null_reason';
    }
}