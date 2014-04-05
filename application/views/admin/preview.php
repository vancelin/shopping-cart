<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>LVAX 購物車</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="css/ie.css" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/template.css');?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/style.css');?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/cssStyle.css');?>" />
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script>
    $(document).ready(function(){
        //for photo_silder
        now = 0;
        var count = $(".slide").length;
        $(".item-cover-prev-btn").click(function(){
            if(now != 0 || now >= count){
                var first = $("#slider img:eq("+(now-1)+")").attr("src");
                $(".item-cover img").attr("src",first);
                now = now - 1;
               
            }
        });
        
        $(".item-cover-next-btn").click(function(){
            if(now != (count -1) && now <= count){
                var first = $("#slider img:eq("+(now+1)+")").attr("src");
                $(".item-cover img").attr("src",first);
                now = now + 1;
            }
        });
        
        $(".slide").live("hover",function(){
            $(".item-cover img").attr("src",$(this).find("img").attr("src"));
            now = $(this).attr("id");
        });
        
    });
    </script>
</head>
<body>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="popup-tool-container">
                <input id="popup-tool-checkbox" type="checkbox" class="hidden" />
                <div id="popup-tool-checkbox-container" class="white-block-box small-border-radius deep-box-shadow none-padding-box coffee-box">
                    <label for="popup-tool-checkbox">TOOL</label>
                </div>
                <div id="popup-tool" class="white-block-box">
                    <ul class="no-decoraction block ver-big-separate">
                        <li>
                            <form action="#" method="post">
                                <span class="block text-left small">數量：</span>
                                <select>
                                    <option>1</option>
                                </select>
                                <select>
                                    <option>樣式</option>
                                </select>
                                <button class="product-tool-button" title="加入購物車"><i class="add-shopcart-ico"> </i></button>
                            </form>
                        </li>
                        <li><form action=""><button class="product-tool-button" title="收藏">收藏</button></form></li>
                    </ul>
                </div>
            </div>
            <div id="content">
                <div id="popup-main">
                    <div class="product-top">
                        <table class="block-table">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td style="width: 40%;">
                                        <div class="block item-cover-show white-block-box stretch-height">
                                            <div class="item-cover">
                                                <img src="<?php echo base_url('public/temp/'.$main_img);?>"/>
                                            </div>
                                            <div class="item-cover-slide coffee-box line-keep">
                                                <button class="item-cover-prev-btn" title="prev">&lt;&lt;</button>
                                                <ul class="no-decoraction hor-list line-keep white-space-clear" id="slider">
                                                <?php echo $img;?>
                                                </ul>
                                                <button class="item-cover-next-btn" title="next">&gt;&gt;</button>
                                            </div>
                                            <div class="clear"> </div>
                                        </div>
                                    </td>
                                    <td style="padding-left: 20px; width: 60%;">
                                        <div class="block item-description white-block-box">
                                            <div class="item-top-flag pink-flag text-left float-box">New</div>
                                            <table class="block-table">
                                                <colgroup>
                                                    <col span="1" />
                                                </colgroup>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h2 class="line-break text-left block"><?php echo $product['product_name'];?></h2>
                                                            <div class="block text-right small text-muted">上架日期：<?php echo $product['update_time'];?></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <dl class="inline-d-list">
                                                            <?php echo $attributes;?>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="item-buy-way">
                                                                <span>Visa</span>
                                                                <span>ATM</span>
                                                            </div>
                                                            <div class="item-price">
                                                                <div class="cap">NT$</div>
                                                                <del><?php echo $product['market_price'];?></del>
                                                                <span><?php echo $product['sale_price'];?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clear"> </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="product-main white-block-box">
                    <?php echo $product['introduction'];?>
                    </div>
                    <div class="product-footer white-block-box hidden">footer</div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <h1 id="logo">
            <a href="<?php echo base_url('home');?>"> </a>
        </h1>
        <div class="small hor-medium-separate">
            <section class="hor-tiny-separate">
                <a href="<?php echo base_url('shop/detail');?>"><button class="button deep-coffee-box small-border-radius">購物清單</button></a>
                <a href="<?php echo base_url('member');?>"><button class="button deep-coffee-box small-border-radius">註冊/登入</button></a>
            </section>
        </div>
        <div class="search-tool white-space-clear pull-right">
            <input type="text" placeholder="Search" class="ico-text search-bar medium focus-stretch" />
            <button class="medium search-button w-ico-container">
                <i class="w-search-ico"> </i>
            </button>
        </div>
    </div>
</body>