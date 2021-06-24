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
    
    
    
    
    
    

    ?>
    
    <!-- 값이 1인 경우, 붉은 하트를 보여줄 것 / 클릭 시 0(좋아요 해제)으로 바뀐다. -->
    <div id="articleLiked" class="flex">
    <button><i style="color:red;" class="fas fa-heart"></i></button>
    <div class="ml-1"><?=$articleDetail['liked'];?></div>
    </div>
<?php }else{ 
    
    
    ?>  
    <!-- 값이 없거나 0인 경우, 회색 하트를 보여줄 것 / 클릭 시 1(좋아요)으로 바뀐다. -->
    <div id="articleLiked" class="flex">
    <button><i class="far fa-heart"></i></button>
    <div class="ml-1"><?=$articleDetail['liked'];?></div>
    </div>
<?php        } ?>
<!-- 
    구현 예정
    Controller에서 heart(digitalCode) 값을 먼저 조회한 후 값에 따라서 분기한 후 변경해주고, 다른 HTML 데이터를 뿌려준다.
    좋아요가 눌리면 조회수도 올라가고 내려가야한다.


 -->

<script>
$(document).ready(function(){
    $("#articleLiked").click(()=>{
        
        $.ajax(
            {
                type:"POST",
                dataType: 'html',
                data: { $heart : "<?php echo $heart;?>" },

                url:"doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$id?>",
                success: function(data){
                    $("#articleLiked").html(data);
                    
                }
        }
        );
        
    });
});
</script>




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