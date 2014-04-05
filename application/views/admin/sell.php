<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>最新訂單{elapsed_time}</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script type="text/javascript">
    var base = "<?php echo base_url('admin/sell/search'); ?>/"

    function search(e){
        var text = $('input#index').val(), method = $('select#search').val();
        if( e.keyCode == 13 || text == 0 ) return false;
        $('#content').stop().fadeOut('fast').empty()
               .load( base + text + '/' + method ).fadeIn('slow');
    }
    </script>

    <script type="text/javascript">
    $(function(){
        $('.tip').each(function(){
            $(this).qtip({
                content:$(this).attr("tip"), 
                position: {
                    corner: {
                        target: 'topMiddle',
                        tooltip: 'bottomLeft'
                    }
                },
                style: { 
                    name: 'blue'
                }
            });
        });
        $(".product_list").hover(function(){
            var serial_id = $(this).attr("rel");
            var next_div = $(this).next().children();
            $.post("<?php echo base_url('admin/sell/show_detail_product');?>",{serial_id:serial_id},function(r){
                $(next_div).find("tbody").html(r);
            });
            $(this).next().fadeIn();
        },function(){
            $(this).next().fadeOut();
        });
        $(".detail").hover(function(){
            $(this).next().fadeIn();
        },function(){
            $(this).next().fadeOut();
        });
        $(".status").dblclick(function(){
            var serial_id = $(this).next().text();
            var status = ($(this).text() == '未處理' || $(this).text() == '待處理') ? 2:0;
            $.post("<?php echo base_url('admin/sell/edit_status');?>",{serial_id:serial_id,status:status},function(r){
                if(r){
                    $(select).css("color","#4E443C").text('已出貨');
                    $(select).removeClass("status");
                }else{
                    $(select).css("color","#F14E32").text('未處理');
                }
            });
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
                <div class="pull-right white-space-clear">
                    <div class="focus-strech-container">
                        <input id="index" type="text" placeholder="Search" class="ico-text search-text medium focus-stretch" onkeyup="javascript:search(event);">
                        <select id="search" class="search-select" onchange="javascript:search(event);">
                            <option value="serial_id">訂單編號</option>
                            <option value="email">買家Email</option>
                            <option value="name">買家姓名</option>
                            <option value="phone">買家電話號碼</option>
                            <option value="address">買家寄送地址</option>
                        </select>
                    </div>
                    <button class="ico-16-container" onclick="javascript:search(event);">
                        <span class="ico-16-box ico-16-search-w"> </span>
                    </button>
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
                        <h3 class="under-line none-margin-box">最新訂單(3天內)</h3>
                        <table class="table-hover-style block-table img-limit-table text-center">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col" class="tip" tip="點選下方可快速修改訂單狀態">出貨狀態</th>
                                    <th scope="col">訂單編號</th>
                                    <th scope="col" class="tip" tip="點選下方可瀏覽此用戶所有訂單">用戶</th>
                                    <th scope="col" class="tip" tip="將滑鼠移動到下方可快速瀏覽此訂單商品內容">商品</th>
                                    <th scope="col" class="tip" tip="將滑鼠移動到下方可快速瀏覽此訂單用戶資料">詳細資料</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">總價</th>
                                    <th scope="col">訂單時間</th>
                                    <th scope="col">付款方式</th>
                                    <th scope="col">附註</th>
                                    <th scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $order):?>
                                    <tr>
                                        <?php if($order['status'] == 1):?>
                                        <td class="status tip" tip="點選此處可快速編輯訂單狀態">待處理</td>
                                        <?php elseif($order['status'] == 0):?>
                                        <td class="status tip" tip="點選此處可快速編輯訂單狀態" style="color: #F14E32;">未處理</td>
                                        <?php elseif($order['status'] == -1):?>
                                        <td class="tip" tip="僅可快速修改已處理或未處理訂單" style="color: #F14E32;">取消訂單</td>
                                        <?php elseif($order['status'] == 2):?>
                                        <td class="tip" tip="僅可快速修改已處理或未處理訂單">已出貨</td>
                                        <?php endif;?>
                                        <td><?php echo $order['serial_id'];?></td>
                                        <td><?php echo '<a href="'.base_url('admin/member/detail/' . $order['email']) . '">' . $order['email'] . '</a>';?></td>
                                        <td>
                                            <a href="javascript: void(0)" class="product_list" rel="<?php echo $order['serial_id'];?>">...</a>
                                            <div class="item-popup-container" style="width:800px;hieght:auto; display:none;">
                                                <table class="item-popup">
                                                    <colgroup>
                                                        <col span="1" width="50%" />
                                                        <col span="1" width="20%" />
                                                        <col span="1" width="15%" />
                                                        <col span="1" width="15%" />
                                                    </colgroup>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript: void(0)" class="detail">...</a>
                                            <div class="item-popup-container" style="width:800px;hieght:auto; display:none;">
                                                <table class="item-popup">
                                                    <colgroup>
                                                        <col span="1" width="15%" />
                                                        <col span="1" width="50%" />
                                                        <col span="1" width="35%" />
                                                    </colgroup>
                                                    <tbody>
                                                        <tr>
                                                            <th>收件人</th>
                                                            <th>地址</th>
                                                            <th>電話</th>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $order['name'];?></td>
                                                            <td><?php echo $order['address'];?></td>
                                                            <td><?php echo $order['phone'];?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                        <td><?php echo $order['qty'];?></td>
                                        <td><?php echo $order['total'];?></td>
                                        <td><?php echo $order['date'];?></td>
                                        <td><?php echo $order['pway'];?></td>
                                        <td><?php echo $order['ps'];?></td>
                                        <td>
                                            <a href="<?php echo base_url('admin/member/detail/' . $order['email']);?>"><img src="<?php echo base_url('public/admin/img/user.png')?>"></a>|
                                            <a href="<?php echo base_url('admin/sell/edit_order/' . $order['serial_id']); ?>"><img src="<?php echo base_url('public/admin/img/edit.png'); ?>" /></a> | 
                                            <a class="delete" href="#" url="<?php echo base_url('admin/sell/del_order/' . $order['serial_id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
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
