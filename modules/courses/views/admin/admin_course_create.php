<h2><?php echo $title;?></h2>

<?php
// showing weekly schedule for reference
// use dropdown to change week
// toggle here as well
echo "<div><a href='#'class='toggleme'>Show/Hide Shedule</a>";
echo "<div id='togglethis'>";
echo "<div id='weeksubmit'>";
echo form_open('courses/admin/create',array('id'=>'autosubmit'));
echo "\n<label for='weekid'>Select Week</label>\n";
echo form_dropdown('weekid',$weeklist) ."\n";
echo form_submit('submit','Change Week');
echo form_close();
echo "</div>\n";

if($types){
    echo "<ul id='filter'>\n";
    foreach ($types as $type){
        if($type == NULL){
            $type = 'all';
        }

        echo "<li><a href='".$type."'>".$type."</a></li>\n";
    }
    //print_r ($types);
    echo "</ul>\n";
}
// creating a calendar style schedule. this is more easy to see
// add 'add schedule link with ajax?
echo "\n<ul id='weeknav'>";
foreach ($weeknav as $key => $schedule){
    echo "\n<li class='menuone'>\n";
    echo $schedule['name'];
        if (count($schedule['children'])){
           echo "\n<ul class='applications' >";
            foreach ($schedule['children'] as $subkey => $subschedule){
              echo "\n<li class='menutwo ".$subschedule['type']."' data-id='id-".$subschedule['id']."' data-type='".$subschedule['type']."'>\n";
              echo anchor($this->lang->line('webshop_folder')."/fitness/calltrainer/".$subschedule['trainer_id'],$subschedule['name'],array('class'=>'coursedetails'));
              echo "<p>".$subschedule['course']."</p>";
              $trainerid = $subschedule['trainer_id'];
              $trainer = $this->MFitness->getTrainerDetails($trainerid);
              echo "<p>".$trainer['trainer_name']."</p>";

              //echo "<p><a href='/fitness/booking/".$schedule['id']."'>Book here</a></p>";
              echo "\n</li>";
            }
        echo "\n</ul>";
    }
    echo "\n</li>\n";
    }
  echo "\n</ul>\n\n</div>\n</div>";

  // form to create new 
echo form_open('courses/admin/create');

echo "<ul>";

echo "<p><label for='week_day_time'>Week Day Time</label><br/>\n";
$options = array('1' => 'week', '2' => 'day', '3' => 'time');
echo form_dropdown('week_day_time',$options) ."</p>\n";


echo "\n<li><label for='name'>Name (Uke40 (04/10 - 10/10) or Mandag 04/10 or 11:00-12:00)</label><br/>\n";
$data = array('name'=>'name','id'=>'name','size'=>25);
echo form_input($data) ."</li>\n";

echo "<p><label for='date'>Date</label>\n";
$data = array('name'=>'date','id'=>'DateTime','size'=>15);
echo form_input($data) ."</p>\n";

echo "<div class='clear'>&nbsp;</div>";

echo "<p><label for='parentid'>Parent Week/Date</label><br/>\n";
echo form_dropdown('parentid',$courses) ."</p>\n";

echo "<p><label for='order'>Order</label><br/>\n";
$data = array('name'=>'order','id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";

// trainers dropdown
echo "<p><label for='trainer_id'>Trainer</label><br/>\n";
echo form_dropdown('trainer_id',$trainers) ."</p>\n";

echo "<p><label for='course'>Course Name</label><br/>\n";
$data = array('name'=>'course','id'=>'course','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='capacity'>Course Max Capacity</label><br/>\n";
$data = array('name'=>'capacity','id'=>'capacity','size'=>5);
echo form_input($data) ."</p>\n";

echo "<p><label for='booked'>Number Bookded</label><br/>\n";
$data = array('name'=>'booked','id'=>'booked','size'=>5);
echo form_input($data) ."</p>\n";

echo "<p><label for='active'>Active</label><br/>\n";
$options = array('1' => 'active', '0' => 'inactive');
echo form_dropdown('active',$options) ."</p>\n";

echo "<p><label for='type'>Type</label><br/>\n";
$data = array('name'=>'type','id'=>'type','size'=>5);
echo form_input($data) ."</p>\n";


echo form_submit('submit','Create Scheduleenu');
echo form_close();

echo "<pre>";
//print_r ($pages);
echo "</pre>";
?>