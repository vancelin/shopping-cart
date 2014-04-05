<?php if( empty( $products ) )header("HTTP/1.1 404 Not Found"); ?>
    <script type="text/javascript">
    $(function(){
        $("#item_content").infinitescroll({
             loadingImg     : "<?php echo base_url('public/img/ajax-loader.gif');?>",
             navSelector    : "a#next:last",
             nextSelector   : "a#next:last",
             itemSelector   : "div#item_content div.item",
             dataType       : 'html',
             path: function(index) {
                $(".quickshop").click(function(){
                    $.post("<?php echo base_url('shop/add');?>",{action:"quick_shop",product_id:$(this).attr("productid")},function(r){
                        $("#quick-shop-panel").load("<?php echo base_url('shop/quickshop');?>");
                    });
                    $(".tool").slideDown("slow");
                });
                return "<?php echo base_url('home/index'); ?>/" + (index-1) + "/" + "<?php echo $this->uri->segment(4, 0);?>";
             }
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div id="scroll">
                    <div id="item_content" class="wrap white-space-clear">
                        <?php foreach($products as $key => $product):?>
                            <div class="item">
                                <table class="filled-table tool-bar">
                                    <tbody>
                                        <tr>
                                            <?php if($product['float_unit']!='0'):?>
                                            <td><button productid="<?php echo $product['id'];?>" class="quickshop">加入</button></td>
                                            <?php else:?>
                                            <td><button>售完</button></td>
                                            <?php endif;?>
                                            <td><button productid="<?php echo $product['id'];?>" class="follow">追蹤</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?php echo base_url('home/product/'.$product['id']);?>" target="_blank" alt="See More ...">
                                    <?php if($product['bargain_price']!='0'):?>
                                    <div class="item-top-flag orange-flag">特價</div>
                                    <?php elseif($product['recommend']):?>
                                    <div class="item-top-flag purple-flag">推薦</div>
                                    <?php else:?>
                                    <div class="item-top-flag gray-flag"></div>
                                    <?php endif;?>
                                    <div class="item-title">
                                        <h5 class="light-brown-box"><?php echo $product['product_name'];?></h5>
                                        <h6 class="item-storage">
                                            <div class="cap">剩餘數量:</div><?php echo $product['float_unit'];?>
                                        </h6>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-nail" productid="<?php echo $product['id'];?>">
                                            <img src="<?php echo base_url('public/product_imgs/'.$product['img_name']);?>" title="<?php echo $product['product_name'];?>" />
                                        </div>
                                        <?php if($product['bargain_price']!='0'):?>
                                            <?php if(date("Y-m-d",strtotime($product['bargain_from'])) <= date("Y-m-d",strtotime(date("Y-m-d"))) && date("Y-m-d",strtotime($product['bargain_to'])) >= date("Y-m-d",strtotime(date("Y-m-d"))))://判斷特價是否過期?>
                                                <div class="item-sale-date">
                                                    <?php echo $product['bargain_from'] ."~". $product['bargain_to'];?>
                                                </div>
                                                <div class="item-price">
                                                    <div class="cap">NT$</div><?php echo $product['bargain_price'];?>
                                                </div>
                                                <div class="item-bottom-flag red-flag">
                                                    <?php $price = ($product['bargain_price'] / $product['market_price']) * 10; $price = round($price,1); echo number_format($price, 1, '.', '')."折";?>
                                                </div>
                                            <?php else:?>
                                                <div class="item-sale-date" style="visibility: hidden;"></div>
                                                <div class="item-price">
                                                    <div class="cap">NT$</div><?php echo $product['sale_price'];?>
                                                </div>
                                                <div class="item-bottom-flag red-flag" style="visibility: hidden;"></div>
                                            <?php endif;?>
                                        <?php else:?>
                                            <div class="item-sale-date" style="visibility: hidden;"></div>
                                            <div class="item-price">
                                                <div class="cap">NT$</div><?php echo $product['sale_price'];?>
                                            </div>
                                            <div class="item-bottom-flag red-flag" style="visibility: hidden;"></div>
                                        <?php endif;?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach;?>
                        <a id="next" href="<?php echo base_url('home/index') . '/' . ($this->uri->segment(3, 0) + 1) . '/' . $this->uri->segment(4, 0); ?>">next</a>
                    </div>
                </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>
    </div>
