<?php
$pageTitleIcon = '<i class="fas fa-feather-alt"></i>';
$pageTitle = "게시물 작성";
?>
<?php require_once __DIR__ . "/../head.php"; ?>

<form action="doWrite" class="mt-10">
<div>
<span>게시판 선택
<select required name="boardId">
<?php foreach($boards as $board){?>
    <?php if($memberId == 1){?>
    <option value="<?=$board['id']?>"><?=$board['name']?></option>
    <?php }else{ ?>
    <?php if($board['id'] != 1){?>
    <option value="<?=$board['id']?>"><?=$board['name']?></option>

    <?php }}?>
<?php }?>
</select>
</span>
</div>
  <div>
    <span>제목</span>
    <input required placeholder="제목을 입력해주세요." type="text" name="title"> 
  </div>
  <div>
    <span>내용</span>
    <textarea required placeholder="내용을 입력해주세요." name="body"></textarea>
  </div>
  <div>
    <input type="submit" value="글작성">
  </div>
</form>

<?php require_once __DIR__ . "/../foot.php"; ?>