<?php

class Admin_model extends CI_Model{

    public function attribute_list($where = 0){
        
        if(!$where){
            return $this->db->query("SELECT attribute.id,attribute.attribute_group_id,attribute.attribute_name,attribute_group.attribute_group_name
                                    FROM attribute
                                    LEFT JOIN attribute_group 
                                    ON attribute.attribute_group_id = attribute_group.id 
                                    order by id desc")->result_array();
        }else{
            return $this->db->query("select * from attribute where attribute_group_id = ?",$where)->result_array();
        }
        
    }
    
    public function category_second_list($category_id){
        return $this->db->query("select * from product_category where parent = ? and type = '2' order by category_id",$category_id)->result_array();
    }
    
    public function del_old_attribute_temp($product_id){
        $this->db->query("delete from attribute_temp where product_id = ?",$product_id);
    }
    
    public function edit_save_img($product_id,$id){
        //將其他圖片主圖設為0
        $this->db->query("update product_imgs set is_main = '0' where product_id = ? and id != ?",array($product_id,$id));
        //將新上傳圖片主圖設為1
        $this->db->query("update product_imgs set is_main = '1' where id = ?",$id);
        
    }
    
    public function update_attribute($is_group,$id,$data){
        
        if($is_group){
            $this->db->where("id",$id);
            $this->db->update("attribute_group",$data);
        }else{
            $this->db->where("id",$id);
            $this->db->update("attribute",$data);
        }
        
    }
    
    public function list_category_parent($id = 0){
        
        if($id){
            return $this->db->query("select * from product_category where type = '1' and category_id != ?",$id)->result_array();
        }else{
            return $this->db->query("select * from product_category where type = '1'")->result_array();
        }
    }
    
    public function chk_category_parent($id){
        
        $result = $this->db->query("select * from product_category where parent = ?",$id);
        
        if($result->num_rows){
            return false;
        }else{
            return $this->list_category_parent($id);
        }
        
    }
    
    public function _count_all($table){
        return $this->db->count_all($table);
    }

    public function _member($email){

        $query = $this->db->query('select * from sc2.userdata where email=? limit 1',$email);

        return $query->result_array();
    }
    
    function manage_login($username,$password){
        
        $query = $this->db->query("SELECT id,username,password 
                                  FROM admin_user 
                                  WHERE username = ? and password =? 
                                  limit 1",array($username,$password));
       
        if($query->num_rows() == 1){
            return $query->row_array();
        }else{
            return FALSE;
        }

    }
    
    function products_list($offset,$perpage){
        
        $this->db->select("product.*,product_imgs.img_name,product_category.*");
        $this->db->from("product");
        $this->db->join("product_imgs","product.id = product_imgs.product_id");
        $this->db->join("product_category","product.category_id = product_category.category_id");
        $this->db->where("product_imgs.is_main","1'");
        $this->db->order_by("product.id",'desc');
        $this->db->limit($perpage,$offset);
        
        $query = $this->db->get();
        
        return $query->result_array();
        
    }

    function _search_products($index, $data = null, $method = 0){

        $this->db->select("product.*,product_imgs.img_name,product_category.*");
        $this->db->from("product");
        $this->db->join("product_imgs","product.id = product_imgs.product_id");
        $this->db->join("product_category","product.category_id = product_category.category_id");
        if( $data && $method ){

            switch($method){
                case 'market_low':
                    if( !is_numeric($data) ) break;
                    $this->db->where('market_price <=', $data);
                    break;
                case 'market_high':
                    if( !is_numeric($data) ) break;
                    $this->db->where('market_price >=', $data);
                    break;

                case 'sale_low':
                    if( !is_numeric($data) ) break;
                    $this->db->where('sale_price <=', $data);
                    break;
                case 'sale_high':
                    if( !is_numeric($data) ) break;
                    $this->db->where('sale_price >=', $data);
                    break;

                case 'bargain_low':
                    if( !is_numeric($data) ) break;
                    $this->db->where('bargain_price <=', $data);
                    break;
                case 'bargain_high':
                    if( !is_numeric($data) ) break;
                    $this->db->where('bargain_price >=', $data);
                    break;

                case 'unit_low':
                    if( !is_numeric($data) ) break;
                    $this->db->where('unit <=', $data);
                    break;
                case 'unit_high':
                    if( !is_numeric($data) ) break;
                    $this->db->where('unit >=', $data);
                    break;

                default:
                    $method = 'product_name';
                    $this->db->like($method, $data);
                    break;
            }
        }
        $this->db->order_by("product.id",'desc');
        $this->db->limit(10, $index);
        
        $query = $this->db->get();

        
        return $query->result_array();
        
    }

}
?>
