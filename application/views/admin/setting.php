<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>全局設定{elapsed_time}</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script>
    $(function(){
        
       $("#save").click(function(){
           
            if($("input[type=text]:eq(2)").val().length > 30){
                
                $("#info").attr("class","tip-error").find("#tip-status").text("Error");
                $("#info").fadeIn("slow").find("#text").text("網站標語不能大於30個字元");
            
            }else{
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/setting/save_setting');?>",
                    data: $("#form").serialize(),
                    success: function() {
                        $("#info").hide();
                        $("#info").attr("class","tip-success").find("#tip-status").text("Success");
                        $("#info").fadeIn("slow").fadeOut("slow").find("#text").text("儲存成功");
                    }
                });
            }
        });
        
        $("#refresh").click(function(){
            $('form')[0].reset(); 
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
                        <h3 class="under-line none-margin-box">全局設定</h3>
                        </br>
                        <p class="tip-success" id="info" style="display:none;"><span class="icon" id="tip-status">Success</span><span id="text" class="text"></span></p>
                        </br>
                        <form id="form">
                            <p>網站名稱 : <input type="text" class="input-text" name="site[]" value="<?php echo $site_setting[0]['value'];?>"></p>
                            <p>網站標語 : <input type="text" class="input-text" name="site[]" value="<?php echo $site_setting[1]['value'];?>">(30字元)</p>
                            <p>網站信箱 : <input type="text" class="input-text" name="site[]" value="<?php echo $site_setting[2]['value'];?>"></p>
                            <p>網站電話 : <input type="text" class="input-text" name="site[]" value="<?php echo $site_setting[3]['value'];?>"></p>
                        </form>
                        <br>
                        <p>網站Logo: <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin/setting/upd');?>"><input type="file" name="logo">   <button class="button-orange small-border-radius">新增Logo</button></p>
                        <p>Logo會自動縮略為 150*50</p>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
