	<script>
        $(function(){
            $("button").click(function(){
                var pwd = $("input[name='password']").val();
                var newpw = $("input[name='newpw']").val();
                var repw = $("input[name='repw']").val();
                
                if(pwd == ''){
                    $("#info").hide();
                    $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                    $("#info").fadeIn("slow").find("#text").text("請輸入密碼!");
                }else if(newpw != repw){
                    $("#info").hide();
                    $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                    $("#info").fadeIn("slow").find("#text").text("兩次密碼不同!");
                }else if($.trim(newpw).length<6){
                    $("#info").hide();
                    $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                    $("#info").fadeIn("slow").find("#text").text("密碼請大於六位數!");
                }else{
                    $.post("<?php echo base_url('member/editpass');?>",{pwd:pwd,newpw:newpw,repw:repw},function(r){
                        if(r == 0){
                            $("#info").hide();
                            $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                            $("#info").fadeIn("slow").find("#text").text("密碼不對!");
                        }else if(r == 1){
                            $("#info").hide();
                            $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                            $("#info").fadeIn("slow").find("#text").text("兩次密碼不同!");
                        }else if(r == 2){
                            $("#info").hide();
                            $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                            $("#info").fadeIn("slow").find("#text").text("修改成功!");
                        }else{
                            $("#info").hide();
                            $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-status").text("Error");
                            $("#info").fadeIn("slow").find("#text").text("未知原因修改失敗");
                        }
                    });
                }
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius nav-bar hor-tiny-separate" style="margin-bottom: 10px;">
                        <span><a href="<?php echo base_url('member') ?>">會員中心</a></span>>
                        <span>修改密碼</span>
                    </div>
                    <div class="white-block-box normal-border-radius center-mid">
                        <h2 class="title">修改密碼</h2>
                        <p class="tip-Success" id="info" style="display:none;"><span class="icon" id="tip-status">Success</span><span id="text" class="text"></span></p>
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
                                            <th>舊密碼</th>
                                            <td colspan="3"><input type="password" name="password" class="text-data-input" style="width: 40%;" placeholder="舊密碼" /></td>
                                    </tr>
                                    <tr>
                                            <th>新密碼</th>
                                            <td colspan="3"><input type="password" name="newpw" class="text-data-input" style="width: 40%;" placeholder="新密碼" /></td>
                                    </tr>
                                    <tr>
                                            <th>再次輸入新密碼</th>
                                            <td colspan="3"><input type="password" name="repw" class="text-data-input" style="width: 40%;" placeholder="再次輸入新密碼" /></td>
                                    </tr>
                            </tbody>
                        </table>
                        <div class="center-mid"><button class="data-button little-border-radius medium-padding-box">更改密碼</button></div>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
	</div>
