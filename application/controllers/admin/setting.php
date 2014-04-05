<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('setting_model');
        $this->load->model('libraries_model');
        if (!$this->session->userdata('manage_logged_in')){          		
            redirect('admin/index');
            exit();
        }
    }

    
    public function index(){
        
        $this->load->view('admin/info');
        
    }
    
    public function save_setting(){
        
        if(!$this->input->post()) redirect("admin/setting");
        
        $column = array("site_name","site_slogan","site_email","site_phone");
        
        foreach($this->input->post("site",true) as $key => $post){
            
            if($post != '') $this->libraries_model->_update("site_setting",array("value"=>$post),"key",$column[$key]);
                    
        }
        
    }
    
    public function set_account(){
        
        $this->load->view("admin/set_account");
        
    }
    
    public function chpass(){
        
        if(!$this->input->post()) redirect("admin/setting/set_account");
        
        $old_pwd = $this->_mix($this->input->post("old_pwd",true));
        
        $username = $this->session->userdata('manage_logged_in')['username'];
        
        if($this->libraries_model->_select("admin_user","password",$old_pwd,0,1,0,0,"row") && $this->libraries_model->_select("admin_user","username",$username,0,1,0,0,"row")){
            
            if($this->input->post("new_pwd",true) == $this->input->post("cfm_pwd",true)){
                
                $data = array(
                    "password"  =>  $this->_mix($this->input->post("new_pwd",true))
                );
                
                $this->libraries_model->_update("admin_user",$data,"username",$username);
                
                $this->session->sess_destroy();
                
                echo "1";
                
            }
        }
        
    }
    
    public function _mix($hash){
        
        $hash = md5($hash);
        
	return substr($hash,10).substr($hash,0,6);
        
    }
    
    public function upd(){
        
        $config['file_name'] = "logo.png";
        $config['upload_path'] = realpath(APPPATH . '../public/img/');
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['overwrite'] = true;
        //讀取upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload("logo")){
            
            $info = $this->upload->data();
            
            $dir = APPPATH . '../public/img/';
                    
            $this->_create_thumbnail($dir,$info['file_name'],200,600);
            
            $this->load->library("lvax");
            $this->lvax->_wait(base_url('admin/setting'),"1","儲存成功!");
            
        }else{
            print_r($this->upload->display_errors());
        }

        
    }
    
    function _create_thumbnail($dir,$fileName,$width,$height){
        
        $config['image_library'] = 'gd2';
        $config['source_image'] = $dir . $fileName;	
        $config['maintain_ratio'] = false;
        $config['width'] = $width;
        $config['height'] = $height;

        $this->load->library('image_lib', $config);
        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();

    }
    
    public function set_footer(){
        
        $data['results'] = $this->libraries_model->_select("site_page",0,0,0,0,"page_sequence",0);
        
        $this->load->view("admin/set_footer",$data);
        
    }
    
    public function save_footer(){
        
        if(!$this->input->post()) redirect (base_url('admin/setting'));
        
        $time = date("Y-m-d H:i:s");
        
        if($this->input->post("url",true) == ''){
            
            $data = array(
                'active'        =>  $this->input->post("chkdio",true),
                'url_active'    =>  '0',
                'page_sequence' =>  $this->input->post("sequence",true),
                'title'         =>  $this->input->post("title",true),
                'content'       =>  $this->input->post("text"),
                'time'          =>  $time
            );

        }else{
            
            $data = array(
                'active'        =>  $this->input->post("chkdio",true),
                'url_active'    =>  '1',
                'url'           =>  $this->input->post("url",true),
                'page_sequence' =>  $this->input->post("sequence",true),
                'title'         =>  $this->input->post("title",true),
                'time'          =>  $time
            );
            
        }
        
        $mode = $this->input->post("mode",true);
        
        if($mode == '1'){
            $this->libraries_model->_update("site_page",$data,"id",$this->input->post("page_id",true));
            $this->load->library("lvax");
            $this->lvax->_wait(base_url('admin/setting/set_footer'),"1","儲存成功!");
        }elseif(!isset($mode)){
            echo $this->libraries_model->_insert("site_page",$data);
        }
        
        
    }
    
    public function site_setting(){
        
        $data['site_setting'] = $this->libraries_model->_select("site_setting");
        $this->load->view("admin/setting",$data);
        
    }
    
    public function smtp(){
        
        $data['smtp_settings'] = $this->libraries_model->_select("site_setting");
        $this->load->view('admin/smtp',$data);
        
    }
    
    public function smtp_save(){
        
        if(!$this->input->post()) redirect (base_url('admin/setting'));
        
        $protocol = $this->input->post("smtp",true);
        
        if($protocol[0] == 'smtp'){
            
            $column = array('protocol','smtp_type','smtp_host','smtp_port','smtp_user','smtp_pass');
            
            foreach($this->input->post("smtp",true) as $key => $post){
                
                if($post != '') @$this->libraries_model->_update("site_setting",array("value"=>$post),"key",$column[$key]);
                
            }
            
            $this->libraries_model->_update("site_setting",array("value"=>$this->input->post("validate",true)),"key","validate");
            
        }elseif($protocol[0] == 'mail' || $protocol[0] == 'sendmail'){
            
            $column = array('protocol','smtp_type','mail_path');
            
            foreach($this->input->post("smtp",true) as $key => $post){
                
                if($post != '') $this->libraries_model->_update("site_setting",array("value"=>$post),"key",$column[$key]);
                
            }
             
        }
        
        $this->load->library("lvax");
        $this->lvax->_wait(base_url('admin/setting/smtp'),"1","儲存成功!");
        
    }
    
    public function send(){
        
        if(!$this->input->post()) redirect (base_url('admin/setting/smtp'));
        
        $this->load->library("lvax");
        
        echo $this->lvax->_send_mail($this->input->post("to",true),$this->input->post("subject",true),$this->input->post("message",true),$this->input->post("from",true),$this->input->post("from_name",true));
        
    }
    
    public function quick_save_setting(){
        
        if(!$this->input->post()) redirect (base_url('admin/setting'));
        
        $mode = $this->input->post("mode",true);
        $new_text = $this->input->post("new_text",true);
        $id = $this->input->post("id",true);
        
        if($mode == 'active'){
            $this->libraries_model->_update("site_page",array("active"=>$new_text),"id",$id);
        }elseif($mode == 'sequence'){
            $this->libraries_model->_update("site_page",array("page_sequence"=>$new_text),"id",$id);
        }elseif($mode == 'page_title'){
            $this->libraries_model->_update("site_page",array("title"=>$new_text),"id",$id);
        }
        
    }
    
    public function edit_page($page_id = 0){
        
        if(!$page_id) redirect (base_url('admin/setting/set_footer'));
        
        $data['result'] = $this->libraries_model->_select("site_page","id",$page_id,0,0,0,0,"row");
        $this->load->view('admin/edit_page',$data);
        
    }
    
    public function bad_login(){
        
        $offset = ($this->uri->segment(4))?$this->uri->segment(4):0;
        $perpage = ($this->uri->segment(5))?$this->uri->segment(5):"10";//預設一頁十筆
        
        $data['results'] = $this->libraries_model->_select("bad_login",0,0,$offset,$perpage,'id',1);
        $this->load->library('lvax');
        $conf = $this->lvax->_pagination('setting/bad_login/','bad_login',$perpage);
        
        $this->pagination->initialize($conf);
        $data["links"] = $this->pagination->create_links();
        
        $this->load->view('admin/bad_login',$data);
        
    }

    public function validmail($update = 0){

        if( $update ){

            $content = $this->input->post('validContent', true);

            if( preg_match('/\#link\#/', $content) ){
                
                $this->libraries_model->_update('site_setting', array('value' => $content), 'key', 'validmail');
                $this->load->library('lvax');
                echo $this->lvax->_json_callback(1);

            }else{
                $this->load->library('lvax');
                echo $this->lvax->_json_callback(-1);

            }

        }else{

            $data = $this->libraries_model->_select('site_setting', 'key', 'validmail')[0];
            $this->load->view('admin/validmail', $data);

        }

    }
    
}
?>
