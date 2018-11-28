<?php
class Members extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Members_model');
        $this->load->model('Welfarefee_model');
        $this->load->model('Expense_model');
        $this->load->model('MembershipFee_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('form');
    }


    public function index()
	{
		$db_member = $this->Members_model->get_all();

        //member/index view of all the members in a table
        $members = array();
        foreach ($db_member as $db_member) {
            $member['id'] = $db_member['id'];
            $member['fullname'] = $db_member['firstName'].' '.$db_member['lastName'];
            $member['joinedOn'] = $db_member['registrationDate'];
            $member['details'] = $db_member['address1'].','.$db_member['address2'].','.$db_member['address3'];
            $member['image'] = '../figs/man.png';
            array_push($members, $member);
        }
        $data['result'] = json_encode(array(
            'data' => array(
                'users' => $members
            )
        ));
        $data['title'] = 'Members';

        $this->load->view('templates/header', $data);
        $this->load->view('members/index');
        $this->load->view('templates/footer');
    }

    public function view($id)
    {
        $this->data['view_member'] = $this->Members_model->get_member($id);
        $this->load->view('templates/header' );
        $this->load->view('members/view', $this->data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
    $data = array('firstName'                   => $this->input->post('firstname'),
                  'lastName'                    => $this->input->post('lastname'),
                  'address1'                    => $this->input->post('address1'),
                  'address2'                    => $this->input->post('address2'),
                  'address3'                    => $this->input->post('address3') ,
                  'registrationDate'            => date("m/d/y h:i:s"),
                  'mobile'                      => $this->input->post('mobile')
                );

    $this->Members_model->insert_member($data);
    $this->session->set_flashdata('message', 'Your data inserted Successfully..');
    redirect('members/index');

    }


    function edit_product($id)
    {
		//$product = $this->Products_model->get_product($product_id);

        //validate form input
        $this->form_validation->set_rules('first_name', 'First name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|xss_clean');
        $this->form_validation->set_rules('address1', 'Address line1', 'required|xss_clean');
        $this->form_validation->set_rules('address2', 'Address line2', 'required|xss_clean');
        $this->form_validation->set_rules('address3', 'Address line3', 'required|xss_clean');
        $this->form_validation->set_rules('mobile', 'Mobile no', 'required|xss_clean');
			if ($this->form_validation->run() == false)
			{
                //get the current membert info
                $this->data['view_member'] = $this->Members_model->get_member($id);
                $this->load->view('members/edit', $this->data);
            }
            else
			{
                //validation pass
                //post values to array
                $data = array(
                    'firstName'                  => $this->input->post('first_name'),
                    'lastName'                   => $this->input->post('last_name'),
                    'address1'                    => $this->input->post('address1'),
                    'address2'                    => $this->input->post('address2'),
                    'address3'                    => $this->input->post('address3'),
                    'registrationDate' => date('Y-m-d'),
                    'mobile'                      =>$this->input->post('mobile'));

                if($this->Members_model->update_member($id, $data))
                {
				   $this->session->set_flashdata('message', "<p>Menber updated successfully.</p>");

                   redirect('members/index');
                }
			}

	}

  function delete_member($id)
  {
		$this->Members_model->delete_member($id);

		$this->session->set_flashdata('message', '<p>Member were successfully deleted!</p>');

		redirect('members/index');
	}

  //Membership fee functions
	public function submit_membership_fee()
    {
    $data = array( 'date'           => date("m/d/y h:i:s"),
                   'amount'         => $this->input->post('amount'),
                   'memberId'       => $this->input->post('memberId'),

                );

    $this->Members_model->insert_membership_fee($data);
    $this->session->set_flashdata('message', 'Your data inserted Successfully..');
    redirect(' ');//redirect to

    }

    //find whether welfare fee is >50000

    public function check_welfare_fee(){
    //get the sum of the  amount column in welfare table using the model
    $wel_sum =$this->Welfarefee_model->get_welfare_amount();
    //get the sum of the  amount column in expense table using the model
    $expense_sum =$this->Expense_model->get_expense_amount();

    if (($wel_sum-$expense_sum)>50000){
        return true;
    }else
        return false;
    }
}
?>

