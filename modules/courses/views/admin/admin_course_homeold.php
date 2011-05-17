<h2><?php echo $title;?></h2>
<p><?php echo anchor("courses/admin/create", "Create new course");?></p>

<?php
// showing weekly schedule for reference
// use dropdown to change week
// toggle here as well
echo "<div><a href='#'class='toggleme'>Show/Hide Shedule</a>";
echo "<div id='togglethis'>";
echo "<div id='weeksubmit'>";
echo form_open('courses/admin/',array('id'=>'autosubmit'));
echo "\n<label for='weekid'>Select Week</label>\n";
echo form_dropdown('weekid',$weeklist) ."\n";
echo form_submit('submit','Change Week');
echo form_close();
echo "</div>\n";

if($types){
    echo "<ul id='filter'>\n";
    foreach ($types as $type){
        if($type == NULL){
            $type = 'all';
        }

        echo "<li><a href='".$type."'>".$type."</a></li>\n";
    }
    //print_r ($types);
    echo "</ul>\n";
}
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
  echo "\n</ul>\n</div>\n</div>";

?>
<?php
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo '<h2>Schedule</h2>';
/**
 * @param array $level The current navigation level array
 * @param string $output The output to be added to
 * @param int $depth The current depth of the tree to determine classname
 */
function generateRowsByLevel($level, &$output, $depth = 0) {

    $depthClassMapping = array(0 => 'parent', 1 => 'child', 2 => 'grandchild');

    foreach ($level as $row) {
        
        $output .= "<tr valign='top'>\n";
        $output .= "<td align='center'>". $row['id']."</td>\n";
        $output .= "<td align='center'>";
        $wdt = $row['week_day_time'];
        if ($wdt == 1){
            $wdt = 'week';
        }elseif($wdt ==2){
            $wdt = 'day';
        }elseif($wdt==3){
            $wdt = 'time';
        }else{
             $wdt = 'Not Defined';
        }
        $output .= $wdt."</td>\n";
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/courses/admin/edit/' .  $row['id'] . '">' . $row['name']."</a></td>\n";
         // show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
        if($row['date']==NULL){
            $newdate = NULL;
             $output .= "<td align='center'>".$newdate."</td>\n";
        }else{
            $newdate =new DateTime($row['date']) ;
             $output .= "<td align='center'>".$newdate->format('H:i D d-m-Y')."</td>\n";
        }
        
       
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\" >". $row['order']."</td>\n";
        $output .= "<td align='center'>";
        $output .= anchor('courses/admin/changeCourseStatus/'.$row['id'],$row['active'], array('class' => $row['active']));
        $output .= "</td>\n";

        //$output .= "<td align='center'>". $row['active']."</td>\n";

        $output .= "<td align='center'>". $row['parentid']."</td>\n";
        
        $output .= "<td align='center'>". $row['course']."</td>\n";
        $output .= "<td align='center'>". $row['trainer_id']."</td>\n";
        $output .= "<td align='center'>". $row['capacity']."</td>\n";
       // $output .= "<td align='center'>". $row['booked']."</td>\n";
        $output .= "<td align='center'>". $row['type']."</td>\n";
        $output .= "<td align='center'>";
        $output .= anchor('courses/admin/edit/'. $row['id'],'edit');
        $output .= " | ";
        $output .= anchor('courses/admin/deleteMenu/'. $row['id'],'delete', array('class' => 'delete_link', 'id' => 'delete_link_'.$row['id']));
        $output .= "</td>\n";
        $output .= "</tr>\n";

        // if the row has any children, parse those to ensure we have a properly 
        // displayed nested table
        if (!empty($row['children'])) {
            generateRowsByLevel($row['children'], $output, $depth + 1);
        }
    }
}

//==================
// RUN THE GENERATOR 
//==================
if (count($navlist)){

    // begin table
    $output = "<div  id='menutable'><table border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    $output .= "<thead>\n<tr valign='top'>\n";
    $output .= "<th>ID</th>\n<th>W/D/T</th>\n<th>Name</th>\n<th>Date</th>\n<th>Order</th>\n<th>Active</th>\n<th>parentid</th>\n<th>Course Name</th>\n<th>trainer_id</th>\n<th>Capacity</th>\n<th>Type</th>\n<th>Actions</th>\n";
    $output .= "</tr>\n</thead>\n<tbody>\n";

    // generate all table rows
    generateRowsByLevel($navlist, $output);

    // close up the table
    $output .= "</tbody>\n</table></div>";

    // display table
    echo $output;
    
}


?>
