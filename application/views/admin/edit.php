<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>商品編輯</title>
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
    <!--for other-->
    <script type="text/javascript" src="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.js');?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.css');?>" />
    <script type="text/javascript">
    $(document).ready(function() {
        $( "#tabs" ).tabs();
        
        $("#category").change(function(){
            $.post("<?php echo base_url('admin/product/category_second_list');?>",{category_id:$("#category").val()},function(r){
                $("#second_category").html(r);
            });
        });
        
        $("#bargain_price").change(function(){
            if($("#bargain_price").val()==0 ||$("#bargain_price").val()=='') {
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
            if(count<(5-<?php echo $image_count;?>)){
                $("#tabs-3").append('<p>\n\
                                        <img class="x" src="<?php echo base_url('public/admin/img/x.png'); ?>"/>\n\
                                        <input type="file" name="file' + count + '" />\n\
                                    </p>');
            }else{
                alert('最多上傳5張');
            }
        });
        
        $(".del_img").click(function(){
            var button = $(this);
            jConfirm('是否刪除此圖片?', '確認框', function(chk) {
                if(chk){
                    $.get(button.attr('url'),function(r){
                        if(r!=''){
                            $("input[name='img_id']").val(r).attr("checked",true); 
                        }
                    });
                    button.parents().parents().filter('tr').remove();
                }
            });
        });

        $(".x").live("click",function(){
            $(this).parent().remove();
        });
        
        $("#attribute").change(function(){
            $.post("<?php echo base_url('admin/product/attribute_set');?>",{group_id:$(this).val()},function(r){
                $("#select").html(r);
            });
            $("input[name='group_id']").attr("value",$(this).val());
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
            
        });
        
        $(".del_spec").live("click",function(){
            var button = $(this);
            jConfirm('是否刪除此規格?', '確認框', function(r) {
                if(r){
                    $.post("<?php echo base_url('admin/product/del_spec');?>",{spec_id:$(button).attr("spec_id")},function(rr){
                        $(button).parents().filter("p").remove();
                    });
                }
            });
        });
        
        $("#more_spec").click(function(){
            $("#tabs-5").append('<p>\n\
                                    <img class="x" src="<?php echo base_url('public/admin/img/x.png'); ?>"/>\n\
                                    <input type="text" name="specs[]" value="" class="input-text">\n\
                                </p>');
        });
        
        $(".spec_value").live("change",function(){
            $.post("<?php echo base_url('admin/product/upd_spec');?>",{spec_id:$(this).attr("id"),spec_val:$.trim($(this).val())});
        });
        
    });
    </script>
</head>
<body>
    <table class="popup block-table float-box toppest stretch-height hidden"> <!-- remove hidden -->
        <colgroup>
            <col span="1" />
        </colgroup>
        <tbody>
            <tr>
                <td>
                    <div class="popup-box">test</div>
                </td>
            </tr>
        </tbody>
    </table>
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
                    <div class="item"><button id="save" class="button-orange small-border-radius">編輯商品</button></div>
                    <div class="item"><button id="continue" class="button-orange small-border-radius">編輯後繼續編輯</button></div>
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
                        <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin/product/edit_save/'.$products['id']);?>">
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
                                    <p>商品名稱 :  <input type="text" name="product_name" value="<?php echo $products['product_name'];?>" class="input-text"></p>
                                    <p>分類 : 
                                        <select id="category" name="category" class="select">
                                            <option>請選擇</option>
                                        <?php foreach ($categorys as $category):?>
                                            <?php if($category['category_id'] == $products['category_id']): ?>
                                                <option selected value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                                            <?php endif; ?>
                                        <?php endforeach;?>
                                        </select>
                                    </p>
                                    <?php if($products['category_second_id']):?>
                                    <p id="second_category">細項 : 
                                        <select id="category_second" name="category_second" class="select">
                                            <?php 
                                                foreach($categorys_second as $category_second):
                                                    if($category_second['category_id'] == $products['category_second_id']):
                                                        ?><option selected value="<?php echo $category_second['category_id'];?>"><?php echo $category_second['category_name'];?></option><?php
                                                    else:
                                                        ?><option value="<?php echo $category_second['category_id'];?>"><?php echo $category_second['category_name'];?></option><?php
                                                    endif;
                                                endforeach;
                                            ?>
                                        </select>
                                    </p>
                                    <?php else:?>
                                    <p id="second_category"></p>
                                    <?php endif;?>
                                    <p>成本 : <input type="text" name="cost" value="<?php echo $products['cost'];?>" class="input-text"></p>
                                    <p>實際庫存 : <input type="text" name="unit" value="<?php echo $products['unit'];?>" class="input-text"> PS:要修改前請先確認此商品沒有尚未出貨之訂單，並一併修改浮動庫存</p>
                                    <p>浮動庫存 : <input type="text" name="float_unit" value="<?php echo $products['float_unit'];?>" class="input-text"> PS:請與實際庫存保存一致，若要修改請先確認此商品沒有尚未出貨之訂單，以防庫存錯誤</p> 
                                    <p>原價 : <input type="text" name="market_price" value="<?php echo $products['market_price'];?>" class="input-text"></p>
                                    <p>售價 : <input type="text" name="sale_price" value="<?php echo $products['sale_price'];?>" class="input-text"></p>
                                    <p>特價 : <input type="text" id="bargain_price" name="bargain_price" value="<?php echo $products['bargain_price'];?>" class="input-text"></p>
                                    
                                    <?php if($products['bargain_price']): ?>
                                    <p>特價日期 : <input type="text" name="from" id="from" value="<?php echo $products['bargain_from'];?>" class="input-text"> 到 <input type="text" name="to" id="to" value="<?php echo $products['bargain_to'];?>" class="input-text"></p>
                                    <?php else: ?>
                                    <p>特價日期 : <input type="text" name="from" id="from" disabled="disabled" value="" class="input-text"> 到 <input type="text" name="to" id="to" disabled="disabled" value="" class="input-text"> 請填寫特價欄位</p>
                                    <?php endif; ?>

                                    <?php if($products['on_sale']):?>
                                    <p>上架 : <span class="check-label">是</span><input type="radio" name="on_sale" value="1" class="input-radio" checked="checked">  <span class="check-label">否</span><input type="radio" name="on_sale" value="0" class="input-radio"></p>
                                    <?php else: ?>
                                    <p>上架 : <span class="check-label">是</span><input type="radio" name="on_sale" value="1" class="input-radio">  <span class="check-label">否</span><input type="radio" name="on_sale" value="0" class="input-radio" checked="checked"></p>
                                    <?php endif; ?>

                                    <?php if($products['recommend']):?>
                                    <p>推薦 : <span class="check-label">是</span><input type="radio" name="recommend" value="1" class="input-radio" checked="checked">  <span class="check-label">否</span><input type="radio" name="recommend" value="0" class="input-radio"></p>
                                    <?php else: ?>
                                    <p>推薦 : <span class="check-label">是</span><input type="radio" name="recommend" value="1" class="input-radio">  <span class="check-label">否</span><input type="radio" name="recommend" value="0" class="input-radio" checked="checked"></p>
                                    <?php endif; ?>
                                    <p><input type="hidden" name="continue" value="0"></p>
                                </div>
                                <div id="tabs-2">
                                    <textarea name="introduction"><?php echo $products['introduction'];?></textarea>
                                </div>
                                <div id="tabs-3">
                                    <table border="1">
                                        <tr>
                                            <th align="left">圖片</th>
                                            <th align="left">設置為主圖</th>
                                            <th align="left">操作</th>
                                        </tr>
                                        <?php foreach($images as $image):?>
                                        <tr>
                                            <td width="500" align="left"><img src="<?php echo base_url('public/product_imgs/'.$image['img_name']);?>" width="100" height="150"/></td>
                                            <?php if($image['is_main']):?>
                                            <td align="left"><input type="radio" checked="checked" name="img_id" value="<?php echo $image['id'];?>"></td>
                                            <?php else:?>
                                            <td align="left"><input type="radio" name="img_id" value="<?php echo $image['id'];?>"></td>
                                            <?php endif;?>
                                            <td align="left"><a href="#" class="del_img" url="<?php echo base_url('admin/product/del_img/' . $image['id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </table>
                                    <p>
                                        <img id="more" src="<?php echo base_url('public/admin/img/more.png'); ?>"/>
                                        <input type="file" name="file0" />
                                    </p>
                                </div>
                                <div id="tabs-4">
                                    <p>
                                        <select id="attribute" name="attribute" class="select">
                                            <option value="0">請選擇</option>
                                            <?php foreach($attribute_group as $row):?>
                                                <?php if($row['id'] == $attribute[0]['attribute_group_id'])://判斷選擇的group_id?>
                                                <option selected="selected" value="<?php echo $row['id']?>"><?php echo $row['attribute_group_name']?></option>
                                                <?php else:?>
                                                <option value="<?php echo $row['id']?>"><?php echo $row['attribute_group_name']?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </p>
                                    <?php if($attribute):?>
                                    <p><input type="hidden" name="group_id" value="<?php echo $attribute[0]['attribute_group_id'];?>"></p>
                                    <?php else:?>
                                    <p><input type="hidden" name="group_id" value=""></p>
                                    <?php endif;?>
                                    <div id="select">
                                    <?php foreach($attribute as $row):?>
                                        <p><?php echo $row['attribute_name'];?> : <input type="hidden" value="<?php echo $row['id'];?>" name="attribute_id[]"><input type='text' value='<?php echo $row['attribute_value'];?>' name='select[]' class='input-text'></p>
                                    <?php endforeach;?>
                                    </div>
                                </div>
                                <div id="tabs-5">
                                    <?php foreach($product_specs as $spec):?>
                                        <p>
                                            <img class="del_spec" spec_id="<?php echo $spec['spec_id'];?>" src="<?php echo base_url('public/admin/img/x.png'); ?>"/>
                                            <input type="text" class="spec_value input-text" id="<?php echo $spec['spec_id'];?>" value="<?php echo $spec['spec_value'];?>">
                                        </p>
                                    <?php endforeach;?>
                                    <p>
                                        <img id="more_spec" src="<?php echo base_url('public/admin/img/more.png'); ?>"/>
                                        <input type="text" name="specs[]" value="" class="input-text">
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
</html>
