<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('admin_model');
        $this->load->model('libraries_model');
        if (!$this->session->userdata('manage_logged_in')){                    
            redirect('admin/index');
            exit();
        }
    }
        
    public function index(){
        
        $session_data = $this->session->userdata('manage_logged_in');
        redirect(base_url('admin/product/product_list'));
        
    }

    public function product_list(){
        
        $offset = ($this->uri->segment(4))?$this->uri->segment(4):0;
        $perpage = ($this->uri->segment(5))?$this->uri->segment(5):"10";//預設一頁十筆
        
        //$data['products'] = $this->libraries_model->_select('product',0,0,$offset,$perpage,'id',1);
        //$data['imgs'] = $this->libraries_model->_select('product_imgs','is_main','1',$offset,$perpage,'id',1);
        
        $data['products'] = $this->admin_model->products_list($offset,$perpage);
        $data['categorys'] = $this->libraries_model->_select("product_category");
        $this->load->library('lvax');
        $conf = $this->lvax->_pagination('product/product_list/','product',$perpage);
                
        $this->pagination->initialize($conf);
        $data["links"] = $this->pagination->create_links();
        $this->load->view('admin/list',$data);
      
    }
   
    
    //新增商品
    public function add(){
        $data['categorys'] = $this->libraries_model->_select('product_category','type','1',0,0,'category_id',0);
        $data['attribute_group'] = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
        $this->load->view('admin/add',$data);
    }
    
    public function category_second_list(){
        
        $categorys_second = $this->admin_model->category_second_list($this->input->post("category_id",TRUE));
        
        if($categorys_second){
            
            $array = array();
            
            foreach($categorys_second as $key => $category){
                
                $array[$key] = "<option value='".$category['category_id']."'>".$category['category_name']."</option>";
                
            }
            
            $content = implode("", $array);
            
            echo '細項 : <select id="category_second" name="category_second" class="droplist-input"><option>請選擇</option>'.$content.'</select>';
            
        }else{
            echo '';
        }
        
    }
    
    //新增屬性
    public function add_attribute(){
        
        $groups = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
        
        $array = array();
        
        foreach($groups as $key => $group){
            $array[$key] = "<option value='".$group['id']."'>".$group['attribute_group_name']."</option>";
        }
        
        echo "<option>請選擇</option>".implode("",$array);
        
    }
    
    //屬性儲存
    public function attribute_save(){
        
        if($this->input->post("attribute_name",TRUE) != '' && $this->input->post("attribute_group_id",TRUE) != ''){
            
            $data = array(
                'attribute_name'        =>$this->input->post("attribute_name",TRUE),
                'attribute_group_id'    =>$this->input->post("attribute_group_id",TRUE)
            );
        
            echo $this->libraries_model->_insert('attribute',$data);
            
        }else{
            redirect(base_url('admin/add_attribute'));
        }
        
    }
    
    //屬性列表
    public function list_attribute(){
        $data['list'] = $this->admin_model->attribute_list();
        $this->load->view('admin/list_attribute',$data);
    }
    
    
    //屬性分組儲存
    public function attribute_group_save(){
        
        if($this->input->post("attribute_group_name",TRUE)!=''){
        
            $data = array(
                'attribute_group_name'    =>$this->input->post("attribute_group_name",TRUE)
            );
            
            echo $this->libraries_model->_insert('attribute_group',$data);
        }else{
            redirect(base_url('admin/product/add_attribute_group'));
        }
        
    }
    
    //屬性分組列表
    public function list_attribute_group($mode = 0){
        if($mode!=0){
            
            $groups = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
            
            $array = array();
            
            foreach($groups as $key => $group){
                
                if($this->input->post("group_id",true) == $group['id']){
                    $array[$key] = "<option selected value='".$group['id']."'>".$group['attribute_group_name']."</option>";
                }else{
                    $array[$key] = "<option value='".$group['id']."'>".$group['attribute_group_name']."</option>";
                }
                
            }
            
            echo "<option>請選擇</option>".implode("",$array);
            
        }else{
            $data['list'] = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
            $this->load->view('admin/list_attribute_group',$data);
        }
    }
    
    //前台ajax選擇分組時列出屬性
    public function attribute_set(){
        
        $group_id = $this->input->post("group_id",TRUE);
        if(is_numeric($group_id)){
        
            $results = $this->admin_model->attribute_list($this->input->post("group_id",TRUE));
            
            if($group_id){
            
                $array = array();

                foreach($results as $key=>$row){
                    $array[$key] = "<p>".$row['attribute_name']." : <input type='hidden' value='".$row['id']."' name='attribute_id[]'>
                                    <input type='hidden' value='".$row['attribute_name']."' name='attribute_name[]'>
                                    <input type='text' value='' name='select[]' class='input-text'></p>";
                }

                $content = implode("",$array);

                echo $content;
                
            }else{
                echo '';
            }
        
        }
        
    }
    
    //儲存商品
    public function save(){
        
        $update_time = date("Y-m-d H:i:s"); 
        
        $this->form_validation->set_rules('product_name', '商品名稱', 'trim|required');
        $this->form_validation->set_rules('category', '大類選項', 'trim|required|numeric');
        $this->form_validation->set_rules('market_price', '原價', 'trim|required|numeric');
        $this->form_validation->set_rules('sale_price', '售價', 'trim|required|numeric');
        $this->form_validation->set_rules('bargain_price', '特價', 'trim|numeric');
        $this->form_validation->set_rules('cost', '成本', 'trim|required|numeric');
        $this->form_validation->set_rules('unit', '數量', 'required|trim|numeric');
        
        if($this->form_validation->run() == FALSE){
            
            $data['response'] = validation_errors();
            
            //重新讀取add function內的資料，不然商品屬性無法讀取
            $data['categorys'] = $this->libraries_model->_select('product_category','type','1',0,0,'category_id',0);
            $data['attribute_group'] = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
            
            $this->load->view('admin/add',$data);
            
        }else{
            
            $products = array(
                'product_name'          => $this->input->post('product_name',TRUE),
                'category_id'           => $this->input->post('category',TRUE),
                'category_second_id'    => $this->input->post('category_second',TRUE),
                'introduction'          => $this->input->post('introduction'),
                'market_price'          => $this->input->post('market_price',TRUE),
                'sale_price'            => $this->input->post('sale_price',TRUE),
                'bargain_price'         => $this->input->post('bargain_price',TRUE),
                'bargain_from'          => $this->input->post('from',TRUE),
                'bargain_to'            => $this->input->post('to',TRUE),
                'cost'                  => $this->input->post('cost',TRUE),
                'update_time'           => $update_time,
                'unit'                  => $this->input->post('unit',TRUE),
                'float_unit'            => $this->input->post('unit',TRUE),
                'on_sale'               => $this->input->post('on_sale',TRUE),
                'recommend'             => $this->input->post('recommend',TRUE)
            );
            
            $product_id = $this->libraries_model->_insert('product',$products);
            
            //儲存規格
            $specs = $this->input->post("specs",TRUE);
            
            if(is_array($specs)){
                foreach($specs as $spec){
                    $data = array(
                        'product_id'    => $product_id,
                        'spec_value'    => $spec
                    );
                    if(!empty($spec)){
                        $this->libraries_model->_insert('product_specs',$data);
                    }
                }
            }else{
                $data = array(
                    'product_id'    => $product_id,
                    'spec_value'    => $specs//2012/12/14修正，但不確定
                );
                if(!empty($spec)){
                    $this->libraries_model->_insert('product_specs',$data);
                }
            }
            /*
            $main_photos = $this->input->post("is_main",true);
            
            foreach($main_photos as $key => $photo){
                
                $i = explode("---",$photo);
                
                $is_main = ($i[1]=='1')?'1':'0';//如果為0則是第一張,設置為主圖
                        
                $image_info = array(
                    'product_id'    =>  $product_id,
                    'img_name'      =>  $i[0],
                    'is_main'       =>  $is_main,
                    'upload_time'   =>  $update_time
                );

                $this->libraries_model->_insert('product_imgs',$image_info);
            }*/
            
            $this->_product_upload($product_id, $update_time);
            
            /*以下為原先使用上傳函式，先做保留
            //建立config
            $config['upload_path'] = realpath(APPPATH . '../public/product_imgs/');
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['overwrite'] = false;
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '512';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            //讀取upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $i = 0;//計算第幾張圖片
            
            foreach($_FILES as $key => $value){
                
                if( !empty($value['name'])){
                    if(!$this->upload->do_upload($key)){
                        
                        $data["error"] = $this->upload->display_errors();
                        echo $data['error'];
                        
                    }else{
                        
                        $info = $this->upload->data();
                        
                        $is_main = (!$i)?'1':'0';//如果為0則是第一張,設置為主圖
                        
                        $image_info = array(
                            'product_id'    =>  $product_id,
                            'img_name'      =>  $info['file_name'],
                            'is_main'       =>  $is_main,
                            'upload_time'   =>  $update_time
                        );
                        
                        $this->libraries_model->_insert('product_imgs',$image_info);
                        $i++;
                    }
                }
            }
             */
            
            
            //將屬性的標題與內容結合
            $attribute_name = $this->input->post("attribute_name",TRUE);
            $attribute_value = $this->input->post("select",TRUE);
            
            if($attribute_name && $attribute_value != ''){
                foreach($attribute_name as $key => $name){

                    $data = array(
                        'product_id'            => $product_id,
                        'attribute_name'        => $name,
                        'attribute_group_id'    => $this->input->post("group_id",TRUE),
                        'attribute_value'       => $attribute_value[$key]
                    );

                    $this->libraries_model->_insert('attribute_temp',$data);

                }
            }
            
            if($this->input->post("continue",TRUE)){
                $this->load->library("lvax");
                $this->lvax->_wait(base_url('admin/product/edit/'.$product_id),"1","儲存成功!");
            }else{
                $this->load->library("lvax");
                $this->lvax->_wait(base_url('admin'),"1","儲存成功!");
            }
           
        }
        
    }
    
    //商品編輯
    public function edit($id = 0){
        if($id){
            $data['products'] = $this->libraries_model->_select('product','id',$id,0,0,'id','1','row');
            $data['attribute'] = $this->libraries_model->_select('attribute_temp','product_id',$id);
            $data['attribute_group'] = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
            $data['images'] = $this->libraries_model->_select('product_imgs','product_id',$id);
            $data['image_count'] = count($data['images']);
            $data['categorys'] = $this->libraries_model->_select('product_category','type','1',0,0,'category_id',0);
            $data['categorys_second'] = $this->admin_model->category_second_list($data['products']['category_id']);
            $data['product_specs'] = $this->libraries_model->_select('product_specs','product_id',$id);
            $this->load->view('admin/edit',$data);
            
        }else{
            redirect(base_url('admin/product/index'));
        }
    }
    
    //商品編輯儲存
    public function edit_save($product_id = 0){
       
        if(!$product_id){
            redirect(base_url('admin/product/index'));
        }
        
        $update_time = date("Y-m-d H:i:s"); 
        
        $product_name =  $this->form_validation->set_rules('product_name', '商品名稱', 'trim|required');
        $category_id =  $this->form_validation->set_rules('category', '大類選項', 'trim|required|numeric');
        $market_price =  $this->form_validation->set_rules('market_price', '原價', 'trim|required|numeric');
        $sale_price =  $this->form_validation->set_rules('sale_price', '售價', 'trim|required|numeric');
        $bargain_price =  $this->form_validation->set_rules('bargain_price', '特價', 'trim|numeric');
        $cost =  $this->form_validation->set_rules('cost', '成本', 'trim|numeric');
        $unit =  $this->form_validation->set_rules('unit', '數量', 'required|trim|numeric');
        
        if($this->form_validation->run() == FALSE){
            
            $data['response'] = validation_errors();
            
            //重新讀取產品資料，不然商品內容被清空
            $data['products'] = $this->libraries_model->_select('product','id',$product_id,0,0,'id','1','row');
            $data['attribute'] = $this->libraries_model->_select('attribute_temp','product_id',$product_id);
            $data['attribute_group'] = $this->libraries_model->_select('attribute_group',0,0,0,0,'id','1');
            $data['images'] = $data['images'] = $this->libraries_model->_select('product_imgs','product_id',$product_id);
            $data['image_count'] = count($data['images']);
            $data['categorys'] = $this->libraries_model->_select('product_category','type','1',0,0,'category_id',0);
            $data['categorys_second'] = $this->admin_model->category_second_list($data['products']['category_id']);
            $data['product_specs'] = $this->libraries_model->_select('product_specs','product_id',$product_id);
            
            $this->load->view('admin/edit',$data);
            
        }else{
            
            $products = array(
                'product_name'          => $this->input->post('product_name',TRUE),
                'category_id'           => $this->input->post('category',TRUE),
                'category_second_id'    => $this->input->post('category_second',TRUE),
                'introduction'          => $this->input->post('introduction'),
                'market_price'          => $this->input->post('market_price',TRUE),
                'sale_price'            => $this->input->post('sale_price',TRUE),
                'bargain_price'         => $this->input->post('bargain_price',TRUE),
                'bargain_from'          => $this->input->post('from',TRUE),
                'bargain_to'            => $this->input->post('to',TRUE),
                'cost'                  => $this->input->post('cost',TRUE),
                'update_time'           => $update_time,
                'unit'                  => $this->input->post('unit',TRUE),
                'float_unit'            => $this->input->post('float_unit',TRUE),
                'on_sale'               => $this->input->post('on_sale',TRUE),
                'recommend'             => $this->input->post('recommend',TRUE)
            );
            
            $this->libraries_model->_update('product',$products,'id',$product_id);
            
            //儲存商品規格，更新的功能改用ajax
            $specs = $this->input->post("specs",TRUE);
            
            
            if(is_array($specs)){
                foreach($specs as $spec){
                    $data = array(
                        'product_id'    => $product_id,
                        'spec_value'    => $spec
                    );
                    if(!empty($spec)){
                        $this->libraries_model->_insert('product_specs',$data);
                    }
                }
            }else{
                $data = array(
                    'product_id'    => $product_id,
                    'spec_value'    => $specs//2012/12/14修正，但不確定
                );
                if(!empty($spec)){
                    $this->libraries_model->_insert('product_specs',$data);
                }
            }
            
            $this->_product_upload($product_id, $update_time,1);
            /*
            //建立config
            $config['upload_path'] = realpath(APPPATH . '../public/product_imgs/');
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['overwrite'] = false;
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '512';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            //讀取upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            foreach($_FILES as $key => $value){
                
                if( !empty($value['name'])){
                    if(!$this->upload->do_upload($key)){
                        
                        $data["error"] = $this->upload->display_errors();
                        echo $data['error'];
                        
                    }else{
                        
                        $info = $this->upload->data();
                        
                        $image_info = array(
                            'product_id'    =>  $product_id,
                            'img_name'      =>  $info['file_name'],
                            'is_main'       =>  0,
                            'upload_time'   =>  $update_time
                        );
                        
                        $this->libraries_model->_insert('product_imgs',$image_info);
                    }
                }
            }*/
            
            //儲存變更的主圖ID
            if($this->input->post("img_id",TRUE)!=''){
                $this->admin_model->edit_save_img($product_id,$this->input->post("img_id",TRUE));
            }
            
            $attribute = $this->libraries_model->_select('attribute_temp','product_id',$product_id);
            
            //判斷是否有選擇 若無則給0
            $old_attr_group_id = (isset($attribute[0]['attribute_group_id']))?$attribute[0]['attribute_group_id']:"0";
            
            //如果原先的group_id不等於後來所選ID則刪除舊有的屬性,新增新的屬性
            if($old_attr_group_id == $this->input->post("group_id",TRUE)){
                
                //將屬性的標題與內容結合
                $attribute_id = $this->input->post("attribute_id",TRUE);
                $attribute_value = $this->input->post("select",TRUE);

                foreach($attribute_value as $key => $value){
                                        $content = array('attribute_value'=>$value);
                    $this->libraries_model->_update('attribute_temp',$content,'id',$attribute_id[$key]);

                }
                
            }else{
                
                //刪除舊有的屬性
                $this->admin_model->del_old_attribute_temp($product_id);
                
                $attribute_id = $this->input->post("attribute_id",TRUE);
                $attribute_value = $this->input->post("select",TRUE);
                $attribute_name = $this->input->post("attribute_name",TRUE);
                
                if(!empty($attribute_name)){
                
                    foreach($attribute_name as $key => $name){

                        $data = array(
                            'product_id'            => $product_id,
                            'attribute_name'        => $name,
                            'attribute_group_id'    => $this->input->post("group_id",TRUE),
                            'attribute_value'       => $attribute_value[$key]
                        );

                        //儲存新選的屬性
                        $this->libraries_model->_insert('attribute_temp',$data);

                    }
                }
            }
            
            if($this->input->post("continue",TRUE)){
                $this->load->library("lvax");
                $this->lvax->_wait(base_url('admin/product/edit/'.$product_id),"1","更新成功!");
            }else{
                $this->load->library("lvax");
                $this->lvax->_wait(base_url('admin/product/'),"1","更新成功!");
            }
           
        }
        
    }
    
    public function upd_spec(){
                $this->libraries_model->_update('product_specs',array('spec_value'=>$this->input->post("spec_val",TRUE)),'spec_id',$this->input->post("spec_id",TRUE));
    }
    
    //刪除商品規格
    public function del_spec(){
                $this->libraries_model->_delete("product_specs","spec_id",$this->input->post("spec_id",TRUE));
    }
    
    //刪除商品
    public function delete($id = 0){
        if($id){
            //if(!$session){redirect(base_url('index'));}
            
            $img_array = $this->libraries_model->_select('product_imgs','product_id',$id);
            
            foreach($img_array as $img){
                unlink('public/product_imgs/'.$img['img_name']);
            }
            
            $this->libraries_model->_delete("product","id",$id);
            $this->libraries_model->_delete("product_imgs","product_id",$id);
            $this->libraries_model->_delete("attribute_temp","product_id",$id);
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    //刪除屬性
    public function del_attribute($id = 0){
        
        //if(!$session){redirect(base_url('index'));}
        
        if($id){
            $this->libraries_model->_delete("attribute","id",$id);
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    //刪除屬性分組
    public function del_attribute_group($id = 0){
        
        //if(!$session){redirect(base_url('index'));}
        
        if($id){
                        $this->libraries_model->_delete("attribute_group","id",$id);
            $this->admin_model->del_attribute_group($id);
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    //儲存屬性
    public function edit_save_attribute(){
        
        $chk = $this->input->post("is_group",TRUE);
        $id = $this->input->post("attribute_id",TRUE);
        
        
        if($chk){
            
            $data = array(
                'attribute_group_name'  => $this->input->post("attribute_group_name",TRUE)
            );
            
            $this->admin_model->update_attribute('1',$id,$data);
            
        }else{
            
            if($this->input->post("attribute_group_id",true)!=''){
                 $data = array("attribute_group_id"=>$this->input->post("attribute_group_id",TRUE));
            }else{
                $data = array('attribute_name'    => $this->input->post("attribute_name",TRUE));
            }
            
            $this->admin_model->update_attribute('0',$id,$data);
        }
    }
    
    //列出分類
    public function list_category(){
        
        $data['list'] = $this->libraries_model->_select('product_category',0,0,0,0,'category_sequence',1);
        
        $data['parents'] = $data['list'];
        
        $this->load->view('admin/list_category',$data);
    }
    
    //編輯分類
    public function edit_category(){
        
        if($this->input->post()){
            
            $id = $this->input->post("id",true);
            $type = $this->input->post("type",true);
            $text = $this->input->post("new_text",true);

            if($type == 'category_sequence'){
                if(!is_numeric($text)){
                    echo '請輸入數字';
                    return false;
                }
            }elseif($type == 'type'){
                if($text != '1' && $text != '2'){
                    echo '分類層級只能為1或2';
                    return false;
                }
            }

            $data = array(
                $type => $text
            );

            $this->libraries_model->_update("product_category",$data,"category_id",$id);//儲存
            
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    //確認第一層分類底下是否有其它的二分類
    public function chk_category_parent(){
        
        if($this->input->post()){
            
            $cate_id = $this->input->post("cate_id",true);
            $query = $this->admin_model->chk_category_parent($this->input->post("id",true));
            
            if(!$query){
                return false;
            }else{
                
                $array = array();
                
                foreach($query as $key => $result){
                    if($cate_id == $result['category_id']){
                        $array[$key] = '<option selected value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                    }else{
                        $array[$key] = '<option value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                    }
                    
                }
                
                $content = implode($array);
                
                echo '<option value="0">第一級</option>'.$content;
            }
            
        }else{
            redirect(base_url('admin'));
        }
        
    }
    
    //儲存編輯頁面的分類
    public function edit_save_category(){
        if($this->input->post()){
            
            $type = ($this->input->post("value",true)==0)?"1":"2";
            
            $data = array(
                'type'  =>  $type,
                'parent'=>  $this->input->post("value",true)
            );
                        
            $this->libraries_model->_update("product_category",$data,"category_id",$this->input->post("id",true));
        }else{
            redirect(base_url('admin/product'));
        }
    }
    
    //新增分類
    public function add_category(){
        
        $data['parent'] = $this->admin_model->list_category_parent();
        
        $this->load->view('admin/add_category',$data);
    }
    
    
    public function category_save(){
        
        if($this->input->post()){
            
            $category_name = $this->input->post("category_name",true);
            $type = $this->input->post("type",true);
            $parent = $this->input->post("parent",true);
            $sequence = $this->input->post("category_sequence",true);

            if(($type == '2') && ($parent != '')){
                $data = array(
                    'category_sequence' => $sequence,
                    'category_name'     => $category_name,
                    'parent'            => $parent,
                    'type'              => $type
                );
            }else{
                $data = array(
                    'category_name'     => $category_name,
                    'type'              => $type
                );
            }

            $this->libraries_model->_insert('product_category',$data);
            redirect(base_url('admin/product/add_category'));            
        }else{
            redirect(base_url('admin/product'));
        }
    }
    /*
    public function preview(){
        
        $data['product'] = array(
            'product_name'          => $this->input->post('product_name',TRUE),
            'category_id'           => $this->input->post('category',TRUE),
            'category_second_id'    => $this->input->post('category_second',TRUE),
            'introduction'          => $this->input->post('introduction',TRUE),
            'market_price'          => $this->input->post('market_price',TRUE),
            'sale_price'            => $this->input->post('sale_price',TRUE),
            'bargain_price'         => $this->input->post('bargain_price',TRUE),
            'bargain_from'          => $this->input->post('from',TRUE),
            'bargain_to'            => $this->input->post('to',TRUE),
            'cost'                  => $this->input->post('cost',TRUE),
            'update_time'           => date("Y-m-d H:i:s"),
            'unit'                  => $this->input->post('unit',TRUE),
            'on_sale'               => $this->input->post('on_sale',TRUE),
            'recommend'             => $this->input->post('recommend',TRUE)
        );
        
        //儲存屬性
        $attribute_name = $this->input->post("attribute_name",TRUE);
        $attribute_value = $this->input->post("select",TRUE);
            
        if($attribute_name && $attribute_value != ''){
            
            $array = array();
            
            foreach($attribute_name as $key => $name){
                
                $array[$key] = "<dt>".$name."</dt><dd>".$attribute_value[$key]."</dd>";
                
            }
            
            $data['attributes'] = implode("",$array);
        }
        
        //儲存規格
        $specs = $this->input->post("specs",TRUE);

        if(is_array($specs)){
            
            $array = array();
            
            foreach($specs as $key => $spec){
                if(!empty($spec)){
                    $data['spec'][$key] = $spec;
                }
            }
            
        }else{
            $data['spec'] = $specs;
        }
        
        $config['upload_path'] = realpath(APPPATH . '../public/temp/');
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['overwrite'] = false;
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '512';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        //讀取upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $i = 0;//計算第幾張圖片
        $img_array = array();
        foreach($_FILES as $key => $value){

            if( !empty($value['name'])){
                if(!$this->upload->do_upload($key)){

                    $data["error"] = $this->upload->display_errors();
                    echo $data['error'];

                }else{

                    $info = $this->upload->data();
                    $data['main_img'] = (!$i)?$info['file_name']:"";
                    
                    $img_array[$key] = '<li id="'.$key.'" class="slide"><img src="'.base_url('public/temp/'.$info['file_name']).'"></li>';
                    $i++;
                }
            }
        }
        
        $data['img'] = implode("",$img_array);
        $this->load->view('admin/preview',$data);
    }*/
    
    public function quick_save_product(){
        
        $mode = $this->input->post("mode",true);
        
        if(!$mode) redirect(base_url('admin/product'));
        
        $product_id = $this->input->post("product_id",true);
        
        $data = array($mode=>$this->input->post("new_text"));
        
        $this->libraries_model->_update("product",$data,"id",$product_id);
        
    }
    
    /* ajax upload
    public function upload(){
        
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['overwrite'] = false;
        $config['encrypt_name'] = TRUE;
        $config['upload_path'] = realpath(APPPATH . '../public/product_imgs/');
        $config['max_size'] = '512';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload("file_upload")){
            
            print_r($this->upload->display_errors());
            
        }else{
            $info = $this->upload->data();
            echo $info['file_name'];
            
        }
       
       
        
        //下方記錄用
        $targetFolder = "D:\AppServ\www\sc\public\admin\up\uploads"; // Relative to the root

        if (!empty($_FILES)) {
                $tempFile = $_FILES['Filedata']['tmp_name'];
                $targetPath = $targetFolder;
                $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

                // Validate the file type
                $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);

                if (in_array($fileParts['extension'],$fileTypes)) {
                        move_uploaded_file($tempFile,$targetFile);
                        echo '1';
                } else {
                        echo 'Invalid file type.';
                }
        }
    } */
    
    public function _product_upload($product_id,$update_time,$mode = 0){
        
        //建立config
        $config['upload_path'] = realpath(APPPATH . '../public/product_imgs/');
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['overwrite'] = false;
        $config['encrypt_name'] = TRUE;
        //讀取upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if($mode){
            $img_result = $this->libraries_model->_select("product_imgs","product_id",$product_id);
        }else{
            $img_reslut = '';
        }
        
        if(!empty($_FILES['file0']['name'])){

            for($i=0;$i<5;$i++){

                if($this->upload->do_upload("file".$i)){

                    $is_main = (!$i)?'1':'0';//如果為0則是第一張,設置為主圖

                    $info = $this->upload->data();

                    $dir = APPPATH . '../public/product_imgs/';

                    $this->_create_thumbnail($dir,$info['file_name'],180,250);

                    $image_info = array(
                        'product_id'    =>  $product_id,
                        'img_name'      =>  $info['file_name'],
                        'is_main'       =>  $is_main,
                        'upload_time'   =>  $update_time
                    );

                    $this->libraries_model->_insert('product_imgs',$image_info);

                }
            }

        }elseif(empty($img_result)){

            $image_info = array(
                'product_id'    =>  $product_id,
                'img_name'      =>  'noProduct.png',
                'is_main'       =>  1,
                'upload_time'   =>  $update_time
            );

            $this->libraries_model->_insert('product_imgs',$image_info);

        }
    }
    
    function _create_thumbnail($dir,$fileName,$width,$height){
        
        $config['image_library'] = 'gd2';
        $config['source_image'] = $dir . $fileName;	
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;

        $this->load->library('image_lib', $config);
        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();

    }
    
    public function del_img($img_id){
        
        $img = $this->libraries_model->_select("product_imgs","id",$img_id,0,0,0,0,"row");
        
        $where = array(
            'product_id'    =>  $img['product_id'],
            'id !='         =>  $img_id 
        );
        
        $imgs = $this->libraries_model->_select("product_imgs",$where);
        
        if($img['is_main'] == '1' && count($imgs) >= 1){//如果刪除的是主圖，且超過兩張圖片，自動將下一張設定為主圖
            
            $this->libraries_model->_update("product_imgs",array("is_main"=>"1"),"id",$imgs[0]['id']);
            
            echo $imgs[0]['id'];
            
        }elseif($img['is_main'] == '1' && count($imgs) == 0){//如果刪除的是主圖，但只有一張圖片，則設定為noProduct.png
            
            $this->libraries_model->_update("product_imgs",array("img_name"=>"noProduct.png"),"id",$img['id']);
            
        }
        
        if($img['img_name'] != 'noProduct.png'){
             
            unlink('public/product_imgs/'.$img['img_name']);
        }

        $this->libraries_model->_delete("product_imgs","id",$img['id']);
        
    }
    
    public function quick_add(){
        
        $categorys = $this->libraries_model->_select("product_category");
        
        $array = array();
        
        foreach($categorys as $key => $category){
            
            $array[$key] = "<option value=".$category['category_id'].">".$category['category_name']."</option>";
            
        }
        
        $content = implode("",$array);
        
        $data['category'] = '<select class="form_input select" name="category[]"><option value="0">請選擇</option>'.$content.'</select>';
        
        $this->load->view("admin/quick_add",$data);
        
    }
    
    public function quick_add_save(){
        
        $update_time = date("Y-m-d H:i:s"); 
        
        $names =        $this->input->post("names",true);
        $market_price = $this->input->post("market_price",true);
        $sale_price =   $this->input->post("sale_price",true);
        $unit =         $this->input->post("unit",true);
        $category =     $this->input->post("category",true);
        $cost       =   $this->input->post("cost",true);
        
        foreach($names as $key => $name){
            
            if($name !='' && $market_price[$key] !='' && $sale_price[$key] !='' && $category[$key] !='' && $unit[$key] !='' && $cost[$key] !=''){
                
                $result = $this->libraries_model->_select("product_category","category_id",$category[$key],0,0,0,0,"row");
                
                if($result['type'] == 1){
                    $data = array(
                        'product_name'      =>  $name,
                        'category_id'       =>  (int)$category[$key],
                        'category_second_id'=>  0,
                        'market_price'      =>  (int)$market_price[$key],
                        'sale_price'        =>  (int)$sale_price[$key],
                        'cost'              =>  (int)$cost[$key],
                        'unit'              =>  (int)$unit[$key],
                        'float_unit'        =>  (int)$unit[$key],
                        'update_time'       =>  $update_time,
                        'on_sale'           =>  1
                    );
                }elseif($result['type'] == 2){
                    $data = array(
                        'product_name'      =>  $name,
                        'category_id'       =>  $result['parent'],
                        'category_second_id'=>  (int)$category[$key],
                        'market_price'      =>  (int)$market_price[$key],
                        'sale_price'        =>  (int)$sale_price[$key],
                        'cost'              =>  (int)$cost[$key],
                        'unit'              =>  (int)$unit[$key],
                        'float_unit'        =>  (int)$unit[$key],
                        'update_time'       =>  $update_time,
                        'on_sale'           =>  1
                    );
                }
                
                $product_id = $this->libraries_model->_insert("product",$data);
                
                $config['upload_path'] = realpath(APPPATH . '../public/product_imgs/');
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
                $config['overwrite'] = false;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if(!$this->upload->do_upload("file".$key)){
                    
                    $image_info = array(
                        'product_id'    =>  $product_id,
                        'img_name'      =>  'noProduct.png',
                        'is_main'       =>  1,
                        'upload_time'   =>  $update_time
                    );
                    
                }else{
                    
                    $info = $this->upload->data();

                    $dir = APPPATH . '../public/product_imgs/';

                    $this->_create_thumbnail($dir,$info['file_name'],180,250);

                    $image_info = array(
                        'product_id'    =>  $product_id,
                        'img_name'      =>  $info['file_name'],
                        'is_main'       =>  1,
                        'upload_time'   =>  $update_time
                    );
                    
                }

                $this->libraries_model->_insert('product_imgs',$image_info);
            }
        }
        $this->load->library("lvax");
        $this->lvax->_wait(base_url('admin/product/quick_add'),"1","儲存成功!");
    }
    
    public function quick_edit_product_cate(){
        
        if(!$this->input->post()) redirect (base_url('admin/product'));
        
        $product_id = $this->input->post("item_id",true);
        $category_id = $this->input->post("cate_id",true);
        
            
        $results = $this->libraries_model->_select("product_category");

        $array = array();

        foreach($results as $key => $result){
            
            if($result['type'] == 1){
                
                if($category_id == $result['category_id']){
                    $array[$key] = '<option sub="0" selected value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                }else{
                    $array[$key] = '<option sub="0" value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                }
                
            }else{
                
                if($category_id == $result['category_id']){
                    $array[$key] = '<option sub="'.$result['parent'].'" selected value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                }else{
                    $array[$key] = '<option sub="'.$result['parent'].'" value="'.$result['category_id'].'">'.$result['category_name'].'</option>';
                }
                
            }

        }

        $content = implode("",$array);

        echo $content;
            
        
    }
    
    public function quick_save_product_cate(){
        
        if(!$this->input->post()) redirect (base_url('admin/product'));
        
        $product_id = $this->input->post("id",true);
        $category_id = $this->input->post("value",true);
        $parent = $this->input->post("parent",true);
        
        if($parent != 0){
            
            $data = array(
                'category_id'           => $parent,
                'category_second_id'    => $category_id
            );
            
        }elseif($parent == 0){
            
            $data = array(
                'category_id'           =>  $category_id,
                'category_second_id'    =>  0
            );
            
        }
        
        $this->libraries_model->_update("product",$data,"id",$product_id);
    }
 

    public function search($data = null ,$method,$index=0){

        $data = urldecode($data);

        $view['categorys'] = $this->libraries_model->_select("product_category");
        if( $this->uri->segment(4, 0) == false ){

            $view['result'] = $this->admin_model->_search_products( $index * 10 );
            $this->load->view('admin/product_search', $view);

        }else{

            $view['result'] = $this->admin_model->_search_products( $index, $data,$method );
            $this->load->view('admin/product_search', $view);
        }

    }
}
?>
