	<div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius">
                        <h2 class="title" style="margin-bottom: -25px;">Acc Center</h2>
                        <div class="block large-padding-box slide-container white-space-clear medium-font-box ver-medium-separate">
                            <?php if(!$status):?>
                                <p class="tip-error" id="info"><span class="icon" id="tip-error">Error</span><span id="text" class="text">尚未驗證帳號,將無法使用<結帳>以及部分功能，請盡速至信箱驗證</span></p>
                            <?php endif;?>
                            <div class="pull-left ver-medium-separate box-half">
                                <div class="light-box-shadow little_big-border-radius" style="border: 1px solid #EEE4D9;">
                                    <h3 class="yellow-box small-margin-box little_big-border-radius light-box-shadow">會員資料</h3>
                                    <dl class="acc-info block wrap block-d-list none-margin-box">
                                        <dt>會員編號</dt>
                                        <dd><?php echo $account['id']; ?></dd>
                                        <dt>會員名稱</dt>
                                        <dd><?php echo $account['name']; ?></dd>
                                        <dt>性別</dt>
                                        <dd><?php echo $account['sex'] ? '小姐' : '先生' ; ?></dd>
                                        <dt>上次登入時間/來源</dt>
                                        <dd><?php echo ($account['lstlogin']!='') ? date('Y-m-d H:i:s',$account['lstlogin']) . ' [' . $account['lstip'].']' : "尚未登入過"?></dd>
                                        <dt>寄件地址</dt>
                                        <dd><?php echo $account['address']; ?></dd>
                                        <dt>連絡電話</dt>
                                        <dd><?php echo $account['phone']; ?></dd>
                                    </dl>
                                    <div style="padding: 0 10px 10px 10px;">
                                        <div class="box-success little-border-radius small-padding-box inline-block box-half"><span class="text-success">總共訂單數： <?php echo $orders; ?></span></div>
                                        <div class="box-warning little-border-radius small-padding-box inline-block box-half"><span class="text-warning">未完成訂單數： <?php echo $pre_orders; ?></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right box-half">
                                <div class="light-box-shadow little_big-border-radius">
                                    <h3 class="yellow-box acc-control">會員資料</h3>
                                    <div class="block ver-small-separate">
                                        <div class="item"><a href="<?php echo base_url('member/data') ?>" class="inline-block">修改個人資料</a></div>
                                        <div class="item"><a href="<?php echo base_url('member/pass') ?>" class="inline-block">修改密碼</a></div>
                                    </div>
                                </div>
                                <div class="light-box-shadow little_big-border-radius">
                                    <h3 class="yellow-box acc-control">Service</h3>
                                    <div class="block ver-small-separate">
                                        <div class="item"><?php echo ($status) ? '<a href="'.base_url("member/orders").'" class="inline-block">訂單查詢</a>':'訂單查詢';?></div>
                                        <div class="item"><?php echo ($status) ? '<a href="'.base_url('member/urfollow').'" class="inline-block">追蹤清單</a>':'追蹤清單';?></div>
                                        <div class="item"><a href="<?php echo base_url('report') ?>" class="inline-block">意見回饋</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="block clear top-line big-padding-box"><a href="<?php echo base_url('member/logout') ?>"><button class="button">登出</button></a></div>
                        </div>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
	</div>
	
