<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p><?php echo anchor("bookings/admin/create", "Create new booking");?>
<?php

if (count($bookingnum)){
	echo "<table id='' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>Course date</th>\n<th>Time</th>\n<th>Course Name</th>\n<th>Trainer Name</th>\n<th>Total Booking</th>\n<th>Capacity</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($bookingnum as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'><a href='admin/bookingdetails/".$list->id."'>".$list->date."</a></td>\n";
                echo "<td align='center'>".$list->time."</td>\n";
                echo "<td align='center'>".$list->course_name."</td>\n";
                echo "<td align='center'>".$list->trainer_name."</td>\n";
                echo "<td align='center'>".$list->total."</td>\n";
		echo "<td align='center'>".$list->capacity."</td>\n";
    // you can't add delete or edit since there are bookings, so don't add delete. Nothing to edit.
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>\n";
}else{
    echo "There is no bookings.\n";
}
/*
if (count($bookings)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>Course date</th>\n<th>Course Name</th>\n<th>Customer Name</th>\n<th>Date Enroll</th><th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($bookings as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list->date."</td>\n";
                echo "<td align='center'>".$list->course."</td>\n";
                echo "<td align='center'>".$list->username."</td>\n";
		echo "<td align='center'>".$list->date_enroll."</td>\n";
		
		echo "<td align='center'>";
		echo anchor('bookings/admin/edit/'.$list->id,'edit');
		echo " | ";
		echo anchor('bookings/admin/delete/'.$list->id,'delete');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}
*/
echo "bookingnum<pre>";
print_r ($bookingnum);
echo "</pre>";


echo "bookings<pre>";
print_r ($bookings);
echo "</pre>";

?>

  