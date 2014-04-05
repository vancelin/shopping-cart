<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller{
    
     public function __construct(){
        parent::__construct();
        $this->load->model('shop_model');
        $this->load->model('libraries_model');
    }
    
    public function index(){
        
        redirect(base_url('shop/detail'));
        
    }
    
    public function add(){
        
        if($this->input->post("action",TRUE) == 'quick_shop'){
            
            $result = $this->shop_model->show_product($this->input->post("product_id",TRUE));
            
            /*name若為中文會被過濾，故修改system/library/cart.php內的product_name_rules 
            * 若升級新版記得修改
            */
            

            if(date("Y-m-d",strtotime($product['bargain_from'])) <= date("Y-m-d",strtotime(date("Y-m-d"))) && date("Y-m-d",strtotime($product['bargain_to'])) >= date("Y-m-d",strtotime(date("Y-m-d")))){
                
                $data = array(
                    'id'      => $result['id'],
                    'qty'     => 1,
                    'price'   => $result['bargain_price'],
                    'name'    => $result['product_name']
                );
                
            }else{
                
                $data = array(
                    'id'      => $result['id'],
                    'qty'     => 1,
                    'price'   => $result['sale_price'],
                    'name'    => $result['product_name']
                );
            }
            
            $this->cart->insert($data);
            
        }elseif($this->input->post("action",TRUE) == 'shop'){
            
            $result = $this->shop_model->show_product($this->input->post("product_id",TRUE));
            
            if(date("Y-m-d",strtotime($result['bargain_to'])) >= date("Y-m-d",strtotime(date("Y-m-d")))){
                
                $data = array(
                    'id'      => $result['id'],
                    'qty'     => 1,
                    'price'   => $result['bargain_price'],
                    'name'    => $result['product_name'],
                    'option'  => $this->input->post("spec",true)
                );
                
            }else{
                
                $data = array(
                    'id'      => $result['id'],
                    'qty'     => 1,
                    'price'   => $result['sale_price'],
                    'name'    => $result['product_name'],
                    'option'  => $this->input->post("spec",true)
                );
            }
            
            $this->cart->insert($data);
            
            redirect(base_url('shop/detail'));
            
        }else{
            
            redirect(base_url('home'));
        }
        
    }
    
    public function del($id = 0){
        
        if($id){
            
            $data = array(
                    'rowid' => $id,
                    'qty'   => 0,
                );
        
            $this->cart->update($data);
            
            redirect('shop');
        
        }elseif($this->input->post("action",TRUE) == 'del_product'){
            
            $data = array(
                'rowid' => $this->input->post("rowid",TRUE),
                'qty'   => 0,
            );
            
            $this->cart->update($data);

        }else{
            
            redirect('shop');
            
        }
        
    }
    
    public function quickshop(){
        
        $contents = $this->cart->contents();
        
        $data['contents'] = $contents;
        
        $data['imgs'] = array();
        
        foreach($contents as $key => $content){
            $data['imgs'][$key] = $this->shop_model->show_img($content['id']);  
        }
        
        $this->load->view('quickshop',$data);
    }
    
    public function detail(){
        
        $this->load->library('user_agent');

        if( !$session = $this->session->userdata('logged_in') ){
            $this->session->set_userdata('refer', base_url('shop/detail'));
        }
        
        $data['referrer'] = $this->agent->referrer();
        
        $contents = $this->cart->contents();
        
        $data['contents'] = $contents;
        
        foreach($contents as $key => $content){
            
            $data['product'][$key] = $this->shop_model->show_product($content['id']);
            
        }
        
        $data['categorys'] = $this->libraries_model->_select('product_category','type','1','category_id',0);
        $data['footer'] = $this->libraries_model->_select('site_page','active','1',0,0,'page_sequence');
        $data['setting'] = $this->libraries_model->_select('site_setting');
        $data['page_name'] = '購物清單';
        if( $this->session->userdata('logged_in') ){
            $data['account'] = $this->session->userdata('logged_in');
        }
        $this->load->view('header',$data);
        $this->load->view('detail',$data);
        $this->load->view('footer',$data);
        
    }
    
    public function delivery_info(){
        
        if(!$this->cart->total_items()) redirect(base_url('home'));
        
        if ($session =  $this->session->userdata('logged_in') ){
            
            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
            
            if(!$user['valid']){
                redirect(base_url('member/index'));
            }
            
            $payment = $this->libraries_model->_select("payment",array("global_active" => 1,"active" => 1));

            $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
            
            $this->load->library("lvax");
            $this->lvax->_front_end("user",$user,"delivery",array("payment"=>$payment,"account"=>$user));
            
        }else{

            redirect('member');

        }
        
    }
    
    public function confirm(){
        
        if(!$this->cart->total_items()) redirect(base_url('home'));
        if(!$this->input->post()) redirect(base_url('home'));
        
        $session = $this->session->userdata('logged_in');
        
        $user = array(
            'email'           => $session['email'],
            'name'            => $this->input->post('name',true),
            'address'         => $this->input->post('address',true),
            'phone'           => $this->input->post('phone',true),
            'ps'              => $this->input->post('ps',true),
            'charges'         => $this->input->post('charges',true)  
        );
        
        $templates = array(
            'totalItem'     =>  $this->cart->total_items(),
            'totalPrice'    =>  $this->cart->total(),
            'user'          =>  $user,
            'account'       =>  $session
        );

        $this->load->library('lvax');
        $this->lvax->_front_end("detail",$this->cart->contents(),"confirm",$templates);
        
    }
    
    public function update(){
        
        if($this->input->post()){
            
            $data = array(
                    'rowid' => $this->input->post("rowid",TRUE),
                    'qty'   => $this->input->post("val",TRUE)
                    );

            $this->cart->update($data);
            
        }else{
            
            redirect(base_url('shop/detail'));
            
        }
    }
    
}
?>
