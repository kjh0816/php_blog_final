<?php 
$loginPage = true;
$pageTitle = "Home";
?>

<?php 
require_once __DIR__ . '/../head.php';
?>


<?php if(isset($_SESSION['loginedMemberId'])){ ?>
<a href="/usr/member/user">내 정보</a><br><br>
<?php }?>
<a href="/usr/board/list">게시판 리스트로 이동</a><br><br>

<a href="/usr/article/list">게시물 리스트로 이동</a>


<?php 
require_once __DIR__ . '/../foot.php';
?>