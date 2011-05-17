<h2><?php echo $title;?></h2>
<?php
// Display what we have now.
/*
echo "courselist<pre>";
print_r ($weeks);
echo "</pre>";
*/
echo "<ul id='weekul'>";
if($weeks){
    foreach($weeks as $key => $week){
        echo "<li>\n";
        echo "<p>".$week."</p>";
        echo anchor($this->lang->line('webshop_folder')."courses/admin/editweek/".$key,'Edit');
        echo " | ";
        echo anchor($this->lang->line('webshop_folder')."courses/admin/deleteweek/".$key,'Delete');
        echo "</li>\n";
    }
}
echo "</ul>";



 // form to create new week
echo form_open('courses/admin/weekhome');

echo "<ul id='createweek' class='clear'>";

echo "<li><label for='name'>Week</label>\n";
$data = array('name'=>'name','id'=>'weekname','size'=>10);
echo form_input($data) ."</li>\n";


echo "<li id='submit'>";
echo form_submit('submit','Create New Date');
echo "</li>";
echo form_close();

?>