<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>底部頁面編輯</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js');?>"></script>
    <!--for editor-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/editor/jquery.cleditor.css');?>" />
    <script type="text/javascript" src="<?php echo base_url('public/admin/editor/jquery.cleditor.min.js');?>"></script>
    <script type="text/javascript">
    $(function(){
        $("textarea").cleditor({width:800, height:200, useCSS:true})[0].focus();
        
        $("#refresh").click(function(){
            $('form')[0].reset();
        }); 
        
        $("#save").click(function(){
            $('form').submit(); 
        });
    });
    </script>
</head>
<body>
    <table class="popup block-table float-box toppest stretch-height hidden"> <!-- remove hidden -->
        <colgroup>
            <col span="1" />
        </colgroup>
        <tbody>
            <tr>
                <td>
                    <div class="popup-box">test</div>
                </td>
            </tr>
        </tbody>
    </table>
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
                    <div class="focus-strech-container">
                        <input type="text" placeholder="Search" class="ico-text search-text medium" />
                        <select name="" id="" class="search-select">
                            <option value="product_name">商品名稱</option>
                            <option value="order_id">訂單編號</option>
                            <option value="order_product">訂單商品</option>
                            <option value="sell_times">銷售次數</option>
                        </select>
                    </div>
                    <button class="ico-16-container">
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
                                    <div class="block"><a href="<?php echo base_url('admin/setting');?>">登入記錄</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-3" type="checkbox" name="link" class="radio" />
                                <label for="link-3" class="label link-title title-font">單一設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/setting/smtp');?>">信件伺服器設定</a></div>
                                    <div class="block"><a href="<?php echo base_url('admin/setting/validmail');?>">驗證信內容</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content">
                        <h3>底部頁面編輯</h3>
                        <form action="<?php echo base_url('admin/setting/save_footer');?>" method="post">
                            <table class="list-table">
                                <colgroup>
                                    <col span="1">
                                    <col span="1">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>標題名稱 : </th>
                                        <td><input type="text" name="title" value="<?php echo $result['title'];?>" class="input-text"/></td>
                                    </tr>
                                    <tr>
                                        <th>網址 : </th>
                                        <td><input type="text" name="url" value="<?php echo $result['url'];?>" class="input-text">EX: http://www.yachoo.com.tw 或 xxx@yahoo.com.tw 若填寫網址,內容將為空！</td>
                                    </tr>
                                    <tr>
                                        <th>排列順序 : </th>
                                        <td><input type="text" name="sequence" value="<?php echo $result['page_sequence'];?>" class="input-text"></td>
                                    </tr>
                                    <tr>
                                        <th>是否顯示 : </th>
                                        <td><?php echo ($result['active']) ? 
                                            '是 <input type="radio" id="chkdio" name="chkdio" value="1" class="input-radio" checked> 否 <input type="radio" id="chkdio" name="chkdio" value="0" class="input-radio">'
                                            : 
                                            '是 <input type="radio" id="chkdio" name="chkdio" value="1" class="input-radio"> 否 <input type="radio" id="chkdio" name="chkdio" value="0" class="input-radio" checked>';?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <textarea name="text" class="textarea"><?php echo $result['content'];?></textarea>
                            <input type="hidden" name="mode" value="1" />
                            <input type="hidden" name="page_id" value="<?php echo $result['id'];?>" />
                            <br>
                            <br>
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
