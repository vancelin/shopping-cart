<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{
    
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
    
     public function category_first_list(){
        
        return $this->db->query("select * from product_category where type = '1' order by category_id")->result_array();
        
    }
    
    public function chk_category($id){
        
        $result = $this->db->query("select * from product_category where category_id = ?",$id);
    
        return $result->num_rows();
        
    }
    
    public function category_second_list($id){
        
        $result = $this->db->query("select * from product_category where parent = ? and type = '2' order by category_id",$id);
        
        if($result->num_rows()){
            return $result->result_array();
        }else{
            return FALSE;
        }
        
    }
    
    public function choice_product($category_id,$page_id){
        
        $where = "category_id = ".$category_id." or category_second_id = ".$category_id;
        
        return $this->db->select('*')
                        ->from('product')
                        ->where('on_sale','1')
                        ->where($where)
                        ->order_by('id','desc')
                        ->limit(8,$page_id*8)
                        ->get()
                        ->result_array();
        
        //return $this->db->query("select * from product where on_sale = '1' and (category_id = ? or category_second_id = ?) order by id desc",array($category_id,$category_id))->result_array();
        
    }
    
    public function choice_img($category_id,$page_id){
        
        $where1 = "product_imgs.is_main = '1'";
        $where2 = "product.on_sale = '1'";
        $where3 = "product.category_id = ".$category_id." or product.category_second_id = ".$category_id;
        
        
        /*return $this->db->select('product_imgs.*')
                        ->from('product')
                        ->join('product_imgs','product.id = product_imgs.product_id')
                        ->where($where1)
                        ->where($where2)
                        ->where($where3)
                        ->order_by('product_imgs.product_id','desc')
                        ->limit(8,$i)
                        ->get()
                        ->result_array();*/
        
        return $this->db->query("SELECT product_imgs . *
                                FROM product
                                JOIN product_imgs ON product.id = product_imgs.product_id
                                WHERE product_imgs.is_main = '1'
                                AND product.on_sale = '1'
                                AND (product.category_id = ? or product.category_second_id = ?)
                                ORDER BY product_imgs.product_id DESC limit ?,?",array($category_id,$category_id,$page_id*8,8))->result_array();
        
    }
    
}
?>
