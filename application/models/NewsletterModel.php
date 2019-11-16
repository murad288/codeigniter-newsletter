<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');

	/**
	 * Newsletter Model
	 * written by M Hossain
	 * 14.09.2019
	 */
	class NewsletterModel extends CI_model
	{
		
		function __construct()
		{
			parent::__construct();
		}

		function add_subscriber(){
			$this->db->set('name',$this->input->post('subs_name',true));
			$this->db->set('email',$this->input->post('subs_email',true));
			if ($group = $this->input->post('subs_group',true)) {
				$group_list ='';
				foreach ($group as $group_name) {
					$group_list .= $group_name.',';
				}
				$group_list = rtrim($group_list,',');
			}
			$this->db->set('subscription_group',$group_list);
			$this->db->set('status','active');

			$this->db->insert('subscriber');

			return $this->db->insert_id();

		}

		function get_subscribers($email=null,$id=null,$status='active'){
			if (!empty($email)) {
				$q = $this->db->get_where('subscriber',array('email'=>$email));
				return $q->row();
			}elseif (!empty($id)) {
				$q = $this->db->get_where('subscriber',array('id'=>$id));
				return $q->row();
			}elseif (!empty($status)) {
				$q = $this->db->get_where('subscriber',array('status'=>$status));
				return $q->result();
			}else{

				$q = $this->db->get('subscriber');
				return $q->result();
			}
			
		}

		function search_subscribers($term, $status='active'){
			if ($term <>'') {
				$this->db->like('name', $term);
				$this->db->or_like('email', $term);

			}
			$q = $this->db->get('subscriber');
			return $q->result();
			
		}

		function edit_subscriber(){
			$this->db->set('name',$this->input->post('subs_name',true));
			//$this->db->set('email',$this->input->post('subs_email',true));
			if ($group = $this->input->post('subs_group',true)) {
				$group_list ='';
				foreach ($group as $group_name) {
					$group_list .= $group_name.',';
				}
				$group_list = rtrim($group_list,',');
			}
			$this->db->set('subscription_group',$group_list);
			$this->db->set('status', $this->input->post('status'));
			$this->db->where('email',$this->input->post('subs_email'));
			$this->db->update('subscriber');

			return true;

		}

		function delete_subscriber(){
			
			$this->db->where('id', $this->input->post('subsc_id'));
			$this->db->delete('subscriber');

			return true;

		}

		function is_exist_subscriber($email){
        	$rows = $this->get_subscribers($email);
        	if ($rows) {
        		return true;
        	}else{
        		return false;
        	}
        }

        function add_group(){
			$this->db->set('group_name',$this->input->post('group_name',true));
			$this->db->set('status', 'active');
			

			$this->db->insert('subscriber_group');

			return $this->db->insert_id();

		}

        function is_exist_group($group){
        	$rows = $this->get_groups($group);
        	if ($rows) {
        		return true;
        	}else{
        		return false;
        	}
        }

        function get_groups($group=null, $id=null){
			if (!empty($group)) {
				$q = $this->db->get_where('subscriber_group',array('group_name'=>$group));
				return $q->row();
			}elseif (!empty($id)) {
				$q = $this->db->get_where('subscriber_group',array('gid'=>$id));
				return $q->row();
			}else{
				$q = $this->db->get('subscriber_group');
				return $q->result();
			}
			
		}

		function update_group(){
			$this->db->set('group_name',$this->input->post('group_name',true));
			
			$this->db->set('status', $this->input->post('group_status'));
			$this->db->where('gid',$this->input->post('gid'));
			$this->db->update('subscriber_group');

			return true;

		}
		//status : 1 //active
		function get_newsletters($nl_id=null, $search_term=null){
			if (!empty($nl_id)) {
				$q = $this->db->get_where('newsletter_contents', array('nl_id'=>$nl_id));
				return $q->row();
			}elseif (!empty($status)) {
				$q = $this->db->get_where('newsletter_contents', array('status'=>$status));
				return $q->row();
			}else{
				$q = $this->db->get('newsletter_contents');
				return $q->result();
			}
			
		}

		function get_newsletter_by_trackingId($tracking_id=null){
			if (!empty($tracking_id)) {
				$q = $this->db->get_where('newsletter_contents', array('tracking_no'=>$tracking_id));
				return $q->row();
			}else{
				return false;
			}
			
		}

		function get_all_newsletters_except_trash(){
			$q = $this->db->get_where('newsletter_contents', array('status<>'=>2));
			return $q->result();
			
		}
		function get_all_newsletters(){
			$q = $this->db->get_where('newsletter_contents');
			return $q->result();
			
		}

		function add_newsletter(){
			$this->db->set('tracking_no', time());
			$this->db->set('nl_group', implode(',', $this->input->post('nl_group')));

			$this->db->set('title', $this->input->post('nl_title'));
			if(!empty($this->input->post('nl_email')) ){
				$this->db->set('nl_email', implode(',', $this->input->post('nl_email')) );
			}else{
				if ($this->input->post('nl_email')==NULL) {
					//set default email
					$this->db->set('nl_email', 'news@prominentbanker.com');
				}else{
					$this->db->set('nl_email', $this->input->post('nl_email'));
				}
				
			}
			
			$this->db->set('nl_contents', $this->input->post('nl_contents'));
			$this->db->set('status', '1');
			$this->db->set('user', 'none');

			$this->db->insert('newsletter_contents');

			return $this->db->insert_id();
		}

		function update_newsletter(){
			
			$this->db->set('nl_group', implode(',', $this->input->post('nl_group')));

			$this->db->set('title', $this->input->post('nl_title'));
			if(!empty($this->input->post('nl_email')) ){
				$this->db->set('nl_email', implode(',', $this->input->post('nl_email')) );
			}else{
				$this->db->set('nl_email', $this->input->post('nl_email') );
			}
			$this->db->set('nl_contents', $this->input->post('nl_contents'));
			//$this->db->set('status', '1');
			//$this->db->set('user', 'none');

			$this->db->where('tracking_no',$this->input->post('tracking_id'));
			$q = $this->db->update('newsletter_contents');

			return $q;
			
		}

		function trash_nl($tracking_no){
			$this->db->set('status', '2');
			//$this->db->set('user', 'none');
			$this->db->where('tracking_no',$tracking_no);
			$q = $this->db->update('newsletter_contents');

			return $q;
		}
		/*
		| NUMERIC $tracking_no
		*/
		function encode_newsletter_tracking_no($tracking_no){
			$this->session->set_userdata('initial_track',time());
			$encoded_track = $tracking_no+$this->session->initial_track;

			return $encoded_track;
		}

		/*
		| NUMERIC $tracking_no
		*/
		function decode_newsletter_tracking_no($encoded_track){
			
			$decoded_track = $encoded_track - $this->session->initial_track;

			return $decoded_track;
		} 

		function create_newsletter_que($title,$email=null, $nl_contents=null){
			if (!empty($email) and $email<>null and $nl_contents<>null and !empty($nl_contents)) {
				$uniqueId = time();
				$this->session->set_flashdata('uniqueId',$uniqueId);

				$this->db->set('title', $title);
				$this->db->set('email', $email);
				$this->db->set('nl_contents', $nl_contents);
				$this->db->set('user', $this->session->userId);
				$this->db->set('created_time', date('Y-m-d h:i:s'));
				$this->db->set('status', 'pending');
				$this->db->set('uniqueId', $uniqueId);

				$this->db->insert('newsletter_que');

				return $this->db->insert_id();
			}else{
				return false;
			}
		}

		function get_newsletter_que($uniqueId){
			$q = $this->db->get_where('newsletter_que', array('uniqueId'=>$uniqueId, 'status'=>'pending'));
			return $q->row();
		}

		function update_newsletter_que($uniqueId){
			$this->db->set('status', 'sent');
			$this->db->where('uniqueId',$uniqueId);
			$this->db->update('newsletter_que');
		}

		
	}