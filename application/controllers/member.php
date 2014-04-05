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
        
        $this->load->library("lvax");
        
        if ($session = $this->session->userdata('logged_in') ){

            if( $refer = $this->session->userdata('refer') ){
                $this->session->unset_userdata('refer');
                redirect( $refer );
            }

            $orders = $this->member_model->_count('checkout', array( 'user_id' => $session['id'] ) );
            $pre_orders = $this->member_model->_count('checkout', array( 'user_id' => $session['id'], 'status' => 0 ) );
            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");

            $this->lvax->_front_end("account",$session,"member/index",array('orders'=>$orders,'pre_orders'=>$pre_orders,'status'=>$user['valid']));
            
        }else{
            
            $this->lvax->_front_end("","","member/login");
            
        }
    }
    
    public function login(){
        
        if ( $this->session->userdata('logged_in') ){

            redirect( base_url('member') );

        }else{
            
            $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback__uservalid');   //_uservalid為callback
            
            $this->load->library("lvax");
            
            if($this->form_validation->run() == FALSE){
                
                $this->lvax->_wait(base_url('member'),"1","登入失敗!!請重新登入");
                
            }else{
                
                redirect( base_url('member') );
                
            }
        
        }
        
    }
    
    public function _uservalid($password){

        $email  = $this->input->post('email');
        
        $where = array(
            'email'     =>  $email,
            'password'  =>  $this->_mix($password)
        );
        
        $result = $this->libraries_model->_select("userdata",$where,0,0,1,0,0,"row");

        if( $result ){

            $sess_array = array(
                'id'       => $result['id'],
                'name'     => $result['name'],
                'sex'      => $result['sex'],
                'address'  => $result['address'],
                'email'    => $result['email'],
                'phone'    => $result['phone'],
                'lstlogin' => $result['last_login'],
                'lstip'    => $result['login_ip']
            );

            $this->session->set_userdata('logged_in', $sess_array);
            $this->member_model->_uptime($result['id']);     //uptime

            return TRUE;

        }else{
            
            $this->load->library("lvax");
            $this->lvax->_bad_login($email);

            return false;
            
        }
            

    }


    //Facebook 登入串接
    public function fbsession(){

        include_once dirname(__FILE__) . "/api/fbsession.php";
        $this->load->library("lvax");

        if ($fbme){

            try{

                $param = array(
                        'method'   => 'users.getinfo',
                        'uids'     => $fbme['id'],
                        'fields'   => 'name,email,sex',
                        'callback' => '',
                        );
                $userInfo = $facebook->api($param);

            } catch (Exception $e) {

                $this->lvax->_wait(base_url('member'),'1','登入失敗!!請重新登入');

            }

            $fbdata = $this->libraries_model->_select('userdata','fbid',$fbme['id'],0,1,0,0,"row");

            if ( $fbdata ) {

                $sess_array = array(
                    'id'       => $fbdata['id'],
                    'name'     => $fbdata['name'],
                    'fbid'     => $fbme['id'],
                    'sex'      => $fbdata['sex'],
                    'address'  => $fbdata['address'],
                    'email'    => $fbdata['email'],
                    'phone'    => $fbdata['phone'],
                    'lstlogin' => $fbdata['last_login'],
                    'lstip'    => $fbdata['login_ip'],
                );

                $this->session->set_userdata('logged_in', $sess_array);
                $this->member_model->_uptime($sess_array['id']);     //uptime

                redirect(base_url('member'));


            }else{

                $this->session->set_userdata( 'fbdata', $userInfo[0] );

                //$this->load->view('member/fbsignup', $userInfo[0]);
                $this->lvax->_front_end('','','member/fbsignup',$userInfo[0]);

            }

        }else{

            redirect( $loginUrl );

        }

    }

    public function fbsignup(){

        $this->load->library("lvax");

        if ( $this->session->userdata('fbdata') ){

            $fbdata = $this->session->userdata('fbdata');

            $rule = 'trim|required|xss_clean';  //共用規則

            $this->form_validation->set_rules('address', 'address', $rule);
            $this->form_validation->set_rules('phone', 'phone', $rule . '|numeric|max_length[10]');

            if($this->form_validation->run() == FALSE){

                $this->load->view('member/fbsignup', $fbdata);

            }else{

                $data = array(
                            'fbid'          =>  $fbdata['uid']   ,
                            'name'          =>  $fbdata['name']  ,
                            'email'         =>  $fbdata['email'] ,
                            'sex'           =>  $fbdata['sex'] == 'male' ? 0 : 1 ,
                            'address'       =>  $this->input->post('address') ,
                            'phone'         =>  $this->input->post('phone')   ,
                        );

                $isMember = $this->libraries_model->_select('userdata','email',$data['email'],0,0,0,0,'row');
                $signup = ( $isMember ) ? $this->libraries_model->_update('userdata', $data, 'email', $data['email'])
                                        : $this->libraries_model->_insert('userdata',$data);
                if ( $signup ){

                    $this->libraries_model->_update("userdata",array("valid"=>1),"email",$data['email']);

                    $this->lvax->_wait(base_url('member'),"3","註冊成功，將跳轉回登入頁面");

                }else{

                    $this->lvax->_wait(base_url('member'),"3","註冊失敗!!請重新註冊");


                }

            }

        }else{

                redirect(base_url('member'));

        }

    }










    
    public function exist(){
        
        if(!$this->input->post()) redirect(base_url('member'));
        
        $email = $this->input->post("email",true);
        
        echo ($this->libraries_model->_select("userdata","email",$email,0,0,0,0,"row")) ? "1" : "0";
        
    }
    
    public function register(){
        
        $rule = 'trim|required|xss_clean';  //共用規則

        $this->form_validation->set_rules('password', '密碼', $rule . '|min_length[6]'); 
        $this->form_validation->set_rules('repassword', '密碼確認', $rule . '|min_length[6]|matches[password]'); 
        $this->form_validation->set_rules('email', 'email', $rule . '|valid_email'); 
        $this->form_validation->set_rules('name', '收件人姓名', $rule); 
        $this->form_validation->set_rules('sex', '性別', 'trim|xss_clean'); 
        $this->form_validation->set_rules('address', '地址', $rule); 
        $this->form_validation->set_rules('phone', '電話', $rule . '|numeric|max_length[10]'); 
        
        $this->load->library("lvax");
        
        if($this->form_validation->run() == FALSE){
            
            $this->lvax->_wait(base_url('member'),"3","註冊失敗!!請重新註冊");
            
        }else{

            $data = array(
                        'password'        => $this->_mix($this->input->post('password')) ,
                        'email'           => $this->input->post('email')     ,
                        'name'            => $this->input->post('name')      ,
                        'sex'             => $this->input->post('sex') == 'male' ? 0 : 1  ,
                        'address'         => $this->input->post('address')   ,
                        'phone'    => $this->input->post('phone')     ,
                    );

            $this->libraries_model->_insert("userdata",$data);
            
            $hash = md5('^_=+%%' + $data['name'] + '%&^_=+');
            
            $link = base_url('member/valid') . '/' . $data['email'] . '/' . $hash;
            
            $content = $this->libraries_model->_select('site_setting', 'key', 'validmail',0,0,0,0,"row");
            
            $content = preg_replace( '/\#link\#/', $link, addslashes($content['value']));
            
            $this->lvax->_send_mail($data['email'], '註冊成功', $content);
            
            $this->lvax->_wait(base_url('member'),"5","註冊成功，我們將發送驗證信件給您，請至您的信箱驗證");

        }
        
    }
    
    public function _mix($hash){

        $hash = md5($hash);
        
        return substr($hash,10).substr($hash,0,6);
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
            
            $where = array(
                'product_id'    =>  (int)$this->input->post("product_id",true),
                'user_id'       =>  $session['id']
            );
            
            if(!$this->libraries_model->_select("user_follow",$where,0,0,0,0,0,"row")){
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
    
    public function unfollow(){
        
        if(!$this->input->post()) redirect(base_url('member'));
        
        if(!$session = $this->session->userdata('logged_in')) redirect(base_url('member'));
        
        $where = array(
            'user_id'   =>  $session['id'],
            'product_id'=>  (int)$this->input->post("product_id",true)
        );
        
        echo ($this->libraries_model->_delete("user_follow",$where)) ? "1" : "0";
        
    }
    
    public function valid($email = null,$hash = null){
        
        if(isset($email) && isset($hash)){
            
            if($user = $this->libraries_model->_select("userdata","email",$email,0,0,0,0,"row")){
                
                $check_hash = md5('^_=+%%' + $user['name'] + '%&^_=+');
                
                if(!$user['valid'] && $hash == $check_hash){
                    
                    $this->libraries_model->_update("userdata",array("valid"=>1),"email",$email);
                    
                    $this->load->library("lvax");
                    
                    $this->lvax->_wait(base_url('member/index'),"3","驗證成功，請登入");
                }
            }
            
        }
        
    }
    
    public function data(){
        
        if ( $session = $this->session->userdata('logged_in') ){
            
            $this->load->library("lvax");
            $this->lvax->_front_end("account",$this->libraries_model->_select("userdata","id",$session['id'],0,0,0,0,"row"),"member/edit");

        }else{

            redirect(base_url('member'));

        }
        
    }
    
    public function edit(){
        
        if ( $session = $this->session->userdata('logged_in') ){
            
            $email = $this->input->post("email",true);
            
            $status = 0;
            
            if($email != $session['email']){
                
                $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
                
                //檢查上次發驗證信時間，如果小於六小時則不發送
                if(date("Y-m-d H:i:s",strtotime($user['last_valid'])) <= date("Y-m-d H:i:s",mktime(date("H")-6, date("i"), date("s"), date("m")  , date("d"), date("Y")))){
                    
                    $data = array(
                        'name'          =>  $this->input->post("name",true),
                        'sex'           =>  $this->input->post("sex",true),
                        'address'       =>  $this->input->post("address",true),
                        'phone'         =>  $this->input->post("phone",true),
                        'email'         =>  $email,
                        'valid'         =>  0,
                        'last_valid'    =>  date("Y-m-d H:i:s")
                    );
                    
                    $status = 1;
                    
                }else{
                    
                    $data = array(
                        'name'          =>  $this->input->post("name",true),
                        'sex'           =>  $this->input->post("sex",true),
                        'address'       =>  $this->input->post("address",true),
                        'phone'         =>  $this->input->post("phone",true)
                    );
                    
                }
                
                if($status){
                    
                    $this->libraries_model->_update("checkout",array("email"=>$email),"email",$session['email']);
                    
                    echo ($this->libraries_model->_update("userdata",$data,"id",$session['id']))?"1":"0";
                    
                    $result = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
                    
                    $hash = md5('^_=+%%' + $result['name'] + '%&^_=+');

                    $link = base_url('member/valid') . '/' . $data['email'] . '/' . $hash;

                    $content = $this->libraries_model->_select('site_setting', 'key', 'validmail',0,0,0,0,"row");

                    $content = preg_replace( '/\#link\#/', $link, addslashes($content['value']));

                    $this->load->library('lvax');

                    $this->lvax->_send_mail($result['email'],"我們收到您重新驗證的要求...", $content);
                    
                }else{
                    
                    $this->libraries_model->_update("userdata",$data,"id",$session['id']);
                    echo '2';
                    
                }
                
            }else{
                
                $data = array(
                    'name'          =>  $this->input->post("name",true),
                    'sex'           =>  $this->input->post("sex",true),
                    'address'       =>  $this->input->post("address",true),
                    'phone'         =>  $this->input->post("phone",true)
                );
                
                echo ($this->libraries_model->_update("userdata",$data,"id",$session['id']))?"1":"0";
                
            }
            
            $result = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");

            $sess_array = array(
                    'id'       => $result['id'],
                    'name'     => $result['name'],
                    'sex'      => $result['sex'],
                    'address'  => $result['address'],
                    'email'    => $result['email'],
                    'phone'    => $result['phone'],
                    'lstlogin' => $result['last_login'],
                    'lstip'    => $result['login_ip']
                );

            $this->session->set_userdata('logged_in', $sess_array);
            
        }else{

            redirect(base_url('member'));

        }
        
    }
    
    public function orders(){

        if ($session = $this->session->userdata('logged_in') ){
            
            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
            
            $offset = ($this->uri->segment(3))?$this->uri->segment(3):0;
            $perpage = ($this->uri->segment(4))?$this->uri->segment(4):"10";//預設一頁十筆
            
            ob_start();//緩衝輸出，因為不知道怎麼用MVC寫XD
            
            $orders = $this->libraries_model->_select("checkout","user_id",$user['id'],$offset,$perpage,"serial_id","desc");
            
            if($order_stats = ($orders) ? true:false){//看有沒有訂單，將訂單狀態輸出到view
                foreach($orders as $key => $item){

                    echo '<tr>
                            <td>'.$item['serial_id'].'</td>
                            <td>'.$item['date'].'</td>
                            <td>'.$item['total'].'</td>
                            <td class="addin-name" style="padding: 0!important;">';

                    $results = $this->libraries_model->_select("checkout_product",array("user_id"=>$user['id'],"order_id"=>$item['serial_id']));

                    $count = count($results);

                    for($i=0;$i<$count;$i++){

                        echo ($i == ($count-1)) ? 
                            '<div class="addin-td last-addin-td">'.$results[$i]['product_name'].'</div></td><td class="addin-mount" style="padding: 0!important;">' //如果是商品名稱的最後一行則輸出數量的第一行
                                : 
                            '<div class="addin-td">'.$results[$i]['product_name'].'</div>';

                    }
                    for($i=0;$i<$count;$i++){

                        echo ($i == ($count-1)) ? 
                            '<div class="addin-td last-addin-td">'.$results[$i]['qty'].'</div></td>' 
                                : 
                            '<div class="addin-td">'.$results[$i]['qty'].'</div>';

                    }

                    echo '<td>'.$item['pway'].'</td>';
                    if($item['status'] == 0){
                        echo '<td><a href="javascript:void(0);" orderid="'.$item['serial_id'].'" class="notify">通知付款</a> | <a href="javascript:void(0);" orderid="'.$item['serial_id'].'" class="cancel">取消訂單</a></td>';
                    }elseif($item['status'] == 1){
                        echo '<td>付款完成</td>';
                    }elseif($item['status'] == 2){
                        echo '<td>已出貨</td>';
                    }elseif($item['status'] == -1){
                        echo '<td>已取消</td>';
                    }
                    echo '</tr>';

                }
            }
            
            $content = ob_get_contents();
            
            ob_end_clean();
            
            $rows = $this->member_model->_count('checkout', array('user_id' => $user['id']));
            
            $this->load->library("lvax");
            $config = $this->_pagination('orders', $rows,$perpage);
            $this->pagination->initialize($config);
            $links = $this->pagination->create_links();
            
            $this->lvax->_front_end("order_data",$content,"member/orders",array("account"=>$session,"order_status"=>$order_stats,"links"=>$links));
            
        }else{

            redirect(base_url('member'));

        }

    }
    
    public function urfollow(){
        
        if ($session = $this->session->userdata('logged_in') ){
        
            $results = $this->member_model->_follow_list($session['id']);
            
            $this->load->library("lvax");
            
            $this->lvax->_front_end("follow_list",$results,"member/urfollow",array("account"=>$session));
            
        }else{
            
            redirect(base_url('member'));
            
        }
        
    }
    
    public function pass(){
        
        if ($session = $this->session->userdata('logged_in') ){
            
            $this->load->library("lvax");
            
            $this->lvax->_front_end("","","member/chpassword",array("account"=>$session));
            
        }else{
            redirect(base_url('member'));
        }
        
    }
    
    public function editpass(){
        
        if(!$this->input->post()) redirect(base_url('member'));
        
        if ($session = $this->session->userdata('logged_in') ){
            
            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
            
            if($this->_mix($this->input->post("pwd",true)) != $user['password']){
                echo '0';
            }elseif($this->input->post("newpw",true) != $this->input->post("repw",true)){
                echo '1';
            }else{
                
                $pwd = $this->_mix($this->input->post("repw",true));
                
                echo ($this->libraries_model->_update("userdata",array("password"=>$pwd),"id",$user['id'])) ? '2' : '3';
            }
            
        }else{
            redirect(base_url('member'));
        }
        
    }
    
    public function paymentdetail(){
        
        if(!$this->input->post()) redirect(base_url('member'));
        
        if ($session = $this->session->userdata('logged_in') ){
            $this->load->library("lvax");
            $this->lvax->_front_end("","","member/paymentdetail",array("account"=>$session,"order_id"=>(int)$this->input->post("order_id",true)));
            
        }else{
            redirect(base_url('member'));
        }
        
    }
    
    public function save_paymentdetail(){
        
        if($session = $this->session->userdata('logged_in')){
            if(!$this->input->post()) redirect(base_url('member'));
            
            $order_id = $this->input->post("order_id",true);

            if($this->input->post("action",true) == 1){
                
                $data = array(
                    'order_id'  =>  (int)$order_id,
                    'user_id'   =>  (int)$session['id'],
                    'bank'      =>  $this->input->post("bank_name",true),
                    'bankCode'  =>  (int)$this->input->post("bank_code",true),
                    'code'      =>  (int)$this->input->post("last5num",true),
                    'cash'      =>  (int)$this->input->post("paymoney",true),
                    'date'      =>  $this->input->post("pDate",true)
                );
                
                $this->libraries_model->_insert("income",$data);
            }
            
            $status = ((int)$this->input->post("action",true)==1) ? "1":"-1";
            
            $this->load->library("lvax");

            if($this->libraries_model->_update("checkout",array("status"=>$status,"close_date"=>date("Y-m-d H:i:s")),array("serial_id"=>$order_id,"user_id"=>$session['id']))){
                $this->lvax->_wait(base_url('member/orders'),"1","通知成功!");
            }else{
                $this->lvax->_wait(base_url('member/orders'),"3","錯誤，請通知網站管理人員!");
            }
            
        }else{
            redirect(base_url('member')); 
        }
        
    }
    
    public function reset(){
        
        if(!$session = $this->session->userdata('logged_in')){
        
            $this->load->library("lvax");
            $this->lvax->_front_end("","","member/reset");
        
        }else{
            redirect(base_url('member'));
        }
        
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
        
        $session_status = $this->libraries_model->_select("userdata","session_key",$session_key,0,1,0,0,"row");
        
        if(!$session_key || !$session_status) redirect (base_url('home'));
        
        $where = array(
            'session_key'       =>  $session_key,
            'session_expire >=' =>  date("Y-m-d H:i:s")
        );
        
        $valid_status = $this->libraries_model->_select("userdata",$where,0,0,1,0,0,"row");
        
        $status = ($valid_status) ? 1:0;
        
        $this->load->library("lvax");
        $this->lvax->_front_end("","","member/reset_pwd",array("status"=>$status,"hash"=>$session_key));
    }
    
    public function reset_pwd(){
        
        if(!$this->input->post()) redirect (base_url('home'));
        
        $this->load->library("lvax");
        
        $pwd = $this->input->post("pwd",true);
        $cfm = $this->input->post("cfm_pwd",true);
        $hash = $this->input->post("h",true);
        
        if($pwd != $cfm){
            $this->lvax->_wait(base_url('member/valid_reset_pwd/'.$hash),"3","兩次密碼不符，請重新修改");
        }else{
            
            $data = array(
                'password'      =>  $this->_mix($pwd),
                'session_key'   =>  0,
                'session_expire'=>  0
            );
            
            if($this->libraries_model->_update("userdata",$data,"session_key",$this->input->post("h",true))){
                $this->lvax->_wait(base_url('member'),"3","重設密碼成功!");
            }else{
                $this->lvax->_wait(base_url('member'),"5","修改失敗，請通知網站管理人員");
            }
            
        }
        
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
}
?>
