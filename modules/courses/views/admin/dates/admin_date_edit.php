<h2><?php echo $title;?></h2>
<?php
//print_r ($week);
 // form to create new date
echo form_open('courses/admin/editdate');

echo "<ul id='createweek' class='clear'>\n";

echo "<li><label for='week_id'>Week</label>\n";
echo form_dropdown('week_id', $weeklist, $date->week_id);
echo "</li>";

echo "<li><label for='date'>Date</label>\n";
$data = array('name'=>'date','id'=>'date','size'=>10, 'value' => $date->date);
echo form_input($data) ."</li>\n";

echo "<li>".form_hidden('date_id',$date->date_id)."</li>";

echo "<li id='submit'>\n";
echo form_submit('submit','Update New Date');
echo "</li>\n";
echo form_close();


?>