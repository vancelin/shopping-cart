<script type="text/javascript">
$(function(){
    $("#content table").infinitescroll({
         loadingImg     : "<?php echo base_url('public/img/ajax-loader.gif');?>",
         navSelector    : "a#next:last",
         nextSelector   : "a#next:last",
         itemSelector   : "#content table tbody tr",
         dataType       : 'html',
         path: function(index) {
            return "<?php echo base_url('admin/member/search') . '/' . $this->uri->segment(4, 0) . '/' . $this->uri->segment(5, 0) . '/'; ?>" + (index-1) ;
         }
    });
})
</script>
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
            <td><?php echo '<a href="'.base_url('admin/member/detail/' . $user['email']) . '">' . $user['email'] . '</a>';?></td>
            <td><?php echo date("Y/m/d H:i:s",$user['last_login']); ?></td>
            <td><?php echo $user['login_ip']; ?></td>

        <?php } ?>
        </tr>
    </tbody>
</table>
<a style="display:none;" id="next" href="<?php echo base_url('admin/member/search') . '/' . $this->uri->segment(4, 0) . '/' . $this->uri->segment(5, 0) . '/' . ($this->uri->segment(6, 0) + 1); ?>" style="display:none;">next</a>
