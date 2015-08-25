<?php
/**
 * Simple file test_custom.php to drop into root of Moodle installation.
 * This is an example of using a sql_table class to format data.
 */
require "../../config.php";
require "$CFG->libdir/tablelib.php";
require "allcourses_table.php";
global $OUTPUT, $PAGE;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ps_selfstudy/allcourses.php');
$PAGE->set_pagelayout('standard');
$table = new allcourses_table('uniqueid');

// Define headers
$PAGE->set_title('Available courses');
$PAGE->set_heading('Available courses');

$site = get_site();
echo $OUTPUT->header(); //output header
// Get the course table.
$table->set_sql('*', "{block_ps_selfstudy_course}", '1');
$table->define_baseurl("$CFG->wwwroot/blocks/ps_availablecourses/allcourses.php");
$table->out(10, true); //print table
echo $OUTPUT->footer();




