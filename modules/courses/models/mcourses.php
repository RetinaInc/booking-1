<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCourses extends Model{

  function MCourses(){
          parent::Model();
      }



/*
 * used in indexnew()
 */
function gettypes(){
        $data = array();
        $this->db->select('type, id');
        $this->db->group_by("type");
        $Q = $this->db->get('omc_courses');
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){

                $data[$row->type] = $row->type;
            }
        }
        $Q->free_result();
        return $data;

}
/*
 * Used in indexnew()
 */

function getdatelist(){
        $data = array();
        $this->db->select('*');
        $Q = $this->db->get('omc_date');
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){
 //$data[] = $row;
                $data[$row->date_id] = $row->date;
            }
        }
        $Q->free_result();
        return $data;

}


/*
 * used in indexnew()
 */

    function getfirstweekid(){
        $data = array();
        $this->db->select('*');
        $this->db->order_by("name", "asc");
        $this->db->limit(1);
        $Q = $this->db->get('omc_week');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
             $data = $row;
            }
        $Q->free_result();
        return $data;

        }
    }


    /*
     * used in indexnew()
     */

    function getdateforweek($week_id=NULL){
        $data = array();
        $this->db->select('*');
        $this->db->where('week_id', $week_id);
        $Q = $this->db->get('omc_date');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    /*
     * used in indexnew()
     * join omc_courses.date_id = omc_date.date_id and join omc_week, omc_date.week_id = omc_week.week_id
     * and get all where week_id is $week_id. first is 1
     */

     function getcourseforweek($week_id=NULL){
        $data = array();
        //$this->db->select('*');
        // known issue: if there is no course on a day, that day or next will not be displayed
        $this->db->select('omc_courses.id,omc_courses.date_id,omc_courses.time,omc_courses.booked,omc_courses.course_name,omc_courses.trainer_id,
            omc_courses.desc,omc_courses.capacity,omc_courses.active,omc_courses.order,omc_courses.booked,omc_courses.type,
            omc_date.date_id,omc_date.date,omc_date.week_id,
            omc_week.week_id,omc_week.name,
            omc_trainer.id AS trainerid, omc_trainer.trainer_name,omc_trainer.trainer_image,omc_trainer.video_url,omc_trainer.desc');
        $this->db->from('omc_date');
        $this->db->join('omc_courses','omc_courses.date_id = omc_date.date_id','left');
        $this->db->join('omc_week', 'omc_date.week_id = omc_week.week_id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id','left');
        $this->db->join('omc_bookings', 'omc_bookings.course_id = omc_courses.id','left');
        $this->db->group_by("omc_courses.id");
        $this->db->where('omc_week.week_id', $week_id);
        $this->db->order_by("date", "asc");
        $this->db->order_by("time", "asc");
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[$row['date']][] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

     function copy_of_getcourseforweek($week_id=NULL){
        $data = array();
        //$this->db->select('*');
        $this->db->select('omc_courses.id,omc_courses.date_id,omc_courses.time,omc_courses.booked,omc_courses.course_name,omc_courses.trainer_id,
            omc_courses.desc,omc_courses.capacity,omc_courses.active,omc_courses.order,omc_courses.booked,omc_courses.type,
            omc_date.date_id,omc_date.date,omc_date.week_id,
            omc_week.week_id,omc_week.name,
            omc_trainer.id AS trainerid, omc_trainer.trainer_name,omc_trainer.trainer_image,omc_trainer.video_url,omc_trainer.desc');
        $this->db->from('omc_date');
        $this->db->join('omc_courses','omc_courses.date_id = omc_date.date_id','left');
        $this->db->join('omc_week', 'omc_date.week_id = omc_week.week_id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id','left');
        $this->db->join('omc_bookings', 'omc_bookings.course_id = omc_courses.id','left');
        $this->db->group_by("omc_courses.id");
        $this->db->where('omc_week.week_id', $week_id);
        $this->db->order_by("date", "asc");
        $this->db->order_by("time", "asc");
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[$row['date']][] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }



   function addnewcourse(){

      $data = array(
       'date_id' => $this->input->post('date_id'),
       'time' => $this->input->post('time'),
       'course_name' => $this->input->post('course_name'),
       'trainer_id' => $this->input->post('trainer_id'),
       'desc' => $this->input->post('desc'),
       'capacity' => $this->input->post('capacity'),
       'active' => $this->input->post('active'),
       'order' => $this->input->post('order'),
       'booked' => $this->input->post('booked'),
       'type' => $this->input->post('type'),
         );

      $this->db->insert('omc_courses', $data);
   }

   /*
    * Used in edit_course()
    *
    */

   function updateCourse(){
       
      $data = array(
          'date_id' =>  $this->input->post('date_id'),
          'time' => $this->input->post('time'),
          'course_name' => $this->input->post('course_name'),
          'trainer_id' => $this->input->post('trainer_id'),
          'desc' => $this->input->post('desc'),
          'capacity' => $this->input->post('capacity'),
          'active' => $this->input->post('active'),
         //  'order' => $this->input->post('order'),
          'booked' => $this->input->post('booked'),
          'type' => $this->input->post('type')
      );
      $id =  $this->input->post('id');
     // $this->db->where('id', $id);
      $this->db->update('omc_courses', $data,array('id'=>$id));
   }


   function delete_course($id){
     $this->db->delete('omc_courses', array('id' => $id));
    }


    /*
     * used in index() to check if there is any same course in omc_courses
     */
    function check_course($date_id=NULL, $time=NULL, $course_name=NULL){
        $data = array();
        $array = array('date_id' => $date_id, 'time' => $time, 'course_name' => $course_name);
        $this->db->where($array);
        $Q = $this->db->get('omc_courses');
        if ($Q->num_rows() > 0){
                $data = TRUE;
            }else{
                $data = FALSE;
            }
        $Q->free_result();
        return $data;
    }




    /*
    * Method relating to omc_week
    *
    */

/*
 * get all week
 */

function getweeks(){
        $data = array();
        $this->db->select('*');
        $Q = $this->db->get('omc_week');
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){
 //$data[] = $row;
               $data[$row->week_id] = $row->name;
            }
        }
        $Q->free_result();
        return $data;
}

// use in weekhome()
function addweek(){
     $data = array(
       'name' => $this->input->post('name'),

         );

      $this->db->insert('omc_week', $data);


}

// use in weekhome()
function updateweek(){
    $week_id = $this->input->post('week_id');
     $data = array(
       'name' => $this->input->post('name'),
         );
    $this->db->where('week_id', $week_id);
    $this->db->update('omc_week', $data);
}

/*
 * Get week info by id
 * used in editweek()
 */
function getweek($id){
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get_where('omc_week',array('week_id'=> $id));
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){
 //$data[] = $row;
               $data = $row;
            }
        }
        $Q->free_result();
        return $data;
}

function deleteweek($id){
     $this->db->delete('omc_week', array('week_id' => $id));
}
   /*
    * Method relating to omc_date
    *
    */

    function getalldatebyweek(){
        $data = array();
        $this->db->join('omc_week', 'omc_date.week_id = omc_week.week_id','right');
        $this->db->order_by("name", "asc");
        $this->db->order_by("date", "asc");
        $Q = $this->db->get('omc_date');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[$row['name']][] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

  /*
   * methods for date
   */

    function adddate(){
     $data = array(
       'date' => $this->input->post('date'),
         'week_id' => $this->input->post('week_id'),

         );

      $this->db->insert('omc_date', $data);


}


/*
 * Get date info by id
 * used in editdate()
 */
function getdate($id){
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get_where('omc_date',array('date_id'=> $id));
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){
 //$data[] = $row;
               $data = $row;
            }
        }
        $Q->free_result();
        return $data;
}

function deletedate($id){
     $this->db->delete('omc_date', array('date_id' => $id));
}

// use in editdate()
function updatedate(){
    $date_id = $this->input->post('date_id');
     $data = array(
       'date' => $this->input->post('date'),
       'week_id' => $this->input->post('week_id'),
         );
    $this->db->where('date_id', $date_id);
    $this->db->update('omc_date', $data);
}

/*
    * Used in edit()
    *
    */

  function getCourse($id){
      $data = array();
      // there are two ids in omc_trainer and omc_courses, so use AS to differenciate
      $this->db->select('omc_courses.*, omc_date.*,
          omc_trainer.id AS trainerid, omc_trainer.trainer_name,omc_trainer.trainer_image,
          omc_trainer.video_url, omc_trainer.desc AS trainer_desc
          ');
      $this->db->from('omc_courses');
      $this->db->join('omc_date', 'omc_date.date_id = omc_courses.date_id');
      $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
      $options = array('omc_courses.id' => $id);
      $this->db->where($options);
    //  $this->db->limit(1);
      $Q = $this->db->get();
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }

      $Q->free_result();
      return $data;
   }



/*
 * used in fitness/booking
 * this will take $booking num and update in omc_couurses.booked
 *
 */

   function updatebooking($course_id, $bookingnum){
       $data = array(
               'booked' => $bookingnum
            );
      //  $this->db->where('id', $course_id);
      //  $this->db->update('omc_courses', $data);
        $this->db->update('omc_courses', $data, array('id' => $course_id));
   }











   

/*
 * end of createnew()
 */




















      /*
       *
       * These are old way to do it
       *
       */
  function generateTree(&$tree, $parentid = 0) {
         $this->db->select('id,name,trainer_id,course,capacity,active,parentid,page_uri,order,type,capacity,booked');
         $this->db->where ('parentid',$parentid);
         $this->db->where ('active','active');
         $this->db->order_by('order asc, parentid asc'); 
         $res = $this->db->get('omc_coursesold');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {
                
				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateTree($tree[$r['id']]['children'],$r['id']);
             }
         }
     }

  function generateallTree(&$tree, $parentid = 0) {
         $this->db->select('id,name,week_day_time,date,trainer_id,course,capacity,active,parentid,order,type,booked');
         $this->db->where ('parentid',$parentid);
         $this->db->order_by('order asc, parentid asc'); 
         $res = $this->db->get('omc_coursesold');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {
                
				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['id']]['children'],$r['id']);
             }
         }
     }

     /*
    * Used in create(), edit()
    *
    */

   function getAllCoursesDisplay(){
       $data[0] = 'root';
       $Q = $this->db->get('omc_coursesold');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();
      return $data;
   }

   /*
    * Used in create()
    *
    */


   function addCourse(){
       // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodate = $this->input->post('date');
        $newdate = new DateTime($eurodate);
        $sqldate = $newdate->format('Y-m-d %H:%i:%s');
        $data = array(
           'name' => $this->input->post('name'),
           'week_day_time' => $this->input->post('week_day_time'),
           'date' => $sqldate,//YYYY-MM-DD HH:MM:SS
           'trainer_id' => $this->input->post('trainer_id'),
           'course' => $this->input->post('course'),
           'capacity' => $this->input->post('capacity'),
           'active' => $this->input->post('active'),
           'parentid' => $this->input->post('parentid'),
           'order' => $this->input->post('order'),
           'booked' => $this->input->post('booked'),
           'type' => $this->input->post('type'),
         );

      $this->db->insert('omc_coursesold', $data);
   }






/*
 * used in index
 */
   function getcoursebyparentid($parentid=NULL){
        // pick up all which has parent id of 0
        $data = array();
        $options = array('parentid' => $parentid);
        $Q = $this->db->getwhere('omc_coursesold',$options);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[$row['id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;

   }

/*
 * used in index
 */
function getcoursetypes(){
        $data = array();
        $this->db->select('type, id');
        $this->db->group_by("type");
        $Q = $this->db->get('omc_coursesold');
        if ($Q->num_rows() > 0){
            foreach ($Q->result() as $row){
                
                $data[$row->type] = $row->type;
            }
        }
        $Q->free_result();
        return $data;

}




	
}
