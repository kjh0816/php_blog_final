<!-- reply 리스트 별 버튼 부여를  위한 JS (시작) -->
<script>
  function toggleText(i) {
    var text = document.getElementById("modifyReply" + i);
    var modifyBtn = document.getElementById("modifyBtn" + i);
    if (text.style.display == "none") {
      text.style.display = "block";
      modifyBtn.style.display = "block";
    } else {
      text.style.display = "none";
      modifyBtn.style.display = "none";
    }
  }
  </script>
  <!-- reply 리스트 별 버튼 부여를  위한 JS (끝) -->



  <?php 

  
  ?>
  <?php 
  $i = 0;
  
  ?>
  
  <?php foreach($replies as $reply){ ?>
  

<!-- 좋아요 관련 (시작)  -->
<?php



  
if(isset($_SESSION['loginedMemberId'])){
  // 로그인된 경우, digitalCode 상태가 Controller에 입력 되어있으므로, 불러온다.

  $replyHeart = intval($reply['digitalCode']);
  

  
 
  
  

}


?>
  
<!-- 좋아요 관련 (끝))  -->

  <?php 
  $i = $i + 1
  ?>
  
        작성자: <?=$reply['nickname']?><br>
        댓글 : <?=$reply['body']?><br>
        <?php if(!isset($_SESSION['loginedMemberId'])){?>

        <!-- 로그인이 안 된 경우, 로그인 페이지로 이동 -->
        <a onclick="alert('로그인이 필요합니다.')" href="/usr/member/login"><i class="far fa-heart"></i></a>
        
        <?php }else{?>
        <?php if($replyHeart == 1){ ?>
        
        <!-- 값이 1인 경우, 붉은 하트를 보여줄 것 / 클릭 시 0(좋아요 해제)으로 바뀐다. -->
        <a href="/usr/reply/doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$reply['articleId']?>&replyId=<?=$reply['replyId']?>&digitalCode=100"><i style="color:red;" class="fas fa-heart"></i></a>
          
        <?php 
        }else{
          
          ?>  
        
        <!-- 값이 없거나 0인 경우, 회색 하트를 보여줄 것 / 클릭 시 1(좋아요)으로 바뀐다. -->
        <a href="/usr/reply/doLiked?memberId=<?=$loginedMemberId?>&articleId=<?=$reply['articleId']?>&replyId=<?=$reply['replyId']?>&digitalCode=1"><i class="far fa-heart"></i></a>


        <?php        } } ?>
        <?=
        $reply['liked'];
        ?>
        
        <!-- 로그인한 회원이 작성한 댓글일 경우, 댓글 수정/삭제 버튼이 보임. -->
        <?php if(isset($_SESSION['loginedMemberId'])){ ?>
        <?php if($reply['memberId'] == $_SESSION['loginedMemberId'] || $_SESSION['loginedMemberId'] == 1){?>
            <button onclick="toggleText(<?=$i?>)">수정하기</button>
            <button onclick="if(confirm('이 댓글을 삭제하시겠습니까?')){
              location.replace('/usr/reply/doDelete?id=<?=$reply['replyId']?>');
            }else{
              return false
            }" class="delete">댓글 삭제</button>
            <form action="/usr/reply/doModify">
            <input type="hidden" name="id" value=<?=$reply['replyId']?>>
            <textarea required placeholder="댓글을 입력해주세요." name="body" id="modifyReply<?=$i?>" style="display: none; width:200px; height: 60px;"></textarea>
            <input id="modifyBtn<?=$i?>" type="submit" value="완료" style="display: none;">
            </form>
        <?php } } ?>
        <hr>

  <?php } ?>

  

