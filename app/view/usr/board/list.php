<?php

$loginPage = true;
$pageTitle = "모든 게시판 리스트";
require_once __DIR__ . '/../head.php';

?>
 
<div><a href="add">게시판 만들기</a></div>
<hr>

<?php foreach($boardList as $board){?>

    
    <a href="detail?id=<?=$board['id']?>">
    게시판 번호: <?=$board['id']?><br>
    게시판 이름: <?=$board['name']?><br>
    게시판 코드: <?=$board['code']?><br>
    게시판 주인: <?=$board['nickname']?> 
    </a>
    <hr>

<?php } ?>

<?php 
require_once __DIR__ . '/../foot.php';
?>