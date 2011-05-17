<h2><?php echo $title;?></h2>
<?php
// Display what we have now.
/*
echo "datelist<pre>";
print_r ($datelist);
echo "</pre>";
*/

 echo "\n<ul id='dateul' class='clear'>\n";
foreach ($datelist as $key => $dates){
    echo "<li class='horizonone clear'><p>".$key."</p>\n";
   if ($dates[0]['date']){
        echo "<ul class='dateul'>\n";
        foreach ($dates as $keyid => $detail){
            echo "<li class='dateli ".$detail['date']."'>\n";

           echo "<p>".$detail['date']."</p>\n";
         //   echo "<p>".$detail['trainer_name']."</p>";
            // it might be better to use anchor
           echo "<p class='clear'>";
             echo anchor($this->lang->line('webshop_folder')."/courses/admin/editdate/".$detail['date_id'],'Edit');
             echo " | ";
             echo anchor($this->lang->line('webshop_folder')."/courses/admin/deletedate/".$detail['date_id'],'Delete');
             echo "</p>";
            //echo "<p><a href='../../fitness/calltrainer/".$detail['trainer_id']."' class='coursedetails'>".$detail['course_name']."</a></p>";
            echo "</li>\n";
    }
    echo "</ul>\n";

   }

       echo "</li>\n";

}
 echo "</li>\n";
 echo "</ul>\n";



 // form to create new date
echo form_open('courses/admin/datehome');

echo "<ul id='createweek' class='clear'>\n";

echo "<li><label for='week_id'>Week</label>\n";
echo form_dropdown('week_id', $weeklist);
echo "</li>";

echo "<li><label for='date'>Date</label>\n";
$data = array('name'=>'date','id'=>'date','size'=>10);
echo form_input($data) ."</li>\n";


echo "<li id='submit'>\n";
echo form_submit('submit','Create New Date');
echo "</li>\n";
echo form_close();

?>