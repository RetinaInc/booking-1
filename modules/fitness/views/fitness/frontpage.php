
<?php
echo "<h1>".$title."</h1>";

$sessionname= $this->session->userdata('username');
if(!empty($sessionname)){
echo "Hello ".$this->session->userdata('username');
echo "<br />";
echo $this->session->userdata('email');
echo "<br />";
print anchor('auth/logout',$this->lang->line('userlib_logout'),array('class'=>'icon_key_go'));
echo "<h3>";
echo anchor("fitness/displaybooking/",'See my bookings');
echo "</h3>";

}else{
    echo "<h3>";
echo 'Log in to see your bookings';
echo "</h3>";
    echo "You can logged in here.\n".form_open('auth/login',array('class'=>'horizontal'));
echo "\n<fieldset>\n<ol>\n<li>\n<label for=\"login_field\">Login</label>\n";
echo "<input type=\"text\" name=\"login_field\" id=\"login_field\" class=\"text\" value=\"\"/>\n</li>\n";
echo "<li>\n<label for=\"password\">". $this->lang->line('userlib_password').":</label>\n";
echo "<input type=\"password\" name=\"password\" id=\"password\" class=\"text\" />\n</li>\n";
echo "<li>\n<label for=\"remember\">". $this->lang->line('userlib_remember_me')."?</label>".form_checkbox('remember','yes',$this->input->post('remember'));
echo "\n</li>\n";
echo "<li class=\"submit\">\n";
echo "<div class=\"buttons\">\n<button type=\"submit\" class=\"positive\" name=\"submit\" value=\"submit\">\n";
echo $this->bep_assets->icon('key');
echo $this->lang->line('userlib_login');
echo "</button>\n<a href=\"".site_url('auth/forgotten_password')."\">\n";
echo $this->bep_assets->icon('arrow_refresh');
echo $this->lang->line('userlib_forgotten_password');
echo "</a>\n";
if($this->preference->item('allow_user_registration')){
    echo "<a href=\"". site_url('auth/register')."\">";
    echo $this->bep_assets->icon('user');
    echo $this->lang->line('userlib_register');
    echo "</a>";
}
echo "</div>\n</li>\n</ol>\n</fieldset>";
echo form_close();
    
}


// use dropdown to change week
echo "<div id='weeksubmit'>";
echo form_open('fitness/index',array('id'=>'autosubmit'));
echo "\n<label for='week_id'>Select Week</label>\n";
echo form_dropdown('week_id',$weeklist) ."\n";
echo form_submit('submit','Change Week');
echo form_close();
echo "</div>\n";

if($types){
    echo "<ul id='filter'>\n";
    echo "<li><a href='all'>all</a></li>\n";
    foreach ($types as $type){
        if(!empty($type)){
            echo "<li><a href='".$type."'>".$type."</a></li>\n";
        }
    }
    //print_r ($types);
    echo "</ul>\n";
}
// creating a calendar style schedule. this is more easy to see
// add 'add schedule link with ajax?
echo "\n<ul id='coursenav' class='clear'>\n";
foreach ($courselist as $key => $course){
    echo "<li class='menuone'><p>".$key."</p>";
   if ($course[0]['course_name']){
        echo "<ul class='dateul'>\n";
        foreach ($course as $keyid => $detail){
            echo "<li class='courseli ".$detail['type']."'>";

            echo "<p>".$detail['time']."</p>";
            echo "<p>".$detail['trainer_name']."</p>";
            // it might be better to use anchor
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."/fitness/calltrainer/".$detail['trainer_id'],$detail['course_name'],array('class'=>'coursedetails'));
            echo "</p>";
            echo "<p>".$detail['booked']." / ".$detail['capacity']."</p>";
            // check if user is logged in or not to show 'book'
            if(is_user()){
            echo "<p>";
            echo anchor($this->lang->line('webshop_folder')."fitness/booking/".$detail['id'],'Book');
            echo "</p>";
            }

            //echo "<p><a href='../../fitness/calltrainer/".$detail['trainer_id']."' class='coursedetails'>".$detail['course_name']."</a></p>";
            echo "</li>";
    }
    echo "</ul>";

   }

       echo "</li>";

}
 echo "</li>";
 echo "</ul>";
/*

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
              if(!empty($sessionname)){
              echo anchor($this->lang->line('webshop_folder')."/fitness/booking/".$subschedule['id'],'Book This',array('class'=>'booking'));
              }
              //echo "<p><a href='/fitness/booking/".$schedule['id']."'>Book here</a></p>";
              echo "\n</li>";
            }
        echo "\n</ul>";
    }
    echo "\n</li>\n";
    }
  echo "\n</ul>\n </div>\n</div>";
 *
 */


?>


				
<div class="clearfix">
    &nbsp;
</div>
		
<?php
/*
echo "<pre>weknav";
print_r ($weeknav1);
echo "</pre><br />";

echo "<pre>weknav1";
print_r ($weeknav);
echo "</pre>";


echo "<pre>";
print_r ($trainers);
echo "</pre>";
*/

?>