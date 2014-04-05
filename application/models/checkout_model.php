<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout_model extends CI_Model{

    public function _check_product($data,$order_id,$user_id){
        
        foreach($data as $detail){
            
            $specs = (isset($detail['option'])) ? $detail['option'] : "";
            
            $content = array(
                'order_id'      =>  $order_id,
                'user_id'       =>  $user_id,
                'product_id'    =>  $detail['id'],
                'product_name'  =>  $detail['name'],
                'specs'         =>  $specs,
                'qty'           =>  $detail['qty'],
                'price'         =>  $detail['subtotal']
            );
            
            $this->db->insert('checkout_product',$content);
            $this->db->query("update product set float_unit = float_unit - ? where id = ?",array($detail['qty'],$detail['id']));//扣除浮動庫存
            
        }
    }

    public function _exsit($email){

        $query = $this->db->select('username')
                          ->from('userdata')
                          ->where('email',$email)
                          ->limit(1)
                          ->get();

        if($query->num_rows() == 1){
            return TRUE;
        }else{
            return false;
        }

    }
    
    

}
?>
