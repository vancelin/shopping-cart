<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Edit</title>
 </head>
 <body>
   <h1>Edit</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('member/edit'); ?>
         <label for="username">Username:</label>
            <span><?php echo $username; ?></span>
     <br/>
          <label for="email">E-mail:</label>
             <input type="text" size="20" id="email" value="<?php echo $email; ?>" name="email"/>
     <br/>
        <label for="name">name:</label>
             <input type="text" value="<?php echo $name; ?>" size="20" id="name" name="name"/>
     <br/>
         <label for="sex">sex:</label>
            <span><?php echo $sex; ?></span>
     <br/>
         <label for="addr">address:</label>
             <input type="text" size="20" id="addr" value="<?php echo $address; ?>" name="address"/>
     <br/>
         <label for="phone">phone number:</label>
             <input type="text" size="20" id="phone" value="<?php echo $phone; ?>" name="phone"/>
     <br/>
     <input type="submit" value="Edit"/>
   </form>
   {elapsed_time}
 </body>
</html>
