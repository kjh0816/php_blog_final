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
    
<!-- 
>> 기존 HTML을 AJAX가 불러와도 기존 데이터가 남아있어서 클릭 이벤트가 동일한 문제.
방법 1)

- $heart의 값을 if문이 실행될 때 변경해준다.

 -->
<?php if($heart == 1){ 
    
    echo "heart = 1,";
    print_r($heart);
    
    $heart = 100;
    
    echo "heart = 100,";
    print_r($heart);

    ?>
    
    <!-- 값이 1인 경우, 붉은 하트를 보여줄 것 / 클릭 시 0(좋아요 해제)으로 바뀐다. -->
    
    <button id="articleLiked"><i style="color:red;" class="fas fa-heart"></i></button>
<?php }else{ 
    
    $heart = 1;
    ?>  
    <!-- 값이 없거나 0인 경우, 회색 하트를 보여줄 것 / 클릭 시 1(좋아요)으로 바뀐다. -->
    
    <button id="articleNotLiked"><i class="far fa-heart"></i></button>

<?php        } ?>

<script>
$(document).ready(function(){
    $("#articleLiked").click(()=>{
        
        $.ajax(
            {
                type:"POST",
                dataType: 'html',
                url:"doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$id?>&digitalCode=100",
                success: function(data){
                    // alert('좋아요를 취소했습니다.');
                    $("#articleLiked").html(data);
                    
                }
        }
        );
        
    });
});
</script>

<script>
$(document).ready(function(){
    $("#articleNotLiked").click(()=>{
        
        $.ajax(
            {
                type:"POST",
                dataType: 'html',
                url:"doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$id?>&digitalCode=1",
                success: function(data){
                    // alert('좋아요를 눌렀습니다.');
                    $("#articleNotLiked").html(data);
                    
                }
        }
        );
        
    });
});
</script>


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