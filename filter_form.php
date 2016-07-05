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
 * Class that generates the filter form.
 *
 * @package    block_ps_availablecourses
 * @copyright  2015 Andres Ramos
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("{$CFG->libdir}/formslib.php");

class filter_form extends moodleform {

    public function definition() {
        global $DB;

        $mform = & $this->_form;

        // Filter by platform.
        $sql = 'SELECT course_platform FROM {block_ps_selfstudy_course} GROUP BY course_platform';
        $platformlist = $DB->get_records_sql($sql);

        $platform = array('Select Platform...');
        foreach ($platformlist as $value) {
            $platform[$value->course_platform] = $value->course_platform;
        }
        $mform->addElement('select', 'platform', "Filter by Platform", $platform);

        // Add course name.
        $mform->addElement('text', 'filter_code', get_string('field_filtercode', 'block_ps_selfstudy'));
        $mform->setType('filter_code', PARAM_NOTAGS);

        $buttonarray = array();
        $buttonarray[] =& $mform->createElement('submit', 'submit_button', get_string('submitbutton', 'block_ps_selfstudy'));
        $buttonarray[] =& $mform->createElement('cancel', 'cancel_button', get_string('resetbutton', 'block_ps_selfstudy'));
        $mform->addGroup($buttonarray, 'buttonarray', '', '', false);

    }

}