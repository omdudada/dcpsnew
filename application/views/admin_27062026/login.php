<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DCPS Nashik Municipal Corporation</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/css/style.css'); ?>">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <div class="circle">NMC</div>
            <h2>Nashik Municipal Corporation<br><small style="font-size:14px;color:#888;">DCPS Management System</small></h2>
        </div>
        <h3>Admin Panel Login</h3>

        <?php if(!empty($errmsg)): ?>
        <div class="alert alert-danger" id="err-msg">
            <strong>Error:</strong> <?php echo $errmsg; ?>
        </div>
        <?php endif; ?>

        <?php echo form_open('admin/login', array('id' => 'loginform', 'autocomplete' => 'off')); ?>
            <div class="form-group">
                <label for="username">Username <span style="color:red">*</span></label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" value="<?php echo set_value('username'); ?>">
                <?php echo form_error('username', '<p style="color:red;font-size:12px;margin-top:3px;">', '</p>'); ?>
            </div>
            <div class="form-group">
                <label for="password">Password <span style="color:red">*</span></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                <?php echo form_error('password', '<p style="color:red;font-size:12px;margin-top:3px;">', '</p>'); ?>
            </div>
            <div class="form-group" style="text-align:right;">
                <button type="submit" class="btn btn-primary" style="width:100%;padding:10px;">Login</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
</body>
</html>