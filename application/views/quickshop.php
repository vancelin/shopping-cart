<?php if($this->cart->contents()):?>

    <script>
    $(".delete").click(function(){
        $.post("<?php echo base_url('shop/del');?>",{action:"del_product",rowid:$(this).attr("rowid")},function(){
            $("#quick-shop-panel").load("<?php echo base_url('shop/quickshop');?>");
        });
    });
    </script>
    <span id="shopcart-quick-amount" class="word-keep">
        <span class="cap small text-left">Total (NT$)</span>
        <span class="text"><?php echo $this->cart->total();?></span>
    </span>
    <div id="shopcart-quick">
        <?php foreach($contents as $key => $content):?>
            <div class="item">
                <a href="<?php echo base_url('home/product/'.$content['id']);?>" class="thumnail"><img src="<?php echo base_url('public/product_imgs/'.$imgs[$key]['img_name']);?>" title="<?php echo $content['name'];?>" /></a>
                <a class="delete" rowid="<?php echo $content['rowid'];?>">X</a>
            </div>
        <?php endforeach;?>
    </div>
    
<?php else:?>
    
    <p>Oops，目前購物車是空的喔!</p>
    
<?php endif;?>

    
    


