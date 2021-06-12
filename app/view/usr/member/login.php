<?php
$loginPage = false;
$pageTitle = "로그인";
?>
<?php require_once __DIR__ . "/../head.php"; ?>


<div class="login-box">
  <h2>Login</h2>
  <form action="doLogin" method="post">
    <div class="user-box">
      <input type="text" name="loginId" required>
      <label>LoginID</label>
    </div>
    <div class="user-box">
      <input type="password" name="loginPw" required>
      <label>Password</label>
    </div>
    <input class="login-button" type="submit" value="Login">
  </form>
</div>


<?php require_once __DIR__ . "/../foot.php"; ?>