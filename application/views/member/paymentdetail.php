        <link rel="stylesheet" href="<?php echo base_url('public/css/custom/jquery-ui-1.9.1.custom.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/css/jquery-ui-timepicker-addon.min.css'); ?>">
        <script type="text/javascript" src="<?php echo base_url('/public/jscripts/jquery/jquery-ui-1.9.1.custom.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('/public/jscripts/jquery/jquery-ui-timepicker-addon.min.js'); ?>"></script>
        <script>
        $(function(){
            full = 0;
            $("button").click(function(){
                $(".input-text").each(function(){
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
                    $("form").submit();
                }
            });
            $.timepicker.regional['zh-TW'] = {
		    timeOnlyTitle: '選擇時分秒',
		    timeText: '時間',
		    hourText: '時',
		    minuteText: '分',
		    secondText: '秒',
		    millisecText: '毫秒',
		    timezoneText: '時區',
		    currentText: '現在時間',
		    closeText: '確定',
		    timeFormat: 'HH:mm',
		    amNames: ['上午', 'AM', 'A'],
		    pmNames: ['下午', 'PM', 'P'],
		    isRTL: false
	    };
	    $.timepicker.setDefaults($.timepicker.regional['zh-TW']);
            $('input[name=paydate]').datetimepicker({
                controlType: 'select',
	        timeFormat: 'HH:mm',
	        defaultValue: '<?php echo date("m/d/Y H:i");?>',
	        altField: "#pDate",
	        altFormat: "yy-mm-dd",
	        altTimeFormat:"HH:mm",
	        altFieldTimeOnly: false,
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                    <div id="content">
                        <div class="white-block-box normal-border-radius center-mid">
                            <h2 class="title">填寫匯款資料</h2>
                            <p class="tip-error" id="info" style="display:none;"><span class="icon" id="tip-status">Error</span><span id="text" class="text"></span></p>
                            <form action="<?php echo base_url('member/save_paymentdetail');?>" method="post">
                                <table class="list-table">
                                    <colgroup>
                                        <col span="1">
                                        <col span="1">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>銀行代碼 : </th>
                                            <td><input type="text" name="bank_code" class="input-text" value=""/></td>
                                            <input type="hidden" value="<?php echo $order_id;?>" name="order_id" />
                                            <input type="hidden" value="1" name="action" />
                                        </tr>
                                        <tr>
                                            <th>銀行名稱 : </th>
                                            <td><input type="text" name="bank_name" class="input-text" value=""/></td>
                                        </tr>
                                        <tr>
                                            <th>轉帳末五碼 : </th>
                                            <td><input type="text" name="last5num" class="input-text" value=""/></td>
                                        </tr>
                                        <tr>
                                            <th>匯款金額 : </th>
                                            <td><input type="text" name="paymoney" class="input-text" value=""/></td>
                                        </tr>
                                        <tr>
                                            <th>匯款日期 : </th>
                                            <td><input type="text" name="paydate" class="input-text" value=""/>
                                            <input type="hidden" id="pDate" name="pDate" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div class="center-mid"><button  class="data-button little-border-radius medium-padding-box">送出</button></div>
                        </div>
                    </div>
                    <div class="webkit-used-footer-padding"> </div>
                </div>
            </div>
        </div>