        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius nav-bar hor-tiny-separate" style="margin-bottom: 10px;">
                        <span><a href="<?php echo base_url('member');?>">會員中心</a></span>>
                        <span>意見回饋</span>
                    </div>
                    <div class="white-block-box normal-border-radius center-mid ver-medium-separate">
                        <h2 class="title">意見回饋</h2>
                        <form action="<?php echo base_url('report/yes');?>" method="post">
                            <table class="data-table td-text-left fill"  cellspacing="5">
                                <colgroup>
                                        <col span="1" />
                                        <col span="1" />
                                        <col span="1" />
                                        <col span="1" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <?php if(@$account):?>
                                            <th>姓名</th>
                                            <td><?php echo $user['name'];?></td>
                                            <th>通知信箱</th>
                                            <td><?php echo $user['email'];?></td>
                                        <?php else:?>
                                            <th>姓名</th>
                                            <td><input type="text" class="text-data-input" style="width: 60%;" value="" name="name"/></td>
                                            <th>通知信箱</th>
                                            <td><input type="text" class="text-data-input" style="width: 60%;" value="" name="email"/></td>
                                        <?php endif;?>
                                    </tr>
                                    <tr>
                                        <th>主旨</th>
                                        <td colspan="3">
                                            <input type="text" class="text-data-input" style="width: 60%;" value="" name="subject"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">內容</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><textarea class="textarea-data-input" name="sug"></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="center-mid"><button  class="data-button little-border-radius medium-padding-box">Send</button></div>
                        </form>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>