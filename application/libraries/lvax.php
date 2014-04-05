<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lvax extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('email');
        $this->load->model('libraries_model');
    }
    
    public function _send_mail($to = null, $subject = null, $message = null, $from = 0, $from_name = 0){
        
        $data = $this->libraries_model->_select("site_setting");
        
        if($data[4]['value'] == 'smtp'){
            
            $config['protocol']     =  $data[4]['value'];
            $config['mailtype']     =  $data[5]['value'];
            $config['smtp_host']    =  $data[6]['value'];
            $config['smtp_port']    =  $data[7]['value'];
            $config['smtp_user']    =  $data[8]['value'];
            $config['smtp_pass']    =  $data[9]['value'];
            $config['validation']   =  $data[10]['value'];
            $config['charset']      =  'utf-8';
            $config['newline']      =  "\r\n";

            
        }elseif($data[4]['value'] == 'sendmail' || $data[4]['value'] == 'mail'){
            
            
            $config['protocol']     =  $data[4]['value'];
            $config['mailtype']     =  $data[5]['value'];
            $config['mailpath']     =  $data[11]['value'];
            $config['charset']      =  'utf-8';
            $config['newline']      =  "\r\n";
            
        }
        
        $this->email->initialize($config);
        
        if(!$from && !$from_name){
            $this->email->from($data[2]['value'],$data[0]['value']);
        }else{
            $this->email->from($from,$from_name);
        }
        
        $this->email->to($to); 

        $this->email->subject($subject);
        $this->email->message($message);  

        if(!$this->email->send()){
            echo $this->email->print_debugger();
        }
    }
    /*
    public function _send_mail($to = null, $subject = null, $message = null, $from = null, $from_name = null, $reply_to = null, $reply_name = null, $cc = null, $bcc = null){

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = '192.168.40.130';//ssl://smtp.gmail.com
        $config['smtp_port']    = '25';//465
        $config['smtp_user']    = 'test@192.168.40.130';//gmail user
        $config['smtp_pass']    = '123456';//gmail pass
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      
        
        $this->email->initialize($config);

        $this->email->from('test@192.168.40.130', 'myname');
        $this->email->to('mrj.zero@gmail.com'); 

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  

        if(!$this->email->send()){
            echo $this->email->print_debugger();
        }else{
            echo 'success';
        }
        
    }*/
    
    public function _json_callback($code = true, $msg = null, $data = null){

        $callback = array(
                        'state' => $code,
                        'msg'   => $msg,
                        'data'  => $data,
                    );

        return json_encode( $callback );

    }
    
    public function _get_ip(){
        
        static $realIP;
        
        if($realIP) return $realIP;

        //代理时
        $ip = getenv('HTTP_CLIENT_IP')?  getenv('HTTP_CLIENT_IP'):getenv('HTTP_X_FORWARDED_FOR');
        preg_match("/[\d\.]{7,15}/", $ip, $match);
        if(isset($match[0])) return $realIP = $match[0];

        //非代理时
        $ip = !empty($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:'0.0.0.0';
        preg_match("/[\d\.]{7,15}/", $ip, $match);

        return $realIP = isset($match[0])? $match[0]:'0.0.0.0';
    }
    
    public function _bad_login($username){
        
        $ip = $this->_get_ip();
        $time = date("Y-m-d H:i:s"); 
        
        $data = array(
            'name_or_email' =>  $username,
            'ip'            =>  $ip,
            'time'          =>  $time
        );
        
        $this->libraries_model->_insert('bad_login',$data);
        
    }
    
    public function _pagination($method, $table, $perpage = 10){  
        $config['base_url'] = base_url('admin/'.$method.'/');  
        $config['total_rows'] = $this->_count_all($table);  
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 4;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<div class="page-control">';
        $config['first_tag_close'] = '</div>';
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<div class="page-control">';
        $config['last_tag_close'] = '</div>';
        $config['next_link'] = '>';
        $config['next_tag_open'] = '<div class="page-control">';
        $config['next_tag_close'] = '</div>';
        $config['prev_link'] = '<';
        $config['prev_tag_open'] = '<div class="page-control">';
        $config['prev_tag_close'] = '</div>';
        return $config;  
    }  
    
    public function _count_all($table){
        return $this->libraries_model->_count_all($table);
    }
    
    public function _wait($url,$second,$words = 0){
        
        $data['setting'] = array(
            'url'       =>  $url,
            'second'    =>  $second,
            'words'     =>  ($words) ? $words : "動作完成!"
        );
        
        $this->load->view("admin/wait",$data);
        
    }
    
    public function _front_end($data_name,$sql_operation,$page_name,$data_array = 0,$other = 0){
        
        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
        $data[$data_name] = $sql_operation;
        $data['setting'] = $this->libraries_model->_select('site_setting');
        $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
        
        if($data_array && is_array($data_array)){
            
            foreach($data_array as $key => $item){
                
                if($key == 'account'){
                    if($item){
                        $data['account'] = $item;
                    }
                }else{
                    $data[$key] = $item;
                }
                
            }
            
        }
        
        if($other){
            $data = $other;
        }
        
        $this->load->view('header',$data);
        $this->load->view($page_name,$data);
        $this->load->view('footer',$data);
        
    }

}