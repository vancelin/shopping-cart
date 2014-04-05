<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('libraries_model');
    }

    public function index(){
        
        $session = $this->session->userdata('logged_in');
        $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
        $this->load->library("lvax");
        
        if($session){
            $this->lvax->_front_end("user",$user,"report",array("account"=>$session));
        }else{
            $this->lvax->_front_end("","","report",array("account"=>$session));
        }
        
    }
    
    public function yes(){
        
        if($this->input->post()){
            
            $session = $this->session->userdata('logged_in');
            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
            $rule = 'trim|required|xss_clean';
            
            if(!$session){
                
                $this->form_validation->set_rules('name', '姓名', $rule);
                $this->form_validation->set_rules('email', 'Email', $rule);
                
            }
            
            $this->form_validation->set_rules('subject', '主旨', $rule . '|max_length[20]');
            $this->form_validation->set_rules('sug', '內容', $rule);
            
            if($this->form_validation->run() == FALSE){
                
                $this->load->library("lvax");
                $this->lvax->_wait(base_url('report'),"3","請重新檢查您的內容");
                
            }else{
                
                $data = array(
                    'name'      =>  ($session) ? $user['name'] : $this->input->post("name",true),
                    'email'     =>  ($session) ? $user['email'] : $this->input->post("email",true),
                    'subject'   =>  $this->input->post("subject",true),
                    'sug'       =>  $this->input->post("sug",true),
                    'date'      =>  time()
                );
                
                $this->libraries_model->_insert("report",$data);
                $this->load->library("lvax");
                $this->lvax->_wait("report","3","感謝您寶貴的意見");
                
            }
            
        }else{
            redirect(base_url('report'));
        }
        
    }

}
?>
