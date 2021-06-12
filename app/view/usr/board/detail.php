<?php 
$loginPage = true;
$pageTitle = "[${board['name']}] 게시판 상세 보기";
?> 

<?php  
require_once __DIR__ . '/../head.php';
?>
<a href="/usr/board/list">게시판 리스트</a>
<hr>
<div>
게시판 번호: <?=$board['id']?><br>
게시판 이름: <?=$board['name']?><br>
게시판 코드: <?=$board['code']?><br>
게시판 주인: <?=$nickname?><br>
게시판 생성일: <?=$board['regDate']?><br>
게시판 수정일: <?=$board['updateDate']?><br>
</div>
<hr>
<?php if($board['memberId'] == $_SESSION['loginedMemberId'] || $_SESSION['loginedMemberId'] == 1){?>
<div>
<span><a href="modify?id=<?=$boardId?>">수정하기</a></span>
<span><a class="delete" onclick="if(!confirm('이 게시판을 삭제하시겠습니까?')){return false}" href="doDelete?id=<?=$boardId?>">삭제하기</a></span>
</div>
<?php } ?>



<?php  
require_once __DIR__ . '/../foot.php';
?>