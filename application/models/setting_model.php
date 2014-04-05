<?php

class Setting_model extends CI_Model{
    
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
    
    public function _update($table,$data,$where,$where_val){
        
        $this->db->where($where,$where_val);
        $this->db->update($table,$data);
        
    }
    
    public function _insert($table,$data){
        
        $this->db->insert($table,$data);
        return $this->db->insert_id();
        
    }
    
}

?>
