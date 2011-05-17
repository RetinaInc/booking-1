<h2><?php echo $title;?></h2>

<?php

 // form to create new
echo form_open('courses/admin/edit_course');

echo "\n<ul id='createcourse' class='clear'>\n";

echo "<li><label for='date_id'>Date</label>\n";
$datelistid = 'id="datelist"';
echo form_dropdown('date_id',$datelist,$course['date_id'],$datelistid) ."</li>\n";

echo "\n<li><label for='time'>Time</label>\n";
$data = array('name'=>'time','id'=>'time','size'=>6,'value' => $course['time']);
echo form_input($data) ."</li>\n";

echo "<li><label for='course_name'>Course Name</label>\n";
$data = array('name'=>'course_name','id'=>'order','size'=>40,'value' => $course['course_name']);
echo form_input($data) ."</li>\n";

// trainers dropdown
echo "<li><label for='trainer_id'>Trainer</label>\n";
echo form_dropdown('trainer_id',$trainers, $course['trainer_id']) ."</li>\n";


echo "<li class='clear'><label for='capacity'>Course Max Capacity</label>\n";
$data = array('name'=>'capacity','id'=>'capacity','size'=>5,'value' => $course['capacity']);
echo form_input($data) ."</li>\n";

echo "<li><label for='booked'>Number Bookded</label>\n";
$data = array('name'=>'booked','id'=>'booked','size'=>5,'value' => $course['booked']);
echo form_input($data) ."</li>\n";

echo "<li><label for='active'>Active</label>\n";
$options = array('1' => 'active', '0' => 'inactive');
echo form_dropdown('active',$options, $course['active']) ."</li>\n";

echo "<li><label for='type'>Type</label>\n";
$data = array('name'=>'type','id'=>'type','size'=>5,'value' => $course['type']);
echo form_input($data) ."</li>\n";

echo "<li><label for='desc'>Description</label>\n";
$data = array('name'=>'desc','id'=>'desc','cols'=>200, 'rows'=>5, 'value' => $course['desc']);
echo form_textarea($data) ."</li>\n";


echo form_hidden('id',$course['id']);

echo "\n<li id='submit'>\n";
echo form_submit('submit','Update Course');
echo "</li>\n</ul>\n";
echo form_close();
echo "\n<div class='clear'>&nbsp;</div>\n";
echo "\n<pre>";
print_r ($course);
echo "</pre>";
?>