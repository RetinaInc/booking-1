<h2><?php echo $title;?></h2>
<p><?php echo anchor("courses/admin/createnew", "Create new course");?></p>

<?php

echo "<pre>";
print_r ($weeklist);
echo "</pre>";

echo "<pre>";
print_r ($datelist);
echo "</pre>";




echo form_open('courses/admin/createnew');
echo "\n<ul>\n";
echo "<li>\n<label for='date_id'>Date</label>\n";
echo form_dropdown('date_id',$datelist) ."</li>\n";

echo "<li>\n<label for='time'>Time</label>\n";
$data = array('name'=>'time','id'=>'time','size'=>20);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='course_name'>Course Name</label>\n";
$data = array('name'=>'course_name','id'=>'course_name', 'size'=>50);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='trainer_id'>Trainer</label>\n";
echo form_dropdown('trainer_id',$trainers) ."</li>\n";

echo "<li>\n<label for='desc'>Description</label>\n";
$data = array('name'=>'desc','id'=>'desc','size'=>90);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='capacity'>Capacity</label>\n";
$data = array('name'=>'capacity','id'=>'capacity','size'=>10);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='active'>Active</label>\n";
$options = array('1' => 'active', '0' => 'inactive');
echo form_dropdown('active',$options) ."</li>\n";

echo "<li>\n<label for='order'>Order</label>\n";
$data = array('name'=>'order','id'=>'order','size'=>10);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='booked'>Number Bookded</label>\n";
$data = array('name'=>'booked','id'=>'booked','size'=>5);
echo form_input($data) ."</li>\n";

echo "<li>\n<label for='type'>Type</label>\n";
$data = array('name'=>'type','id'=>'type','size'=>5);
echo form_input($data) ."</li>\n";

echo form_submit('submit','Create Course');
echo "</ul>";
echo form_close();


?>
