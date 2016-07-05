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
 * Block class that displays a text and a link to access to the list
 * of courses available to be requested.
 *
 * @package    block_ps_availablecourses
 * @copyright  2015 Andres Ramos
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_ps_availablecourses extends block_list {

    public function init() {
        $this->title = get_string('selfstudy', 'block_ps_availablecourses');
    }

    public function get_content() {

        global $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();

        // Intro.
        $this->content->items[] = get_string('intro', 'block_ps_availablecourses');

        $url1 = new moodle_url('/blocks/ps_availablecourses/allcourses.php');
        $this->content->footer = html_writer::link($url1, get_string('viewall', 'block_ps_availablecourses'));

        return $this->content;
    }

    /**
     * Defines where this block should be available.
     * @return array
     **/
    public function applicable_formats() {
        return array(
               'site-index' => true,
              'course-view' => true,
        'course-view-social' => true,
                      'mod' => true,
                 'mod-quiz' => true
        );
    }

    /**
     * Defines whether you can allow multiple instances of the same block.
     * @return true/false
     **/
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Defines where this block has configuration options.
     * @return false, so it doesn't have config.
     **/
    public function has_config() {
        return false;
    }

}