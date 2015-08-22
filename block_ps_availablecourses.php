<?php

require_once('/config.php');



class block_ps_availablecourses extends block_list {

	public function init() {
		$this->title = get_string('selfstudy','block_ps_availablecourses');
	}

	public function get_content() {
		
		global $DB, $OUTPUT;

		if ($this->content !== null) {
	      return $this->content;
	    }

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        
        //introduction
        $this->content->items[] = "<p>In this section you can find the list of all self-study courses. Click on the course for more information or click on See full list to display all courses.</p>";
        
        //get courses only copies type
        $courses = $DB->get_records('block_ps_selfstudy_course', array ('course_type'=>'0','course_status'=>'0'), $sort='', $fields='*', $limitfrom=0, $limitnum=0);
        foreach($courses as $key => $value) {
        	//build the list of courses
        	$this->content->items[] = '<div><a href="#">'.$value->course_name.'</a></div>';
        }
        $this->content->footer = '<br><div style="text-align:center"><a href="blocks/ps_availablecourses/allcourses.php">See full list</a></div>';

	    return $this->content;
	}   // Here's the closing bracket for the class definition

	public function applicable_formats() {
	  return array(
	           'site-index' => true,
	          'course-view' => true, 
	   'course-view-social' => true,
	                  'mod' => true, 
	             'mod-quiz' => true
	  );
	}

	public function instance_allow_multiple() {
    return false;
    }

    //Allow configurations
    function has_config() {
        return false;
    }

}