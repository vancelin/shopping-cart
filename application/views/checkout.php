    <script>
    function chkuser($email){

        $.trim($email) == '' ? 
            $('#errorbox').text('email欄位不可留空') : $('#errorbox').text('') ;

        var baseurl = '<?php echo base_url('checkout/exsit'); ?>';
        $.getJSON( baseurl + '/' + $email ,
            function($data){
                $data ? 
                    $('#errorbox').text('email已經被註冊') : $('#errorbox').text('可以使用') ;
            }
        )

    }
    $(function(){
        
        var total = $("#shipping_cost").text();
        
        $("select").change(function(){
            
            var charges = $("select option:selected").text().replace(/^[^0-9]*/,"");
            
            if($(this).val()!=''){
                var str = parseInt(total) + parseInt(charges);
                $("#totle_text").html("商品 + 運費 : NT$ " + str);
            }else{
                $("#totle_text").html("商品金額 : NT$" + total);
            }
        });
    });
    </script>
    <div id="main-wrap">
        <div id="main">
            <div class="webkit-used-top-padding"> </div>
            <div id="content">
                <div class="white-block-box normal-border-radius center-mid ver-medium-separate">
                    <h1 class="title">結帳</h1>
                    <form action="<?php echo base_url('checkout/check');?>" method="post">
                        <table class="list-table text-mid table-border-collapse line-break" cellspacing="5">
                            <colgroup>
                                <col span="1" width="55%" />
                                <col span="1" width="10%" />
                                <col span="1" width="10%" />
                                <col span="1" width="15%" />
                                <col span="1" width="10%" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>商品名稱</th> <!-- 流水編號  -->
                                    <th>單價</th>
                                    <th>數量</th>
                                    <th>規格</th>
                                    <th>金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($detail as $product):?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['price']; ?></td>
                                    <td><?php echo $product['qty']; ?></td>
                                    <?php echo (isset($product['option'])) ? "<td>".$product['option']."</td>" : "<td></td>";?>
                                    <td><?php echo $product['subtotal']; ?></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot class="text-right bold big">
                                <tr>
                                    <td colspan="4" class="text-right" id="totle_text">商品金額 : NT$<span id="shipping_cost"><?php echo $totalPrice; ?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <hr style="border-bottom: 1px dashed #e0e0e0;"/>
                        <table class="data-table td-text-left" cellspacing="5">
                            <colgroup>
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                                <col span="1" />
                            </colgroup>
                            <?php echo validation_errors(); ?>
                            <tbody>
                                <tr>
                                    <td colspan="4"><h4 style="border-left: 6px double #E39A4B;">出貨資料確認</h4></td>
                                </tr>
                                <?php if(isset($user)):?>
                                    <tr>
                                        <th>收件人</th>
                                        <td><input type="text" class="text-data-input" placeholder="Name" name="name" value="<?php echo $user['name'];?>"/></td>
                                        <th>聯絡電話 / 手機</th>
                                        <td><input type="tel" class="text-data-input" style="width: 40%;" placeholder="Tel/Mobile" name="phone" value="<?php echo $user['phone'];?>"/></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <input type="hidden" onblur="chkuser(this.value)" name="email" value="<?php echo $user['email'];?>"/><?php echo $user['email'];?><span id="errorbox"></span>
                                        </td>
                                        <th>付款方式</th>
                                        <td>
                                            <select name="charges" class="select-data-input">
                                                <option></option>
                                                <?php 
                                                foreach($payment as $pway){
                                                    echo '<option value="'. $pway['way'] .' - 運費 '.$pway['charges'].'">'.$pway['way'].' - 運費 '.$pway['charges'].'</option>';
                                                };
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>地址</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Location" name="address" value="<?php echo $user['address'];?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>附註</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Ps" name="ps"/>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <th>收件人</th>
                                        <td><input type="text" class="text-data-input" placeholder="Name" name="name" value=""/></td>
                                        <th>聯絡電話 / 手機</th>
                                        <td><input type="tel" class="text-data-input" style="width: 40%;" placeholder="Tel/Mobile" name="phone" value=""/></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <input onblur="chkuser(this.value)" type="email" class="text-data-input" style="width: 60%;" placeholder="Email" name="email" value=""/><span id="errorbox"></span>
                                        </td>
                                        <th>付款方式</th>
                                        <td>
                                            <select name="charges" class="select-data-input">
                                                <option>請選擇</option>
                                                <?php 
                                                foreach($payment as $pway):
                                                    echo '<option value="'. $pway['way'] .'">'.$pway['way'].' - 運費 '.$pway['charges'].'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>地址</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Location" name="address" value=""/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>附註</th>
                                        <td colspan="3" class="ver-small-separate">
                                            <input type="text" class="text-data-input"  style="width: 60%;" placeholder="Ps" name="ps" value=""/>
                                        </td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center"><a href="<?php echo base_url('shop/detail');?>" class="data-button little-border-radius medium-padding-box">回上一頁</a> <button type="submit"  class="data-button little-border-radius medium-padding-box">下單</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            <div class="webkit-used-footer-padding"> </div>
        </div>
    </div>
