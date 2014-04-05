<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>快速新增{elapsed_time}</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script type="text/javascript">
    $(function(){
        
        status = 0;
        $("#add").click(function(){
            var file_count = $(".input-file").length;
            $("tbody").append('<tr>\n\
                                <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>\n\
                                <td>\n\
                                    <div class="input-file-container">\n\
                                        <input type="file" name="file' + file_count + '" class="input-file form_input"/> \n\
                                        <button class="input-file-button" title="Browers ..."><span >上傳檔案</span></button>\n\
                                    </div>\n\
                                </td>\n\
                                <td><?php echo $category;?></td>\n\
                                <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>\n\
                                <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input"></td>\n\
                                <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input"></td>\n\
                                <td><input type="text" value="" name="unit[]" class="input-justify-text form_input"></td>\n\
                            </tr>');
        });
        
        $("#save").click(function(){
            $(".form_input").each(function(){
                if($(this).val() == '' || $(this).val() == 0){
                    $("#info").fadeIn("slow").find("#text").text("請填滿所有欄位 !");
                    status = 0;
                    return false;
                }else{
                    status = 1;
                }
            });
            
            if(status == 1){
                $("form").submit();
            }
        });
        
        $(".number").change(function(){  //keyup事件處理
            $(this).val($(this).val().replace(/\D|^0/g,''));  
        }).bind("paste",function(){  //CTR+V事件處理
            $(this).val($(this).val().replace(/\D|^0/g,''));  
        }).css("ime-mode", "disabled");  //CSS設定輸入法不可用
        
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
                    <div class="item"><button id="add" class="button-orange small-border-radius">增加一個欄位</button></div>
                    <div class="item"><button id="save" class="button-orange small-border-radius">儲存</button></div>
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
                    <div id="content" class="ver-medium-separate">
                        <h3 class="under-line none-margin-box">快速新增</h3>
                        <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                        <form enctype="multipart/form-data" action="<?php echo base_url('admin/product/quick_add_save');?>" method="post">
                            <table class="table-hover-style block-table img-limit-table text-center">
                                <colgroup>
                                    <col span="1" />
                                    <col span="1" />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">商品名稱</th>
                                        <th scope="col">縮圖</th>
                                        <th scope="col">大類</th>
                                        <th scope="col">成本</th>
                                        <th scope="col">原價</th>
                                        <th scope="col">售價</th>
                                        <th scope="col">數量</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>
                                        <td>
                                            <div class="input-file-container">
                                                <a class="input-file-button" title="Browers ..."><span>上傳檔案</span></a>
                                                <input type="file" name="file1" id="" class="input-file" size="1" />
                                            </div>
                                        </td>
                                        <td><?php echo $category;?></td>
                                        <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="unit[]" class="input-justify-text form_input number"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>
                                        <td>
                                            <div class="input-file-container">
                                                <a class="input-file-button" title="Browers ..."><span>上傳檔案</span></a>
                                                <input type="file" name="file1" id="" class="input-file" size="1" />
                                            </div>
                                        </td>
                                        <td><?php echo $category;?></td>
                                        <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="unit[]" class="input-justify-text form_input number"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>
                                        <td>
                                            <div class="input-file-container">
                                                <a class="input-file-button" title="Browers ..."><span>上傳檔案</span></a>
                                                <input type="file" name="file1" id="" class="input-file" size="1" />
                                            </div>
                                        </td>
                                        <td><?php echo $category;?></td>
                                        <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="unit[]" class="input-justify-text form_input number"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>
                                        <td>
                                            <div class="input-file-container">
                                                <a class="input-file-button" title="Browers ..."><span>上傳檔案</span></a>
                                                <input type="file" name="file1" id="" class="input-file" size="1" />
                                            </div>
                                        </td>
                                        <td><?php echo $category;?></td>
                                        <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="unit[]" class="input-justify-text form_input number"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" name="names[]" class="input-justify-text form_input"></td>
                                        <td>
                                            <div class="input-file-container">
                                                <a class="input-file-button" title="Browers ..."><span>上傳檔案</span></a>
                                                <input type="file" name="file1" id="" class="input-file" size="1" />
                                            </div>
                                        </td>
                                        <td><?php echo $category;?></td>
                                        <td><input type="text" value="" name="cost[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="market_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="sale_price[]" class="input-justify-text form_input number"></td>
                                        <td><input type="text" value="" name="unit[]" class="input-justify-text form_input number"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
</html>
