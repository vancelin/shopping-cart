<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Change password</title>
 </head>
 <body>
   <h1>Edit</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('member/chpass'); ?>
         <label for="username">Username:</label>
            <span><?php echo $username; ?></span>
     <br/>
          <label for="password">Please type your old password:</label>
             <input type="password" size="20" id="password" value="" name="password"/>
    <br/>
          <label for="password">Please type new password:</label>
             <input type="password" size="20" id="newpw" value="" name="newpw"/>
    <br/>
          <label for="password">Please Retype your new password:</label>
             <input type="password" size="20" id="renewpw" value="" name="renewpw"/>
    <br/>
     <input type="submit" value="Change password"/>
   </form>
   {elapsed_time}
 </body>
</html>
