<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>商品新增</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js');?>"></script>
    <!--for editor-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/editor/jquery.cleditor.css');?>" />
    <script type="text/javascript" src="<?php echo base_url('public/admin/editor/jquery.cleditor.min.js');?>"></script>
    <!--for upfile
    <script src="<?php echo base_url('public/admin/up/jquery.uploadify.min.js');?>" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/up/uploadify.css');?>">-->
    <script type="text/javascript">
    $(document).ready(function() {
        $( "#tabs" ).tabs();
        
        $("#category").change(function(){
            $.post("<?php echo base_url('admin/product/category_second_list');?>",{category_id:$("#category").val()},function(r){
                $("#second_category").html(r);
            });
        });
        
        $("#bargain_price").change(function(){
            if($("#bargain_price").val()==0 || $("#bargain_price").val()=='') {
                $("#from,#to").attr("value","");
                $("#from,#to").attr("disabled", true);
                
            } else {
                $("#from,#to").attr("disabled", false);
            } 
        });
        
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            onSelect: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
                $( "#from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            }
        });
        
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            onSelect: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
                $( "#to" ).datepicker( "option", "dateFormat", "yy-mm-dd");
            }
        });
        
        $("textarea").cleditor({width:800, height:200, useCSS:true})[0].focus();

        $("#more").click(function(){
            var count = $(".x").length + 1;
            if(count<5){
                $("#tabs-3").append('<p>\n\
                                        <img class="x" src="<?php echo base_url('public/admin/img/x.png'); ?>"/>\n\
                                        <input type="file" name="file' + count + '" />\n\
                                    </p>');
            }else{
                alert('最多上傳5張');
            }
            
        });

        $(".x").live("click",function(){
            $(this).parent().remove();
        });
        
        $("#attribute").change(function(){
           $.post("attribute_set",{group_id:$(this).val()},function(r){
               $("#select").html(r);
           });
           $("input[name='group_id']").attr("value",$(this).val());
        });
        
        $("#more_spec").click(function(){
            $("#tabs-5").append('<p>\n\
                                    <img class="x" src="<?php echo base_url('public/admin/img/x.png'); ?>"/>\n\
                                    <input type="text" name="specs[]" value="" class="input-text">\n\
                                </p>');
        });
        
        $("#save").click(function(){
            $('form').submit(); 
        });
        
        $("#continue").click(function(){
            $("input[name='continue']").attr("value","1");
            $('form').submit(); 
        });
        
        $("#refresh").click(function(){
            $('form')[0].reset(); 
        });
        
        $("#preview").click(function(){
            /*if($("input[name=product_name]").val()=='' || $("#attribute").val()=='0' || $("input[name=sale_price]").val()==''){
                alert('請填滿商品資訊');
                return false;
            }*/
            $.ajax("preview",{
                data:$("form").serialize(),
                type:"post",
                success: function() {
                    $("#preview_view").removeClass("hidden");
                    $("#preview_view").load("preview");
                }
            });
        });
        /*
        $('#file_upload').uploadify({
            'removeTimeout' : 86400,
            'uploadLimit' : 5,
            'swf'   : '<?php echo base_url('public/admin/up/uploadify.swf');?>',
            'uploader'  : '<?php echo base_url('admin/product/upload');?>',
            'buttonText' : "上傳圖片",
            'formData'  : {'sessdata' : '<?php //echo $this->my_session->get_encrypted_sessdata();?>'},
            'fileObjName' : 'file_upload',
            'onUploadSuccess' : function(file, data, response) {
                if(/\w+\.(jpg|jpeg|bmp|gif)/.test(data)){
                    var count = $(".is_main").length;
                    $("#tabs-3").append("<input type='hidden' class='is_main' name='is_main[]' value='" + data + "---" + (count+1) + "'>");
                }else{
                    alert('錯誤!\n' + data);
                }
            }
        });*/
    });
    </script>
</head>
<body>
    <div id="preview_view" class="popup block-table float-box toppest stretch-height hidden"> <!-- remove hidden -->
    </div>
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
                    <div class="item"><button id="continue" class="button-orange small-border-radius">增加後繼續編輯</button></div>
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
                    <div id="content">
                        <?php 
                        if(isset($response)):
                        echo '<h2>' . $response . '</h2>'; 
                        endif;
                        ?>
                        <form enctype="multipart/form-data" method="post" action="save">
                            <h3>商品新增</h3>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-1">基本資訊</a></li>
                                    <li><a href="#tabs-2">詳細描述</a></li>
                                    <li><a href="#tabs-3">圖片</a></li>
                                    <li><a href="#tabs-4">商品屬性</a></li>
                                    <li><a href="#tabs-5">商品規格</a></li>
                                </ul>
                                <div id="tabs-1">
                                    <p>商品名稱 :  <input type="text" name="product_name" value="" class="input-text"></p>
                                    <p>分類 : 
                                        <select id="category" name="category" class="select">
                                            <option>請選擇</option>
                                        <?php foreach($categorys as $category):?>
                                            <option value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </p>
                                    <p id="second_category"></p>
                                    <p>成本 : <input type="text" name="cost" value="" class="input-text"></p>
                                    <p>庫存 : <input type="text" name="unit" value="" class="input-text"></p>
                                    <p>原價 : <input type="text" name="market_price" value="" class="input-text"></p>
                                    <p>售價 : <input type="text" name="sale_price" value="" class="input-text"></p>
                                    <p>特價 : <input type="text" id="bargain_price" name="bargain_price" value="" class="input-text"></p>
                                    <p>特價日期 : <input type="text" name="from" id="from" disabled="disabled" value="" class="input-text"> 到 <input type="text" name="to" id="to" disabled="disabled" value="" class="input-text"> 請填寫特價欄位</p>
                                    <p>上架 : <span class="check-label">是</span><input type="radio" name="on_sale" value="1" class="input-radio" checked="checked">  <span class="check-label">否</span><input type="radio" name="on_sale" value="0" class="input-radio"></p>
                                    <p>推薦 : <span class="check-label">是</span><input type="radio" name="recommend" value="1" class="input-radio">  <span class="check-label">否</span><input type="radio" name="recommend" value="0" class="input-radio" checked="checked"></p>
                                    <p><input type="hidden" name="continue" value="0" ></p>
                                </div>
                                <div id="tabs-2">
                                    <textarea name="introduction"></textarea>
                                </div>
                                <div id="tabs-3">
                                    <!--
                                    <div id="queue"></div>
                                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                                    <br>
                                    <p>預設選擇的第一張圖片為主圖，可一次選取五張圖片</p>
                                    -->
                                    <p>
                                        <img id="more" src="<?php echo base_url('public/admin/img/more.png'); ?>"/>
                                        <input type="file" name="file0" /> ※預設為主圖
                                    </p>
                                </div>
                                <div id="tabs-4">
                                    <p>
                                        <select id="attribute" name="attribute" class="select">
                                            <option value="0">請選擇</option>
                                            <?php foreach($attribute_group as $row):?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['attribute_group_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </p>
                                    <p><input type="hidden" name="group_id" value=""></p>
                                    <div id="select"></div>
                                </div>
                                <div id="tabs-5">
                                    <p>
                                        <img id="more_spec" src="<?php echo base_url('public/admin/img/more.png'); ?>"/>
                                        <input type="text" name="specs[]" value="" class="input-text"> EX.顏色、尺寸等
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
