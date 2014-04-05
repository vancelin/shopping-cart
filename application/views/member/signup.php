<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Register</title>
   <script src="<?php echo base_url('public/jscripts/jquery/jquery-1.8.2.js');?>"></script>
<script type="text/javascript">
function chkuser($username){

    $.trim($username) == '' ? 
        $('#errorbox').text('帳號欄位不可留空') : $('#errorbox').text('') ;

    var baseurl = '<?php echo base_url('member/exsit'); ?>';
    $.getJSON( baseurl + '/' + $username ,
        function($data){
            $data ? 
                $('#errorbox').text('帳號已經被註冊') : $('#errorbox').text('這個帳號可以使用') ;
        }
    )

}
</script>
 </head>
 <body>
   <h1>Register</h1>
   <div id="errorbox"></div>
   <?php echo validation_errors(); ?>
   <?php echo form_open('member/register'); ?>
         <label for="username">Username:</label>
             <input type="text" size="20" id="username" onblur="chkuser(document.getElementById('username').value)" name="username"/>
     <br/>
         <label for="password">password:</label>
             <input type="password" size="20" id="passowrd" name="password"/>
     <br/>
         <label for="repassword">Retype-Password:</label>
             <input type="password" size="20" id="repassowrd" name="repassword"/>
     <br/>
          <label for="email">E-mail:</label>
             <input type="text" size="20" id="email" name="email"/>
     <br/>
        <label for="name">name:</label>
             <input type="text" value="" size="20" id="name" name="name"/>
     <br/>
         <label for="sex">sex:</label>
             <input  type="radio" name="sex" value="male">男
             <input  type="radio" name="sex" value="female">女
     <br/>
         <label for="addr">address:</label>
             <input type="text" size="20" id="addr" name="address"/>
     <br/>
         <label for="phone">phone number:</label>
             <input type="text" size="20" id="phone" name="phone"/>
     <br/>
     <input type="submit" value="Register"/>
   </form>
   {elapsed_time}
 </body>
</html>
