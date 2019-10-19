<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Newsletter extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('NewsletterModel');
		}

        function index(){
		    $this->load->view('nl_admin/dashboard');
        }
		

        function add_subscriber(){
        	$data['title'] = 'Add subscriber';
        	$data['newsletter_group'] = $this->NewsletterModel->get_groups();
        	if ($this->input->method()=='post') {
        		if($this->NewsletterModel->is_exist_subscriber($this->input->post('subs_email'))){
        			$error[] = $this->session->set_flashdata('err_msg','This email is already subscribed.');
        		}

        		if (count(@$error)>0) {
        			$this->load->view('nl_admin/add_subscriber_form', $data);
        		}else{
        			$this->NewsletterModel->add_subscriber();
	        		$this->session->set_flashdata('successMsg', 'Success! Subscriber is added successfully.');
	        		redirect('newsletter/subscribers','refresh');
        		}
        		
        	}else{
        		$this->load->view('nl_admin/add_subscriber_form', $data);
        	}
        }

        function subscribers(){
        	$data['title'] = 'Subscribers';
        	$data['subscribers']= $this->NewsletterModel->get_subscribers();
        	$data['newsletter_group'] = $this->NewsletterModel->get_groups();
        	foreach ($data['newsletter_group'] as $group_list) {
            	$data['nl_group_list'][$group_list->gid] = $group_list->group_name;
            }
        	$this->load->view('nl_admin/subscriber_list', $data);
        }

        function subscriber_edit($id){
        	$data['title'] = 'Edit subscriber';
        	$data['newsletter_group'] = $this->NewsletterModel->get_groups();
        	$data['subsc_info'] = $this->NewsletterModel->get_subscribers(null,$id);
        	if ($this->input->method()=='post') {
        		//error check

        		if (count(@$error)>0) {
        			$this->load->view('nl_admin/edit_subscriber_form', $data);
        		}else{
        			$this->NewsletterModel->edit_subscriber();
	        		$this->session->set_flashdata('successMsg', 'Success! Subscriber is update successfully.');
	        		redirect('newsletter/subscribers','refresh');
        		}
        		
        	}else{
        		if (empty($id)) {
        			$data['error'] = 'Invalid subscriber.';
        		}
        		
        		if ($data['subsc_info']<>true) {
        			$this->session->set_flashdata('errorMsg', 'Error! No subscriber found.');
	        		redirect('newsletter/subscribers','refresh');
        		}
        		$this->load->view('nl_admin/edit_subscriber_form', $data);
        	}
        }

        function subscriber_delete($id){
        	$data['title'] = 'Delete subscriber alert';
        	$data['newsletter_group'] = $this->NewsletterModel->get_groups();
        	$data['subsc_info'] = $this->NewsletterModel->get_subscribers(null,$id);
        	if ($data['subsc_info']<>true) {
    			$this->session->set_flashdata('errorMsg', 'Error! No subscriber found.');
        		redirect('newsletter/subscribers','refresh');
    		}else{
    			if ($this->input->method()=='post') {
    				$this->NewsletterModel->delete_subscriber($id);
	    			$this->session->set_flashdata('successMsg', 'Success! Subscriber deleted.');
	        		redirect('newsletter/subscribers','refresh');
    			}else{
    				$data['id'] = $id;
    				$this->load->view('nl_admin/delete_subscriber_alert', $data);
    			}
    			
    		}
    		
        }


        function groups(){
        	$data['title'] = 'Groups';
        	$data['groups']= $this->NewsletterModel->get_groups();
        	$this->load->view('nl_admin/group_list', $data);
        }

        function add_group(){
        	$data['title'] = 'Add subscriber';
        	if ($this->input->method()=='post') {
        		//form data
        		$data['group_name'] = $this->input->post('group_name');
        		//check duplicate entry
        		if($this->NewsletterModel->is_exist_group($this->input->post('group_name'))){
        			$error[] = $this->session->set_flashdata('err_msg','This group is already exist.');
        		}

        		if (count(@$error)>0) {
        			$this->load->view('nl_admin/add_group_form', $data);
        		}else{
        			$insert = $this->NewsletterModel->add_group();
        			if ($insert) {
        				$this->session->set_flashdata('successMsg', 'Success! Group is added successfully.');

        			}
	        		redirect('newsletter/groups','refresh');
	        		
        		}
        		
        	}else{
        		$this->load->view('nl_admin/add_group_form', $data);
        	}
        }

        function edit_group($gid){
        	$data['title'] = 'Edit Group';
        	$data['group_info'] = $this->NewsletterModel->get_groups($group=null, $id=$gid);

        	if ($this->input->method()=='post') {
        		//form data
        		$data['group_name'] = $this->input->post('group_name');
        		//check duplicate entry
        		if(count($this->NewsletterModel->get_groups($this->input->post('group_name')))>1){
        			$error[] = $this->session->set_flashdata('err_msg','This group is already exist.');
        		}
        		if (empty($this->input->post('gid'))) {
        			$error[] = $this->session->set_flashdata('err_msg','Invalid group ID.');
        		}

        		if (count(@$error)>0) {
        			$this->load->view('nl_admin/edit_group_form', $data);
        		}else{
        			$update = $this->NewsletterModel->update_group($gid);
        			if ($update) {
        				$this->session->set_flashdata('successMsg', 'Success! Group is updated successfully.');

        			}
	        		redirect('newsletter/groups','refresh');
	        		
        		}
        		
        	}else{
        		$this->load->view('nl_admin/edit_group_form', $data);
        	}
        }

        function n_list(){
			$data['title'] = 'Newsletter list';
        	$data['newsletters']= $this->NewsletterModel->get_newsletters();
        	$this->load->view('nl_admin/newsletter_list', $data);
        }

        function draft_newsletter(){
			$data['title'] = 'Draft Newsletter';
			$data['newsletter_group'] = $this->NewsletterModel->get_groups();
			if ($this->input->method()=='post') {

				//form validation
				if (empty($this->input->post('nl_group')) || empty($this->input->post('nl_email'))) {
					$data['error'][] = 'Newsletter group or Email required.';
				}

				if (count($data['error'])>0) {
					header('Content-Type: application/json');
					echo json_encode($data['error']);
					//$this->load->view('nl_admin/draft_newsletter', $data);
				}else{
					$this->NewsletterModel->add_newsletter();
					redirect('newsletter/n_list');
				}
			}else{
				$this->load->view('nl_admin/draft_newsletter', $data);
			}
        	
        	
        }




	}