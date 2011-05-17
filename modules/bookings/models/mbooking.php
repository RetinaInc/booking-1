<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBooking extends Base_Model{

  function MBooking(){
      parent::Base_Model();
      // Setup tables
      $this->_TABLES = array('Bookings' => 'omc_bookings');
      }

      /*
       * Used in bookings/controllers/admin()
       */

      function getAllBookings($id=NULL){
        $data = array();
        $this->db->select('*');
        $this->db->join('be_users', 'be_users.id = omc_bookings.customer_id');
        $this->db->join('omc_courses', 'omc_bookings.course_id = omc_courses.id');
        $this->db->join('omc_date', 'omc_courses.date_id = omc_date.date_id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
        //$this->db->where ('active','1');
        $this->db->order_by('date asc');
        if ($this->uri->segment(4)){
                $id = $this->uri->segment(4);
                $this->db->where('omc_bookings.course_id',$id);
            }

        $query = $this->db->get('omc_bookings');


        //$query = $this->fetch('Bookings','*');
         if ($query->num_rows() > 0) {
             // let's return object this time instead of array
            foreach ($query->result() as $row) {
                $data[] = $row;
             }
         }
          $query->free_result();
          return $data;

      }


      /*
       * Used in index
       * generate booked number by courses
       */
    function getAllBookingnum($id=NULL){
        $data = array();
        //$this->db->select('*');
        $this->db->select('omc_courses.id, omc_date.date,omc_courses.course_name,omc_courses.time,
            count(*) AS total, omc_courses.capacity, omc_trainer.trainer_name');
        $this->db->from('omc_bookings');
        $this->db->order_by('omc_date.date asc');
        $this->db->order_by('omc_courses.time asc');
        $this->db->group_by("course_id");
        $this->db->join('omc_courses', 'omc_bookings.course_id = omc_courses.id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
        $this->db->join('omc_date', 'omc_date.date_id = omc_courses.date_id');
        if ($this->uri->segment(4)){
                $id = $this->uri->segment(4);
                $this->db->where('omc_bookings.course_id',$id);
            }
        
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
             }
        }
        $query->free_result();
        return $data;

      }

      function getAllBookingnumold($id=NULL){
          $data = array();
        $this->db->select('omc_courses.id, omc_courses.date,omc_courses.course,course_id, count(*) AS total, omc_courses.capacity, omc_trainer.trainer_name');
        $this->db->order_by('omc_bookings.course_id asc');
        $this->db->group_by("course_id");
        $this->db->join('omc_courses', 'omc_bookings.course_id = omc_courses.id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
        if ($this->uri->segment(4)){
                $id = $this->uri->segment(4);
                $this->db->where('omc_bookings.course_id',$id);
            }
        $this->db->from('omc_bookings');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
             }
        }
        $query->free_result();
        return $data;
          
      }


/*
 * Used in bookings/admin/bookingdetails()
 */

    function getAllBookingdetails($id){
        $data = array();
        $this->db->select('omc_courses.id, omc_date.date,omc_courses.course_name,omc_courses.id, count(*) AS total, omc_courses.capacity, omc_trainer.trainer_name');
        $this->db->order_by('omc_bookings.course_id asc');
        $this->db->group_by("course_id");
        $this->db->join('omc_courses', 'omc_bookings.course_id = omc_courses.id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');
        $this->db->join('omc_date', 'omc_date.date_id = omc_courses.date_id');
        $this->db->from('omc_bookings');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
             }
        }
        $query->free_result();
        return $data;


      }


/*
 * used in fitness/deletebooking
 *
 */

    function getbookingdetails($booking_id){
        $data = array();
        $this->db->select('*');
        $query = $this->db->get_where('omc_bookings',array('booking_id' => $booking_id));
        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data = $row;
             }
        }
        $query->free_result();
        return $data;
    }


function getAllBookingdetailsold($id){
        $this->db->select('omc_courses.id, omc_courses.date,omc_courses.course,course_id, count(*) AS total, omc_courses.capacity, omc_trainer.trainer_name');
        $this->db->order_by('omc_bookings.course_id asc');
        $this->db->group_by("course_id");
        $this->db->join('omc_courses', 'omc_bookings.course_id = omc_courses.id');
        $this->db->join('omc_trainer', 'omc_trainer.id = omc_courses.trainer_id');

        $this->db->from('omc_bookings');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
             }
        }
        $query->free_result();
        return $data;


      }


      function getbookingnum($id){
            $this->db->select('count(*) AS total');
            $this->db->group_by("course_id");
            $query = $this->db->get_where('omc_bookings', array('booking_id' => $id));
            if ($query->num_rows() > 0){
                    $data = $query;
            }
            $query->free_result();
            return $data;

      }










      

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
 * not used yet
 */
      function generateTreewithtrainer(&$tree, $parentid = 0) {

           $data = array();
	$this->db->select('*');
	$this->db->from('omc_courses');
        $this->db->join('omc_trainer', 'omc_courses.trainer_id = omc_trainer.id ','right outer');
        $this->db->order_by('omc_courses.time asc, omc_courses.parentid asc');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                // $data[$row['id']][] = $row;
                // push found result onto existing tree
                $data[$row['id']] = $row;
                // create placeholder for children
                $data[$row['id']]['children'] = array();
                // find any children of currently found child
                $this->generateTree($data[$row['id']]['children'],$row['id']);
            }
        }
        $query->free_result();
        return $data;
     }

}