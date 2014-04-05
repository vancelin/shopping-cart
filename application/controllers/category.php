<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('libraries_model');
    }
    
    public function index($category_id = 0, $page = 0){
        
        if($category_id){
            
            $templates = array(
                'imgs'          =>  $this->category_model->choice_img($category_id,$page),
                'category_id'   =>  $category_id,
                'account'       =>  $this->session->userdata('logged_in')
            );
            
            $this->load->library('lvax');
            $this->lvax->_front_end("products",$this->category_model->choice_product($category_id,$page),"category",$templates);
            
        }else{

            redirect(base_url('home'));
        }
    }
    
    public function category_second_list($id = 0){
        
        if($id && $this->category_model->chk_category($id)){
            
            $results = $this->category_model->category_second_list($id);
            
            if(!$results){
                
                return FALSE;
                
            }else{
                $array = array();

                foreach($results as $key => $result){

                    $array[$key] = "<li><a href='".base_url('category/index/'.$result['category_id'])."' >".$result['category_name']."</a></li>";

                }

                $content = implode("",$array);

                echo $content;
                
            }
            
        }else{
            redirect(base_url('home'));
        }
        
    }

}
?>
