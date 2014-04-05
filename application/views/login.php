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
    <title>Login</title>
    <!--[if lte IE 9]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/template.css');?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/css/cssStyle.css');?>" />
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
                        <div id="log">
                            <div id="loginform" class="text-center">
                                <form action="<?php echo base_url('admin/index/validate_credentials');?>" method="post">
                                    <div class="wrap">
                                        <label for="email">Account</label>
                                        <input id="email" type="text" name="username"/>
                                    </div>
                                    <div class="wrap">
                                        <label for="psw">Password</label>
                                        <input id="psw" type="password" name="password"/>
                                    </div>
                                    <div class="block">
                                        <label for="vcode"><img src="<?php echo base_url('home/keycik');?>" /></label>
                                        <input id="vcode" type="text" name="Checknum"/>
                                    </div>
                                    <div>
                                        <button class="login-button">Login</button>
                                    </div>
                                    <div class="clear"> </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
