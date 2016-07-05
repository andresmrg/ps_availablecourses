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
 * Display all selfstudy courses
 * @package     block_ps_selfstudy
 * @copyright   2015 Andres Ramos
 */

require_once(__DIR__ . '/../../config.php');
require($CFG->libdir . '/tablelib.php');
require_once('filter_form.php');
require('allcourses_table.php');
global $OUTPUT, $PAGE;

// Prevent guest user from seeing this page.
require_login();
if (isguestuser()) {
    print_error('guestsarenotallowed');
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ps_availablecourses/allcourses.php');
$PAGE->set_pagelayout('standard');
$table = new allcourses_table('uniqueid');
$filterform = new filter_form();

// Define headers.
$PAGE->set_title('Available courses');
$PAGE->set_heading('Available courses');
// Nav breadcump.
$PAGE->navbar->add('Available courses');

// Get params from URL.
$code = optional_param('code',  0,  PARAM_NOTAGS);
$platform = optional_param('platform',  0,  PARAM_NOTAGS);

if ($filterform->is_cancelled()) {

    $courseurl = new moodle_url('/blocks/ps_availablecourses/allcourses.php');
    redirect($courseurl);

} else if ($fromform = $filterform->get_data()) {

    $builturl = '';
    if ($fromform->platform) {
        $builturl .= 'platform='.$fromform->platform.'&';
    }
    if ($fromform->filter_code) {
        $builturl .= 'code='.$fromform->filter_code.'&';
    }
    $builturl = rtrim($builturl, "&");

    $url = new moodle_url($CFG->wwwroot.'/blocks/ps_availablecourses/allcourses.php?'.$builturl);
    redirect($url);

} else {

    // Add filters to the query.
    $sqlconditions = '';
    if ($code) {
        $sqlconditions .= "course_code = '".$code."' AND ";
    }
    if ($platform) {
        $sqlconditions .= "course_platform = '".$platform."' AND ";
    }

    // Remove AND at the end of the line if any.
    $sqlconditions = rtrim(trim($sqlconditions, " "), "AND");

    if (!$sqlconditions) {
        $sqlconditions = '1';
    }

    $site = get_site();
    echo $OUTPUT->header(); // Output header.
    $filterform->display();
    echo "<hr>";

    // SQL to get all requests.
    $fields = '*';
    $from = "{block_ps_selfstudy_course}";

    // Put a fixed height for the rows and expand the course name column 20%.
    $table->column_style('course_name', 'width', '20%');
    $table->column_style_all('height', '60px');
    $table->set_sql($fields, $from, $sqlconditions);
    $table->define_baseurl("$CFG->wwwroot/blocks/ps_availablecourses/allcourses.php");
    $table->out(30, true);
    echo $OUTPUT->footer();

}