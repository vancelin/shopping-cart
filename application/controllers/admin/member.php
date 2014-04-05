<?php

class Member extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('libraries_model');
        $this->load->model('admin_model');
        $this->load->library('pagination');
        $this->load->library('lvax');
    }

    public function index($index = 0){

        $select = 'id,fbid,name,sex,email,phone,address,login_ip,last_login';
        $data['result'] = $this->libraries_model->_select('userdata', 0, 0, $index * 10, 10, 'id', 0, 'result',$select);

        $this->load->view('admin/member',$data);

    }

    public function search($data = null ,$method='email',$index=0){

        $data = urldecode($data);
        if( $this->uri->segment(4, 0) == false ){

            $select = 'id,fbid,name,sex,email,phone,address,login_ip,last_login';
            $view['result'] = $this->libraries_model->_select('userdata', 0, 0, $index * 10, 10, 'id', 0, 'result',$select);
            $this->load->view('admin/member_search', $view);

        }else{

            if( $method == 'password' ) return;
            $view['result'] = $this->libraries_model->
                _select('userdata', $method, 0, $index * 10, 10, 'id', 0, 'result', 0, $data);
            $this->load->view('admin/member_search', $view);
        }

    }

    public function detail($email=null){

        if (!$this->session->userdata('manage_logged_in')){          		
            redirect(base_url('admin'));
            return;
        }

        if( $email ){
            $data['email'] = $email;
            $data['user'] = $this->admin_model->_member($email);
            $this->load->view('admin/member_detail', $data);
        }
    }

    public function reset($email = null){

        if (!$this->session->userdata('manage_logged_in')){
            redirect(base_url('admin'));
            return;
        }

        if( $email ){
            $user = $this->admin_model->_member($email);
            if( $user ){

                $data = array('password' => $this->_mix("123456") );
                echo ( $this->libraries_model->_update('userdata', $data, 'email', $email) ) ?
                     $this->lvax->_json_callback(1) : $this->lvax->_json_callback(0);
            }
        }

    }

    public function report($index = 0){

        if (!$this->session->userdata('manage_logged_in')){
            redirect(base_url('admin'));
            return;
        }

        $data['reports'] = $this->libraries_model->_select('report', 0, 0, $index, 10, 'date', 'desc');

        $conf = $this->lvax->_pagination('member/report/','report',10);
        $this->pagination->initialize($conf);
        $data["links"] = $this->pagination->create_links();

        $this->load->view('admin/report', $data);

    }

    public function _mix($hash){

        $hash = md5($hash);

        return substr($hash,10).substr($hash,0,6);
    }

}
?>
