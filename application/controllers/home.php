<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('index_model');
        $this->load->model('libraries_model');
    }

    public function index($page_id = 0,$action = 0){
        
        //載入template
        $this->load->library('lvax');
        $this->lvax->_front_end("products",$this->index_model->products_list($page_id,0,$action),"home",array("page_id"=>$page_id,"account"=>$this->session->userdata('logged_in')));
        
    }

    
    public function product($id = 0){
        
        $product = $this->index_model->show_product($id);
        
        if($id && $product){
            
            $templates = array(
                'attributes'    =>  $this->libraries_model->_select('attribute_temp','product_id',$id),
                'imgs'          =>  $this->index_model->show_img($id),
                'main_img'      =>  $this->index_model->show_img($id,1),//抓主圖
                'product_specs' =>  $this->libraries_model->_select('product_specs','product_id',$id,0,0,0,0),
                'page_name'     =>  $product['product_name'],
                'payments'      =>  $this->libraries_model->_select("payment",0,0,0,0,"id","1"),
                'account'       =>  $this->session->userdata('logged_in')
            );
            
            $this->load->library('lvax');
            $this->lvax->_front_end("product",$product,"product",$templates);
            
        }else{
            redirect(base_url('home'));
        }
        
    }
    
    public function search($page_id = 0,$query = 0){
        
        if($this->input->post()){
            
            redirect (base_url('home/search/0/'.$this->input->post("query",true)));
            
        }else{
            
            $products = $this->index_model->products_list($page_id,$query);

            $templates = array(
                'page_id'   =>  $page_id,
                'count'     =>  count($products),
                'account'       =>  $this->session->userdata('logged_in')
            );
            
            $this->load->library('lvax');
            $this->lvax->_front_end("products",$products,"search",$templates);

        }
    }
    
    function keycik(){
        
        $img_height = 30;  // 圖形高度
        $img_width = 100;   // 圖形寬度
        $mass = 0;        // 雜點的數量，數字愈大愈不容易辨識

        $num = "";              // rand後所存的地方
        $num_max = 4;      // 產生6個驗證碼
        for( $i=0; $i<$num_max; $i++ )
        {
            $num .= rand(0,9);
        }

        $this->load->library('session');
        $this->session->set_userdata('Checknum',$num);


        // 創造圖片，定義圖形和文字顏色
        Header("Content-type: image/PNG");
        srand((double)microtime()*1000000);
        $im = imagecreate($img_width,$img_height);
        $black = ImageColorAllocate($im, 250,250,250);         // (0,0,0)文字為黑色
        $gray = ImageColorAllocate($im, 0,0,0); // (200,200,200)背景是灰色
        imagefill($im,0,0,$gray); 

        // 在圖形產上黑點，起干擾作用;
        for( $i=0; $i<$mass; $i++ )
        {
            imagesetpixel($im, rand(0,$img_width), rand(0,$img_height), $black);
        }

        // 將數字隨機顯示在圖形上,文字的位置都按一定波動範圍隨機生成
        $strx=rand(3,8);
        for( $i=0; $i<$num_max; $i++ )
        {
            $strpos=rand(1,8);
            imagestring($im,5,$strx,$strpos, substr($num,$i,1), $black);
            $strx+=rand(8,14);
        }
            ImagePNG($im);
            ImageDestroy($im);  
    }
    
    public function page($page_id = 0){
        
        if(!$page_id) redirect (base_url('home'));
        
        $templates = array(
            'account'       =>  $this->session->userdata('logged_in')
        );
            
        $this->load->library('lvax');
        $this->lvax->_front_end("page",$this->libraries_model->_select("site_page","id",$page_id,0,0,0,0,"row"),"page",$templates);
    }
    
}
?>
