<?php
/**
 * Simple file test_custom.php to drop into root of Moodle installation.
 * This is an example of using a sql_table class to format data.
 */
require "../../config.php";
require "$CFG->libdir/tablelib.php";
require_once('filter_form.php');
require "allcourses_table.php";
global $OUTPUT, $PAGE;

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

// Define headers
$PAGE->set_title('Available courses');
$PAGE->set_heading('Available courses');

if($filterform->is_cancelled()) {

	$courseurl = new moodle_url('/blocks/ps_availablecourses/allcourses.php');
	redirect($courseurl);

} else if ($fromform = $filterform->get_data()) {

	$url = new moodle_url($CFG->wwwroot.'/blocks/ps_availablecourses/allcourses.php?code='.$fromform->filter_code);
    redirect($url);

    //commented this since the filter should be through get method.
	//$sqlconditions = "course_code = '".$fromform->filter_code."' AND ";
	/*$site = get_site();
	echo $OUTPUT->header(); //output header
	$filterform->display();
	echo "<hr>";
	// Get the course table.
	$fields = '*';
	$from = "{block_ps_selfstudy_course}";
	$sqlconditions .= '1';
	$table->set_sql($fields, $from, $sqlconditions);
	$table->define_baseurl("$CFG->wwwroot/blocks/ps_availablecourses/allcourses.php");
	$table->out(30, true); //print table
	echo $OUTPUT->footer();*/

} else {

	//if was filtered, look for the code.
	if(isset($_GET['code'])) {
		$course_code = $_GET['code'];
		$sqlconditions = "course_code = '".$course_code."'";
	} else {
		$sqlconditions = '1';
	}

	$site = get_site();
	echo $OUTPUT->header(); //output header
	$filterform->display();
	echo "<hr>";
	//sql to get all requests
	$fields = '*';
	$from = "{block_ps_selfstudy_course}";
	//$sqlconditions = '1';
	$table->set_sql($fields, $from, $sqlconditions);
	$table->define_baseurl("$CFG->wwwroot/blocks/ps_availablecourses/allcourses.php");
	$table->out(30, true); //print table
	echo $OUTPUT->footer();

}