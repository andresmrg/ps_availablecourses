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
        
        //get courses only copies type
        $courses = $DB->get_records('block_ps_selfstudy_course', array ('course_type'=>'0','course_status'=>'0'), $sort='', $fields='*', $limitfrom=0, $limitnum=0);
        
        //on each course
        foreach($courses as $key => $value) {
        	//build url and built array of items
        	$this->content->items[] = '<div style="text-align:center"><a href="#">'.$value->course_name.'</a>';

        }
        $this->content->footer = '<div style="text-align:center"><a href="#">See full list</a></div>';
        //$this->content->footer = html_writer::link('/blocks/ps_availablecourses/allcourses.php', 'See full list', array('id' => 'psfootercenter'));
        //$this->content->footer = html_writer::link('/blocks/ps_availablecourses/allcourses.php', 'See full list');

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