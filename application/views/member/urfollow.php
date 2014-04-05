        <script>
        $(function(){
            $(".cancel-follow").click(function(){
                var button = $(this);
                var product_id = $(this).attr("product_id");
                $.post("<?php echo base_url('member/unfollow');?>",{product_id:product_id},function(r){
                    if(r == 1){
                        $(button).parent().parent().filter("tr").remove();
                    }
                });
            });
        });
        </script>
        <div id="main-wrap">
            <div id="main">
                <div class="webkit-used-top-padding"> </div>
                <div id="content">
                    <div class="white-block-box normal-border-radius nav-bar hor-tiny-separate" style="margin-bottom: 10px;">
                        <span><a href="<?php echo base_url('member');?>">會員中心</a></span>
                        <span>追蹤清單</span>
                    </div>
                    <div class="white-block-box ver-medium-separate normal-border-radius">
                            <h6 class="subtitle">追蹤清單</h6>
                            <table class="table-hover-style block-table">
                                    <colgroup>
                                        <col span="1" />
                                        <col span="1" />
                                        <col span="1" />
                                        <col span="1" />
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th scope="col">商品名稱</th>
                                            <th scope="col">商品售價</th>
                                            <th scope="col">商品數量</th>
                                            <th scope="col">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($follow_list as $list):?>
                                            <tr>
                                                <td><a target="_blank" href="<?php echo base_url('home/product/'.$list['id']);?>"><?php echo $list['product_name'];?></a></td>
                                                <td><?php echo $list['sale_price'];?></td>
                                                <td><?php echo $list['float_unit'];?></td>
                                                <td>
                                                    <a href="javascript:void(0);" product_id="<?php echo $list['product_id'];?>" class="cancel-follow">取消追蹤</a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                            </table>
                    </div>
                <div class="webkit-used-footer-padding"> </div>
            </div>
        </div>