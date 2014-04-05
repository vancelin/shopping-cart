<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('libraries_model');
        $this->load->model('member_model');

        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index(){
        
        if ( $this->session->userdata('logged_in') ){

            if( $refer = $this->session->userdata('refer') ){
                $this->session->unset_userdata('refer');
                redirect( $refer );
            }
            
            $session_data = $this->session->userdata('logged_in');
            $data['account'] = $session_data;

            $orders = $this->member_model->_count('checkout', array( 'email' => $session_data['email'] ) );
            $pre_orders = $this->member_model->_count('checkout', array( 'email' => $session_data['email'], 'status' => 0 ) );

            $data['orders'] = ($orders - $pre_orders);
            $data['pre_orders'] = $pre_orders;

            $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
            $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
            $data['setting'] = $this->libraries_model->_select('site_setting');
            
            $this->load->view('header',$data);
            $this->load->view('member/index',$data);
            $this->load->view('footer',$data);

        }else{
            
            $this->login();
        }

    }

    //註冊頁面
    public function signup(){

        $this->load->view('member/signup');

    }

    //Facebook 登入串接
    public function fbsession(){

        include_once dirname(__FILE__) . "/api/fbsession.php";

        if ($fbme){

            try{
                $param = array(
                        'method'   => 'users.getinfo',
                        'uids'     => $fbme['id'],
                        'fields'   => 'name,email,username,sex',
                        'callback' => '',
                        );
                $userInfo = $facebook->api($param);
            } catch (Exception $e) {
                print_r($e);
            }

            print_r( $userInfo );

            $fbdata = $this->member_model->_fblogin( $fbme['id'] );
            if ( $fbdata != false ) {

                $sess_array = array(
                    'id'       => $fbdata['id'],
                    'name'     => $fbdata['name'],
                    'fbid'     => $fbme['id'],
                    'sex'      => $fbdata['sex'],
                    'address'  => $fbdata['address'],
                    'email'    => $fbdata['email'],
                    'phone'    => $fbdata['phone_number'],
                    'username' => $fbdata['username'],
                    'lstlogin' => $fbdata['last_login'],
                    'lstip'    => $fbdata['login_ip'],
                );

                $this->session->set_userdata('logged_in', $sess_array);
                $this->member_model->_uptime($fbdata['id']);     //uptime

                $this->index();

            }else{

                $this->session->set_userdata( 'fbdata', $userInfo[0] );

                $this->load->view('member/fbsignup', $userInfo[0]);
            }

        }else{

            redirect( $loginUrl );

        }

    }

    public function fbsignup(){

        if ( $this->session->userdata('fbdata') ){

            $fbdata = $this->session->userdata('fbdata');

            $rule = 'trim|required|xss_clean';  //共用規則

            $this->form_validation->set_rules('address', 'address', $rule);
            $this->form_validation->set_rules('phone', 'phone', $rule . '|numeric|max_length[10]');
            if ( $this->input->post('username') ){

                    $this->form_validation->set_rules('username', 'Username', $rule . '|alpha_dash|is_unique[userdata.username]');
                    $username = $this->input->post('username');
     
            }else{

                $username = $fbdata['username'];

            }

            if($this->form_validation->run() == FALSE){

                $this->form_validation->set_rules('fbsignup', 'Failed, Please try again.');
                $this->load->view('member/fbsignup', $fbdata);

            }else{

                $data = array(
                            'fbid'          =>  $fbdata['uid']   ,
                            'name'          =>  $fbdata['name']  ,
                            'email'         =>  $fbdata['email'] ,
                            'username'      =>  $username        ,
                            'sex'           =>  $fbdata['sex'] == 'male' ? 0 : 1 ,
                            'address'       =>  $this->input->post('address') ,
                            'phone_number'  =>  $this->input->post('phone')   ,
                        );

                if ( $this->member_model->_register($data) ){

                    $this->member_model->_valid($data['email'], $this->member_model->_mix($data['username']) );
                    echo 'success! Now you can use facebook account to shopping!';

                }else{

                    echo 'Failed , please try again.';

                }

            }

        }else{

                redirect(base_url('member'));

        }

    }

    //註冊處理
    public function register(){

        $rule = 'trim|required|xss_clean';  //共用規則

        //username's is_unique[userdata.username] will check username whether exist or not
        $this->form_validation->set_rules('username', 'Username', $rule . '|alpha_dash|is_unique[userdata.username]');
        $this->form_validation->set_rules('password', 'Password', $rule . '|min_length[6]'); 
        $this->form_validation->set_rules('repassword', 'rePassword', $rule . '|min_length[6]|matches[password]'); 
        $this->form_validation->set_rules('email', 'email', $rule . '|valid_email|is_unique[userdata.email]'); 
        $this->form_validation->set_rules('name', 'name', $rule); 
        $this->form_validation->set_rules('sex', 'sex', $rule); 
        $this->form_validation->set_rules('address', 'address', $rule); 
        $this->form_validation->set_rules('phone', 'phone', $rule . '|numeric|max_length[10]'); 


        if($this->form_validation->run() == FALSE){

            redirect(base_url('member'));

        }else{

            //$username = $this->input->post('username');
            //$password = $this->input->post('password');

            $data = array(
                        'password'        => $this->input->post('password')  ,
                        'email'           => $this->input->post('email')     ,
                        'name'            => $this->input->post('name')      ,
                        'sex'             => $this->input->post('sex') == 'male' ? 0 : 1  ,
                        'address'         => $this->input->post('address')   ,
                        'phone_number'    => $this->input->post('phone')     ,
                    );

            $this->_register($data);

        }

    }

    //檢查使用者是否存在, 方便Ajax
    public function exsit($account){

        //echo $this->member_model->_exsit($account) ? 'exsit' : 'none' ;
        echo json_encode($this->member_model->_exsit($account));
    }

    public function valid($email = null,$hash = null){

        if( $this->member_model->_valid($email, $hash) ){

            echo 'Your account has been valid.';

        }else{

            echo 'Failed, Please check the link is validation.';

        }

    }

    //登入驗證 ,顯示表單
    public function login(){
        
        if ( $this->session->userdata('logged_in') ){

            redirect( 'member' );

        }else{

            $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback__uservalid');   //_uservalid為callback
            if($this->form_validation->run() == FALSE){
                
                $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
                $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
                $data['page_name'] = '會員登入';
                $data['setting'] = $this->libraries_model->_select('site_setting');
                

                $this->load->view('header',$data);
                $this->load->view('member/login',$data);
                $this->load->view('footer',$data);

            }else{
                
                $this->index();

            }

        }
    }


    public function orders($index = 0, $id = 0, $mode = 0){

        if ( $this->session->userdata('logged_in') ){

            $session = $this->session->userdata('logged_in');

            if( $index == 'cancel' && $id != 0 ){

                $where = array( 'email' => $session['email'], 'date' => $id );
                $result = $this->libraries_model->_select('checkout', $where );
                if( $result ){

                    $this->libraries_model->_update('checkout', array('status'=> -1), $where);

                }

            }else if( $index == 'payment' && $id != 0 ){

                $result = $this->member_model->_orders($session['email'],0,1,$id);
                if( $result ){

                        $data['detail'] = $result;
                        $data['pway']   = $result[0]['pway'];
                        $data['total']  = $result[0]['total'];
                        $data['id']     = $id;

                    if( !$mode ){
                        
                        $data['account'] = $session;
                        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
                        $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
                        $data['setting'] = $this->libraries_model->_select('site_setting');
                        
                        $this->load->view('header',$data);
                        $this->load->view('member/payment' , $data);
                        $this->load->view('footer',$data);
                        return;

                    }else{

                       $bank     = $this->input->post('bank');
                       $bankCode = $this->input->post('bankCode');
                       $code     = $this->input->post('code');
                       $cash     = $this->input->post('cash');
                       $date     = $this->input->post('date');


                       $income = compact('bank', 'bankCode', 'code', 'cash', 'date');
                       $income['id']    = $result[0]['date'];
                       $income['email'] = $session['email'];
                       if( $this->libraries_model->_insert('income', $income) ){

                           echo '<script>alert("failed");</script>';

                       }

                       $where = array( 'email' => $session['email'], 'date' => $id );
                       $this->libraries_model->_update('checkout', array('status'=> 3), $where);

                       $this->orders();
                       return;

                    }

                }


            }

            $data['result'] = $this->member_model->_orders($session['email'],$index);

            $rows = $this->member_model->_count('checkout', array( 'email' => $session['email'] ) );

            $config = $this->_pagination('orders', $rows);
            $this->pagination->initialize($config);
            $data['links'] = $this->pagination->create_links();
            $data['account'] = $session;
            $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
            $data['setting'] = $this->libraries_model->_select('site_setting');
            $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');

            $this->load->view('header',$data);
            $this->load->view('member/orders', $data);
            $this->load->view('footer',$data);

        }else{

            redirect(base_url('member'));

        }

    }

    public function data(){

        if ( $session = $this->session->userdata('logged_in') ){

            $session = $this->session->userdata('logged_in');

            $data = array(
                        'username' => $session['username'],
                        'name'     => $session['name'],
                        'sex'      =>
                            $session['sex'] == 0 ? '男' : '女' ,
                        'address'  => $session['address'],
                        'email'    => $session['email'],
                        'phone'    => $session['phone'],
                    );
            
            $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
            $data['setting'] = $this->libraries_model->_select('site_setting');
            $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
            $data['account'] = $session;

            $this->load->view('header', $data);
            $this->load->view('member/edit', $data);
            $this->load->view('footer', $data);

        }else{

            redirect(base_url('member'));

        }

    }

    public function edit(){

        if ( $this->session->userdata('logged_in') ) {
            $rule = 'trim|required|xss_clean';  //共用規則

            $this->form_validation->set_rules('email', 'email', $rule . '|valid_email'); 
            $this->form_validation->set_rules('name', 'name', $rule);
            $this->form_validation->set_rules('address', 'address', $rule); 
            $this->form_validation->set_rules('phone', 'phone', $rule . '|numeric|max_length[10]'); 

            $session = $this->session->userdata('logged_in');
            if($this->form_validation->run() == FALSE){
                $this->load->library("lvax");
                echo $this->lvax->_json_callback( -1, validation_errors() );

            }else{

                $data = array(
                            'email'           => $this->input->post('email'),
                            'name'            => $this->input->post('name'),
                            'address'         => $this->input->post('address'),
                            'phone_number'    => $this->input->post('phone')     
                        );

                $this->session->set_flashdata('edit', $data);

                $data['fbid'] = isset($session['fbid']);
                $this->load->library("lvax");
                //$this->load->view('member/isedit', $data);
                echo $this->lvax->_json_callback( true, null, $data );

            }

        }else{

            redirect('home');

        }

    }

    public function isedit(){

        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        $password = $this->_mix( $this->input->post('password') );

        if ( $this->session->userdata('logged_in') ){

            $session = $this->session->userdata('logged_in');
            if ( ($this->member_model->_uservalid( $session['username'], $password )) ||
                 (isset($session['fbid']) && $this->member_model->_fblogin($session['fbid']))
               ){

                $editdata = $this->session->flashdata('edit');

                $updata = $this->member_model->_updata( $session['username'], $editdata );
                if ( $updata ){
                    $this->load->library("lvax");
                    echo  $this->lvax->_json_callback(1, 'updata success!');
                    $editdata = array_replace( $this->session->userdata('logged_in'), $editdata );
                    $this->session->set_userdata('logged_in', $editdata);

                }else{
                    $this->load->library("lvax");
                    echo $this->lvax->_json_callback(0, 'failed');

                }

            }else{
                $this->load->library("lvax");
                echo $this->lvax->_json_callback(-1, 'password invailed.');
                $this->session->keep_flashdata('edit');
            }

        }else{

            redirect(base_url('member'));

        }

    }

    public function pass(){

        if ( $session = $this->session->userdata('logged_in') ){

            $session = $this->session->userdata('logged_in');
            $chk = $this->member_model->_chkpass($session['email']);
            $data = array(
                        'username' => $session['username'] ,
                        'password' => ($chk['password']) ? true : false ,
                    );

            $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
            $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
            $data['setting'] = $this->libraries_model->_select('site_setting');
            $data['account'] = $session;
            
            $this->load->view('header',$data);
            $this->load->view('member/chpassword', $data);
            $this->load->view('footer',$data);

        }else{

            redirect(base_url('member'));

        }

    }

    public function chpass(){

        if ( $this->session->userdata('logged_in') ){

            $session = $this->session->userdata('logged_in');
            $chk = $this->member_model->_chkpass($session['email']);

            $rule = 'trim|required|xss_clean';  //共用規則

            if( $chk['password'] ){
                $this->form_validation->set_rules('password', '密碼', $rule . '|min_length[6]');
            }

            $this->form_validation->set_rules('newpw', '新密碼', $rule . '|min_length[6]'); 
            $this->form_validation->set_rules('renewpw', '再次輸入新密碼', $rule . '|min_length[6]|matches[newpw]'); 

            if($this->form_validation->run() == FALSE){
                $this->load->library("lvax");
                echo $this->lvax->_json_callback( -1, validation_errors() );

            }else{

                $password = $this->input->post('password');
                $newpw = $this->input->post('newpw');
                if ( $this->member_model->_uservalid( $session['username'], $this->_mix($password) ) || !$chk['password'] ){

                    $data = array(
                        'password' => $this->_mix($newpw) ,
                    );
                    $this->load->library("lvax");
                    echo $this->lvax->_json_callback($this->member_model->_updata( $session['username'], $data ) );

                }else{
                    $this->load->library("lvax");
                    echo $this->lvax->_json_callback(false);

                }

            }

        }else{

            redirect(base_url('member'));

        }

    }

    public function logout(){

        if ( $this->session->userdata('logged_in') ){

            $this->session->unset_userdata('logged_in');
            redirect(base_url('home'));

        }else{

            redirect(base_url('member'));

        }

    }
    
    public function follow(){
        
        if ( $this->session->userdata('logged_in') ){
            
            $session = $this->session->userdata('logged_in');
            
            $data = array(
                'user_id'       =>  $session['id'],
                'product_id'    =>  $this->input->post("product_id",true),
                'follow_time'   =>  date("Y-m-d H:i:s")
            );
            
            if(!$this->libraries_model->_select("user_follow","product_id",(int)$this->input->post("product_id",true),0,0,0,0,"row")){
                if($this->libraries_model->_insert("user_follow",$data)){
                    echo '1';
                }
            }else{
                echo '1';
            }
            
        }else{
            echo '0';
        }
    }





/**

 + private funtion
 |
 - php宣告private funtion會造成callback報錯
 - 底下皆為私有funtion

**/



    //產生hash
    public function _mix($hash){

        $hash = md5($hash);
        //print_r( substr($hash,10).substr($hash,0,6) );
        
        return substr($hash,10).substr($hash,0,6);
    }

    //登入驗證 callback
    public function _uservalid($password){

        $email  = $this->input->post('email');
        $result = $this->member_model->_login( $this->_mix($password), $email );

        if( $result ){

            $sess_array = array(
                'id'       => $result['id'],
                'name'     => $result['name'],
                'sex'      => $result['sex'],
                'address'  => $result['address'],
                'email'    => $result['email'],
                'phone'    => $result['phone_number'],
                'username' => $result['username'],
                'lstlogin' => $result['last_login'],
                'lstip'    => $result['login_ip'],
            );

            $this->session->set_userdata('logged_in', $sess_array);
            $this->member_model->_uptime($result['id']);     //uptime

            return TRUE;

        }
            $this->load->library("lvax");
            $this->lvax->_bad_login($email);

            $this->form_validation->set_message('_uservalid', 'Invailed user');
            return false;

    }

    //使用者註冊 callback
    public function _register($data){

        $data['password'] = $this->_mix($data['password']);
        
        $this->load->library("lvax");
        
        if($this->member_model->_register($data)){
            $this->lvax->_wait(base_url('member'),"3","註冊成功，將跳轉回登入頁面");
        }else{
            $this->lvax->_wait(base_url('member'),"5","註冊失敗!!請重新註冊，即將跳轉回登入頁面");
        }
        echo $this->member_model->_register($data) ? 'success<br/>' : 'failed<br/>' ;
        $link = base_url('member/valid') . '/' . $data['email'] . '/' . $this->member_model->__mix($data['username']);
        $content = $this->libraries_model->_select('site_setting', 'key', 'validmail')[0];
        $content = preg_replace( '/\#link\#/', $link, addslashes($content['value']));
        $this->load->library("lvax");
        $this->lvax->_send_mail($data['email'], '註冊成功', $content);

    }

    public function _pagination($method, $rows, $perpage = 10){  

        $config['base_url'] = base_url('member/'.$method.'/');  
        $config['total_rows'] = $rows;  
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 3;
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['next_link'] = '>';
        $config['prev_link'] = '<';
        return $config;  

    }  

    public function _header($data = null){


        if( $data == null ){
            $session_data = $this->session->userdata('logged_in');
            $data['account'] = $session_data;
        }

        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
        $data['setting'] = $this->libraries_model->_select('site_setting');

        $this->load->view('header',$data);
    }
    
    public function reset(){
        
        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
        $data['setting'] = $this->libraries_model->_select('site_setting');
        $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
        
        $this->load->view('header',$data);
        $this->load->view("member/reset",$data);
        $this->load->view('footer',$data);
        
    }
    
    public function send_reset_pwd(){
        
        if(!$this->input->post()) redirect (base_url('member'));
        
        $email = $this->input->post("email",true);
        
        if($user = $this->libraries_model->_select("userdata","email",$email,0,0,0,0,"row")){
            
            $this->load->library("lvax");
            
            $session_key = md5($user['email'].date("Y-m-d H:i:s"));
            
            $link = base_url('member/valid_reset_pwd')."/".$session_key;
            
            $message = "您好，我們收到您忘記密碼的通知，請<a target='_blank' href='".$link."'>點此</a>進行密碼修改，此連結有效期限為一天，謝謝";
            
            $this->lvax->_send_mail($user['email'],"密碼修改通知",$message);
            
            $data = array(
                'session_key'   =>  $session_key,
                'session_expire'=>  date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d")+1,date("Y")))
            );
            
            $this->libraries_model->_update("userdata",$data,"email",$user['email']);
            
            echo 1;
            
        }else{
            echo 0;
        }
        
    }
    
    public function valid_reset_pwd($session_key = 0){
        
        if(!$session_key) redirect (base_url('home'));
        
        $where = array(
            'session_key'       =>  $session_key,
            'session_expire >=' =>  date("Y-m-d H:i:s")
        );
        
        $valid_status = $this->libraries_model->_select("userdata",$where,0,0,0,0,0,"row");
        
        $data['status'] = ($valid_status) ? 1:0;
        $data['hash'] = $session_key;
        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
        $data['setting'] = $this->libraries_model->_select('site_setting');
        $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
        
        $this->load->view('header',$data);
        $this->load->view("member/reset_pwd",$data);
        $this->load->view('footer',$data);
            
    }
    
    public function reset_pwd(){
        
        if(!$this->input->post()) redirect (base_url('home'));
        
        $pwd = $this->input->post("pwd",true);
        $cfm = $this->input->post("cfm_pwd",true);
        
        if($pwd != $cfm){
            echo 0;
        }else{
            
            $data = array(
                'password'      =>  $this->_mix($pwd),
                'session_key'   =>  0,
                'session_expire'=>  0
            );
            
            if($this->libraries_model->_update("userdata",$data,"session_key",$this->input->post("h",true))){
                echo 1;
            }else{
                echo 0;
            }
            
        }
    }

}

?>
