<?php

class Members_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function insert_member($data)
  {
    // $data: assoc array of member details.
    // insert member to the database
    $this->db->insert('member',$data);
  }


  public function get_member($id)
  {
    // get member details by given id in member table
    $this->db->where('id', $id);
    $query=$this->db->get('member');
    return $query->row();

  }

  public function get_all()
  {
    // get members details by  member table
    $this->db->select("*");
    $this->db->from("member");
    $query = $this->db->get();
    return $query->result_array();

  }

  public function delete_member($id)
  {
    // delete member details by given id in member table
    $this->db->where('id', $id);
    $this->db->delete('member');
  }

  public function update_user($data ,$id)
  {
    // update member details by given id in member table.
    $this->db->where('id' , $id);
    $this->db->update('member', $data );
  }
}
