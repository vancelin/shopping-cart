<!DOCTYPE HTML>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv='refresh' content='<?php echo $setting['second'];?>;url="<?php echo $setting['url'];?>"'>"
        <title>等待跳轉...</title>
        <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    </head>
    <body>
        <div id="main-wrap">
            <table class="block-table float-box toppest stretch-height">
                <colgroup>
                    <col span="1" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="mid">
                            <div id="log" class="white-block-box center-mid">
                                <div id="wait-wrap" class="text-center">
                                    <div class="medium-line-height little-large bold center"><?php echo $setting['words'];?></div>
                                    <img src="<?php echo base_url('public/admin/img/loader.gif');?>" alt="Loading" />
                                    <div class="medium center hor-medium-separate"><span class="inline"><?php echo $setting['second'];?></span>秒後跳轉...</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>