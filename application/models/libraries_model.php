<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Libraries_model extends CI_Model{
    
    public function _select($table,$where = 0,$where_val = 0,$offset = 0,$per_page = 0,$order = 0,$desc = 0,$result = 'result',$select = 0,$like = 0){
        
        if (!$select) $select = '*';

        $this->db->select($select);
        $this->db->from($table);
        
        if($where && $where_val && !$like){
            $this->db->where($where,$where_val);
        }elseif($where && !$where_val && !$like){
            $this->db->where($where);
        }elseif($where && $like && !$where_val){
            $this->db->like($where, $like); 
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
    
    public function _update($table,$data,$where = 0,$where_val = 0 ){
        
        if($where && $where_val){
            $this->db->where($where,$where_val);
        }elseif($where && !$where_val){
            $this->db->where($where);
        }
        
        $this->db->update($table,$data);
        return ($this->db->affected_rows() > 0);
    }
    
    public function _insert($table,$data){
        
        $this->db->insert($table,$data);
        return $this->db->insert_id();
        
    }
    
    public function _delete($table,$where,$where_val = 0){
        
        if($where && $where_val){
            $this->db->where($where,$where_val);
        }elseif($where && !$where_val){
            $this->db->where($where);
        }
        
        $this->db->delete($table); 
        
        return ($this->db->affected_rows() > 0);
        
    }
    
    public function _count_all($table){
        return $this->db->count_all($table);
    }
    
}
?>
