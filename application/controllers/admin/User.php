<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index()
    {
        $this->data['page_title'] = '使用者管理';

        $query = $this->ion_auth_model->getUsers();
        $data = array();
        //total rows count
        $totalRec = (!empty($query)? count($query) : 0);
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/user/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //get the posts data
        $this->data['auth'] = $this->ion_auth_model->getUsers(array('limit'=>$this->perPage));

        $this->render('admin/user/index');
    }

    function ajaxData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->get('keywords');
        // $sortBy = $this->input->get('sortBy');
        $category = $this->input->get('category');
        $status = $this->input->get('status');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        // if(!empty($sortBy)){
        //     $conditions['search']['sortBy'] = $sortBy;
        // }
        if(!empty($category)){
            $conditions['search']['category'] = $category;
        }
        if(!empty($status)){
            $conditions['search']['status'] = $status;
        }
        //total rows count
        $totalRec = count($this->ion_auth_model->getUsers($conditions));
        //pagination configuration
        $config['target']      = '#datatable';
        $config['base_url']    = base_url().'admin/user/ajaxData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination_admin->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $this->data['auth'] = $this->ion_auth_model->getUsers($conditions);
        //load the view
        $this->load->view('admin/user/ajax-data', $this->data, false);
    }

    public function export()
    {

    	$AlllineData = array();
    	$fields = array('流水號', '帳號', '名稱', '電子郵件', '手機號碼', '聯絡地址', '生日', '推薦碼', '註冊日期');
    	array_push($AlllineData, $fields);

	    if (!empty($this->input->post('username'))) {

	    	foreach ($this->input->post('username') as $username) {
	    		$this->db->select('*');
	            $this->db->where('username', $username);
	            $query = $this->db->get('users');
	            if ($query->num_rows() > 0) {
			        foreach($query->result_array() as $row){

			        	$lineData = array
				        (
				            $row['id'],
				            $row['username'],
				            $row['full_name'],
				            $row['email'],
				            "+'".$row['phone'],
				            $row['county'].$row['district'].$row['address'],
				            $row['birthday'],
				            $row['recommend_code'],
				            $row['created_at'],
				        );
				        array_push($AlllineData, $lineData);

			        }
			    }
	        }

	    } else {

	        // $this->db->select('*');
	        $this->db->join('users_groups', 'users_groups.user_id = users.id');
            $this->db->where('group_id', 2);
            $query = $this->db->get('users');
            if ($query->num_rows() > 0) {
		        foreach($query->result_array() as $row){

		        	$lineData = array
			        (
			            $row['id'],
			            $row['username'],
			            $row['full_name'],
			            $row['email'],
			            strval($row['phone']),
			            $row['county'].$row['district'].$row['address'],
			            $row['birthday'],
			            $row['recommend_code'],
			            $row['created_at'],
			        );
			        array_push($AlllineData, $lineData);

		        }
		    }

		}

        // header('Content-Type: application/json');
        // echo json_encode($AlllineData, JSON_PRETTY_PRINT);

        function filterData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // file name for download
        $fileName = "使用者_".date('Y-m-d H-i-s') . ".xls";

        // headers for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        $flag = false;
        // utf8_to_big5_array() 把陣列utf8_to_big5
        foreach(utf8_to_big5_array($AlllineData) as $row) {
            if(!$flag) {
                // display column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";
        }
	    
    }

    // create a new user
	public function create_user()
    {
    	$this->data['page_title'] = '建立使用者';
        //$this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('/admin/auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
				'creator_id' => $this->ion_auth->user()->row()->id,
				'created_at' => date('Y-m-d H:i:s'),
            );
        }
        if ($this->form_validation->run() == true && $id = $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
        	$data = array(
				'access_id' => $id,
	        );
	        $this->db->insert('access', $data);
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("auth", 'refresh');
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            //$this->_render_page('auth/create_user', $this->data);
            $this->render('admin/user/create_user','admin_master');
        }
    }

	// edit a user
	public function edit_user($id)
	{
		$this->data['page_title'] = '使用者管理';
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('/admin/user', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			// if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			if ($id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			// if ($this->form_validation->run() === TRUE)
			// {
				$data = array(
					'full_name'  => $this->input->post('full_name'),
					'gender'     => $this->input->post('gender'),
					'email'      => $this->input->post('email'),
					'phone'      => $this->input->post('phone'),
					'county'     => $this->input->post('county'),
					'district'   => $this->input->post('district'),
					'address'    => $this->input->post('address'),
					'birthday'   => $this->input->post('birthday'),
					'updater_id' => $this->ion_auth->user()->row()->id,
					'updated_at' => date('Y-m-d H:i:s'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('/admin/user', 'refresh');
					}
					else
					{
						redirect('/admin/user', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('/auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
			    }
			// }
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
			'class' => 'form-control'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
			'class' => 'form-control'
		);

		//$this->_render_page('auth/edit_user', $this->data);
		$this->render('admin/user/edit_user','admin_master');
	}

	public function delete_user($id)
	{
		$this_user = $this->mysql_model->_select('users','id',$id,'row');
		if($this_user['oauth_uid']!=''){

			//
			$userID = $this_user['oauth_uid'];
			$text1 = '歡迎加入';
			$text2 = '我們是美食特攻隊，專門為上班族解決午餐的煩惱！點擊下方按鈕註冊，立即開始享受美食吧！';
			$text3 = '立即註冊';
			$array = urlencode('[{
	"type": "flex","altText": "'.$text1.' By The Way","contents": {"type": "bubble","direction": "ltr","body": {"type": "box","layout": "vertical","contents": [
	{"type": "text","text": "'.$text1.' By The Way","size": "lg","align": "center","weight": "bold"},{"type": "text","text": "'.$text2.'","margin": "md","align": "center","wrap": true}]},"footer": {"type": "box","layout": "horizontal","contents": [{"type": "button","action": {"type": "uri","label": "'.$text3.'",
	"uri": "line://app/1570658971-vEX85E04"},"style": "primary"}]}}}]');

			$url = 'http://api2.sstrm.net/util/loadScriptToExec?q=genericLinePush&botID=1570658971&userID='.$userID.'&msgJA='.$array.'';

	    	file_get_contents($url);
	    	//

		}

		if($this->ion_auth->delete_user($id)){
			$this->db->where('user_id', $id);
        	$this->db->delete('user_coupon');
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('/admin/user');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('/admin/user');
		}
	}

// 	public function test222()
// 	{
// 		$userID = 'U54ff59e24d04516376f104e26420aefa';
// 		$text1 = '歡迎加入';
// 		$text2 = '我們是美食特攻隊，專門為上班族解決午餐的煩惱！點擊下方按鈕註冊，立即開始享受美食吧！';
// 		$text3 = '立即註冊';
// 		$array = urlencode('[{
// "type": "flex","altText": "'.$text1.' By The Way","contents": {"type": "bubble","direction": "ltr","body": {"type": "box","layout": "vertical","contents": [
// {"type": "text","text": "'.$text1.' By The Way","size": "lg","align": "center","weight": "bold"},{"type": "text","text": "'.$text2.'","margin": "md","align": "center","wrap": true}]},"footer": {"type": "box","layout": "horizontal","contents": [{"type": "button","action": {"type": "uri","label": "'.$text3.'",
// "uri": "line://app/1570658971-vEX85E04"},"style": "primary"}]}}}]');

// 		$url = 'http://api2.sstrm.net/util/loadScriptToExec?q=genericLinePush&botID=1570658971&userID='.$userID.'&msgJA='.$array.'';

//     	file_get_contents($url);
// 	}

	// change password
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			//$this->_render_page('auth/change_password', $this->data);
			$this->render('admin/user/change_password','admin_master');
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				// if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	public function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			//$this->_render_page('auth/forgot_password', $this->data);
			$this->render('admin/user/forgot_password','admin_master');
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

        		if($this->config->item('identity', 'ion_auth') != 'email')
            	{
            		$this->ion_auth->set_error('forgot_password_identity_not_found');
            	}
            	else
            	{
            	   $this->ion_auth->set_error('forgot_password_email_not_found');
            	}

                $this->session->set_flashdata('message', $this->ion_auth->errors());
        		redirect("auth/forgot_password", 'refresh');
    		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				//$this->_render_page('auth/reset_password', $this->data);
				$this->render('admin/user/reset_password','admin_master');
			}
			else
			{
				// do we have a valid request?
				if ($user->id != $this->input->post('user_id'))
				// if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("/auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("/auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		$this->data['page_title'] = '關閉帳號';
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('您必須是管理員才可以瀏覽此頁面。');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			//$this->_render_page('auth/deactivate_user', $this->data);
			$this->render('admin/user/deactivate_user','admin_master');
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($id != $this->input->post('id'))
				// if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('/auth', 'refresh');
		}
	}

	public function edit_delivery_time($id)
	{
		$this->data['page_title'] = '選擇可訂購時間';

		// validate form input
		if (isset($_POST) && !empty($_POST))
		{
			if (!empty($this->input->post('delivery_time'))) {
				$this->db->where('user_id', $id);
				$this->db->delete('users_delivery_time');
            	foreach ($this->input->post('delivery_time') as $delivery_time) {
            		$insert_data = array(
						'user_id'          => $id,
						'delivery_time_id' => $delivery_time,
		            );
		            $this->db->insert('users_delivery_time', $insert_data);
            	}
            	$this->session->set_flashdata('message', '選擇可訂購時間更新成功！');
            }
		}
		$this->data['delivery_time'] = $this->mysql_model->_select('delivery_time');
		$this->data['users_delivery_time'] = $this->mysql_model->_select('users_delivery_time', 'user_id', $id);

		$this->render('admin/user/edit_delivery_time','admin_master');
	}

	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

	function updateUsers() {
        $updateData = array(
            'full_name' => $this->input->post('full_name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
        );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('users',$updateData);
    }

}