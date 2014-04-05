<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>屬性分組列表</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <!--for othher-->
    <script type="text/javascript" src="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.js');?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/jscripts/jquery.alerts-1.1/jquery.alerts.css');?>" />
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".del_attribute_group").live("click",function(){
            var button = $(this);
            jConfirm('是否刪除此屬性群組?', '確認框', function(r) {
                if(r){
                    $.get(button.attr('url'));
                    button.parents().parents().filter('tr').remove();
                }
            });
        });
        $("#add_new").click(function(){
            $("#new_area").show("slow");
        });
        $("#add").click(function(){
            var name = $("#attribute_group_name").val();
            if(name==''){
                $("#info").fadeIn("slow").find("#text").text("請填寫屬性分組名稱 !");
            }else{
                $.post("<?php echo base_url('admin/product/attribute_group_save');?>",{attribute_group_name:name},function(r){
                    $("#new_area").hide("slow");
                    $("#info").hide();
                    $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                    $("#info").find("#text").text("新增成功！");
                    $("#info").fadeOut();
                    $("tbody").prepend('<tr><th>' + r + '</th><td>' + name + '</td><td><a class="del_attribute_group" href="#" url="<?php echo base_url('admin/product/del_attribute_group/'); ?>'+ r +'"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a></td></tr>');
               });
            }
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
                    $.post("<?php echo base_url('admin/product/edit_save_attribute');?>",{attribute_id:item_id,is_group:'1',attribute_group_name:new_text});
                }else{
                    $(item).html(old_text);
                    alert("請勿為空");
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
                        <h3 class="under-line none-margin-box">屬性分組列表</h3>
                        <p><button id="add_new" class="button-orange">新增一組屬性分組</button> 
                        <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                        <p id="new_area" style="display:none;">屬性分組名稱 : <input class="input-text" type="input" value="" id="attribute_group_name"><button id="add" class="button-orange">新增</button></p>
                        <table class="table-hover-style block-table img-limit-table">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="tip" tip="點選下方可編輯名稱">屬性分組名稱</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list as $row):?>
                                <tr>
                                    <th><?php echo $row['id'];?></th>
                                    <td class="click-to-edit"><?php echo $row['attribute_group_name'];?></td>
                                    <td>
                                        <a class="del_attribute_group" href="#" url="<?php echo base_url('admin/product/del_attribute_group/' . $row['id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
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
