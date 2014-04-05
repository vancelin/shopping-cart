<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>意見回饋{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>


    <script type="text/javascript">
    $(function(){
        $('#content div.item').each(function(i){
            $(this).next('a').click(function(){
                $(this).prev().slideToggle('slow');
            })
        });
        $('#expend').click(function(){
            $('#content div.item').each(function(i){
                $(this).slideDown('slow');
            });
        })
        $('#close').click(function(){
            $('#content div.item').each(function(i){
                $(this).slideUp('slow');
            });
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
                <div id="tool">
                    <div class="item">
                        <button id="expend" class="button-orange small-border-radius button-big">全部展開</button>
                    </div>
                    <div class="item">
                        <button id="close" class="button-orange small-border-radius button-big">全部收合</button>
                    </div>
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
                        <h3 class="under-line none-margin-box">意見回饋</h3>
                        </br>
                        <div class="page-container"><?php echo $links;?></div>
                        <?php foreach( $reports as $list ){ ?>
                        <div class='item'>
                            <table class="list-table">
                                <colgroup>
                                    <col span="1">
                                    <col span="1">
                                </colgroup>
                                <tbody>

                                    <tr>
                                        <th>日期</th>
                                        <td><?php echo date('Y-m-d H:i:s', $list['date']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>提訴人</th>
                                        <td><?php echo $list['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $list['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>主旨</th>
                                        <td><?php echo $list['subject']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>內容</th>
                                        <td><?php echo nl2br($list['sug']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            -------------------------------------------
                        </div>
                        <a href="###" style="float:right;">展開/收合</a>
                        <br/>
                       <?php } ?>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
