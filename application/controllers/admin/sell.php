<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('sell_model');
        $this->load->model('libraries_model');
        if (!$this->session->userdata('manage_logged_in')){          		
            redirect('admin/index');
            exit();
        }
    }
    
    public function index($mode = 0,$sub_mode = 0){
        
        if(!$mode && !$sub_mode){
            $data['orders'] = $this->sell_model->_show_orders();
        }elseif($mode == 'status' || $mode == 'user'){
            $data['orders'] = $this->sell_model->_show_orders($mode,$sub_mode);
        }else{
            redirect(base_url('admin/sell'));
        }
        
        $this->load->view("admin/sell",$data);
    }
    
    public function orders($mode = 0,$sub_mode = 0){
        
        if(!$mode && !$sub_mode){
            $data['orders'] = $this->sell_model->_show_orders("all");
        }elseif($mode == 'status' || $mode == 'user'){
            $data['orders'] = $this->sell_model->_show_orders($mode,$sub_mode);
        }else{
            redirect(base_url('admin/sell'));
        }
        
        $this->load->view("admin/orders",$data);
    }
    
    public function show_detail_product(){
        
        $serial_id = $this->input->post("serial_id",true);
        
        if(!isset($serial_id)) redirect(base_url('admin/sell'));
        
        $details = $this->sell_model->_show_detail_product($serial_id);
        $array = array();
        
        foreach($details as $key => $detail){
            $array[$key] = "<tr><td>".$detail['product_name']."</td><td>".$detail['specs']."</td><td>".$detail['qty']."</td><td>".$detail['price']."</td></tr>";
        }
        
        $content = implode("",$array);
        echo "<tr><th>商品名稱</th><th>規格</th><th>數量</th><th>價錢</th></tr>".$content;
        
    }
    
    public function edit_status(){
        
        $serial_id = $this->input->post("serial_id",true);
        $status = $this->input->post("status",true);
        
        if(!isset($serial_id) && !isset($status)) redirect(base_url('admin/sell'));
        
        echo $this->sell_model->_edit_status($serial_id,$status);
        
    }
    
    public function edit_order($order_id = 0){
        
        if(!$order_id) redirect(base_url('admin/sell'));
        
        $data['orders']  = $this->sell_model->_show_detail_order($order_id);
        $data['payment'] = $this->libraries_model->_select('income', 'order_id', $data['orders'][0]['serial_id']);
        
        $this->load->view('admin/edit_order',$data);
            
    }
    
    public function edit_detail_status(){
        
        if(!$this->input->post()) redirect(base_url('admin/sell'));
        
        $data = array(
            'name'      =>  $this->input->post("name",true),
            'address'   =>  $this->input->post("address",true),
            'phone'     =>  $this->input->post("phone",true),
            'status'    =>  $this->input->post("status",true)
        );
        
        $this->sell_model->_edit_status($this->input->post("order-id",true),$this->input->post("status",true));
        $this->libraries_model->_update("checkout",$data,"serial_id",(int)$this->input->post("order-id",true));
        
        if($this->input->post("status",true)=='-1' || $this->input->post("status",true)=='0'){
            $this->libraries_model->_delete("income","order_id",(int)$this->input->post("order-id",true));
        }
        
        redirect(base_url('admin/sell'));
    }
    
    public function rank(){
        
        $data['results'] = $this->sell_model->_sell_rank();
        
        $this->load->view('admin/rank',$data);
        
    }
    
    public function payment(){
        
        $data['pways'] = $this->libraries_model->_select("payment",0,0,0,0,"id");
        
        $this->load->view('admin/payment',$data);
        
    }
    
    public function payment_save(){
        
        if(!$this->input->post()) redirect (base_url('admin/sell'));
        
        $this->libraries_model->_update("payment",array('active' => '0'));//先將全部都設為0
        
        foreach($this->input->post("pway",true) as $chk){
            
            $this->libraries_model->_update("payment",array('active' => '1'),"id",$chk);//再將勾選的設為1
            
        }
        $this->load->library("lvax");
        $this->lvax->_wait(base_url('admin/sell/payment'),"1","儲存成功!");
    }
    
    public function pway_save(){
        
        if(!$this->input->post() || $this->input->post("pway_id",true) == '') redirect (base_url('admin/sell'));
        
        $data = array(
            'charges'   =>  $this->input->post("charges",true),
            'content'   =>  $this->input->post("content",true)
        );
        
        $this->libraries_model->_update("payment",$data,"id",$this->input->post("pway_id",true));
        
        $this->load->library("lvax");
        $this->lvax->_wait(base_url('admin/sell/payment'),"1","儲存成功!");
        
    }
    
    public function pway($way_id = 0){
        
        $row = $this->libraries_model->_select("payment","id",$way_id,0,0,0,0,"row");
        
        if(!$way_id || !$row) redirect (base_url('admin/sell'));
        
        $data['page'] = $this->libraries_model->_select("payment","id",$way_id,0,0,0,0,"row");
        $this->load->view('admin/pway',$data);
        
    }

    public function search($data = null ,$method='email',$index=0){

        $data = urldecode($data);
        if( $this->uri->segment(4, 0) == false ){

            $view['result'] = $this->libraries_model->_select('checkout', 0, 0, $index * 10, 10, 'serial_id', 0, 'result');
            $this->load->view('admin/sell_search', $view);

        }else{

            $view['result'] = $this->libraries_model->
                _select('checkout', $method, 0, $index * 10, 10, 'serial_id', 0, 'result', 0, $data);

            $this->load->view('admin/sell_search', $view);
        }

    }
    
    public function profit(){
        
        $month = ($this->input->post("month",true)) ? $this->input->post("month",true) : "0";
        $mode = ($this->input->post("mode",true)) ? $this->input->post("mode",true) : "0";
        $setting = $this->libraries_model->_select("site_setting","key","site_start_date",0,1,0,0,"row");
        $data['setting'] = $setting['value'];
        $data['mode']    = $mode;
        $array = array();
        $i = 0;
        
        if($month && preg_match("/\d*\-\d*/",$month)){//如果有選擇月份
            
            if(date("Y-m",strtotime($setting['value'])) > date("Y-m",strtotime($month))) redirect(base_url('admin/sell/profit'));//檢查輸入月份有沒有大於起始日期
            
            $time = explode("-",$month);
            $nxt_m = date("Y-m",mktime(0,0,0,$time[1]+1));//日期範圍結尾
            
            for($thisday = date("Y-m-d",strtotime($month));$thisday < $nxt_m;$thisday = date("Y-m-d",strtotime($thisday)+86400)){
                $all = $this->sell_model->_show_total_n_orders($thisday,$mode);
                $cost = $this->sell_model->_show_profit($thisday,$mode);
                $profit = $all['total'] - $cost['cost'];
                $array[$i] = "<tr><td>".$thisday."</td><td>".$all['count']."</td><td>".$all['total']."</td><td>".$profit."</td></tr>";
                $i = $i+1;
            }
            
        }else{
            
            for($today = date("Y-m-d");$today >= $setting['value'];$today = date("Y-m-d",strtotime($today)-86400)){//如果今天大於起始日期,則開始減少一天的時間,直到起始日為止

                if($i<=30){//只列出30天
                    $all = $this->sell_model->_show_total_n_orders($today,$mode);
                    $cost = $this->sell_model->_show_profit($today,$mode);
                    $profit = $all['total'] - $cost['cost'];
                    $array[$i] = "<tr><td>".$today."</td><td>".$all['count']."</td><td>".$all['total']."</td><td>".$profit."</td></tr>";
                    $i = $i+1;
                }
            }

        }
        
        $data['content'] = implode("",$array);
        $this->load->view("admin/profit",$data);
        
    }
    
    public function save_date(){
        
        if(!$this->input->post()) redirect (base_url('admin/profit'));
        
        $this->load->library("lvax");
        
        if($this->libraries_model->_update("site_setting",array("value"=>$this->input->post("start_date",true)),"key","site_start_date")){
            $this->lvax->_wait(base_url('admin/sell/profit'),"1","儲存成功!");
        }else{
            $this->lvax->_wait(base_url('admin/sell/profit'),"3","儲存失敗!");
        }
        
    }

    
}
    
?>
