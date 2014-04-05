    <div id="footer">
        <div id="copyright-tag"><span rel="auther">LVAX</span> © 2013</div>
        <div id="footer-wrap">
            <div class="wrap">
                <div class="pull-left">
                    <div class="hor-small-separate normal">
                        <?php foreach($footer as $link):?>
                        <?php if($link['url_active']):?>
                            <?php if($link['under_site']):?>
                            <span><a target="_blank" href="<?php echo base_url($link['url']);?>"><?php echo $link['title'];?></a></span>
                            <?php else:?>
                            <span><a target="_blank" href="<?php echo $link['url'];?>"><?php echo $link['title'];?></a></span>
                            <?php endif;?>
                        <?php elseif(!$link['url_active'] && $link['content'] != ''):?>
                            <span><a target="_blank" href="<?php echo base_url('home/page/'.$link['id']);?>"><?php echo $link['title'];?></a></span>
                        <?php endif;?>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="pull-right hor-small-separate">
                    <div class="item"><span class="pull-left ico-16-box ico-16-tel"> </span><?php echo $setting[3]['value'];?></div>
                    <div class="item"><span class="pull-left ico-16-box ico-16-mail"> </span><?php echo $setting[2]['value'];?></div>
                </div>
            </div>
        </div>
    </div>
</html>