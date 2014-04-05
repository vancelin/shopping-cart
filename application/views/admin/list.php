<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>商品列表{elapsed_time}</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js');?>"></script>
    <!--for other-->
    <script type="text/javascript" src="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.js');?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.css');?>" />
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".delete").click(function(){
            var button = $(this);
            jConfirm('是否刪除此商品?', '確認框', function(r) {
                if(r){
                    $.get(button.attr('url'));
                    button.parents().parents().filter('tr').remove();
                }
            });
        });
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
        
        $(".click-to-select").dblclick(function(){
            var item = $(this);
            var item_id = $(this).parent().attr("id");
            var cate_id = $(this).attr("cate_id");
            var old_text = $(this).text();
            
            $.post("<?php echo base_url('admin/product/quick_edit_product_cate');?>",{item_id:item_id,cate_id:cate_id},function(r){
                var input = $("<select id='category_id' class='droplist-input'></select>");
                $(item).html(input);
                $(r).appendTo("#category_id");
                $(input).focus();
                $(input).blur(function(){
                    if(cate_id == $(input).val()){
                        $(item).html(old_text);
                    }else{
                        $.post("<?php echo base_url('admin/product/quick_save_product_cate')?>",{id:item_id,value:$(input).val(),parent:$(input).find("option:selected").attr("sub")});
                        $(item).html($(input).find("option:selected").text());
                        $(item).attr("cate_id",$(input).find("option:selected").val());
                    }
                });
            });
        });
        
        $(".click-to-edit").dblclick(function(){
            
            var item = $(this);
            var item_id = $(this).parent().attr("id");
            var mode = $(this).attr("mode");
            
            if(mode == 'on_sale' || mode == 'recommend'){
                var status = $(this).attr("status");
                var new_text = ($(this).attr("status") == '1') ? "0":"1";
                var input = (status == '1') ? "<img src='<?php echo base_url('public/admin/img/tick.png');?>'/>" : "<img src='<?php echo base_url('public/admin/img/no.png');?>'/>";
                $(this).attr("status",new_text).html(input);
                $.post("<?php echo base_url('admin/product/quick_save_product');?>",{product_id:item_id,mode:mode,new_text:status});
            }else if(mode == 'product_name'){
                var old_text = $(this).text();
                var input = $("<textarea id='' rows='3' cols='80'>" + $.trim(old_text) + "</textarea>");
                $(item).children().show().html(input);
            }else{
                var old_text = $(this).text();
                var input = $("<input type='text' class='input-text' value='" +old_text+ "'>");
                $(this).html(input);
            }
            
            if(mode != 'on_sale' && mode != 'recommend'){
                
                $(input).select();
                $(input).blur(function(){
                    var new_text = (mode == 'product_name') ? $(input).val() : $(this).val();
                    if($.trim(new_text) != ''){
                        if(mode == 'product_name'){
                            $(item).html(new_text+'<div class="item-popup-container" style="width: auto;hieght:auto; display:none;"></div>');
                        }else{
                            $(item).html(new_text);
                        }
                        $.post("<?php echo base_url('admin/product/quick_save_product');?>",{product_id:item_id,mode:mode,new_text:new_text});
                    }else{
                        $(item).html(old_text);
                        alert("請勿為空");
                    }
                });
            }
        });
    });
    
    var base = "<?php echo base_url('admin/product/search'); ?>/"

    function search(e){
        var text = $('input#index').val(), method = $('select#search').val();

        if (method.slice(-1) == '_'){
            $('select#range').show('slow');
            method += $('select#range').val();
            if ( isNaN(text) ) return false;
        }else{
            $('select#range').hide('slow');
        }

        if( e.keyCode == 13 || text == 0 ) return false;
        $('#content').stop().fadeOut('fast').empty()
               .load( base + text + '/' + method ).fadeIn('slow');
    }
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
                    <div class="focus-strech-container">
                        <input id="index" type="text" placeholder="Search" class="ico-text search-text medium focus-stretch" onkeyup="javascript:search(event);">
                        <select id="search" class="search-select" onchange="javascript:search(event);">
                            <option value="product_name">商品名稱</option>

                            <option value="unit_">庫存量</option>

                            <option value="market_">價格</option>
                            <option value="sale_">售價</option>
                            <option value="bargain_">特價</option>

                        </select>
                        <select id="range" class="search-select" onchange="javascript:search(event);" style="display:none;">
                            <option value="low">以下</option>
                            <option value="high">以上</option>
                        </select>
                    </div>

                    <button class="ico-16-container" onclick="javascript:search(event);">
                        <span class="ico-16-box ico-16-search-w"> </span>
                    </button>
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
                        <h3 class="under-line none-margin-box">商品列表</h3>
                        <div class="page-container"><?php echo $links;?></div>
                        <table class="table-hover-style block-table img-limit-table text-center">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">縮圖</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯商品名稱">名稱</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯商品類別">分類</th>
                                    <th scope="col" class="tip" tip="點選下方可編輯商品價格">價格</th>
                                    <th scope="col">實際庫存</th>
                                    <th scope="col">浮動庫存</th>
                                    <th scope="col" class="tip" tip="點選下方可快速上下架商品">上架</th>
                                    <th scope="col" class="tip" tip="點選下方可快速更改推薦狀態">推薦</th>
                                    <th scope="col">特價</th>
                                    <th scope="col">上架日期</th>
                                    <th scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $product):?>
                                    <tr id="<?php echo $product['id'];?>">
                                        <td>
                                            <img src="<?php echo base_url('public/product_imgs/'.$product['img_name']);?>">
                                        </td>
                                        <td class="click-to-edit" mode="product_name">
                                            <?php echo $product['product_name'];?>
                                            <div class="item-popup-container" style="width: auto;hieght:auto; display:none;"></div>
                                        </td>
                                        <?php if($product['category_second_id'] == 0):?>
                                            <td class="click-to-select" cate_id="<?php echo $product['category_id'];?>"><?php echo $product['category_name'];?></td>
                                        <?php else:?>
                                            <?php foreach($categorys as $category):?>
                                                <?php if($product['category_second_id'] == $category['category_id']):?>
                                                    <td class="click-to-select" cate_id="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></td>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        <td class="click-to-edit" mode="market_price"><?php echo $product['market_price'];?></td>
                                        <td><?php echo $product['unit'];?></td>
                                        <td><?php echo $product['float_unit'];?></td>
                                        <?php echo ($product['on_sale'])?"<td mode='on_sale' status='0' class='click-to-edit'><img src='".base_url('public/admin/img/tick.png')."'/></td>":"<td mode='on_sale' status='1' class='click-to-edit'><img src='".base_url('public/admin/img/no.png')."'/></td>";?>
                                        <?php echo ($product['recommend'])?"<td mode='recommend' status='0' class='click-to-edit'><img src='".base_url('public/admin/img/tick.png')."'/></td>":"<td mode='recommend' status='1' class='click-to-edit'><img src='".base_url('public/admin/img/no.png')."'/></td>";?>
                                        <?php echo ($product['bargain_price'])?"<td><img src='".base_url('public/admin/img/tick.png')."'/></td>":"<td><img src='".base_url('public/admin/img/no.png')."'/></td>";?>

                                        <td><?php echo $product['update_time'];?></td>

                                        <td>
                                        <a href="<?php echo base_url('admin/product/edit/' . $product['id']); ?>"><img src="<?php echo base_url('public/admin/img/edit.png'); ?>" /></a> | 
                                        <a class="delete" href="#" url="<?php echo base_url('admin/product/delete/' . $product['id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
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
</html>
