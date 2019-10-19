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

		function get_subscribers($email=null,$id=null){
			if (!empty($email)) {
				$q = $this->db->get_where('subscriber',array('email'=>$email));
				return $q->row();
			}elseif (!empty($id)) {
				$q = $this->db->get_where('subscriber',array('id'=>$id));
				return $q->row();
			}else{

				$q = $this->db->get('subscriber');
				return $q->result();
			}
			
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

		function get_newsletters($nl_id=null, $search_term=null){
			if (!empty($nl_id)) {
				$q = $this->db->get_where('newsletter_contents',array('nl_id'=>$nl_id));
				return $q->row();
			}else{
				$q = $this->db->get('newsletter_contents');
				return $q->result();
			}
			
		}

		function add_newsletter(){
			$this->db->set('tracking_no', time());
			$this->db->set('nl_group', $this->input->post('nl_group'));
			$this->db->set('title', $this->input->post('nl_title'));
			$this->db->set('nl_email', $this->input->post('nl_email'));
			$this->db->set('nl_contents', $this->input->post('nl_contents'));
			$this->db->set('status', '1');
			$this->db->set('user', 'none');

			$this->db->insert('newsletter_contents');
		}

		
	}