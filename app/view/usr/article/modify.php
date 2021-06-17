<?php
$pageTitleIcon = '<i class="fas fa-edit"></i>';
$pageTitle = "게시물 수정, ${id}번 게시물";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<div>
  <a href="list">글 리스트</a>
  <a href="detail?id=<?=$id?>">원문</a>
</div>
<hr>

<form action="doModify">
<input type="hidden" name="id" value="<?=$article['id']?>"> 
<div>
    <span>번호</span>
    <span><?=$article['id']?></span>
  </div>
  <div>
    <span>제목</span>
    <input required placeholder="제목을 입력해주세요." type="text" name="title" value="<?=$article['title']?>"> 
  </div>
  <div>
    <span>내용</span>
    <textarea required placeholder="내용을 입력해주세요." name="body"><?=$article['body']?></textarea>
  </div>
  <div>
    <input type="submit" value="글수정">
  </div>
</form>

<?php require_once __DIR__ . "/../foot.php"; ?>