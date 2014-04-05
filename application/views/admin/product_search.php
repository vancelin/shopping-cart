<script>
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
</script>
<h3 class="under-line none-margin-box">商品列表</h3>
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
        <?php foreach($result as $product):?>
            <tr id="<?php echo $product['id'];?>">
                <td>
                    <img src="<?php echo base_url('public/product_imgs/'.$product['img_name']);?>">
                </td>
                <td class="click-to-edit" mode="product_name">
                    <?php echo $product['product_name'];?>
                    <div class="item-popup-container" style="width: auto;hieght:auto; display:none;"></div>
                </td>
                <?php if($product['category_second_id'] == 0):?>
                    <td class="click-to-select" parent="0" cate_id="<?php echo $product['category_id'];?>"><?php echo $product['category_name'];?></td>
                <?php else:?>
                    <?php foreach($categorys as $category):?>
                        <?php if($product['category_second_id'] == $category['category_id']):?>
                            <td class="click-to-select" parent="<?php echo $category['parent'];?>" cate_id="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></td>
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
