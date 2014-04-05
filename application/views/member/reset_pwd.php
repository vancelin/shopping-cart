        <script>
        $(function(){
            $("button").click(function(){
                if($("#pwd").val() != $("#cfm_pwd").val()){
                    $("#info").hide();
                    $("#info").fadeIn("slow").find("#text").text("兩次密碼不符 !");
                }else if($("#pwd").val() == '' || $("#cfm_pwd").val() == ''){
                    $("#info").hide();
                    $("#info").fadeIn("slow").find("#text").text("請勿為空 !");
                }else{
                    $("form").submit();
                }
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                <div id="content">
                    <div class="white-block-box normal-border-radius center-mid">
                        <?php if($status):?>
                            <h2 class="title">重設密碼</h2>
                            <p class="tip-Error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                            <form action="<?php echo base_url('member/reset_pwd');?>" method="post">
                                <table class="data-table td-text-left" cellspacing="5">
                                    <colgroup>
                                            <col span="1" />
                                            <col span="1" />
                                            <col span="1" />
                                            <col span="1" />
                                    </colgroup>
                                    <div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;"></div>
                                    <tbody>
                                        <tr>
                                            <th>新密碼</th>
                                            <td colspan="3">
                                                <input type="password" name="pwd" id="pwd" value="" class="text-data-input" style="width: 40%;" placeholder="新密碼" />
                                                <input type="hidden" name="h" id="h" value="<?php echo $hash;?>" class="reset"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>再次輸入新密碼</th>
                                            <td colspan="3"><input type="password" name="cfm_pwd" id="cfm_pwd" class="text-data-input" style="width: 40%;" placeholder="再次輸入新密碼" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div class="center-mid"><button class="data-button little-border-radius medium-padding-box">更改密碼</button></div>
                        <?php else:?>
                            <p>錯誤!請重新寄送密碼修改信件!</p>
                        <?php endif;?>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>