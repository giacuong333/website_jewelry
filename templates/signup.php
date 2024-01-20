<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <title>Sign up</title>
  </head>
  <body>
    <form action="../includes/signup.inc.php" method="post">
      <input type="text" name="fullname" placeholder="Your fullname" />
      <input type="email" name="email" placeholder="Your email" />
      <input type="password" name="password" placeholder="Your password" />
      <input type="text" name="phonenumber" placeholder="Your phone number" />
      <select name="role" id="">
        <option value="1">Quản lý</option>
        <option value="2">Nhân viên</option>
      </select>

      <input type="submit" name="signup" value="signup" />
    </form>
    <!-- <script src="./js/login.js"></script> -->
  </body>
</html>
