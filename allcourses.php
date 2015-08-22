<?php

require_once('../../config.php');
//require_once('course_form.php');
//require_once('allcourses_form.php');

global $DB, $OUTPUT, $PAGE;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ps_availablecourses/allcourses.php');
$PAGE->set_pagelayout('standard');

/*
1. get records from db
2. display records in the box, title, description and a button

*/

//get courses only copies type
$courses = $DB->get_records('block_ps_selfstudy_course', array ('course_type'=>'0','course_status'=>'0'), $sort='', $fields='*', $limitfrom=0, $limitnum=0);

$site = get_site();
echo $OUTPUT->header();
foreach($courses as $key => $value) {
	echo $OUTPUT->box('
		<div style="border:solid 1px #CCC; padding: 20px; margin-bottom: 10px;">
			<strong>Course Title:</strong> '.$value->course_name.'<br><br>
			<p>'.$value->course_description.'</p>
			<a class="ps_request_button" href="'.$CFG->wwwroot.'/blocks/ps_selfstudy/requestcourse.php?id='.$value->id.'">Request Course</a>
		</div>');
}
echo $OUTPUT->footer();



// form didn't validate or this is the first display