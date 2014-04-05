<?php

class Load_views extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->model('main_model');
        $this->load->model('load_config');

    }

/*
*   $default_views
*   預設模板設定 供寫在這頁載入的model使用
*   建議盡量預設傳值以下為主
*/

/* models */

    //預設前台模板載入
    public function _view($page = null, $view = null, $default_views = null){

            //預設模板設定 ,$default_views 可自行傳值 格式參照36行
            if ( !$default_views ) {

                //GET title
                $config['title'] = $this->load_config->_title();

                //獲取category的資料
                $view_cat = $this->load_config->_category();

                //獲取static為news的資料
                $view_static = $this->load_config->_static();

                //預設必載入的模板 ,依照先後順序 包含個別設定
                $default_views = array(
                        'main' => $config ,
                        'menu' => $view_cat ,
                        'left' => $view_static ,
                        'right' => null ,
                    );

            }

            //判斷模板有無呼叫成功
            if ( $this->_load_view( $default_views ) != 0 ){
                echo 'error ,please contact administrator';
            }

            if( $page ){
                //想呈現的mid wrapper內容
                $this->load->view($page, $view);
            }

            //footer
            $this->load->view( 'main/footer' );
    }

    //預設後台模板載入
    public function _manage_view($page = null, $view = null, $default_views = null){

            if ( !$default_views ) {

                //GET title
                $config['title'] = $this->load_config->_title();

                //預設必載入的模板 ,依照先後順序 包含個別設定
                $default_views = array(
                        'head' => $config ,
                        'info' => null ,
                        'menu' => null ,
                        'side' => null ,
                    );

            }

            //判斷模板有無呼叫成功
            if ( $this->_load_view( $default_views, 'manage/default/' ) != 0 ){
                echo 'error ,please contact administrator';
            }

            if( $page ){
                //想呈現的mid wrapper內容
                $this->load->view($page, $view);
            }

            //footer
            $this->load->view( 'manage/default/footer' );
    }

/* private function */

    //私有函數, 迴圈進行main模板載入
    private function _load_view($temps, $dir = 'main/'){
        foreach (array_keys($temps) as $view){

            //data 作為中繼存放 views 的個別設定
            $data = $temps[$view];

            $view = $dir . $view;
            $this->load->view($view, $data);
        }
        return 0;
    }
}

?>
