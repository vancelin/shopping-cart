<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>新增分類</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script>
    </script>
    <script>
    $(function(){
        $("#save").click(function(){
            if($("input[name=category_name]").val()==''){
                alert('請填寫分類名稱');
            }else{
                $('form').submit(); 
            }
        });
        $("#refresh").click(function(){
            $('form')[0].reset(); 
        });
        $("input[name=type]").change(function(){
            if($(this).val()=='2'){
                $("#select_input").show();
            }else{
                $("#select_input").hide();
            }
        });
    });
    </script>
</head>
<body>
    <div id="main-wrap">
        <div class="contain fixed toppest">
            <div id="top" >
                <div id="account-info">
                    <div class="hor-small-separate white-space-clear small-font-box">
                        <div class="item"><?php echo $this->session->userdata('manage_logged_in')['username'];?></div>
                        <div class="item"><a href="<?php echo base_url('admin/index/logout');?>">登出</a></div>
                        <div class="item"><a href="<?php echo base_url();?>">回前台</a></div>
                    </div>
                </div>
                <div>
                    <div id="menu" class="inline-list hor-medium-separate white-space-clear big-font-box bold">
                        <div class="item"><a href="<?php echo base_url('admin/product/product_list');?>">商品</a></div>
                        <div class="item"><a href="<?php echo base_url('admin/member');?>">會員</a></div>
                        <div class="item"><a href="<?php echo base_url('admin/sell');?>">銷售</a></div>
                        
                        <div class="item"><a href="<?php echo base_url('admin/setting');?>">設定</a></div>
                    </div>
                </div>
            </div>
            <div id="tool-bar" class="white-space-clear">
                <div id="tool" class="inline-list text-left hor-small-separate pull-left">
                    <div class="item"><button id="save" class="button-orange small-border-radius">儲存</button></div>
                    <div class="item"><button id="refresh" class="button-orange small-border-radius">清除</button></div>
                </div>
                <div class="pull-right white-space-clear">
                </div>
            </div>
        </div>
        <div class="contain" style="padding-top: 144px;">
            <div id="main">
                <div id="main2">
                    <div id="link">
                        <div class="block-list slide-container white-space-clear medium-font-box">
                            <div class="block">
                                <input id="link-1" type="checkbox" name="link" class="radio" />
                                <label for="link-1" class="label link-title title-font">商品管理</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/product');?>">商品列表</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/product/add');?>">商品新增</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/product/quick_add');?>">快速新增</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-2" type="checkbox" name="link" class="radio" />
                                <label for="link-2" class="label link-title title-font">商品屬性</label>
                                <div class="link-content medium-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/product/list_category');?>">分類列表</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/product/add_category');?>">新增分類</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/product/list_attribute_group');?>">屬性分組列表</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/product/list_attribute');?>">屬性列表</a></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content" class="ver-large-separate">
                        <h3 class="under-line none-margin-box">新增分類</h3>
                        <form action="<?php echo base_url('admin/product/category_save');?>" method="post">
                            <p>分類名稱 : <input type="text" name="category_name" class="input-text"></p>
                            <p>分類排序 : <input type="text" name="category_sequence" class="input-text"></p>
                            <p>分類層級 : <span class="check-label">第一級</span><input type="radio" name="type" value="1" class="input-radio" checked="checked">  <span class="check-label">第二級</span><input type="radio" name="type" value="2" class="input-radio"></p>
                            <p id="select_input" style="display:none">上層選擇 : 
                                <select id="parent" name="parent" class="select">
                                    <?php 
                                    foreach($parent as $select):
                                        echo "<option value='".$select['category_id']."'>".$select['category_name']."</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </p>
                        </form>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
