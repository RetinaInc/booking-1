<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p><?php echo anchor("trainers/admin/create", "Create new trainer");?>
<?php

if (count($trainers)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>Trainer ID</th>\n<th>Trainer's Name</th><th>Trainer's Image</th><th>Video URL</th><th>Description</th><th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($trainers as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list['id']."</td>\n";
		echo "<td align='center'>".$list['trainer_name']."</td>\n";
		echo "<td align='center'>".$list['trainer_image']."</td>\n";
		echo "<td align='center'>".$list['video_url']."</td>\n";
		echo "<td align='center'>".$list['desc']."</td>\n";
	
		echo "<td align='center'>";
		echo anchor('trainers/admin/edit/'.$list['id'],'edit');
		echo " | ";
		echo anchor('trainers/admin/delete/'.$list['id'],'delete');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}
?>