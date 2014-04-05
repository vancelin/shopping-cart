<!DOCTYPE HTML>
<html class="no-js">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=9">
            <title>訂單成立通知信</title>
            <style>
                    body {
                            background-color: #FFF;
                    }
                    #template-wrap {
                            margin: 0 auto;
                            border: 2px dashed #E0E0E0;
                            width: 780px;
                            height: auto;
                            background-color: #FFF;
                    }
            </style>
    </head>
    <body>
        <div id="template-wrap">
            <div id="wrap" style="margin: 10px 2%; border: 1px solid #44372B; padding: 0; width: 96%; background-color: #FFF; font-style: 14px; line-height: 20px;letter-spacing: 0;">
                <a id="header" href="<?php echo base_url();?>" style="vertical-align: top; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;-webkit-background-clip: border-box;-moz-background-clip: border-box;background-clip: border-box;" >
                    <div style="margin: 0; border-bottom: 3px double #FFF; padding: 0; background-color: #F0EADE;">
                        <a href="<?php echo base_url();?>"><img src="#logo#" height="45" style="margin: 5px 0 5px 15px; border: 0; vertical-align: middle;" /></a>
                    </div>
                </a>
                <div id="body" style="clear: both; margin: 5px 2%; width: 96%; padding: 1%; color: #4E443C; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;">
                    <p style="font-style: 14px; color: #B0B0B0;">此信件為系統發出信件，請勿直接回覆，感謝您的配合。謝謝！</p>
                    <p>親愛的會員您好：</br>關於您訂購下列商品之需求，我們已收到且確認成立，其內容如下：</p>
                    <table style="margin: 5px 5%; border-top: 1px solid #E0E0E0; border-bottom: 1px solid #E0E0E0; width: 90%; table-layout: fixed; border-collapse: collapse; text-align: center; vertical-align: middle;">
                        <colgroup>
                            <col span="1" width="60%" />
                            <col span="1" width="20%" />
                            <col span="1" width="20%" />
                        </colgroup>
                        <thead>
                            <tr style="border-bottom: 3px double #E0E0E0; background-color: #E39A4B; color: #62170A;">
                                <th style="border-right: 1px dashed #E0E0E0; padding: 5px 0; font-weight: bold;">商品名稱</th>
                                <th style="border-left: 1px dashed #E0E0E0; border-right: 1px dashed #E0E0E0; padding: 5px 0; font-weight: bold;">商品數量</th>
                                <th style="border-left: 1px dashed #E0E0E0; border-right: 1px dashed #E0E0E0; padding: 5px 0; font-weight: bold;">商品價錢</th>
                            </tr>
                        </thead>
                        <tbody>
                            #content#
                        </tbody>
                        <tfoot>
                            <tr style="text-align: right; color: #FF3C3C; text-shadow: 1px 1px 1px #CCC;">
                                <td colspan="6">總價：<span style="display: inline;font-weight: bold;">#total#</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <p style="clear:both;padding:5px;margin:0 2%;width:96%;">
                    買家給你的話：
                    <span style="display: block;">#something_to_you#</span>
                </p>
                <div id="footer" style="clear: both; margin: 0 2%; border-top: 1px solid #E0E0E0; padding: 5px 1%; width: 96%; font-style: 14px; color: #B0B0B0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;">
                    <p>運送方式及運費：<span style="color: #FF3C3C;">#payment#</span></p>
                </div>
                <div style="clear: both; border-top: 3px double #FFF; padding: 5px 1%; display: block; width: 100%; color: #999; background-color: #F0EADE; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;">R.D. © 2013</div>
            </div>
    </body>
</html>