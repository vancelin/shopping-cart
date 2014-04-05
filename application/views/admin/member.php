<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>會員列表</title>
    <!--[if (lte IE 9)]>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('public/admin/style/ie.css');?>" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/style/template.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssStyle.css');?>">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.qtip-1.0.0-rc3.min.js');?>"></script>
    <script src="<?php echo base_url('public/jscripts/jquery/jquery.infinitescroll.min.js');?>"></script>
    <script>
    $(function(){
        $('.tip').each(function(){
            $(this).qtip({
                content:$(this).attr("tip"), 
                position: {
                    corner: {
                        target: 'topMiddle',
                        tooltip: 'bottomLeft'
                    }
                },
                style: { 
                    name: 'blue'
                }
            });
        });
        $("#content table").infinitescroll({
             loadingImg     : "<?php echo base_url('public/img/ajax-loader.gif');?>",
             navSelector    : "a#next:last",
             nextSelector   : "a#next:last",
             itemSelector   : "#content table tbody tr",
             dataType       : 'html',
             path: function(index) {
                $(".quickshop").click(function(){
                    $.post("<?php echo base_url('shop/add');?>",{action:"quick_shop",product_id:$(this).attr("productid")},function(r){
                        $("#quick-shop-panel").load("<?php echo base_url('shop/quickshop');?>");
                    });
                    $(".tool").slideDown("slow");
                });
                return "<?php echo base_url('admin/member/index/') . '/'; ?>" + (index) ;
             }
        });

    });
    </script>

<script type="text/javascript">
var base = "<?php echo base_url('admin/member/search'); ?>/"

function search(e){
    var text = $('input#index').val(), method = $('select#search').val();
    if( e.keyCode == 13 || text == 0 ) return false;
    $('#content').stop().fadeOut('fast').empty()
           .load( base + text + '/' + method ).fadeIn('slow');
}
</script>

</head>
<body>
    <div id="main-wrap">
        <div class="contain fixed toppest">
            <div id="top">
                <div id="account-info">
                    <div class="hor-small-separate white-space-clear small-font-box">
                        <div class="item"><?php echo $this->session->userdata('manage_logged_in')['username'];?></div>
                        <div class="item"><a href="<?php echo base_url('admin/index/logout');?>">登出</a></div>
                        <div class="item"><a href="<?php echo base_url();?>">回前台</a></div>
                    </div>
                </div>
                <div>
                    <div id="menu" class="hor-medium-separate white-space-clear big-font-box bold">
                        <div class="item"><a href="<?php echo base_url('admin/product/product_list');?>">商品</a></div>
                        <div class="item"><a href="<?php echo base_url('admin/member');?>">會員</a></div>
                        <div class="item"><a href="<?php echo base_url('admin/sell');?>">銷售</a></div>
                        
                        <div class="item"><a href="<?php echo base_url('admin/setting');?>">設定</a></div>
                    </div>
                </div>
            </div>
            <div id="tool-bar" class="white-space-clear">
                <div class="pull-right white-space-clear">
                    <div class="focus-strech-container">
                        <input id="index" type="text" placeholder="Search" class="ico-text search-text medium focus-stretch" onkeyup="javascript:search(event);">
                        <select id="search" class="search-select" onchange="javascript:search(event);">
                            <option value="email">Email</option>
                            <option value="name">姓名</option>
                            <option value="address">地址</option>
                            <option value="phone">電話</option>
                            <option value="id">使用者編號</option>
                            <option value="fbid">fbid</option>
                        </select>
                    </div>
                    <button class="ico-16-container" onclick="javascript:search(event);">
                        <span class="ico-16-box ico-16-search-w"> </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="contain" style="padding-top: 144px;">
            <div id="main">
                <div id="tag-bar" class="block hor-small-separate white-space-clear invisibility">
                    <div class="medium-box"><a href="">test</a></div>
                    <div class="medium-box"><a href="">test</a></div>
                    <div class="medium-box"><a href="">test</a></div>
                </div>
                <div id="main2">
                    <!--[if (lte IE 8)]>
                        <div id="link" class="link-8">
                    <![endif]-->
                    <!--[if (!IE)|(gte IE 9)]><!-->
                        <div id="link">
                    <!--<![endif]-->
                        <div class="block-list slide-container white-space-clear medium-font-box">
                            <!--[if (lte IE 8)]>
                                <div class="block" style="width= 100px;height: 100px;">
                                    <img src="./img/admin-login.png" width="100px" height="100px;" />
                                </div>
                            <![endif]-->
                            <div class="block">
                                <input id="link-1" type="checkbox" name="link" class="radio" />
                                <label for="link-1" class="label link-title title-font">會員管理</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/member');?>">會員列表</a></div>
                                </div>
                            </div>
                            <div class="block">
                                <input id="link-1" type="checkbox" name="link" class="radio" />
                                <label for="link-1" class="label link-title title-font">意見回饋</label>
                                <div class="link-content small-slide">
                                    <div class="block"><a href="<?php echo base_url('admin/member/report');?>">意見回饋</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content">
                        <h3 class="under-line none-margin-box">會員列表</h3>
                        <table class="table-hover-style block-table img-limit-table text-center">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">fbid</th>
                                    <th scope="col">姓名</th>
                                    <th scope="col">性別</th>
                                    <th scope="col" class="tip" tip="點選可查看使用者詳細資料">Email</th>
                                    <th scope="col">上次登入時間</th>
                                    <th scope="col">上次登錄來源</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $result as $user ){ ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['fbid'];?></td>   
                                    <td><?php echo $user['name'];?></td>
                                    <td><?php echo ($user['sex'])? '女':'男';?></td>                                   
                                    <td style="overflow: hidden; text-overflow: ellipsis; -ms-text-overflow: ellipsis;"><?php echo '<a href="'.base_url('admin/member/detail/' . $user['email']) . '">' . $user['email'] . '</a>';?></td>
                                    <td><?php echo date("Y/m/d H:i:s",$user['last_login']); ?></td>
                                    <td><?php echo $user['login_ip']; ?></td>

                                <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                        <a style="display:none;" id="next" href="<?php echo base_url('admin/member/index') . '/' . ($this->uri->segment(4, 0) + 1); ?>">next</a>

                    </div>
                    <div class="clear"> </div>
                </div>
            </div>
        </div>
        <div class="webkit-used-footer-padding clear"> </div>
    </div>
</body>
