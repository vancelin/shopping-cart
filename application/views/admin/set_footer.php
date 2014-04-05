<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>底部頁面設定{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <!--for editor-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/editor/jquery.cleditor.css');?>" />
    <script type="text/javascript" src="<?php echo base_url('public/admin/editor/jquery.cleditor.min.js');?>"></script>
    <script>
    $(function(){
        $("#add").click(function(){
            $("form").show("slow");
        });
       
        $("textarea").cleditor({width:800, height:200, useCSS:true})[0].focus();
        
        $("#refresh").click(function(){
            $('form')[0].reset();
        }); 
        $("#save").click(function(){
            
            var title = $("#title").val();
            var text = $("textarea").val();
            var url = $("#url").val();
            var sequence = $("#sequence").val();
            var chkdio = $('input[name=chkdio]:checked').val();
            
            if((title != '') && (url != '' || text != '')){
                
                var active = (chkdio == 1) ? "<img src='<?php echo base_url('public/admin/img/tick.png');?>'/>" : "<img src='<?php echo base_url('public/admin/img/no.png');?>'/>";
                
                var url_active = (url != '') ? "<img src='<?php echo base_url('public/admin/img/tick.png');?>'/>" : "<img src='<?php echo base_url('public/admin/img/no.png');?>'/>";
                
                $.post("<?php echo base_url('admin/setting/save_footer');?>",{title:title,text:text,chkdio:chkdio,url:url,sequence:sequence},function(r){
                    
                    $("table").find("tbody").prepend('<tr><td>' + active + '</td><td>' + url_active + '</td><td>' + sequence + '</td><td>' + $("#title").val() + '</td><td><a href="<?php echo base_url('admin/setting/edit_page');?>/' + r + '"><img src="<?php echo base_url('public/admin/img/edit.png'); ?>" /></a></td></tr>');
                    $("form").hide();
                    $("#info").hide();
                    $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                    $("#info").find("#text").text("新增成功！");
                    $("#info").fadeOut();
                    $('form')[0].reset();
                });
                
            }else{
                $("#info").fadeIn("slow").find("#text").text("請填寫標題與內容 !");
            }
            
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
        
        $(".click-to-edit").dblclick(function(){
            var item = $(this);
            var page_id = $(this).parent().attr("page_id");
            var mode = $(this).attr("mode");
            
            if(mode == 'active'){
                var status = $(this).attr("status");
                var new_text = ($(this).attr("status") == '1') ? "0":"1";
                var input = (status == '1') ? "<img src='<?php echo base_url('public/admin/img/tick.png');?>'/>" : "<img src='<?php echo base_url('public/admin/img/no.png');?>'/>";
                $(this).attr("status",new_text).html(input);
                $.post("<?php echo base_url('admin/setting/quick_save_setting');?>",{id:page_id,mode:mode,new_text:status});
            }else if(mode == 'sequence' || mode == 'page_title'){
                var old_text = $(this).text();
                var input = $("<input type='text' class='input-text' value='" +old_text+ "'>");
                $(this).html(input);
            }
            
            if(mode !='active'){
                $(input).select();
                $(input).blur(function(){
                   var new_text = $(this).val();
                   if($.trim(new_text) != ''){
                       $(item).html(new_text);
                       $.post("<?php echo base_url('admin/setting/quick_save_setting');?>",{id:page_id,mode:mode,new_text:new_text});
                   }
                });
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
                    <!--[if (lte IE 8)]>
                        <div id="link" class="link-8">
                    <![endif]-->
                    <!--[if (!IE)|(gte IE 9)]><!-->
                        <div id="link">
                    <!--<![endif]-->
                        <div class="block-list slide-container white-space-clear medium-font-box">
                            <!--[if (lte IE 8)]>
                                <div class="block" style="width= 100px;height: 100px;">
                                    <img src="./img/admin-login.png" width="100px" height="100px;" />
                                </div>
                            <![endif]-->
                            <div class="block">
                                <input id="link-1" type="checkbox" name="link" class="radio" />
                                <label for="link-1" class="label link-title title-font">全局設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/setting');?>">主機環境</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/setting/site_setting');?>">全局設定</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/setting/set_footer');?>">底部頁面設定</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-2" type="checkbox" name="link" class="radio" />
                                <label for="link-2" class="label link-title title-font">管理者設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/setting/set_account');?>">帳密修改</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/setting/bad_login');?>">錯誤登入記錄</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-3" type="checkbox" name="link" class="radio" />
                                <label for="link-3" class="label link-title title-font">單一設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/setting/smtp');?>">寄信設定</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/setting/validmail');?>">驗證信內容</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content">
                        <h3 class="under-line none-margin-box">底部設定</h3>
                        <br>
                        <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                        <br>
                        <button id="add" class="button-orange">新增一組頁面</button>
                        <br>
                        <br>
                        <form style="display:none;">
                            <table class="list-table">
                                <colgroup>
                                    <col span="1">
                                    <col span="1">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>標題名稱 : </th>
                                        <td><input type="text" id="title" value="" class="input-text"/></td>
                                    </tr>
                                    <tr>
                                        <th>網址 : </th>
                                        <td><input type="text" id="url" value="" class="input-text">EX: http://www.yachoo.com.tw 或 xxx@yahoo.com.tw 若填寫網址,內容將為空！</td>
                                    </tr>
                                    <tr>
                                        <th>排列順序 : </th>
                                        <td><input type="text" id="sequence" value="" class="input-text"></td>
                                    </tr>
                                    <tr>
                                        <th>是否顯示 : </th>
                                        <td>是 <input type="radio" id="chkdio" name="chkdio" value="1" class="input-radio" checked>否 <input type="radio" id="chkdio" name="chkdio" value="0" class="input-radio"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <textarea class="textarea"></textarea>
                            <br>
                            <br>
                        </form>
                        <table class="table-hover-style block-table img-limit-table text-center">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col" class="tip" tip="點選下方編輯是否顯示">展示</th>
                                    <th scope="col">是否為網址</th>
                                    <th scope="col" class="tip" tip="點選下方編輯順序">展示順序</th>
                                    <th scope="col" class="tip" tip="點選下方編輯頁面標題">頁面標題</th>
                                    <th scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($results as $result):?>
                                    <tr page_id="<?php echo $result['id'];?>">
                                        <?php if($result['active'] && !$result['under_site']):?>
                                        <td class="click-to-edit"  status="0" mode="active"><img src="<?php echo base_url('public/admin/img/tick.png');?>"/></td>
                                        <?php elseif($result['active'] && $result['under_site']):?>
                                        <td><img src="<?php echo base_url('public/admin/img/tick.png');?>"/></td>
                                        <?php else:?>
                                        <td class="click-to-edit" status="1" mode="active"><img src="<?php echo base_url('public/admin/img/no.png');?>"/></td>
                                        <?php endif;?>
                                        
                                        <?php if($result['url_active']):?>
                                        <td><img src="<?php echo base_url('public/admin/img/tick.png');?>"/></td>
                                        <?php else:?>
                                        <td><img src="<?php echo base_url('public/admin/img/no.png');?>"/></td>
                                        <?php endif;?>
                                        
                                        <td mode="sequence" class="click-to-edit"><?php echo $result['page_sequence'];?></td>
                                        <td mode="page_title" class="click-to-edit"><?php echo $result['title'];?></td>
                                        <?php if(!$result['under_site']):?>
                                        <td>
                                            <a href="<?php echo base_url('admin/setting/edit_page/'.$result['id']);?>"><img src="<?php echo base_url('public/admin/img/edit.png'); ?>" /></a> |
                                            <a class="delete" href="#" url="<?php echo base_url('admin/setting/page_del/' . $result['id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
                                        </td>
                                        <?php else:?>
                                        <td></td>
                                        <?php endif;?>
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
