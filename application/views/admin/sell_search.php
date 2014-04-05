<script type="text/javascript">
$(function(){
    var url = location.href;
    if(url == '<?php echo base_url('admin/sell/orders/status/not');?>'){
        $("#status a").attr("href","<?php echo base_url('admin/sell/orders/status/ok');?>");
    }else{
        $("#status a").attr("href","<?php echo base_url('admin/sell/orders/status/not');?>");
    }
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
    $(".product_list").hover(function(){
        var serial_id = $(this).attr("rel");
        var next_div = $(this).next().children();
        $.post("<?php echo base_url('admin/sell/show_detail_product');?>",{serial_id:serial_id},function(r){
            $(next_div).find("tbody").html(r);
        });
        $(this).next().fadeIn();
    },function(){
        $(this).next().fadeOut();
    });
    $(".detail").hover(function(){
        $(this).next().fadeIn();
    },function(){
        $(this).next().fadeOut();
    });
    $(".status").dblclick(function(){
        var serial_id = $(this).next().text();
        var status = ($(this).text() == '未處理')?"1":"0";
        var select = $(this);
        $.post("<?php echo base_url('admin/sell/edit_status');?>",{serial_id:serial_id,status:status},function(r){
            if(r){
                $(select).css("color","#4E443C").text('已收費準備出貨');
            }else{
                $(select).css("color","#F14E32").text('未處理');
            }
        });
    });
});
</script>
<h3 class="under-line none-margin-box">訂單查詢</h3>
<table class="table-hover-style block-table img-limit-table text-center">
    <colgroup>
        <col span="1" />
        <col span="1" />
        <col span="1" />
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
            <th scope="col" class="tip" tip="點選下方可快速修改訂單狀態">出貨狀態</th>
            <th scope="col" class="tip" tip="點選下方可瀏覽此用戶所有訂單">用戶</th>
            <th scope="col" class="tip" tip="將滑鼠移動到下方可快速瀏覽此訂單商品內容">商品</th>
            <th scope="col" class="tip" tip="將滑鼠移動到下方可快速瀏覽此訂單用戶資料">詳細資料</th>
            <th scope="col">數量</th>
            <th scope="col">總價</th>
            <th scope="col">訂單時間</th>
            <th scope="col">付款方式</th>
            <th scope="col">附註</th>
            <th scope="col">操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($result as $order):?>
            <tr>
                <?php if($order['status'] == 1):?>
                <td class="status tip" tip="點選此處可快速編輯訂單狀態">已處理</td>
                <?php elseif($order['status'] == 0):?>
                <td class="status tip" tip="點選此處可快速編輯訂單狀態" style="color: #F14E32;">未處理</td>
                <?php elseif($order['status'] == -1):?>
                <td class="tip" tip="僅可快速修改已處理或未處理訂單" style="color: #F14E32;">取消訂單</td>
                <?php elseif($order['status'] == 2):?>
                <td class="tip" tip="僅可快速修改已處理或未處理訂單">已出貨</td>
                <?php endif;?>
                <td><?php echo '<a href="'.base_url('admin/member/detail/' . $order['email']) . '">' . $order['email'] . '</a>';?></td>
                <td>
                    <a href="javascript: void(0)" class="product_list" rel="<?php echo $order['serial_id'];?>">...</a>
                    <div class="item-popup-container" style="width:800px;hieght:auto; display:none;">
                        <table class="item-popup">
                            <colgroup>
                                <col span="1" width="50%" />
                                <col span="1" width="20%" />
                                <col span="1" width="15%" />
                                <col span="1" width="15%" />
                            </colgroup>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td>
                    <a href="javascript: void(0)" class="detail">...</a>
                    <div class="item-popup-container" style="width:800px;hieght:auto; display:none;">
                        <table class="item-popup">
                            <colgroup>
                                <col span="1" width="15%" />
                                <col span="1" width="50%" />
                                <col span="1" width="35%" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>收件人</th>
                                    <th>地址</th>
                                    <th>電話</th>
                                </tr>
                                <tr>
                                    <td><?php echo $order['name'];?></td>
                                    <td><?php echo $order['address'];?></td>
                                    <td><?php echo $order['phone'];?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td><?php echo $order['qty'];?></td>
                <td><?php echo $order['total'];?></td>
                <td><?php echo $order['date'];?></td>
                <td><?php echo $order['pway'];?></td>
                <td><?php echo $order['ps'];?></td>
                <td>
                    <a href="<?php echo base_url('admin/member/detail/' . $order['email']);?>"><img src="<?php echo base_url('public/admin/img/user.png')?>"></a>|
                    <a href="<?php echo base_url('admin/sell/edit_order/' . $order['serial_id']); ?>"><img src="<?php echo base_url('public/admin/img/edit.png'); ?>" /></a> | 
                    <a class="delete" href="#" url="<?php echo base_url('admin/sell/del_order/' . $order['serial_id']); ?>"><img src="<?php echo base_url('public/admin/img/trash.gif'); ?>" /></a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
