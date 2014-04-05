        <script>
        $(function(){
            $("button").click(function(){
                $("#wrap-table").show();
                var email = $("#email").val();
                $.post("<?php echo base_url('member/send_reset_pwd');?>",{email:email},function(r){
                    if(r == 1){
                        $("#info").hide();
                        $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                        $("#info").find("#text").text("已將修改密碼通知信寄出！");
                        $("#email").attr("value","");
                    }else{
                        $("#info").hide();
                        $("#info").fadeIn("slow").find("#text").text("查無此Email !");
                    }
                    $("#wrap-table").hide();
                });
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                    <div id="content">
                        <div class="white-block-box normal-border-radius center-mid">
                            <h2 class="title">忘記密碼?</h2>
                            <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                            <table class="data-table td-text-left"  cellspacing="5">
                                <colgroup>
                                    <col span="1" />
                                    <col span="1" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>電子信箱</th>
                                        <td><input id="email" type="text" class="text-data-input" style="width: 60%;" /></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="center-mid"><button  class="data-button little-border-radius medium-padding-box">Send</button></div>
                        </div>
                    </div>
                    <div class="webkit-used-footer-padding"> </div>
                </div>
            </div>
        </div>