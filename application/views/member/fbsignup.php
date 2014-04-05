    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box ver-medium-separate normal-border-radius">
                    <h2 class="title">Facebook用戶註冊</h2>
                    <div class="confirm-bar">
                        <span class="confirm-done">1.登入Facebook</span>
                        <span class="confirm-present">2.填寫基本資料</span>
                        <span class="confirm-not-yet">3.完成註冊！</span>
                    </div>
                    <h6 class="subtitle">收件人資料填寫</h6>
                    <form action="<?php echo base_url('member/fbsignup');?>" method="post">
                        <table class="data-table td-text-left fill" cellspacing="5">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <?php echo validation_errors(); ?>
                            <tbody>
                                    <tr>
                                        <th>姓名</th>
                                        <td><?php echo $name; ?></td>
                                        <th>聯絡電話 / 手機</th>
                                        <td><input type="tel" class="text-data-input" style="width: 40%;" placeholder="Tel/Mobile" name="phone" value=""/></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <?php echo $email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>地址</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Location" name="address" value=""/>
                                        </td>
                                    </tr>
                        </table>
                        <div class="shopcart-tool text-center block clear">
                            <div class="pull-right"><button title="Checkout" class="next-button">Done</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>
