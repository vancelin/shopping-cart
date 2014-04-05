    <script>
    function chk_charges(){
        if($("#charges").val()!=''){
            $("form").submit();
        }else{
            $("#info").fadeIn("slow").find("#text").text("請選擇付款方式 !");
        }
    }
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box ver-medium-separate normal-border-radius">
                    <h2 class="title">收件人資料</h2>
                    <div class="confirm-bar">
                        <span class="confirm-done">1.下單確認</span>
                        <span class="confirm-present">2.遞送資料</span>
                        <span class="confirm-not-yet">3.完成下單</span>
                    </div>
                    <h6 class="subtitle">收件人資料填寫</h6>
                    <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                    <form action="<?php echo base_url('shop/confirm');?>" method="post">
                        <table class="data-table td-text-left fill" cellspacing="5">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <?php if(isset($user)):?>
                                    <tr>
                                        <th>收件人</th>
                                        <td><input type="text" class="text-data-input" placeholder="Name" name="name" value="<?php echo $user['name'];?>"/></td>
                                        <th>聯絡電話 / 手機</th>
                                        <td><input type="tel" class="text-data-input" style="width: 40%;" placeholder="Tel/Mobile" name="phone" value="<?php echo $user['phone'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <?php echo $user['email'];?>
                                        </td>
                                        <th>付款方式</th>
                                        <td>
                                            <select name="charges" id="charges" class="select-data-input">
                                                <option></option>
                                                <?php 
                                                foreach($payment as $pway){
                                                    echo '<option value="'. $pway['way'] .' - 運費 '.$pway['charges'].'">'.$pway['way'].' - 運費 '.$pway['charges'].'</option>';
                                                };
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>地址</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Location" name="address" value="<?php echo $user['address'];?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>附註</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Ps" name="ps"/>
                                        </td>
                                    </tr>
                                <?php endif;?>
                        </table>
                        <div class="shopcart-tool text-center block clear">
                            <div class="pull-left"><a href="<?php echo base_url('shop/detail');?>" class="prev-button" alt="Back">Back</a></div>
                            <div class="pull-right"><button title="Checkout" class="next-button" onclick="chk_charges();return false;">Done</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>