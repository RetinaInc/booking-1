<h2><?php echo $title;?></h2>

<?php
echo form_open('bookings/admin/create');
echo "<p><label for='trainer_name'>Trainer Name</label><br/>";
$data = array('name'=>'trainer_name','id'=>'trainer_name','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='trainer_image'>Trainer Image</label><br/>";
$data = array('name'=>'trainer_image','id'=>'trainer_image','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='video_url'>Video URL</label><br/>";
$data = array('name'=>'video_url','id'=>'video_url', 'size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='desc'>Description</label><br/>";
$data = array('name'=>'desc','id'=>'desc', 'rows'=>'8', 'cols'=>'80');
echo form_textarea($data) ."</p>\n";


echo form_submit('submit','create trainer');
echo form_close();


?>