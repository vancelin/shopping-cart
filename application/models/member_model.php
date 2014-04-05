<?php

class Member_model extends CI_Model{

    //檢查用戶名是否存在
    public function _exsit($email){

        $query = $this->db->select('email')
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

    public function _chkpass($email){

        $query = $this->db->select('password')
                          ->from('userdata')
                          ->where('email', $email)
                          ->limit(1)
                          ->get()
                          ->row_array();
        return $query;

    }

    //註冊新使用者
    public function _register($data){

        $add = $this->db->insert('userdata', $data);

        return $add;

    }

    //登入驗證
    public function _login($password, $email = null){

        if ( $email != null ) {

            $query = $this->db->select('*')
                              ->from('userdata')
                              ->where('email = ' . "'" . $email . "'")
                              ->where('password = ' . "'" . $password . "'")
                              ->limit(1)
                              ->get()
                              ->row_array();
            if($query){
                return ( $query['valid'] ? $query : false );
            }else{
                return FALSE;
            }
        }
            return FALSE;
    }

    //使用facebook帳戶檢查是否註冊
    public function _fblogin($fbid){

        $query = $this->db->select('*')
                          ->from('userdata')
                          ->where('fbid = ' . "'" . $fbid . "'")
                          ->limit(1)
                          ->get()
                          ->row_array();
        return $query;

    }

    //更新上次登入ip ,時間
    public function _uptime($id){

        //UPDATE  `shopping_cart`.`userdata` SET  `last_login` =  'x' WHERE  `userdata`.`id` =3;
        $data = array(
                    'login_ip' => $_SERVER['REMOTE_ADDR'],
                    'last_login' => time(),
                );

        $this->db->where('id',$id)
                 ->update('userdata', $data );

        return TRUE;

    }

    //使用者驗證
    public function _uservalid($username, $password){

        $query = $this->db->select('username,password')
                          ->from('userdata')
                          ->where('username = ' . "'" . $username . "'")
                          ->where('password = ' . "'" . $password . "'")
                          ->limit(1)
                          ->get();

        if($query->num_rows() == 1){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    //更新使用者修改的資料
    public function _updata($username, $data){

        if ( $data == null ){

            return false;

        }

        $this->db->where('username', $username);
        $updata = $this->db->update('userdata', $data);

        return $updata;

    }

    public function _valid($email, $hash){

        $check = $this->db->select('username, valid')->from('userdata')
                   ->where('email', $email)->limit(1)->get()->row_array();

        if( $check && !$check['valid'] ){

            //md5('^_=+%%' + $check['username'] + '%&^_=+')
            if( $this->__mix($check['username']) == $hash ){

                $data = array( 'valid' => 1, );
                $this->db->where('email',$email)->update('userdata', $data );

                return true;

            }
                return false;
        }else{

            return false;
        }

    }

    public function _orders($email,$index, $mode = 0, $id = 0){

        if(!$mode){
         $this->db->select('*')->from('checkout')
               ->where('email', $email)->order_by("date", "desc")->limit(10,$index);
         $query  = $this->db->get();

         if( $result['query']  = $query->result_array() ){
             for($i=0;$i<$query->num_rows();$i++){
                 $detail = $this->db->
                              query('select * from sc2.checkout_product where order_id=?', $result['query'][$i]['serial_id']);
                 $result['detail'][] = $detail->result_array();
             }
         }

        return $result;
        }else{

            return $this->db->from('checkout')
                            ->join('checkout_product', 'checkout.serial_id = checkout_product.order_id')
                            ->where('email', $email)
                            ->where('date', $id)
                            ->get()->result_array();

        }

    }

    public function _count($table, $where = null){

        if( $where ) $this->db->where($where);

        return $this->db->from($table)
                         ->count_all_results();

    }

    public function __mix($hash){

        return md5('^_=+%%' + $hash + '%&^_=+');

    }
    
    public function _list_orders($email){
        
        $query = $this->db->from("checkout")
                          ->join("checkout_product","checkout.serial_id = checkout_product.order_id")
                          ->where('email', $email)
                          ->get();
        
        return $query->result_array();
        
    }
    
    public function _follow_list($id){
        
        $query = $this->db->from("user_follow")
                        ->join("product","user_follow.product_id = product.id")
                        ->where("user_id",$id)
                        ->where("product.on_sale","1")
                        ->get();
        
        return $query->result_array();
        
    }

}
?>
