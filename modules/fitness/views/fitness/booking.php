<?php
echo "<h1>".$title."</h1>";
if ($this->uri->segment(3)){
    echo "You have booked the following course.";
    echo "<ul>\n";
    echo "<li>";
    echo $coursedetails->course_name;
    echo "</li>";
    echo "<li>";
    echo $coursedetails->time;
    echo "</li>";
    echo "</ul>";
}

echo "Hello ".$this->session->userdata('username');
echo "<br />";
echo $this->session->userdata('email');
echo "<h3>";
echo anchor("fitness/index",'Go back to Home');
echo "</h3>";

echo '<h2>$allbookings</h2>';
echo "\n<ul id='allbookings' class='clear'>\n";
foreach ($allbookings as $key => $course){
    echo "<li class='menuone'><p>".$key."</p>";
   if ($course[0]['course_name']){
        echo "<ul class='dateul'>\n";
        foreach ($course as $keyid => $detail){
            echo "<li class='courseli ".$detail['type']."'>";
            echo "<p>".$detail['name']."</p>";
            echo "<p>".$detail['time']."</p>";
            echo "<p>".$detail['trainer_name']."</p>";
            // it might be better to use anchor
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."/fitness/calltrainer/".$detail['trainer_id'],$detail['course_name'],array('class'=>'coursedetails'));
            echo "</p>";
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."fitness/deletebooking/".$detail['booking_id'],'Delete');
            echo "</p>";
            //echo "<p><a href='../../fitness/calltrainer/".$detail['trainer_id']."' class='coursedetails'>".$detail['course_name']."</a></p>";
            echo "</li>";
    }
    echo "</ul>";

   }

       echo "</li>";

}
 echo "</li>";
 echo "</ul>";


echo "<div class='clear'>&nbsp;</div>";

echo '<h2>$bookings</h2>';
echo "<ul id='booking'>";
foreach ($bookings as $key => $detail){
            echo "<li class='bookingli'>";
            echo "<p>".$detail->date."</p>";
            echo "<p>".$detail->time."</p>";
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."/fitness/calltrainer/".$detail->trainer_id,$detail->course_name,array('class'=>'coursedetails'));
            echo "</p>";
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."courses/admin/delete/".$detail->id,'Delete');
            echo "</p>";
            echo "</li>";
    }
  echo "\n</ul>\n";
  

echo "<pre>bookings";
print_r ($bookings);
echo "</pre><br />";

echo "<pre>allbookings";
print_r ($allbookings);
echo "</pre><br />";

echo "<pre>coursedetails";
print_r ($coursedetails);
echo "</pre><br />";
?>