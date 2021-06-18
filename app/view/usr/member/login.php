<?php
// $pageTitleIcon = '<i class="fas fa-user-friends"></i>';
$pageTitleIcon = "false";
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
    <div class="login-page-buttons">
    <input class="btn btn-primary mr-20" type="submit" value="Login">
    <a href="join" class="btn btn-secondary ml-10">Sign up</a>
    </div>
  </form>
</div>


<?php require_once __DIR__ . "/../foot.php"; ?>