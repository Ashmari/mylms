<?php
class Transaction extends CI_Controller 
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('transaction_model');
		$this->load->library('form_validation');
    }
    
    
    public function index()
	{
		$this->data['transaction_list'] = $this->transaction_model->get_all();
		
		//transaction/index view of all the transaction in a table
        $this->load->view('transaction/index', $this->data);
        
        $this->load->view('templates/header');
        $this->load->view('templates/footer' );
      
    }
    public function view($id)
    {
        $this->data['view_transaction'] = $this->transaction_model->get_transaction($id);
        
 
       
        $this->load->view('templates/header' );
        $this->load->view('transaction/view', $this->data);
        $this->load->view('templates/footer');
    }
    public function submit_data()
    {
    $data = array('source'                    => $this->input->post('source'),
                  'type'                      => $this->input->post('type'),
                  'description'               => $this->input->post('description')
                );
    
    $this->transaction_model->insert_transaction($data);
    $this->session->set_flashdata('message', 'Your data inserted Successfully..');
    redirect('transaction/index');
    }
    function edit_transaction($id) 
    {
		//$product = $this->Products_model->get_product($product_id);
        //validate form input
        $this->form_validation->set_rules('source', 'source', 'required|xss_clean');
        $this->form_validation->set_rules('type', 'type', 'required|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'required|xss_clean');
		
           
			if ($this->form_validation->run() == false)
			{
                //get the current transaction info
                $this->data['view_transaction'] = $this->transaction_model->get_transaction($id);
                $this->load->view('transaction/edit', $this->data);
            }	
            else 
			{
                //validation pass 
                //post values to array
                $data = array(
                    'source'                        => $this->input->post('source'),
                    'type'                      => $this->input->post('type'),
                    'description'                      => $this->input->post('description')
                );
                if($this->transaction_model->update_transaction($id, $data))
                {
				   $this->session->set_flashdata('message', "<p>transaction updated successfully.</p>");
				
                   redirect('transaction/index');
                }
			}				
		
	}	
	
    function delete_transaction($id) 
    {
		$this->transaction_model->delete_transaction($id);
		
		$this->session->set_flashdata('message', '<p>transaction were successfully deleted!</p>');
		
		redirect('transaction/index');
	}
    
	
    
}
?>