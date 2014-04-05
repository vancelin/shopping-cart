    <script>
    $(document).ready(function() {
        $(".quantity").change(function(){
            var rowid = $(this).attr("rowid");
            var val = $(this).val();
            var total = $(this).parent().prev().prev().text();
            if(parseInt(val) > parseInt(total)){
                alert('哎呀,貨不夠了,可能要調整一下購買數量噢');
                $(this).attr("value","1");
            }else{
                $.post("<?php echo base_url('shop/update');?>",{rowid:rowid,val:val},function(){
                    location.reload();
                });
            }
            
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box ver-medium-separate normal-border-radius">
                    <?php $count = $this->cart->total_items(); ?>

                    <?php if($count <= 0 ): ?>
                        <div class="shopcart-empty">購物清單是空的喔！</div>
                    <?php else: ?>
                    <h2 class="title">購物清單確認</h2>
                    <div class="confirm-bar">
                        <span class="confirm-present">1.下單確認</span>
                        <span class="confirm-not-yet">2.遞送資料</span>
                        <span class="confirm-not-yet">3.完成下單</span>
                    </div>
                    <h6 class="subtitle">購物車內容</h6>
                        <table class="table-hover-style block-table">
                            <colgroup>
                                <col span="1" width="30%"/>
                                <col span="1" width="10%"/>
                                <col span="1" width="15%"/>
                                <col span="1" width="15%"/>
                                <col span="1" width="10%"/>
                                <col span="1" width="10%"/>
                                <col span="1" width="10%"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">商品名稱</th>
                                    <th scope="col">單價</th>
                                    <th scope="col">庫存量</th>
                                    <th scope="col">規格</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">小計</th>
                                    <th scope="col">動作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($contents as $key => $content):?>
                                    <tr>
                                        <td><?php echo $content['name'];?></td>
                                        <td><?php echo $content['price'];?></td>
                                        <td><?php echo $product[$key]['float_unit'];?></td>
                                        <?php echo (isset($content['option'])) ? "<td>".$content['option']."</td>" : "<td></td>";?>
                                        <td><input style="width:50px;" type="text" class="quantity" rowid="<?php echo $content['rowid'];?>" value="<?php echo $content['qty'];?>"></td>
                                        <td><?php echo $content['subtotal'];?></td>
                                        <td><a href="<?php echo base_url('shop/del/'.$content['rowid']);?>" id="cancel">刪除</a></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" scope="row" class="text-right">
                                        Total : NTD <?php echo $this->cart->total(); ?>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="shopcart-tool text-center block clear">
                            <div class="pull-left"><a href="<?php echo $referrer;?>" class="prev-button" alt="Back">Back</a></div>
                            <div class="pull-right"><a href="<?php echo base_url('shop/delivery_info');?>" class="next-button" alt="Confirm">Confirm</a></div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>
