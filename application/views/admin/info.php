<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>主機環境{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
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
                        <h3 class="under-line none-margin-box">主機環境</h3>
                        <br>
                        <table class="table-hover-style block-table img-limit-table text-center">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>版本</td><td>0.9.0 Alpha</td>
                                    
                                    <td>是否有新版</td><td>尚未</td>
                                </tr>
                                <tr>
                                    <td>主機網址、IP</td><td><?php echo $_SERVER['SERVER_NAME'];?> (<?php if('/'==DIRECTORY_SEPARATOR){echo $_SERVER['SERVER_ADDR'];}else{echo @gethostbyname($_SERVER['SERVER_NAME']);} ?>)</td>
                                    
                                    <td>操作系統</td><td><?php $os = explode(" ", php_uname()); echo $os[0];?> &nbsp;核心版本：<?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?></td>
                                </tr>
                                <tr>
                                    <td>伺服器類型</td><td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
                                    
                                    <td>網站端口</td><td><?php echo $_SERVER['SERVER_PORT'];?></td>
                                </tr>
                                <tr>
                                    <td>網站管理員信箱</td><td><?php echo $_SERVER['SERVER_ADMIN'];?></td>
                                    
                                    <td>網站目錄位置</td><td><?php $len = strlen(BASEPATH); echo substr(BASEPATH,0,$len-7);?></td>
                                </tr>
                                <tr>
                                    <td>PHP 版本</td><td><?php echo PHP_VERSION;?></td>
                                    
                                    <td>上傳檔案大小限制</td><td><?php echo get_cfg_var("upload_max_filesize");?></td>
                                </tr>
                                <tr>
                                    <td>magic_quotes_gpc (自動轉義字串)</td><td><?php echo (get_cfg_var("magic_quotes_gpc")) ? "<img src='".base_url('public/admin/img/tick.png')."'/>" : "<img src='".base_url('public/admin/img/no.png')."'/>";?></td>
                                    
                                    <td>magic_quotes_runtime (外部字串轉義)</td><td><?php echo (get_cfg_var("magic_quotes_runtime")) ? "<img src='".base_url('public/admin/img/tick.png')."'/>" : "<img src='".base_url('public/admin/img/no.png')."'/>";?></td>
                                </tr>
                                <tr>
                                    <td>GD 圖型函式庫</td><td><?php $gd_info = @gd_info(); echo (function_exists("gd_info")) ? @$gd_info['GD Version'] : "<font style='color: #F14E32;'>若無此函示庫，將無法使用上傳圖片功能</font>";?></td>
                                    
                                    <td>SMTP 寄信函式</td><td><?php echo (get_cfg_var("SMTP")) ? "<img src='".base_url('public/admin/img/tick.png')."'/>" : "<img src='".base_url('public/admin/img/no.png')."'/>";?></td>
                                </tr>
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
