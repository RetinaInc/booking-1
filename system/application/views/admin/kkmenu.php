

    <li id="fitness"><span class="icon_general"><?php print 'Fitness'?></span>
        <ul>
            <?php if(check('Courses',NULL,FALSE)):?><li><?php print anchor('courses/admin','Courses',array('class'=>'icon_calendar'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Bookings',NULL,FALSE)):?><li><?php print anchor('bookings/admin','Bookings',array('class'=>'icon_user_red'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Trainers',NULL,FALSE)):?><li><?php print anchor('trainers/admin','Trainers',array('class'=>'icon_user_suit'))?></li><?php echo "\n"; endif;?>

        </ul>
    </li>
