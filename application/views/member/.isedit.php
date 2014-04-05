<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
    <script type="text/javascript">
    $(function(){
        $('button:submit').click(function(){
            $(this).attr('disabled', true);
            $.post( '<?php echo base_url('member/isedit') ?>',
                $('form').serialize(),
                function(data){
                    $('div#msg').text( data.msg );
                    if( data.state != 1 ){
                        $(this).attr('disabled', false);
                    }
                }, 'json')
        })
    })
    </script>
 <head>
   <title>Edit</title>
 </head>
 <body>
    <div id="msg">
       <?php echo validation_errors(); ?>
   </div>
   <h1>Edit</h1>
   <?php echo form_open('member/isedit'); ?>
          <label for="email">E-mail:</label>
             <span><?php echo $email; ?></span>
     <br/>
        <label for="name">name:</label>
             <span><?php echo $name; ?></span>
     <br/>
         <label for="addr">address:</label>
             <span><?php echo $address; ?></span>
     <br/>
         <label for="phone">phone number:</label>
             <span><?php echo $phone_number; ?></span>
     <br/>
     <br/>
     <br/>
        <?php if ( !$fbid ){ ?>
        <label for="phone">Please enter your password to confirm:</label>
             <input type="password" size="20" id="password" value="" name="password"/>
        <?php } ?>
     <br/>
     <button type="submit" onclick="javascript:return false;">Confirm</button>
   </form>
   {elapsed_time}
 </body>
</html>
