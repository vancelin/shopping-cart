<?php

class Sell_model extends CI_Model{
    
    public function _select($table,$where = 0,$where_val = 0,$offset = 0,$per_page = 0,$order = 0,$desc = 0,$result = 'result'){
        
        $this->db->from($table);
        
        if($where && $where_val){
            $this->db->where($where,$where_val);
        }
        
        if($order && $desc){
            $this->db->order_by($order,'desc');
        }elseif($order && !$desc){
            $this->db->order_by($order,'asc');
        }
        
        if($offset && $per_page){
            $this->db->limit($per_page,$offset);
        }elseif(!$offset && $per_page){
            $this->db->limit($per_page);
        }
        
        $query = $this->db->get();
        
        if($result == 'row'){
            return $query->row_array();
        }elseif($result == 'result'){
            return $query->result_array();
        }
        
    }
    
    public function _insert($table,$data){
        
        $this->db->insert($table,$data);
        return $this->db->insert_id();
        
    }
    
    public function _update($table,$data,$where,$where_val){
        
        $this->db->where($where,$where_val);
        $this->db->update($table,$data);
    }
    
    public function _show_orders($mode = 0,$sub_mode = 0){
        
        if(!$mode && !$sub_mode){
            
            $days = strtotime(date("Y-m-d H:i:s")) - (86400 * 3); //顯示最近三天
            
            return $this->db->query("select * from checkout where date > ? order by `serial_id` desc",$days)->result_array();
            
        }elseif($mode == 'status'){
            
            if($sub_mode == 'not'){
                return $this->db->query("select * from checkout where status = '0' order by `serial_id` desc")->result_array();
                
            }elseif($sub_mode == 'ok'){
                
                return $this->db->query("select * from checkout where status = '1' order by `serial_id` desc")->result_array();
                
            }
            
        }elseif($mode == 'user'){
            
            return $this->db->query("select * from checkout where email = ? order by `serial_id` desc",$sub_mode)->result_array();
            
        }elseif($mode == 'all'){
            
            return $this->db->query("select * from checkout order by `serial_id` desc")->result_array();
            
        }
        
        
    }
    
    public function _show_detail_product($serial_id){
        
        return $this->db->query("select * from checkout_product where order_id = ?",$serial_id)->result_array();
        
    }
    
    public function _edit_status($serial_id,$status){
        
            $orders = $this->db->query("SELECT * FROM checkout JOIN checkout_product ON checkout.serial_id = checkout_product.order_id WHERE checkout.serial_id = ?",$serial_id)->result_array();
            
            foreach($orders as $order){
                
                if($order['status'] != 2 && $status == 2):
                    $this->db->query("update product set unit = unit - ? where product_name like ?",array($order['qty'],$order['product_name']));
                elseif($order['status'] == 2 && $status != 2):
                    $this->db->query("update product set unit = unit + ? where product_name like ?",array($order['qty'],$order['product_name']));
                endif;
                
            }
            
            $this->db->query("update checkout set status = ? where serial_id = ?",array($status,$serial_id));
            
            return ($status == 2)?true:false;
           
    }
    
    public function _show_detail_order($order_id){
        
        return $this->db->query("SELECT *,checkout.qty as total_qty FROM checkout JOIN checkout_product ON checkout.serial_id = checkout_product.order_id WHERE checkout.serial_id = ?",$order_id)->result_array();
        
    }
    
    public function _sell_rank(){
        
        return $this->db->query("SELECT * , COUNT(*) as count
                                FROM checkout_product 
                                join product_imgs 
                                on checkout_product.product_id = product_imgs.product_id 
                                where product_imgs.is_main = '1' 
                                GROUP BY checkout_product.product_id
                                HAVING COUNT( * ) >1
                                order by count desc")
                        ->result_array();
        
    }
    
    public function _show_total_n_orders($today,$mode = 0){
        
        if($mode==1){       
            return $this->db->query("SELECT count(*) as count,sum(total) as total
                                    FROM checkout
                                    WHERE TO_DAYS(checkout.date) = TO_DAYS(?)",$today)->row_array();
        }else{
            return $this->db->query("SELECT count(*) as count,sum(total) as total
                                    FROM checkout
                                    where (status = '1' or status = '2')
                                    and TO_DAYS(checkout.close_date) = TO_DAYS(?)",$today)->row_array();
        }   
            
        
    }
    
    public function _show_profit($today,$mode = 0){
        
        if($mode==1){  
            return $this->db->query("select sum(product.cost) as cost
                                    from checkout
                                    join checkout_product on checkout.serial_id = checkout_product.order_id
                                    join product on checkout_product.product_id = product.id
                                    where TO_DAYS(checkout.date) = TO_DAYS(?)",$today)->row_array(); 
        }else{
            return $this->db->query("select sum(product.cost) as cost
                                    from checkout
                                    join checkout_product on checkout.serial_id = checkout_product.order_id
                                    join product on checkout_product.product_id = product.id
                                    where (status = '1' or status = '2')
                                    and TO_DAYS(checkout.close_date) = TO_DAYS(?)",$today)->row_array(); 
        }
    }
    
}

?>