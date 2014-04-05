    <script>
    $(document).ready(function(){
        //for photo_silder
        now = 0;
        var count = $(".slide").length;
        $(".item-cover-prev-btn").click(function(){
            if(now != 0 || now >= count){
                var first = $("#slider img:eq("+(now-1)+")").attr("src");
                $(".item-cover img").attr("src",first);
                now = now - 1;
               
            }
        });
        
        $(".item-cover-next-btn").click(function(){
            if(now != (count -1) && now <= count){
                var first = $("#slider img:eq("+(now+1)+")").attr("src");
                $(".item-cover img").attr("src",first);
                now = now + 1;
            }
        });
        
        $(".slide").live("hover",function(){
            $(".item-cover img").attr("src",$(this).find("img").attr("src"));
            now = $(this).attr("id");
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div id="popup-main">
                    <div class="product-top">
                        <table class="block-table">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td style="width: 40%;">
                                        <div class="block item-cover-show white-block-box">
                                            <div class="item-cover">
                                                <img src="<?php echo base_url('public/product_imgs/'.$main_img['img_name']);?>"/>
                                            </div>
                                            <div class="item-cover-slide line-keep">
                                                <button class="item-cover-prev-btn" title="prev">&lt;&lt;</button>
                                                <button class="item-cover-next-btn" title="next">&gt;&gt;</button>
                                                <div class="slide-wrap" id="slider">
                                                    <?php foreach($imgs as $key => $img):?>
                                                        <div class="item slide" id="<?php echo $key;?>"><img src="<?php echo base_url('public/product_imgs/'.$img['img_name']);?>"/></div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                            <div class="clear"> </div>
                                        </div>
                                    </td>
                                    <td style="padding-left: 20px; width: 60%;">
                                        <div class="block item-description white-block-box">
                                            <div class="item-top-flag pink-flag text-left float-box">New</div>
                                            <div class="blcok" style="margin-top: 10px;">
                                                <h2 class="line-break text-left block"><?php echo $product['product_name'];?></h2>
                                                <?php if($product['bargain_price']!='0'):?>
                                                    <?php if(date("Y-m-d",strtotime($product['bargain_to'])) >= date("Y-m-d",strtotime(date("Y-m-d"))))://判斷折價是否過期?>
                                                        <div class="text-left medium pull-left bold" style="color: #F14E32;">特價 : <?php echo $product['bargain_from']." ~ ".$product['bargain_to'];?></div>
                                                    <?php endif;?>
                                                <?php endif;?>
                                                <div class="block text-right small text-muted">上架日期：<?php echo $product['update_time'];?></div>
                                            </div>
                                            <div class="block" style="padding-top: 5px;">
                                                <dl class="inline-d-list">
                                                    <?php
                                                    foreach($attributes as $attribute):
                                                        echo "<dt>".$attribute['attribute_name']."</dt><dd>".$attribute['attribute_value']."</dd>";
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </div>
                                            <div class="block clear">
                                                <div class="pull-left  item-storage">
                                                    <?php if($product['float_unit']!='0'):?>
                                                        <span>庫存量：</span>
                                                        <span class="inner inline-block"><?php echo $product['float_unit'];?></span>
                                                    <?php else:?>
                                                        <span>庫存量：</span>
                                                        <span>Oops,賣完囉!</span>
                                                    <?php endif;?>
                                                </div>
                                                <div class="inline-block pull-right">
                                                    <form action="<?php echo base_url('shop/add');?>" method="post" class="inline-block hor-small-separate">
                                                        <input type="hidden" name="action" value="shop">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['id'];?>">
                                                        <?php if(isset($product_specs[0]['spec_value'])):?>
                                                        <div class="inline-block top pull-left" style="width: 100px; height: 50px;">
                                                            <div class="block clear center-mid ver-small-separate">
                                                                <span class="text-left small block">樣式</span>
                                                                <select name="spec" class="light-box-shadow block text-center fill">
                                                                    <option value="">請選擇</option>
                                                                    <?php foreach($product_specs as $spec):?>
                                                                    <option value="<?php echo $spec['spec_value'];?>"><?php echo $spec['spec_value'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($product['float_unit']!='0'):?>
                                                        <button class="product-tool-button top pull-left" title="加入購物車"><i class="add-shopcart-ico"> </i></button>
                                                        <?php endif;?>
                                                    </form>
                                                    <button class="inline-block top product-tool-button follow" title="追蹤" product_id="<?php echo $product['id'];?>">追蹤</button>
                                                </div>
                                            </div>
                                            <div class="block clear">
                                                <div class="shipping-way pull-left">
                                                    <?php 
                                                    foreach($payments as $payment):
                                                        if($payment['global_active'] && $payment['active']):
                                                            switch($payment['id']){
                                                                case "1":
                                                                    echo '<cite class="ico-32-inPerson" alt="in person" title="商品自取"></cite>';
                                                                    break;
                                                                case "2":
                                                                    echo '<cite class="ico-32-atm" alt="atm" title="ATM轉帳(宅配)"></cite>';
                                                                    break;
                                                                case "3":
                                                                    echo '<cite class="ico-32-ship" alt="ship" title="貨到付款"></cite>';
                                                                    break;
                                                                case "4":
                                                                    echo '<cite class="ico-32-mailSend" alt="mail" title="郵寄"></cite>';
                                                                    break;
                                                                case "5":
                                                                    echo '<cite class="ico-32-mailSend" alt="mail" title="郵寄掛號"></cite>';
                                                                    break;
                                                                case "6":
                                                                    echo '<cite class="ico-32-paypal" alt="paypal" title="paypal"></cite>';
                                                                    break;
                                                                case "7":
                                                                    echo '<cite class="ico-32-visa" alt="visa" title="visa"></cite>
                                                                          <cite class="ico-32-mastercard" alt="mastercard" title="mastercard"></cite>';
                                                                    break;
                                                                case "8":
                                                                    echo '<cite class="ico-32-store" alt="store" title="超商取貨"></cite>';
                                                                    break;
                                                            }
                                                        endif;
                                                    endforeach;
                                                    ?>
                                                </div>
                                                <div class="item-price">
                                                    <div class="cap">NT$</div>
                                                    <?php if($product['bargain_price']!='0'):?>
                                                        <del><?php echo $product['market_price'];?></del>
                                                        <?php if(date("Y-m-d",strtotime($product['bargain_to'])) >= date("Y-m-d",strtotime(date("Y-m-d"))))://判斷折價是否過期?>
                                                            <span><?php echo $product['bargain_price'];?></span>
                                                        <?php else:?>
                                                            <span><?php echo $product['sale_price'];?></span>
                                                        <?php endif;?>
                                                    <?php else:?>
                                                        <del><?php echo $product['market_price'];?></del>
                                                        <span><?php echo $product['sale_price'];?></span>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--<div class="product-footer white-block-box clear">
                        <h6 class="subtitle">相關產品</h6>
                        <div class="item-container text-center">
                            <ul class="plugin-wrap">
                                <li class="item"><a href="javascript: void(0);">
                                        <div class="item-nail center-mid">
                                                <img src="<?php echo base_url('public/product_imgs/noProduct.png');?>" title="see more" />
                                        </div>
                                        <span>testtesttesttesttesttesttesttesttesttesttesttesttesttest</span>
                                </a></li>
                                <li class="item"><a href="javascript: void(0);">1</a></li>
                                <li class="item"><a href="javascript: void(0);">2</a></li>
                                <li class="item"><a href="javascript: void(0);">3</a></li>
                                <li class="item"><a href="javascript: void(0);">4</a></li>
                                <li class="item"><a href="javascript: void(0);">5</a></li>
                                <li class="item"><a href="javascript: void(0);">6</a></li>
                            </ul>
                        </div>
                    </div>-->
                    <div class="product-main white-block-box clear">
                        <?php echo $product['introduction'];?>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>
    </div>