<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>分類列表</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script>
    $(function(){
        $('.tip').each(function(){
            $(this).qtip({
                content:$(this).attr("tip"), 
                position: {
                    corner: {
                        target: 'topMiddle',
                        tooltip: 'bottomLeft'
                    }
                },
                style: { 
                    name: 'blue'
                }
            });
        });
        $(".click-to-edit").dblclick(function(){
            var item = $(this);
            var item_id = $(this).parent().children(":first").text();
            var type = $(this).attr("id");
            var old_text = $(this).text();
            var input = $("<input type='text' class='input-text' value='" + old_text + "'>");
            $(this).html(input);
            $(input).select();
            $(input).blur(function(){
                var new_text = $(this).val();
                if($.trim(new_text) != ''){
                    $(item).html(new_text);
                    $.post("<?php echo base_url('admin/product/edit_category');?>",{id:item_id,type:type,new_text:new_text},function(r){
                        if(r != ''){
                            $(item).html(old_text);
                            alert(r);
                        }
                    });
                }
           });
        });
        
        $(".click-to-select").dblclick(function(){
            var item = $(this);
            var item_id = $(this).parent().children(":first").text();
            var cate_id = $(this).attr("cate_id");
            var old_text = $(this).text();
            $.post("<?php echo base_url('admin/product/chk_category_parent');?>",{id:item_id,cate_id:cate_id},function(r){
                if(!r){
                    alert('此分類底下還有其他分類,請移除下層分類後編輯');
                }else{
                    var input = $("<select id='cate_select' class='droplist-input'></select>");
                    $(item).html(input);
                    $(r).appendTo("#cate_select");
                    $(input).focus();
                    $(input).blur(function(){
                        if(cate_id == $(input).val()){
                            $(item).html(old_text);
                        }else{
                            $.post("<?php echo base_url('admin/product/edit_save_category')?>",{id:item_id,value:$(input).val()});
                            $(item).html($(input).find("option:selected").text());
                            $(item).attr("cate_id",$(input).val());
                            if($(input).val()=='0'){
                                $(item).prev().text("1");
                            }else{
                                $(item).prev().text("2");
                            }
                        }
                    });
                }
            });
            
            
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
                        <h3 class="under-line none-margin-box">分類列表</h3>
                        <table class="table-hover-style block-table img-limit-table">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            <thead>
                                <tr>
                                    <th scope="col">編號</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯排列順序">排序</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯名稱">分類名稱</th>
                                    <th scope="col">分類層級</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯上級分類">上級分類</th>
                                    <th scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach($list as $key => $category):?>
                                    <tr>
                                        <th><?php echo $category['category_id'];?></th>
                                        <td class="click-to-edit" id="category_sequence" tabindex="0"><?php echo $category['category_sequence'];?></td>
                                        <td class="click-to-edit" id="category_name" tabindex="0"><?php echo $category['category_name'];?></td>
                                        <td id="type"><?php echo $category['type'];?></td>
                                        <?php if($category['parent'] != '0'):?>
                                            <?php 
                                            foreach($parents as $parent):
                                                if($category['parent'] == $parent['category_id']){
                                                    echo '<td class="click-to-select" tabindex="0" cate_id="'.$parent['category_id'].'">'.$parent['category_name'].'</td>';
                                                }
                                            endforeach;
                                            ?>
                                        <?php else:?>
                                        <td class="click-to-select">第一級</td>
                                        <?php endif;?>
                                        <td>
                                            <a class="del_category" href="#"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
