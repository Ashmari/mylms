<?php
class Welfarefee_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function insert_welfarefee($data)
  {
    // $data: assoc array of welfarefee details.
    // insert welfarefee to the database
    $this->db->insert('welfarefee',$data);
  }
  public function get_welfarefee($id)
  {
    // get welfarefee details by given id in welfarefee table
    $this->db->where('id', $id);
    $query=$this->db->get('welfarefee');
    return $query->row();
  }
  public function get_all()
  {
    // get welfarefees details by  welfarefee table
    $this->db->select("*");
    $this->db->from("welfarefee");
    $query = $this->db->get();
    return $query;
  }
  public function delete_welfarefee($id)
  {
    // delete welfarefee details by given id in welfarefee table
    $this->db->where('id', $id);
    $this->db->delete('welfarefee');
  }
  public function update_welfarefee($data ,$id)
  {
    // update welfarefee details by given id in welfarefee table.
    $this->db->where('id' , $id);
    $this->db->update('welfarefee', $data );
  }

  public function get_welfare_amount()
  {
    //get the sum of the amount column
    $this->db->select_sum('amount');
    $result = $this->db->get('welfarefee')->row();
    return $result->amount;
  }
}
?>
