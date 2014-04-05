        <script>
        $(function(){
            $(".notify").live("click",function(){
                var id = $(this).attr("orderid");
                $("#action").attr("value",1);
                $("#order_id").attr("value",id);
                if(id!=''){
                    $("form").submit();
                }
            });
            $(".cancel").live("click",function(){
                var id = $(this).attr("orderid");
                $("#action").attr("value",0);
                $("form").attr("action","<?php echo base_url('member/save_paymentdetail');?>");
                $("#order_id").attr("value",id);
                if(id!=''){
                    $("form").submit();
                }
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius nav-bar hor-tiny-separate" style="margin-bottom: 10px;">
                        <span><a href="<?php echo base_url('member');?>">會員中心</a></span>
                        <span>訂單查詢</span>
                    </div>
                    <div class="white-block-box normal-border-radius center-mid ver-medium-separate">
                        <h2 class="title">訂單查詢</h2>
                        <?php if($order_status):?>
                        <table class="table-hover-style fill-table line-break" cellspacing="0">
                            <colgroup>
                                    <col span="1" width="5%" />
                                    <col span="1" width="10%" />
                                    <col span="1" width="10%" />
                                    <col span="1" width="45%" />
                                    <col span="1" width="5%" />
                                    <col span="1" width="10%" />
                                    <col span="1" width="15%" />
                            </colgroup>
                            <thead>
                                    <tr>
                                        <th>訂單編號</th>
                                        <th>下單時間</th>
                                        <th>訂單金額</th>
                                        <th>下單商品</th>
                                        <th>商品數量</th>
                                        <th>運送方式</th>
                                        <th>處理狀況</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php echo $order_data;?>
                            </tbody>
                            <tfoot class="text-right">
                                <div class="page-container"><?php echo $links;?></div>
                        </table>
                        <form action="<?php echo base_url('member/paymentdetail');?>" method="post">
                            <input type="hidden" value="1" id="action" name="action"/>
                            <input type="hidden" value="" id="order_id" name="order_id"/>
                        </form>
                        <?php else:?>
                            你還沒有訂單喔 :)
                        <?php endif;?>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>
