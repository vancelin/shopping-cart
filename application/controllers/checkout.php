<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('checkout_model');
        $this->load->model('libraries_model');
    }


    public function exsit($email = null){

        if( $email ){
            echo json_encode( $this->checkout_model->_exsit($email) );
        }

    }

    public function check(){
        
        $rule = 'trim|required|xss_clean';  //共用規則

        if( !$this->session->userdata('logged_in') ){

            redirect('member');

        }
        
        $this->load->library("lvax");

        $session = $this->session->userdata('logged_in');
        $user = $this->libraries_model->_select("userdata","id",$session['id'],0,1,0,0,"row");
        
        $this->form_validation->set_rules('name', '收件人', $rule);
        $this->form_validation->set_rules('address', '地址', $rule); 
        $this->form_validation->set_rules('phone', '聯絡電話 / 手機', $rule . '|numeric|max_length[10]'); 
        $this->form_validation->set_rules('ps', '附註', 'xss_clean');
        $this->form_validation->set_rules('charges', '付款方式', $rule);

        $user_data = array(
            'email'           => $user['email'],
            'name'            => $this->input->post('name'),
            'address'         => $this->input->post('address'),
            'phone'           => $this->input->post('phone'),
            'ps'              => $this->input->post('ps')
        );

        $totalItem   = $this->cart->total_items();
        $totalPrice  = $this->cart->total();
        $detail      = $this->cart->contents();

        if ($this->form_validation->run() == FALSE){

            $this->lvax->_wait(base_url('shop/detail'),"3","資料填寫錯誤，請重新填寫");
            

        }else{

            $data_array = array(
                'items'     =>  $this->cart->contents(),
                'totalPrice'=>  $this->cart->total()
            );
            
            $send_info = $this->_send_notify($user['email'],$data_array,$this->input->post("charges",true));//寄出通知信
            
            $check = array(
                'user_id'   =>  $user['id'],
                'name'      =>  $user_data['name'],
                'email'     =>  $user_data['email'],
                'address'   =>  $user_data['address'],
                'phone'     =>  $user_data['phone'],
                'ps'        =>  $user_data['ps'],
                'qty'       =>  $totalItem,
                'total'     =>  $totalPrice,
                'pway'      =>  $this->input->post("charges",true),
                'date'      =>  date("Y-m-d H:i:s")
            );
            
            if( ($order_id = $this->libraries_model->_insert("checkout",$check)) && ($send_info == '')){
                
                $this->checkout_model->_check_product($detail,$order_id,$user['id']);
                
                $this->cart->destroy();
                
                $this->lvax->_wait(base_url(),"3","訂單已成立!");

            }elseif(($order_id = $this->libraries_model->_insert("checkout",$check)) && ($send_info != '')){
                
                $this->checkout_model->_check_product($detail,$order_id,$user['id']);
                
                $this->cart->destroy();
                
                $this->lvax->_wait(base_url(),"5","通知信寄出失敗，錯誤訊息如下，但交易完成，請通知維護人員");
                echo $send_info;
                
            }else{

                $this->lvax->_wait(base_url(),"5","錯誤，請通知維護人員");

            }
        }
    }
    
    public function _send_notify($send_to,$data_array = 0,$pway = 0){
        
        if($data_array && $pway){
        
            $array = array();
            
            foreach($data_array as $key => $items){
                
                if($key == 'items'){
                    
                    foreach($items as $key => $item){
                
                    $array[$key] = '<tr style="border-bottom: 1px solid #E0E0E0;">
                                        <td title="title" style="border-right: 1px solid #E0E0E0; -ms-text-overflow: ellipsis;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">'.$item['name'].'</td>
                                        <td title="quantity" style="border-left: 1px solid #E0E0E0; border-right: 1px double #E0E0E0;">'.$item['qty'].'</td>
                                        <td title="subtotal" style="border-left: 1px solid #E0E0E0; border-right: 1px double #E0E0E0;">'.$item['price'].'</td>
                                    </tr>';
                    }
                }
                
            }
            
            $content = implode("",$array);
            
            $str = explode(" - ",$pway);
            
            $where = "way like '".$str[0]."'";
            
            $pway_content = $this->libraries_model->_select("payment",$where);
            
            $this->load->helper('file');
            
            $string = read_file('application/views/admin/checkout_mail.php');
            
            $string = preg_replace('/\#content\#/', $content,$string);
            
            $string = preg_replace('/\#logo\#/', base_url('public/img/logo.png'),$string);
            
            $string = preg_replace('/\#total\#/',$data_array['totalPrice'],$string);
            
            $string = preg_replace('/\#payment\#/',$pway,$string);
            
            $message = preg_replace('/\#something_to_you\#/',$pway_content[0]['content'], $string);
            
            $setting = $this->libraries_model->_select("site_setting","key","site_name",0,0,0,0,"row");
            
            $this->load->library("lvax");
            
            $this->lvax->_send_mail($send_to,$setting['value']." 訂購通知單",$message);
        }
        
    }
}
?>
