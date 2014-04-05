<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>訂單確認</title>
    <!--[if (lte IE 9)]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
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
                        <input id="index" type="text" placeholder="Search" class="ico-text search-text medium" />
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
                                    <div class="block"><a href="#">銷售列表</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-3" type="checkbox" name="link" class="radio" />
                                <label for="link-3" class="label link-title title-font">設定</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="#">設定</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content" class="ver-large-separate">
                        <h3 class="under-line none-margin-box">訂單確認</h3>
                        <table class="table-hover-style block-table img-limit-table">
                            <colgroup>
                                <col span="1" width="50%" />
                                <col span="1" width="20%"/>
                                <col span="1" width="15%" />
                                <col span="1" width="15%" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">商品名稱</th>
                                    <th scope="col">規格</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">價錢</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $order):?>
                                <tr>
                                    <td><?php echo $order['product_name'];?></td>
                                    <td><?php echo $order['specs'];?></td>
                                    <td><?php echo $order['qty'];?></td>
                                    <td><?php echo $order['price'];?></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right bold big-padding-box">
                                        <span class="pull-left">訂單日期: <?php echo $orders[0]['date'];?></span>
                                        <div class="blcok hor-big-separate">
                                            <span>總數量:<?php echo $orders[0]['total_qty'];?></span>
                                            <span>總金額:<?php echo $orders[0]['total'];?></span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <hr  style="border-bottom: 1px dashed #d0d0d0;" />
                        <div class="ver-medium-separate">
                            <form action="<?php echo base_url('admin/sell/edit_detail_status');?>" method="post">
                                <input type="hidden" name="order-id" value="<?php echo $orders[0]['serial_id'];?>">
                                <dl class="data-list block-d-list pull-left box-half">
                                    <dt>收件人</dt>
                                    <dd><input class="input-text" name="name" type="text" value="<?php echo $orders[0]['name'];?>"></dd>
                                    <dt>E-mail</dt>
                                    <dd><?php echo $orders[0]['email'];?></dd>
                                    <dt>地址</dt>
                                    <dd class="line-break"><input class="input-text" type="text" value="<?php echo $orders[0]['address'];?>" name="address"</dd>
                                    <dt>電話</dt>
                                    <dd><input class="input-text" type="text" value="<?php echo $orders[0]['phone'];?>" name="phone"</dd>
                                    <dt>附註</dt>
                                    <?php if($orders[0]['ps'] == ''):?>
                                    <dd>N/A</dd>
                                    <?php else:?>
                                    <dd><?php echo $orders[0]['ps'];?></dd>
                                    <?php endif;?>
                                    <dt>出貨狀態</dt>
                                    <dd>
                                        <p>未處理 <input class="input-radio" type="radio" name="status" value="0" <?php if($orders[0]['status'] == '0' ):?> checked<?php endif;?>></p>
                                        <p>已收款，待出貨 <input class="input-radio" type="radio" name="status" value="1" <?php if($orders[0]['status'] == '1'):?> checked<?php endif;?>></p>
                                        <p>已出貨 <input class="input-radio" type="radio" name="status" value="2" <?php if($orders[0]['status'] == '2'):?> checked<?php endif;?>></p>
                                        <p>取消訂單 <input class="input-radio" type="radio" name="status" value="-1" <?php if($orders[0]['status'] == '-1'):?> checked<?php endif;?>></p>
                                    </dd>
                                </dl>

                                <span class="pull-left block bold box-half">付款資料</span>
                                <table class="pull-left list-table">
                                    <colgroup>
                                        <col span="1">
                                        <col span="1">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>訂單編號</th>
                                            <td><?php echo $orders[0]['serial_id']; ?></td>
                                        </tr>

                                        <tr>
                                            <th>銀行代碼</th>
                                            <td><?php if($payment) echo $payment[0]['bankCode']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>銀行名稱</th>
                                            <td><?php if($payment) echo $payment[0]['bank']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>轉帳末五碼</th>
                                            <td><?php if($payment) echo $payment[0]['code']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>匯款金額</th>
                                            <td><?php if($payment) echo $payment[0]['cash']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>匯款日期</th>
                                            <td><?php if( $payment && $payment[0]['date'] ){ echo date('Y/m/d-H:i',strtotime($payment[0]['date']) ); }else{ echo '　　　　　　　　　　'; }?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clear text-center ver-large-separate"><button class="data-button">訂單確認</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
</html>
