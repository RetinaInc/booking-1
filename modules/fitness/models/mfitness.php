<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MFitness extends Model{

  function MFitness(){
          parent::Model();
      }
/*
  function generateTree(&$tree, $parentid = 0) {
        $this->db->select('*');
       // $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
        $this->db->where ('parentid',$parentid);
	$this->db->where ('active','1');
        $this->db->order_by('order asc, parentid asc');
         $res = $this->db->get('omc_courses');
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
          $res->free_result();
          return $tree;
     }
*/
     function getTrainerDetails($id){
        $data = array();
        $options = array('id' =>$id);
        $Q = $this->db->getwhere('omc_trainer',$options,1);
        if ($Q->num_rows() > 0){
          $data = $Q->row_array();
        }

        $Q->free_result();
        return $data;
         }


     /*
      *
      * used in booking()
      */

     function getcoursedetails(){
        $data = array();
	$id = $this->uri->segment(3);
        $this->db->select('*');
        $this->db->from('omc_courses');
        $this->db->where('id', $id);
	//$query = $this->fetch('omc_courses','*','',array('id'=>$id));
        $query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data = $row;
            }
        }
        $query->free_result();
        return $data;
     }


     function bookcourse($course_id,$user_id){
         $date_enrol = date("Y-m-d");
         $data = array(
            'customer_id' => $user_id,
            'course_id' => $course_id,
            'date_enroll' => $date_enrol,
             );
	  $this->db->insert('omc_bookings',$data);         
     }


     function checkbooking($course_id,$user_id){
        $data = array();
        $query = $this->db->get_where('omc_bookings', array('customer_id' => $user_id,'course_id' =>$course_id), 1);
        if ($query->num_rows() > 0){
            // there is a booking already
          $data = TRUE;
        }else{
            // no booking in db
            $data = FALSE;
        }
        $query->free_result();
        return $data;

     }


     function getuser($user_email){
        $data = array();
        $query = $this->db->get_where('be_users', array('email' => $user_email), 1);
        if ($query->num_rows() > 0){
          foreach ($query->result() as $row){
                $data = $row;
            }
        }
        $query->free_result();
        return $data;
     }

     function getmybooking($user_id){
        $data = array();
        $this->db->join('omc_courses', 'omc_courses.id = omc_bookings.course_id');
        $this->db->join('omc_date', 'omc_date.date_id = omc_courses.date_id');
        $this->db->order_by('date');
        $query = $this->db->get_where('omc_bookings', array('customer_id' => $user_id));
        if ($query->num_rows() > 0){
          foreach ($query->result() as $row){
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;

     }


     function getallmycourses($customer_id=NULL){
        $data = array();
        //$this->db->select('*');
        $this->db->select('omc_courses.id,omc_courses.date_id,omc_courses.time,omc_courses.course_name,omc_courses.trainer_id,
            omc_courses.desc,omc_courses.capacity,omc_courses.active,omc_courses.order,omc_courses.booked,omc_courses.type,
            omc_date.date_id,omc_date.date,omc_date.week_id,
            omc_week.week_id,omc_week.name,
            omc_trainer.id AS trainerid, omc_trainer.trainer_name,omc_trainer.trainer_image,omc_trainer.video_url,omc_trainer.desc,
            omc_bookings.*
            ');
        $this->db->from('omc_bookings');
        $this->db->join('omc_courses','omc_courses.id = omc_bookings.course_id','right');
        $this->db->join('omc_date','omc_date.date_id = omc_courses.date_id','right');
        $this->db->join('omc_week', 'omc_date.week_id = omc_week.week_id','right');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id','right');
        $this->db->where('omc_bookings.customer_id', $customer_id);
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

    function deletebooking($booking_id){
        $this->db->where('booking_id', $booking_id);
        $this->db->delete('omc_bookings');
    }


    /*
     * counting booking by course_id
     */

    function countbooking($course_id){
       
        $data = array();
        $this->db->select('COUNT(*) AS totalbooking');
        $this->db->from('omc_bookings');
        $this->db->where('course_id',$course_id);
        $this->db->limit(1);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data = $row;
            }
        }
        $Q->free_result();
        return $data;

    }

/*
 * Used in fitness/booking
 *  get capacity of a course
 */

    function getcoursecapacity($course_id = NULL){
        $this->db->select('capacity');
        $Q = $this->db->get_where('omc_courses', array('id' => $course_id),1);
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data = $row;
            }
        }
        $Q->free_result();
        return $data;


    }




// not used yet
    function check_booking_id($user_id, $booking_id){
        $data = array();
        $query = $this->db->get_where('omc_bookings', array('customer_id' => $user_id,'booking_id'=>$booking_id));
        if ($query->num_rows() > 0){
                $data = TRUE;
        }else{
            $data = FALSE;
        }
        $query->free_result();
        return $data;

    }


}