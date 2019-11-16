<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Newsletter extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('NewsletterModel');
			$this->session->set_userdata('userId','1');
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
	        		/*=================================*/
	        		
	        		$this->load->library('email');
	        		//$config['protocol'] = 'sendmail';
	        		 $this->email->set_mailtype("html");
	        		

	        		$this->email->from('service@prominentbanker.com', 'Prominent Banker', 'service@prominentbanker.com');
	        		$this->email->to($this->input->post('subs_email'));
	        		$this->email->subject('Subscription success');
	        		$message = 'Dear user</br>';
	        		$message .= '<p>Thank you for Subscription of newsletter. Please confirm your subscription now.';
	        		$message .= '<br> You can unsubscrie this service any time.</p>';
	        		$message .= '<p>Thank you.</p>';

					$this->email->message($message);
					if($this->email->send()){

					}
					
					$this->email->clear();
					/*==================================*/
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
        	$data['newsletters']= $this->NewsletterModel->get_all_newsletters_except_trash();
        	$this->load->view('nl_admin/newsletter_list', $data);
        }

        function draft_newsletter(){
			$data['title'] = 'Draft Newsletter';
			$data['newsletter_group'] = $this->NewsletterModel->get_groups();
			if ($this->input->method()=='post') {
				//echo var_dump($this->input->post('nl_group'));
				//form validation
				if (empty($this->input->post('nl_group')) AND empty($this->input->post('nl_email'))) {
					$msg['error'][] = 'Newsletter group or Email required.';
				}
				
				if (empty($this->input->post('nl_title'))) {
					$msg['error'][] = 'Newsletter title required.';
				}
				if (count(@$msg['error'])>0) {
					//header('Content-Type: application/json');
					ob_clean();
					echo json_encode($msg);
					//$this->load->view('nl_admin/draft_newsletter', $data);
				}else{
					$insert =  $this->NewsletterModel->add_newsletter();
					if ($insert) {
						$msg['success'] = 'success';
					}else{
						$msg['error'] = 'Error';
					}
					ob_clean();
					echo json_encode($msg);
					//redirect('newsletter/n_list');
				}
			}else{
				$this->load->view('nl_admin/draft_newsletter', $data);
			}
        	
        	
        }

        function edit_newsletter($newsletter_id=null){
			$data['title'] = 'Edit Newsletter';
			$data['newsletter_group'] = $this->NewsletterModel->get_groups();
			$data['newsletters']= $this->NewsletterModel->get_newsletters($newsletter_id);
			if (!$data['newsletters']) {
				redirect('newsletter/n_list');
			}
			if ($this->input->method()=='post') {
				//echo var_dump($this->input->post('nl_group'));
				//form validation
				if (empty($this->input->post('nl_group')) AND empty($this->input->post('nl_email'))) {
					$msg['error'][] = 'Newsletter group or Email required.';
				}
				
				if (empty($this->input->post('nl_title'))) {
					$msg['error'][] = 'Newsletter title required.';
				}
				if (count(@$msg['error'])>0) {
					//header('Content-Type: application/json');
					echo json_encode($msg);
					//$this->load->view('nl_admin/draft_newsletter', $data);
				}else{
					$update =  $this->NewsletterModel->update_newsletter();
					if ($update) {
						$msg['success'] = 'success';
					}else{
						$msg['error'] = 'Error';
					}
					
					echo json_encode($msg);
					//redirect('newsletter/n_list');
				}
			}else{
				$this->load->view('nl_admin/edit_newsletter', $data);
			}
        	
        	
        }

        function send_newsletter(){
			if ($this->input->method()=='post') {
				$encoded_tracking = $this->input->post('tracking_no');
				if (!empty($encoded_tracking) AND $encoded_tracking<>null) {
					$decoded_tracking_no = $this->NewsletterModel->decode_newsletter_tracking_no($encoded_tracking);
					$newsletter_info = $this->NewsletterModel->get_newsletter_by_trackingId($decoded_tracking_no);
					if ($newsletter_info) {
						$data['status'] = 'success';
						$data['msg'] = '<p>Creating newsletter que. Please wait...</p>';

						$nl_group = $newsletter_info->nl_group;
						$nl_email = $newsletter_info->nl_email.',';
						$nl_content = $newsletter_info->nl_contents;
						//get all groups
						
						//parsing all email from group
						//get all subscribers
						$all_subscribers = $this->NewsletterModel->get_subscribers();
						foreach ($all_subscribers as $subscriber) {
							$subscriber_group = explode(',', $subscriber->subscription_group);
							if(in_array($nl_group, $subscriber_group)){
								$nl_email .= $subscriber->email.',';
							}
						}
						$nl_email = rtrim($nl_email, ',');
						$nl_email = explode(',', $nl_email); //convert to array;
						$nl_email = array_unique($nl_email); //only uniqye content
						$nl_email = implode(',', $nl_email);

						//now create newsletter que in another table
						
						$this->NewsletterModel->create_newsletter_que($newsletter_info->title, $nl_email, $nl_content);
						
						/*
						get all subc list
						explode group id from subc list array(1,3)

						*/
						$data['que_status'] = 'success';

					}else{
						$data['status'] = 'failed';
					}

				}else{
					$data['status'] = 'failed';
					//redirect('newsletter/n_list');
				}
					//redirect('newsletter/n_list');
				
			}else{
				//echo $decoded_tracking_no;
				//$this->load->view('nl_admin/edit_newsletter', $data);
				$data['status'] = 'invalid';
			}
			echo json_encode($data);
        	
        	
        }

        function send_email_newsletter(){
        	$uniqueId = $this->session->uniqueId;
        	if (!empty($uniqueId)) {
        		$newsletter = $this->NewsletterModel->get_newsletter_que($uniqueId);
        		if ($newsletter) {
        			//content
	        		$email_list = explode(',', $newsletter->email) ;
	        		$newsletter_content = $newsletter->nl_contents;

	        		$this->load->library('email');
	        		//$config['protocol'] = 'sendmail';
	        		$config['mailtype'] = 'html';
	        		$this->email->initialize($config);

	        		$this->email->from('service@prominentbanker.com', 'Prominent Banker', 'service@prominentbanker.com');
	        		foreach ($email_list as $email) {
	        			$this->email->to($email);
	        		}
	        		$this->email->subject($newsletter->title);
					$this->email->message($newsletter_content);
					if($this->email->send()){
						$data['status']='success';
	        			$data['msg'] = 'Newsletter sent.';
					}else{
						$data['status']='failed';
						$data['msg']=$this->email->print_debugger();
					}
					$this->email->clear();
					$this->NewsletterModel->update_newsletter_que($uniqueId);
					
        		}else{
        			$data['status']='failed';
	        		$data['msg'] = 'Newsletter not found.';
        		}
        		

        	}else{
        		$data['status']='invalid';
        		$data['msg'] = 'Newsletter que not found.';
        	}
        	echo  json_encode($data);
        }

        function get_newsletter_info(){
			$data['title'] = 'Edit Newsletter';
			
			if ($this->input->method()=='post') {
				$tracking_id = $this->input->post('tracking_no');
				if (!empty($tracking_id)) {
					$data['newsletter'] = $this->NewsletterModel->get_newsletter_by_trackingId($tracking_id);
					if ($data['newsletter']) {
						$this->load->view('nl_admin/send_newsletter_preview', $data);
					}else{ 
						echo 'No newsletter found.';
					}
				}else{
					echo 'Invalid request. Please try again later.';
				}
				
			}else{
				//echo $decoded_tracking_no;
				//$this->load->view('nl_admin/edit_newsletter', $data);
			}
        	
        	
        }

        function search_subscribers_email(){
        	$q = $this->NewsletterModel->search_subscribers($this->input->post('searchTerm'));
        	
        	if ($q) {
        		foreach ($q as $res) {
        			$data[] = array("id"=>$res->email, "text"=>$res->email);
        		}
        	}
        	echo json_encode($data);
        }

        function trash_newsletter(){
        	$encoded_tracking = $this->input->post('tracking_no');
        	if (!empty($encoded_tracking) AND $encoded_tracking<>null) {
				$decoded_tracking_no = $this->NewsletterModel->decode_newsletter_tracking_no($encoded_tracking);

				$q = $this->NewsletterModel->trash_nl($decoded_tracking_no);
	        	if ($q) {
	        		$data['msg'] = 'success';
	        		$data['tracking_no'] =$decoded_tracking_no;
	        	}else{
	        		$data['msg']='error';
	        	}

			}else{
				$data['msg'] = 'invalid';
			}

        	echo json_encode($data);
        }




	}