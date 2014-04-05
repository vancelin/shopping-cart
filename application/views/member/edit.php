        <script>
        $(function(){
            $("button").click(function(){
                var email = $("input[name=email]").val();
                var name = $("input[name=name]").val();
                var phone = $("input[name=phone]").val();
                var address = $("input[name=address]").val();
                var sex = $("input[name=gender]:checked").val();
                $("#wrap-table").show();
                $.post("<?php echo base_url('member/edit');?>",{email:email,name:name,phone:phone,address:address,sex:sex},function(r){
                    $("#wrap-table").hide();
                    if(r == 1){
                        $("#info").hide();
                        $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                        $("#info").find("#text").text("修改成功，若有修改Email，請重新驗證!");
                    }else if(r == 0){
                        $("#info").hide();
                        $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                        $("#info").fadeIn("slow").find("#text").text("出錯了，請通知維護人員!");
                    }else if(r == 2){
                        $("#info").hide();
                        $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                        $("#info").fadeIn("slow").find("#text").text("6小時內您無法再修改信箱及驗證");
                    }else{
                        alert(r);
                    }
                });
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius nav-bar hor-tiny-separate" style="margin-bottom: 10px;">
                        <span><a href="<?php echo base_url('member');?>">會員中心</a></span>
                        <span>個人資料</span>
                    </div>
                    <div class="white-block-box normal-border-radius center-mid">
                        <h2 class="title">個人資料</h2>
                        <h4 class="subtitle">修改個人資料</h4>
                        <p class="tip-Success" id="info" style="display:none;"><span class="icon" id="tip-status">Success</span><span id="text" class="text"></span></p>
                        <table class="data-table td-text-left" cellspacing="5">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>收件人姓名</th>
                                    <td><input type="text" class="text-data-input" name="name" placeholder="Name" value="<?php echo $account['name'];?>"/></td>
                                    <th>性別</th>
                                    <td class="hor-medium-separate">
                                        <?php if(!$account['sex']):?>
                                            <div class="inline">
                                                <input id="male" class="radio-input" name="gender" type="radio" checked value="1"/>
                                                <label for="male" class="check-label">先生</label>
                                            </div>
                                            <div class="inline">
                                                <input id="female" class="radio-input" name="gender" type="radio" value="0"/>
                                                <label for="female" class="check-label">小姐</label>
                                            </div>
                                        <?php else:?>
                                            <div class="inline">
                                                <input id="male" class="radio-input" name="gender" type="radio" value="1"/>
                                                <label for="male" class="check-label">先生</label>
                                            </div>
                                            <div class="inline">
                                                <input id="female" class="radio-input" name="gender" type="radio" checked value="0"/>
                                                <label for="female" class="check-label">小姐</label>
                                            </div>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3">
                                        <input type="email" class="text-data-input" name="email" style="width: 60%;" placeholder="Email" value="<?php echo $account['email'];?>"/>
                                        <span class="data-description">修改需重新驗證</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>連絡電話</th>
                                    <td colspan="3"><input type="tel" class="text-data-input" name="phone" style="width: 40%;" placeholder="Tel/Mobile" value="<?php echo $account['phone'];?>"/></td>
                                </tr>
                                <tr>
                                    <th>收件地址</th>
                                    <td colspan="3"><input type="text" class="text-data-input" name="address" style="width: 40%;"  value="<?php echo $account['address'];?>"/></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="center-mid"><button class="data-button little-border-radius medium-padding-box">更改</button></div>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>
