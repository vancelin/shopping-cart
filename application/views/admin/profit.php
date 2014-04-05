<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>利潤分析{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js');?>"></script>
    <script type="text/javascript">
    $(function(){
        $("#start_date").datepicker();
        $("#start_date").datepicker("option", "dateFormat","yy-mm-dd");
        
        $("#save").click(function(){
            if($("#start_date").val()!=''){
                $("form").submit();
            }else{
                $("#info").attr("class","tip-error").find("#tip-status").text("Error");
                $("#info").fadeIn("slow").find("#text").text("請選擇日期");
            }
        });
        
        $("#edit").click(function(){
            alert(1);
            $(".item-popup-container").html("123").show();
        });
        
        $("#all").click(function(){
            $("input[name=mode]").attr("value",1);
            $("form").submit();
        });
        $("#deal").click(function(){
            $("input[name=mode]").attr("value",0);
            $("form").submit();
        });
        
        $("#query_date").datepicker();
        $("#query_date").datepicker("option", "dateFormat","yy-mm");
        
        $("#query_date").change(function(){
            if($(this).val!=''){
                $("input[name=mode]").attr("value",0);
                $(".button-orange").show();
            }
        });
        $("#m-deal").click(function(){
            $("input[name=mode]").attr("value",0);
            $("form").submit();
        });
        $("#m-all").click(function(){
            $("input[name=mode]").attr("value",1);
            $("form").submit();
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
                    <?php if($setting==''):?>
                        <div class="item"><button id="save" class="button-orange small-border-radius">儲存日期設定</button></div>
                    <?php else:?>
                        <?php if($mode):?>
                            <div class="item"><button id="deal" class="button-orange small-border-radius">成交之訂單</button></div>
                        <?php else:?>
                            <div class="item"><button id="all" class="button-orange small-border-radius">全部訂單</button></div>
                        <?php endif;?>
                    <?php endif;?>
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
                        <h3 class="under-line none-margin-box">
                            <?php echo ($mode) ? "利潤分析 (30天內無論是否成交之所有訂單)":"利潤分析 (30天內已經成交之訂單)";?>
                        </h3>
                        <?php if($setting==''):?>
                            <br>
                            <br>
                            <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                            <br>
                            <br>
                            <br>
                            <form action="<?php echo base_url('admin/sell/save_date');?>" method="post">
                                <p>你還沒填入報表開始計算日期，請輸入日期 <input type="text" value="" name="start_date" class="input-text" id="start_date"></p>
                            </form>
                        <?php else:?>
                            <br>
                            <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                            <br>
                            <p>
                                起算日期 : <span id="edit_area"><?php echo $setting;?></span>
                            </p>
                            <br>
                            <form action="<?php echo base_url('admin/sell/profit');?>" method="post">
                                <p>
                                    查詢月份 : <input type="text" value="" name="month" class="input-text" id="query_date">
                                </p>
                                <input type="hidden" value="0" name="mode" />
                            </form>
                            <button style="display:none;" class="button-orange" id="m-all">月份全部訂單</button> <button style="display:none;" class="button-orange" id="m-deal">月份成交之訂單</button>
                            <br>
                            <br>
                            <table class="table-hover-style block-table img-limit-table text-center">
                                <colgroup>
                                    <col span="1" />
                                    <col span="1" />
                                    <col span="1" />
                                    <col span="1" />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">日期</th>
                                        <th scope="col">訂單筆數</th>
                                        <th scope="col">總交易金額</th>
                                        <th scope="col">淨利統計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $content;?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
