<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>信件伺服器設定{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js');?>"></script>
    <script>
    $(function(){
        $( "#tabs" ).tabs();
        
        if($("#select").val() != 'smtp'){
            $(".smtp_class").hide();
            $(".smtp_input").attr("name","");
            $("#mail_path").show();
        }
        
        $("select").change(function(){
            var send_way = $("#select option:selected").val();
            if(send_way == 'mail' || send_way == 'sendmail'){
                $(".smtp_class").hide();
                $(".smtp_input").attr("name","");
                $("#mail_path").show();
            }else if(send_way == 'smtp'){
                $(".smtp_class").show();
                $("#mail_path").hide();
                $(".smtp_input").attr("name","smtp[]");
            }
        });
        
        $("#save").click(function(){
            $('form').submit();  
        });
        
        $("#google_smtp").click(function(){
            $("#smtp_url").attr("value","ssl://smtp.gmail.com");
            $("#smtp_port").attr("value","465");
        });
        
        $("#try_send").click(function(){
            if(($("input[name='to']").val() && $("input[name='from']").val() && $("input[name='subject']").val() && $("input[name='message']").val() && $("input[name='from_name']").val()) != ''){
                $.post("<?php echo base_url('admin/setting/send');?>",{
                    to:$("input[name='to']").val(),
                    from:$("input[name='from']").val(),
                    subject:$("input[name='subject']").val(),
                    message:$("input[name='message']").val(),
                    from_name:$("input[name='from_name']").val()
                },function(r){
                    if(r == ''){
                        $("#info").hide();
                        $("#info").fadeIn("slow").find("#text").text("成功寄出!");
                        $("#info").fadeOut("slow");
                    }else{
                        alert(r);
                    }
                });
            }else{
                $("#info").hide();
                $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                $("#info").find("#text").text("請填滿寄信資訊！");
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
                    <div class="item"><button id="save" class="button-orange small-border-radius">儲存設定</button></div>
                    <div class="item"><button id="try_send" class="button-orange small-border-radius">測試寄信</button></div>
                    <div class="item"><button id="google_smtp" class="button-orange small-border-radius">插入Google</button></div>
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
                        <h3 class="under-line none-margin-box">信件伺服器設定</h3>
                        <br>
                        <p class="tip-success" id="info" style="display:none;"><span class="icon" id="tip-status">Success</span><span id="text" class="text"></span></p>
                        <br>
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">信件伺服器設定</a></li>
                                <li><a href="#tabs-2">寄信測試</a></li>
                            </ul>
                            <div id="tabs-1">
                                <form action="<?php echo base_url('admin/setting/smtp_save');?>" method="post">
                                    <p>
                                        寄信方式 
                                        <select id="select" name="smtp[]" class="select">
                                            <option value="smtp" <?php echo ($smtp_settings[4]['value'] == 'smtp')? "selected":"";?> >SMTP</option>
                                            <option value="sendmail" <?php if($smtp_settings[4]['value'] == 'sendmail'):?> selected<?php endif;?> >sendmail</option>
                                            <option value="mail" <?php echo ($smtp_settings[4]['value'] == 'mail')? "selected":"";?> >mail</option>
                                        </select>
                                    </p>
                                    <p>
                                        信件類型 
                                        <select name="smtp[]" class="select">
                                            <option value="text" <?php echo ($smtp_settings[5]['value'] == 'text')? "selected":"";?> >文字</option>
                                            <option value="html" <?php echo ($smtp_settings[5]['value'] == 'html')? "selected":"";?> >網頁</option>
                                        </select>
                                    </p>
                                    <p class="smtp_class">SMTP 網址 <input type="text" id="smtp_url" value="<?php echo $smtp_settings[6]['value'];?>" class="smtp_input input-text" name="smtp[]" ></p>
                                    <p class="smtp_class">SMTP 端口 <input type="text" id="smtp_port" value="<?php echo $smtp_settings[7]['value'];?>" class="smtp_input input-text" name="smtp[]" </p>
                                    <p class="smtp_class">SMTP 帳號 <input type="text" value="<?php echo $smtp_settings[8]['value'];?>" class="smtp_input input-text" name="smtp[]" ></p>
                                    <p class="smtp_class">SMTP 密碼 <input type="password" value="<?php echo $smtp_settings[9]['value'];?>" class="smtp_input input-text" name="smtp[]" ></p>
                                    <p class="smtp_class">
                                        是否需要驗證 
                                        是<input type="radio" value="true" name="validate" class="input-radio" <?php echo ($smtp_settings[10]['value'])? "checked":"";?> >
                                        否<input type="radio" value="false" name="validate" class="input-radio" <?php echo (!$smtp_settings[10]['value'])? "checked":"";?> ></p>
                                    <p style="display:none;" id="mail_path">寄信路徑 <input type="text" value="<?php echo $smtp_settings[11]['value'];?>" name="smtp[]" class="input-text"></p>
                                </form>
                            </div>
                            <div id="tabs-2">
                                <table class="list-table">
                                    <colgroup>
                                        <col span="1">
                                        <col span="1">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>收件人</th>
                                            <td><input type="text" value="" name="to" class="input-text"></td>
                                        </tr>
                                        <tr>
                                            <th>寄件人</th>
                                            <td><input type="text" value="" name="from" class="input-text"></td>
                                        </tr>
                                        <tr>
                                            <th>寄件人姓名</th>
                                            <td><input type="text" value="" name="from_name" class="input-text"></td>
                                        </tr>
                                        <tr>
                                            <th>測試標題</th>
                                            <td><input type="text" value="" name="subject" class="input-text"></td>
                                        </tr>
                                        <tr>
                                            <th>測試內容</th>
                                            <td><input type="text" value="" name="message" class="input-text"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
