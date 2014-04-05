<?php
    include_once dirname(__FILE__) . "/facebook.php";

$fbconfig['appid' ]     = "447388551980265";
$fbconfig['secret']     = "5a0343fff08b774f78f405f264d99815";
$fbconfig['baseurl']    = "http://localhost/sc/member/fbsession";

$facebook = new Facebook(
    array(
        'appId'  => $fbconfig['appid'],
        'secret' => $fbconfig['secret'],
        'cookie' => true,
    )
);

    $fbme = null;

    $uid = $facebook->getUser();

    if ($uid){
        try{
            $fbme = $facebook->api('/me');
        } catch (FacebookApiException $e){
        }
    }
    $loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,user_about_me',
                'redirect_uri'  => $fbconfig['baseurl']
            )
    );


    /**
    $user = $facebook->getUser();

    $loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,user_about_me',
                'redirect_uri'  => $fbconfig['baseurl']
            )
    );
    
    $logoutUrl  = $facebook->getLogoutUrl();
    **/

?>
