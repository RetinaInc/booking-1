<h2><?php echo $title;?></h2>
<?php

echo anchor($this->lang->line('webshop_folder')."courses/admin/weekhome",'Create Week', array('class'=>'week_date'))."\n";
echo anchor($this->lang->line('webshop_folder')."courses/admin/datehome",'Create Date', array('class'=>'week_date'))."\n";

// showing weekly schedule for reference
// use dropdown to change week
// toggle here as well
echo "<div class='clear'>\n<a href='#'class='toggleme'><p  id='showhide'>Show/Hide Shedule</p></a>\n";
echo "<div class='clear' id='togglethis'>\n";
echo "<div id='weeksubmit'>\n";
echo form_open('courses/admin/index',array('id'=>'autosubmit'));
echo "\n<label for='week_id'>Select Week</label>\n";
echo form_dropdown('week_id',$weeklist) ."\n";
echo form_submit('submit','Change Week');
echo form_close();
echo "</div>\n";

if($types){
    echo "<ul id='filter'>\n";
    echo "<li><a href='all'>all</a></li>";
    foreach ($types as $type){
        if(!empty($type)){
            echo "<li><a href='".$type."'>".$type."</a></li>\n";
        }       
    }
    //print_r ($types);
    echo "</ul>\n";
}
// first display weeks
/*
echo "\n<ul id='weeklist'>\n";
foreach ($weekdatelist as $key => $datelist){

 // if date_created exist then conver it to European way from MwSQL way
            if($datelist['date']){
                $newdatecreated =new DateTime($datelist['date']) ;

            }else{
                $newdatecreated = NULL;
            }
            echo "<li class='listdate'>".$newdatecreated->format('l d-m-Y')."</li>\n";

    }
  echo "</ul>\n";
*/
  // display courses

 echo "\n<ul id='coursenav' class='clear'>\n";
foreach ($courselist as $key => $course){
    echo "<li class='menuone'><p>".$key."</p>\n";
   if ($course[0]['course_name']){
        echo "<ul class='dateul'>\n";
        foreach ($course as $keyid => $detail){
            echo "<li class='courseli ".$detail['type']."'>\n";

            echo "<p>".$detail['time']."</p>\n";
            echo "<p>".$detail['trainer_name']."</p>\n";
            // it might be better to use anchor
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."/fitness/calltrainer/".$detail['trainer_id'],$detail['course_name'],array('class'=>'coursedetails'));
            echo "</p>\n";
             echo "<p>".$detail['booked']." / ".$detail['capacity']."</p>\n";
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."courses/admin/edit_course/".$detail['id'],'Edit');
            echo " | ";
            echo anchor($this->lang->line('webshop_folder')."courses/admin/delete_course/".$detail['id'],'Delete');
            echo "</p>\n";
            //echo "<p><a href='../../fitness/calltrainer/".$detail['trainer_id']."' class='coursedetails'>".$detail['course_name']."</a></p>";
            echo "</li>\n";
    }
    echo "</ul>\n";

   }

       echo "</li>\n";

}
 echo "</li>\n";
 echo "</ul>\n</div>\n</div>\n";

 // form to create new
echo form_open('courses/admin/index');

echo "\n<ul id='createcourse' class='clear'>\n";

echo "<li><label for='date_id'>Date</label>\n";
$datelistid = 'id="datelist"';
echo form_dropdown('date_id',$datelist,'',$datelistid) ."</li>\n";

echo "\n<li><label for='time'>Time</label>\n";
$data = array('name'=>'time','id'=>'time','size'=>6);
echo form_input($data) ."</li>\n";

echo "<li><label for='course_name'>Course Name</label>\n";
$data = array('name'=>'course_name','id'=>'order','size'=>40);
echo form_input($data) ."</li>\n";

// trainers dropdown
echo "<li><label for='trainer_id'>Trainer</label>\n";
echo form_dropdown('trainer_id',$trainers) ."</li>\n";

echo "<li class='clear'><label for='capacity'>Course Max Capacity</label>\n";
$data = array('name'=>'capacity','id'=>'capacity','size'=>5);
echo form_input($data) ."</li>\n";

echo "<li><label for='booked'>Number Bookded</label>\n";
$data = array('name'=>'booked','id'=>'booked','size'=>5);
echo form_input($data) ."</li>\n";

echo "<li><label for='active'>Active</label>\n";
$options = array('1' => 'active', '0' => 'inactive');
echo form_dropdown('active',$options) ."</li>\n";

echo "<li><label for='type'>Type</label>\n";
$data = array('name'=>'type','id'=>'type','size'=>5);
echo form_input($data) ."</li>\n";

echo "<li><label for='desc'>Description</label>\n";
$data = array('name'=>'desc','id'=>'desc','cols'=>200, 'rows'=>5);
echo form_textarea($data) ."</li>\n";


echo "<li id='submit'>";
echo form_submit('submit','Create New Course');
echo "</li></ul>";
echo form_close();

echo "\n<div class='clear'>&nbsp;</div>\n";


/*


echo "weekdatelist<pre>";
print_r ($datelist);
echo "</pre>";

echo "firstweek<pre>";
print_r ($firstweek);
echo "</pre><br />";

echo "weeklist<pre>";
print_r ($weeklist);
echo "</pre>";

echo "types<pre>";
print_r ($types);
echo "</pre>";

echo "<pre>";
print_r ($courselist);
echo "</pre>";

*/


?>
