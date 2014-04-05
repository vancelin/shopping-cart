<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_model extends CI_Model{
    
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
    
    public function products_list($page_id,$query = 0,$action = 0){
        
        $this->db->select('product_imgs.*,product.*');
        $this->db->from('product');
        $this->db->join('product_imgs','product.id = product_imgs.product_id');
        
        if($query){
            $this->db->like('product.product_name',$query);
        }
        
        if($action){
            
            switch($action){
                case "price_desc":
                    $this->db->where('product_imgs.is_main','1');
                    $this->db->where('product.on_sale','1');
                    $this->db->order_by("product.sale_price desc,product.bargain_price asc");
                    break;
                case "price_asc":
                    $this->db->where('product_imgs.is_main','1');
                    $this->db->where('product.on_sale','1');
                    $this->db->order_by("product.sale_price asc,product.bargain_price asc");
                    break;
                case "newin":
                    $date = date('Y-m-d', time() - (24 * 60 * 60 * 7));//七天內新品
                    
                    $this->db->where('product_imgs.is_main','1');
                    $this->db->where('product.on_sale','1');
                    $this->db->where('product.update_time >=',$date);
                    $this->db->order_by("product.id", "desc");
                    break;
                case "recommend":
                    $this->db->where('product_imgs.is_main','1');
                    $this->db->where('product.on_sale','1');
                    $this->db->where('product.recommend','1');
                    $this->db->order_by("product.id", "desc");
                    break;
                case "bargain":
                    $this->db->where('product_imgs.is_main','1');
                    $this->db->where('product.on_sale','1');
                    $this->db->where('product.bargain_price !=','0');
                    $this->db->order_by("product.id", "desc");
                    break;
            }
            
        }else{
            $this->db->where('product_imgs.is_main','1');
            $this->db->where('product.on_sale','1');
            $this->db->order_by("product.id", "desc");
        }
        
        $this->db->limit(8,$page_id*8);
                
        $result = $this->db->get();
                        
        return $result->result_array();
        
    }
    /*優化功能了，先註解看有沒有問題，沒問題以後刪掉
    public function product_list($page_id,$query = 0){

        $this->db->select('*');
        $this->db->from('product');
        
        if($query){
            $this->db->like('product_name',$query);
        }
        
        $this->db->where('on_sale','1');
        $this->db->order_by("id", "desc");
        $this->db->limit(8,$page_id*8);
        
        $result = $this->db->get();
                        
        return $result->result_array();
        //return $this->db->query("select * from product where on_sale = '1' order by id desc limit $i,4")->result_array();
        
    }
    
    public function img_list($page_id,$query = 0){
 
        $this->db->select('product_imgs.*');
        $this->db->from('product');
        $this->db->join('product_imgs','product.id = product_imgs.product_id');
                        
        if($query){
            $this->db->like('product.product_name',$query);
        }
        
        $this->db->where('product_imgs.is_main','1');
        $this->db->where('product.on_sale','1');
        $this->db->order_by("product_imgs.product_id", "desc");
        $this->db->limit(8,$page_id*8);
                
        $result = $this->db->get();
                        
        return $result->result_array();
        
    }
    */
    
    public function show_product($id = 0){
        if($id){
            return $this->db->query("select * from product where id = ?",$id)->row_array();
        }else{
            return False;
        }
    }
    
    public function show_img($id,$is_main = 0){
        if(!$is_main){
            return $this->db->query("select * from product_imgs where product_id = ? order by product_id desc",$id)->result_array();
        }else{
            return $this->db->query("select * from product_imgs where product_id = ? and is_main = '1' limit 1",$id)->row_array();
        }
    }
    
    public function count_column($product_id){
        
        $row = $this->db->query("select * from checkout_product where product_id = ?",$product_id);
        
        return $row->num_rows();
        
    }
    
}
?>
