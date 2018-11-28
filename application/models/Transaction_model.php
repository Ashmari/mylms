<?php
class Transaction_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function insert_transaction($data)
  {
    // $data: assoc array of transaction details.
    // insert transaction to the database
    $this->db->insert('transaction',$data);
  }
  public function get_transaction($id)
  {
    // get transaction details by given id in transaction table
    $this->db->where('id', $id);
    $query=$this->db->get('transaction');
    return $query->row();
  }
  public function get_all()
  {
    // get transactions details by  transaction table
    $this->db->select("*");  
    $this->db->from("transaction");  
    $query = $this->db->get();  
    return $query;  
  }
  public function delete_transaction($id)
  {
    // delete transaction details by given id in transaction table
    $this->db->where('id', $id);
    $this->db->delete('transaction');
  }
  public function update_transaction($data ,$id)
  {
    // update transaction details by given id in transaction table.
    $this->db->where('id' , $id);
    $this->db->update('transaction', $data );
  }
}