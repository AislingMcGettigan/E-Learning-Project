<?php include('session.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
    </head>
    <body>
        <div class="header">
            <h2>Create a New Account</h2>
        </div>
        <form method="post" action="Registration.php">
            <?php include('errorLoop.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $fName; ?>">
            </div>
            <div class="input-group">
              <label>Last Name</label>
              <input type="text" name="surname" value="<?php echo $sName; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Student ID</label>
                <input type="text" name="studentId" value="<?php echo $stuId; ?>">
            </div>
            <div class="input-group">
                <label>Educational Department</label>
                <select name="educationalDepartment" >
                    <option value="" <?php if($edDepartment == "") {?> selected disabled <?php } ?>></option>
                    <option value="School of Computing" <?php if($edDepartment == "School of Computing") {?> selected <?php } ?>>School of Computing</option>
                    <option value="School of Science" <?php if($edDepartment == "School of Science") {?> selected <?php } ?>>School of Science</option>
                    <option value="School of Engineering" <?php if($edDepartment == "School of Engineering") {?> selected <?php } ?>>School of Engineering</option>
                    <option value="School of Nursing" <?php if($edDepartment == "School of Nursing") {?> selected <?php } ?>>School of Nursing</option>
                    <option value="School of Business" <?php if($edDepartment == "School of Business") {?> selected <?php } ?>>School of Business</option>
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="registerUser">Register</button>
            </div>
            <p>
                Already a member? <a href="Login.php">Sign in</a>
            </p>
      </form>
    </body>
</html>
