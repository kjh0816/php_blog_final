


<!-- 삭제 버튼 클릭 시, 비밀번호 입력하는 부분 보이게 하는 함수 -->
<script>
  function showInputModify() {
    var text = document.getElementById("LoginPw1");
    var btn = document.getElementById("Btn1");
    if (text.style.display === "none") {
      text.style.display = "block";
      btn.style.display = "block";
    } else {
      text.style.display = "none";
      btn.style.display = "none";
    }
  }
</script>

<script>
  function showInputDelete() {
    var text = document.getElementById("LoginPw2");
    var btn = document.getElementById("Btn2");
    if (text.style.display === "none") {
      text.style.display = "block";
      btn.style.display = "block";
    } else {
      text.style.display = "none";
      btn.style.display = "none";
    }
  }
</script>





<?php 
$pageTitleIcon = '<i class="fas fa-address-card"></i>';
$pageTitle = "내 정보";
?>
<?php require_once __DIR__ . '/../head.php'?>
<nav class="user-info mt-10 ml-4">
<div>
이름 : <?=$member['name']?><br><br>
별명 : <?=$member['nickname']?><br><br>
핸드폰 번호 : <?=$member['cellphoneNo']?><br><br>
이메일 : <?=$member['email']?>
</div>
<section class="flex mt-10 ml-2">
<button onclick="showInputModify()" class ="text-blue-700 font-bold modify-delete-border mr-7">정보 수정</button>
<form action="modify" method="post">
    <input type="password" required placeholder="비밀번호 입력" style="width: 202px; display:none;" id="LoginPw1" name="loginPw">
    <input  type="submit" value="수정페이지로 이동" id="Btn1" style="width: 208px; display:none;">
</form>
<button class ="text-red-500 font-bold modify-delete-border ml-7" onclick="showInputDelete()">회원 탈퇴</button>

<form action="doQuit" method="post" class="ml-4">
    <input type="password" required placeholder="비밀번호 입력" style="width: 202px; display:none;" id="LoginPw2" name="loginPw">
    <input  onclick="if(!confirm('정말 탈퇴하시겠습니까?')){
    return false;
    }" type="submit" value="입력 완료" id="Btn2" style="width: 208px; display:none;">
</form>

</section>
</nav>


<?php require_once __DIR__ . '/../foot.php'?>