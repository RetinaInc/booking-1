<ul id="filter">
   
    <li><a href="all">Everything</a></li>
    <li><a href="red">Red</a></li>
    <li><a href="green">Green</a></li>
    <li><a href="blue">Blue</a></li>
     <li><a href="white">White</a></li>
 </ul>

<?php
// showing weekly schedule for reference
// use dropdown to change week
echo "<div id='weeksubmit'>";
echo form_open('courses/admin/',array('id'=>'autosubmit'));
echo "\n<label for='weekid'>Select Week</label>\n";
echo form_dropdown('weekid',$weeklist) ."\n";
echo form_submit('submit','Change Week');
echo form_close();
echo "</div>";

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
  echo "\n</ul>\n";

?>