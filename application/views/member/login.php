    <script>
    $(function(){
        full = 0;
        $("#sign-email").change(function(){
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(filter.test($(this).val())){
                $.post("<?php echo base_url('member/exist');?>",{email:$(this).val()},function(r){
                    if(r == 1){
                        $("#info").hide();
                        $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                        $("#info").fadeIn("slow").find("#text").text("此Email已被註冊!");
                    }else if(r == 0){
                        $("#info").hide();
                        $("#info").attr("class","tip-success").fadeIn("slow").find("#tip-status").text("Success");
                        $("#info").find("#text").text("此Email可以註冊");
                    }
                });
            }else{
                $("#info").hide();
                $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                $("#info").fadeIn("slow").find("#text").text("請填寫正確Email格式!");
            }
        });
        $("#sign-psd").blur(function(){
            if($.trim($(this).val()).length<6){
                $("#info").hide();
                $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                $("#info").fadeIn("slow").find("#text").text("密碼最少六位數");
            }else{
                $("#sign-dbpsd").blur(function(){
                    if($("#sign-dbpsd").val()!=$("#sign-psd").val()){
                        $("#info").hide();
                        $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                        $("#info").fadeIn("slow").find("#text").text("兩次密碼不符!");
                    }else if($.trim($(this).val()).length<6){
                        $("#info").hide();
                        $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                        $("#info").fadeIn("slow").find("#text").text("密碼最少六位");
                    }else{
                        $("#info").hide();
                    }
                });
            }
        });
        $("#sign-tel").blur(function(){
            if($.trim($(this).val()).length>10){
                $("#info").hide();
                $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                $("#info").fadeIn("slow").find("#text").text("電話請勿超過10位數");
            }
        });
        $("#register").click(function(){
            $(".register_class").each(function(){
                if($(this).val()==''){
                    $("#info").hide();
                    $("#info").attr("class","tip-error").fadeIn("slow").find("#tip-error").text("Error");
                    $("#info").fadeIn("slow").find("#text").text("請填滿欄位");
                    full = 0;
                    return false;
                }else{
                    full = 1;
                }
            });
            if(full == 1){
                $("#wrap-table").show();
                $("form").submit();
            }
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box">
                    <table class="filled-table">
                        <colgroup>
                                <col span="1" />
                                <col span="1" />
                        </colgroup>
                        <tbody style="border-collapse: collapse;">
                            <tr>
                                <td id="login" class="ver-big-separate">
                                    <h2>登入</h2>
                                    <!-- <form action="" class="medium-padding-box ver-big-separate"> -->
                                        <?php echo form_open('member/login', array('class' => 'medium-padding-box ver-big-separate' ) ); ?>
                                            <section class="block">
                                                <label for="log-email" class="block text-left">E-mail</label>
                                                <input id="log-email" type="email" name="email" class="text-input" placeholder="Email" />
                                            </section>
                                            <section class="block">
                                                <label for="log-psd" class="block text-left">密碼</label>
                                                <input id="log-psd" type="password" name="password" class="text-input" placeholder="Password" />
                                            </section>
                                            <section class="block hor-medium-separate text-center">
                                                <button>Login</button>
                                                <button onclick="javascript:location.href='<?php echo base_url('member/fbsession'); ?>';return false;">FB Login</button>
                                                <button onclick="javascript:location.href='<?php echo base_url('member/reset'); ?>';return false;">忘記密碼</button>
                                            </section>
                                    </form>
                            </td>
                            <td id="signin">
                                    <h2>註冊</h2>
                                    <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                                    <!-- <form action="" class="medium-padding-box ver-big-separate"> -->
                                    <?php echo form_open('member/register', array('class' => 'medium-padding-box ver-big-separate') ); ?>
                                        <section class="block">
                                                <label for="sign-email" class="block text-left">E-mail</label>
                                                <input id="sign-email" type="email" class="text-input register_class" placeholder="Email" name="email" />
                                        </section>
                                        <section class="block">
                                                <label for="sign-psd" class="block text-left">密碼</label>
                                                <input id="sign-psd" type="password" class="text-input register_class" placeholder="密碼" name="password" />
                                        </section>
                                        <section class="block">
                                                <label for="sign-dbpsd" class="block text-left">再次輸入密碼</label>
                                                <input id="sign-dbpsd" type="password" class="text-input register_class" placeholder="再次輸入密碼" name="repassword" />
                                        </section>
                                        <section class="block">
                                                <label for="sign-name" class="block text-left">收件人姓名</label>
                                                <input id="sign-name" type="text" class="text-input register_class" placeholder="收件人姓名" name="name" />
                                        </section>
                                        <section class="block">
                                                <label for="sign-tel" class="block text-left">電話</label>
                                                <input id="sign-tel" type="tel" class="text-input register_class" placeholder="電話" name="phone" />
                                        </section>
                                        <section class="block">
                                                <label for="sign-address" class="block text-left">地址</label>
                                                <input id="sign-address" type="text" class="text-input register_class" placeholder="地址" name="address" />
                                        </section>
                                        <section class="block">
                                                <span class="more-right-dis">性別</span>
                                                <input id="sign-sub-yes" type="radio" class="radio-input" name="sex" value="1" />
                                                <label for="sign-sub-yes" class="check-label text-left">男</label>
                                                <input id="sign-sub-no" type="radio" class="radio-input"  name="sex" value="0" />
                                                <label for="sign-sub-no" class="check-label text-left">女</label>
                                        </section>

                                        <!--<section class="block">
                                                <span class="more-right-dis">Subscript?</span>
                                                <input name="sub" id="sign-sub-yes" type="radio" class="radio-input" />
                                                <label for="sign-sub-yes" class="check-label text-left">Yes</label>
                                                <input name="sub" id="sign-sub-no" type="radio" class="radio-input" />
                                                <label for="sign-sub-no" class="check-label text-left">No</label>
                                        </section>-->
                                    </form>
                                    <section class="block hor-medium-separate text-center">
                                        <button id="register">註冊</button>
                                    </section>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>