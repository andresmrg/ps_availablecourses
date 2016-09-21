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
 * Define the table, headers and columns to display list of courses.
 * @package     block_ps_availablecourses
 * @copyright   2015 Andres Ramos
 */

class allcourses_table extends table_sql {

    /**
     * Constructor
     * @param int $uniqueid all tables have to have a unique id, this is used
     *      as a key when storing table properties like sort order in the session.
     */
    public function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // Define the list of columns to show.
        $columns = array('course_code', 'course_platform', 'course_name',
                        'course_description', 'course_hours', 'course_type', 'actions');
        $this->sortable(true, 'course_code', SORT_ASC);
        $this->collapsible(false);
        $this->no_sorting('actions');
        $this->no_sorting('course_description');
        $this->define_columns($columns);

        // Define the titles of columns to show in header.
        $headers = array('Course Code', 'Course Platform', 'Course Name', 'Description', 'Hours', 'Course Type', 'Action');
        $this->define_headers($headers);
    }

    /**
     * Generate the display of the course's code column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_course_code($values) {

        global $DB;
        $descriptionlink = $DB->get_record('block_ps_selfstudy_course', array('id' => $values->id), $fields = 'description_link');
        $url = $descriptionlink->description_link;

        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        if (!empty($descriptionlink)) {
            return '<a href="'.$url.'" target="_blank" style="text-decoration:underline;">' . $values->course_code . '</a>';
        } else {
            return $values->course_code;
        }
    }

    /**
     * Generate the display of the course's name column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_course_name($values) {
        $coursename = $values->course_name;
        return '<p style="width: 100%; height: 60px; margin: 0; padding: 0; overflow: auto;">' . $coursename . '</p>';
    }

    /**
     * Generate the display of the course's description column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_course_description($values) {
        $description = $values->course_description;
        return '<p style="width: 100%; height: 60px; margin: 0; padding: 0; overflow: auto;">' . $description . '</p>';
    }

    /**
     * Generate the display of the course's type column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_course_type($values) {

        // If the value is 0, show Phisical copy, else, Link course.
        if ($values->course_type == 0) {
            $str = get_string('physicalcopy', 'block_ps_availablecourses');
        } else {
            $str = get_string('linkcourse', 'block_ps_availablecourses');
        }

        return $str;
    }

    /**
     * Generate the display of the course's status column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_course_status($values) {
        // If the value is 0, show Active copy, else, Disable.
        if ($values->course_status == 0) {
            return get_string('active', 'block_ps_availablecourses');
        } else {
            return get_string('disable', 'block_ps_availablecourses');
        }
    }

    /**
     * Generate the display of the course's creationg date column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_date_created($values) {
        // Show readable date from timestamp.
        $date = $values->date_created;
        return date("m/d/Y", $date);
    }

    /**
     * Generate the display of the action column.
     * @param object $values the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_actions($values) {
        global $DB, $CFG;

        // Show readable date from timestamp.
        if ($values->course_type == 0) {
            $requesturl = $CFG->wwwroot."/blocks/ps_selfstudy/requestcourse.php?id=".$values->id;
            $returnurl = '<a href="' . $requesturl . '">' . get_string('requestcourse', 'block_ps_availablecourses') . '</a>';
        } else {
            $requesturl = $CFG->wwwroot."/blocks/ps_selfstudy/action.php?action=go&courseid=".$values->id;
            $returnurl = '<a href="' . $requesturl . '" target="_blank">' . get_string('requestcourse', 'block_ps_availablecourses') . '</a>';
        }

        return $returnurl;
    }
}