<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>會員資料{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script type="text/javascript">
    $(function(){
        $('#reset').click(function(){
            $.get("<?php echo base_url('admin/member/reset').'/'.$this->uri->segment(4,0);?>",
                  function(data){
                    if( data.state != -1 ){
                        $("#info").attr("class","tip-success").find("#tip-status").text("Success");
                        $("#info").fadeIn("slow").find("#text").text("密碼已重設為123456!");
                    }
                  }, 'json')
        })
    })
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
                    <div class="item"><button id="reset" class="button-orange small-border-radius">重置使用者密碼</button></div>
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
                                <label for="link-1" class="label link-title title-font">會員管理</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/member');?>">會員列表</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-1" type="checkbox" name="link" class="radio" />
                                <label for="link-1" class="label link-title title-font">意見回饋</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/member/report');?>">意見回饋</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content">
                        <h3 class="under-line none-margin-box">會員資料</h3>
                        </br>
                        <p class="tip-success" id="info" style="display:none;"><span class="icon" id="tip-status">Success</span><span id="text" class="text"></span></p>
                        </br>
                        <?php if( $user ){ ?>
                            <table class="list-table">
                                <colgroup>
                                    <col span="1">
                                    <col span="1">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>會員編號</th>
                                        <td><?php echo $user[0]['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>姓名</th>
                                        <td><?php echo $user[0]['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>性別</th>
                                        <td><?php echo ($user[0]['sex']) ? '小姐' : '先生' ; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $user[0]['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>聯絡電話</th>
                                        <td><?php echo $user[0]['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>地址</th>
                                        <td><?php echo $user[0]['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>上次登入時間</th>
                                        <td><?php echo date( 'Y-m-d H:i:s', $user[0]['last_login']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>上次登入ip</th>
                                        <td><?php echo $user[0]['login_ip']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                    <?php }else{ ?>
                        很抱歉, 沒有<?php echo $this->uri->segment(4,0); ?>這位會員
                    <?php } ?>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
