<?php 
$pageTitleIcon = '<i class="fas fa-newspaper"></i>';
$pageTitle = "${id}번 게시물 상세페이지";


$body = str_replace('<script', '<t-script>', $article['body']);
$body = str_replace('</script>', '</t-script>', $article['body']);
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>



<div class="article-detail-section mt-10">
    번호 : <?=$articleDetail['id']?><br><br>
    게시판 : <?=$articleDetail['name']?><br><br>
    제목 : <?=$articleDetail['title']?><br><br>
    조회수 : <?=$articleDetail['count']?><br><br>
    작성자 : <?=$articleDetail['nickname']?><br><br>
    작성날짜 : <?=$articleDetail['regDate']?><br><br>
    수정날짜 : <?=$articleDetail['updateDate']?><br><br>
    내용 : <script type="text/x-template"><?=$body?></script>
      <div class="toast-ui-viewer"></div>
    

<?php if($heart == 1){ ?>
    
    <!-- 값이 1인 경우, 붉은 하트를 보여줄 것 / 클릭 시 0(좋아요 해제)으로 바뀐다. -->
    <a href="doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$id?>&digitalCode=100"><i style="color:red;" class="fas fa-heart"></i></a>

<?php }else{ ?>  
    <!-- 값이 없거나 0인 경우, 회색 하트를 보여줄 것 / 클릭 시 1(좋아요)으로 바뀐다. -->
    <a href="doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$id?>&digitalCode=1"><i class="far fa-heart"></i></a>


<?php        } ?>

<?= 
// 좋아요 수
$articleDetail['liked'];
?>
</div>
<br>
<hr>
<?php if(isset($_SESSION['loginedMemberId'])){ ?>
<?php if($article['memberId'] == $_SESSION['loginedMemberId'] || $_SESSION['loginedMemberId'] == 1){?>
<a href="modify?id=<?=$articleDetail['id']?>">수정하기</a>
<button onclick="if(confirm('이 게시물을 삭제하시겠습니까?')){
    location.replace('doDelete?id=<?=$articleDetail['id']?>');
    }else{
        return false;
    }">삭제하기</button>


<?php } } ?>

<?php if(isset($_SESSION['loginedMemberId'])){ ?>

<div class="article-detail-reply-section">
<form action="/usr/reply/doWrite">
<input type="hidden" name ="relId" value="<?=$articleDetail['id']?>" >
<textarea required placeholder="댓글을 입력해주세요." name="body" style="width:200px; height: 60px;"></textarea><br>
<input type="submit" value="작성 완료">
</form>
</div>
<?php } ?>

<?php 

App__runAction("usr/reply/list");

?>

<?php require_once __DIR__ . "/../foot.php";   
?>