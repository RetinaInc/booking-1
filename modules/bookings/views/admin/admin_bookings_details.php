<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p><?php echo anchor("bookings/admin/create", "Create new booking");?>
<?php
if (count($bookingnum)){
    foreach ($bookingnum as $key => $list){
    echo "<ul>";
    echo "<li>Date: ".$list->date."</li>";
    echo "<li>Course Name: ".$list->course_name."</li>";
    echo "<li>Trainer Name: ".$list->trainer_name."</li>";
    echo "<li>Total Number Booked: ".$list->total."</li>";
    echo "<li>Total Number Capacity: ".$list->capacity."</li>";
    echo "</ul>";
    }
}

if (count($bookingdetails)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>Customer Name</th>\n<th>User Email</th>\n<th>Date Enroll</th>\n<th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($bookingdetails as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list->username."</td>\n";
                echo "<td align='center'>".$list->email."</td>\n";
                echo "<td align='center'>".$list->date_enroll."</td>\n";
		echo "<td align='center'>";
		echo anchor('bookings/admin/edit_booking/'.$list->id,'edit');
		echo " | ";
		echo anchor('bookings/admin/delete_booking/'.$list->id,'delete');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}


echo "bookingnum<pre>";
print_r ($bookingnum);
echo "</pre><br />bookingdetails";
echo "<pre>";
print_r ($bookingdetails);
echo "</pre>";


?>
