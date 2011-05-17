<h2><?php echo $title;?></h2>
<?php


print_r ($week);
 // form to create new week
echo form_open('courses/admin/editweek');

echo "<ul id='createweek' class='clear'>";

echo "<li><label for='name'>Week</label>\n";
$data = array('name'=>'name','id'=>'weekname','size'=>10, 'value' => $week->name);
echo form_input($data) ."</li>\n";

echo "<li>".form_hidden('week_id',$week->week_id)."</li>";

echo "<li id='submit'>";
echo form_submit('submit','Update Week');
echo "</li>";
echo form_close();

?>