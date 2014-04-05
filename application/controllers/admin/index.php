<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('libraries_model');
        $this->load->library('lvax');
    }

    public function index(){
        if (!$this->session->userdata('manage_logged_in')){          		
            $this->load->view('login');
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('admin'));
    }

    public function validate_credentials(){

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        $this->form_validation->set_message('required','%s不能為空值');

        if($this->form_validation->run() == FALSE){
            $this->load->view('login');
        }else{
            redirect('admin/product/index', 'refresh');
        }
    }

    public function check_database($password){

        $username = $this->input->post('username');
        
        $password = $this->_mix($password);

        $result = $this->admin_model->manage_login($username, $password);
        
        //驗證碼
        $chec = $this->input->post('Checknum');
        $checknum = $this->session->userdata('Checknum');                

        if($chec != $checknum) return false;

        if($result){
            
            $sess_array = array();

            $sess_array = array(
                'id' => $result['id'],
                'username' => $result['username'],
                'admin' => TRUE,
                'logged_in' => TRUE
            );
            
            $this->session->set_userdata('manage_logged_in',$sess_array);
            
            //記錄登入狀態
            $ip = $this->lvax->_get_ip();
            $time = date("Y-m-d H:i:s"); 
            
            $this->libraries_model->_update('admin_user',array('last_login_ip'=>$ip,'last_login_time'=>$time),'username',$result['username']);
            
            return TRUE;
        }else{
            $this->form_validation->set_message('check_database','錯誤的帳號或密碼');
            
            $this->lvax->_bad_login($this->input->post('username',true));
            
            return FALSE;
        }

    }
    
    public function _mix($hash){
        
        $hash = md5($hash);
        
	return substr($hash,10).substr($hash,0,6);
        
    }
}
?>
