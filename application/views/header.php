<!DOCTYPE HTML>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- SNS tags -->
    <!-- All of link use 'http URL' >> 'http://~' -->
    <meta property="og:title" content="<?php echo $setting[0]['value'] ." - ". @$page_name ;?>{elapsed_time}"/> <!-- Page Title -->
    <meta property="og:type" content="website"/> <!-- Website Type  (STATIC) -->
    <meta property="og:url" content="<?php echo base_url();?>"/> <!-- Website Url -->
    <meta property="og:image" content="<?php echo base_url('public/img/logo.jpg');?>"/> <!-- Image Display -->
    <!-- If in product page ,then oglimage<content="<?php echo base_url('public/product_imgs/'.$main_img['img_name']);?>"> -->
    <meta property="og:site_name" content="<?php echo $setting[0]['value'];?>"/> <!-- Website Name -->
    <!--                -->
    <title><?php echo $setting[0]['value'] ." - ". @$page_name ;?>{elapsed_time}</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/ie.css');?>" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/template.css');?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/style.css');?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/cssStyle.css');?>" />
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.infinitescroll.min.js');?>"></script>
    <script>
    $(document).ready(function() {
        $("#quick-shop-panel").load("<?php echo base_url('shop/quickshop');?>");
        $("#shopcart-quick-check-label").click(function(){
            if ($(".tool").is(":hidden")) {
                $(".tool").slideDown("slow");
            } else {
                $(".tool").slideUp("slow");
            }
        });
        $(".quickshop").live("click",function(){
            $.post("<?php echo base_url('shop/add');?>",{action:"quick_shop",product_id:$(this).attr("productid")},function(r){
                $("#quick-shop-panel").load("<?php echo base_url('shop/quickshop');?>");
            });
            $(".tool").slideDown("slow");
        });
        $(".follow").live("click",function(){
            $.post("<?php echo base_url('member/follow');?>",{product_id:$(this).attr("productid")},function(r){
                if(r == 1){
                    $("#follow-tip").fadeIn("slow").fadeOut("slow");
                }else if(r == 0){
                    $("#login-tip").fadeIn("slow");
                }
            });
        });
        $(".category-menu").mouseover(function(){
            $.get("<?php echo base_url('category/category_second_list');?>/"+$(this).attr("id"),function(r){
                if(r){
                    $(".dropdown-menu-container .second-category").html(r);
                }else{
                    $(".dropdown-menu-container .second-category").html('');
                }
            });
        });
        
        var url = window.location.pathname.split('/');
        var several = url.length - 3;
        
        if(url[3] == 'search'){
            $("#search-tool").remove();
        }
    });
    </script>
</head>
<body>
<table id="wrap-table" style="display:none;">
    <colgroup>
        <col span="1" width="100%">
    </colgroup>
    <tr>
        <td class="ver-medium-separate">
            <img src="<?php echo base_url('public/img/send-w.gif');?>" alt="waiting" />
            <div class="block blod large">請勿按上一頁或離開此頁面，等待頁面完成...</div>
        </td>
    </tr>
</table>
<div id="top">
    <div id="nav-top">
        <div class="nav-top-container text-left">
            <div id="logo-container">
                <a id="logo" href="<?php echo base_url();?>"><img src="<?php echo base_url('public/img/logo.png');?>" alt="R.D." /></a>
                <div id="slogan" class="text-left line-keep"><?php echo $setting[1]['value'];?></div> <!-- 30 letters ,max-width: 455px ,max-height: 30px -->
            </div>
            <div id="nav-acc" class="hor-small-separate medium">
                <!--      -->
                <a href="<?php echo base_url('shop/detail');?>" class="inline-block">
                    <span class="ico-16-box ico-16-shopcart"> </span>Shop Cart
                </a>
                <?php if( !(isset($account)) ): ?>
                <!-- Visitor -->
                <a href="<?php echo base_url('member');?>" class="inline-block">
                    <span class="alert-bubble" id="login-tip" style="display:none;">請先登入</span>
                    <span class="ico-16-box ico-16-info"> </span>Login
                </a>
                <?php else: ?>
                <!-- User -->
                <a href="<?php echo base_url('member');?>" class="inline-block">
                    <span class="alert-bubble" id="follow-tip" style="display:none;">追蹤成功</span>
                    <span class="ico-16-box ico-16-user"> </span>
                        <?php echo $account['name']; ?>
                </a>
                <a href="<?php echo base_url('member/logout');?>" class="inline-block">
                    <span class="ico-16-box ico-16-info"> </span>Logout
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="nav" class="text-center">
        <div class="wrap text-left">
            <div id="menu-container" class="no-decoraction hor-none-separate">
                <div class="menu dropdown-menu-container">
                    <a href="" class="dropdown-menu-title">排序方式</a>
                    <ul class="dropdown-menu ver-list">
                        <li><a href="<?php echo base_url('home/index/0');?>/price_asc">價錢由低至高</a></li>
                        <li><a href="<?php echo base_url('home/index/0');?>/price_desc">價錢由高至低</a></li>
                        <li><a href="<?php echo base_url('home/index/0');?>/newin">一週內新品</a></li>
                        <li><a href="<?php echo base_url('home/index/0');?>/bargain">特價</a></li>
                        <li><a href="<?php echo base_url('home/index/0');?>/recommend">推薦</a></li>
                    </ul>
                </div>
                <?php foreach($categorys as $category):?>
                <div class="menu dropdown-menu-container">
                    <a id="<?php echo $category['category_id'];?>" href="<?php echo base_url('category/index/'.$category['category_id']);?>" class="dropdown-menu-title category-menu"><?php echo $category['category_name'];?></a>
                    <ul class="dropdown-menu ver-list second-category"></ul>
                </div>
                <?php endforeach;?>
            </div>
            <div id="search-tool" class="search-tool white-space-clear">
                <form action="<?php echo base_url('home/search');?>" method="post">
                    <div class="focus-strech-container">
                        <input type="text" placeholder="Search" name="query" class="ico-text search-text" />
                    </div>
                    <button class="ico-16-container">
                        <span class="ico-16-box ico-16-search-w"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="shopcart-quick-check-container">
        <div class="tool" style="display:none;">
            <div id="quick-shop-panel" style="padding-top: 8px;">
                <div class="clear"> </div>
            </div>
        </div>
        <div id="shopcart-quick-check-label">=</div>
    </div>
</div>
