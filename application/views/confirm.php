    <script>
    $(function(){
        $(".next-button").click(function(){
            $("#wrap-table").show(); 
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box ver-medium-separate normal-border-radius">
                    <h2 class="title">最後確認</h2>
                    <div class="confirm-bar">
                        <span class="confirm-done">1.下單確認</span>
                        <span class="confirm-done">2.遞送資料</span>
                        <span class="confirm-present">3.完成下單</span>
                    </div>
                    <h6 class="subtitle">訂購物品確認</h6>
                    <table class="table-hover-style block-table">
                        <colgroup>
                            <col span="1" width="55%" />
                            <col span="1" width="10%" />
                            <col span="1" width="10%" />
                            <col span="1" width="15%" />
                            <col span="1" width="10%" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>商品名稱</th> <!-- 流水編號  -->
                                <th>單價</th>
                                <th>數量</th>
                                <th>規格</th>
                                <th>金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($detail as $product):?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['price']; ?></td>
                                    <td><?php echo $product['qty']; ?></td>
                                    <?php echo (isset($product['option'])) ? "<td>".$product['option']."</td>" : "<td></td>";?>
                                    <td><?php echo $product['subtotal']; ?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" scope="row" class="text-right">
                                    商品金額: <?php echo $totalPrice; ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <?php echo validation_errors(); ?>
                    <h6 class="subtitle top-space">收件人資料確認</h6>
                    <form action="<?php echo base_url('checkout/check');?>" method="post">
                        <table class="data-table td-text-left fill" cellspacing="5">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>收件人 <input type="hidden" name="name" value="<?php echo $user['name'];?>"></th>
                                    <td><?php echo $user['name'];?></td>
                                    <th>付款方式 / 運費 <input type="hidden" name="charges" value="<?php echo @$user['charges'];?>"></th>
                                    <td><?php echo @$user['charges'];?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><?php echo $user['email'];?></td>
                                </tr>
                                <tr>
                                    <th>聯絡電話 / 手機 <input type="hidden" name="phone" value="<?php echo $user['phone'];?>"></th>
                                    <td colspan="3"><?php echo $user['phone'];?></td>
                                </tr>
                                <tr>
                                    <th>寄送地址 <input type="hidden" name="address" value="<?php echo $user['address'];?>"></th>
                                    <td colspan="3"><?php echo $user['address'];?></td>
                                </tr>
                                <tr>
                                    <th>附註 <input type="hidden" name="ps" value="<?php echo $user['ps'];?>"></th>
                                    <td colspan="3"><?php echo $user['ps'];?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="shopcart-tool text-center block clear">
                            <div class="pull-left"><a href="<?php echo base_url('shop/delivery_info');?>" class="prev-button" alt="Back">Back</a></div>
                            <div class="pull-right"><button title="Done" class="next-button">Done</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>