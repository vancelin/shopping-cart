<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>付款方式{elapsed_time}</title>
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
           $('form').submit(); 
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
                                <label for="link-1" class="label link-title title-font">訂單管理</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/sell');?>">最新訂單</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/sell/orders');?>">訂單列表</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-2" type="checkbox" name="link" class="radio" />
                                <label for="link-2" class="label link-title title-font">銷售管理</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/sell/profit');?>">利潤分析</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/sell/rank');?>">銷售排名</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-3" type="checkbox" name="link" class="radio" />
                                <label for="link-3" class="label link-title title-font">設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/sell/payment');?>">付款方式</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content">
                        <h3 class="under-line none-margin-box">付款方式</h3>
                        <br>
                        <form id="payment" action="<?php echo base_url("admin/sell/payment_save");?>" method="post">
                            
                        <?php foreach($pways as $pway):?>
                            <?php if(!$pway['global_active']):?>
                                <p><input type="checkbox" class="radio-input" disabled>
                            <?php elseif($pway['active']):?>
                                <p><input type="checkbox" name="pway[]" value="<?php echo $pway['id'];?>" class="radio-input" checked>
                            <?php elseif(!$pway['active']):?>
                                <p><input type="checkbox" name="pway[]" value="<?php echo $pway['id'];?>" class="radio-input">
                            <?php endif;?>
                                    
                            <?php if($pway['active']):?>
                                <a href="<?php echo base_url('admin/sell/pway/'.$pway['id']);?>"><?php echo $pway['way'];?></a></p>
                            <?php elseif(!$pway['active']):?>
                                <a href="javascript:void(0);"><?php echo $pway['way'];?></a></p>
                            <?php endif;?>
                        <?php endforeach;?>
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
