<?php

if(isset($_GET["page"])){
  $page = $_GET["page"]; // 하단에서 다른 페이지 클릭하면 해당 페이지 값 가져와서 보여줌
} else {
  $page = 1; // 게시판 처음 들어가면 1페이지로 시작
}
  // 아래 두 변수는 boardId값이 입력됐을 경우, 값이 바뀜.
  $pageTitleIcon = '<i class="fas fa-newspaper"></i>';
  $pageTitle = "모든 게시물 리스트";
?>

<?php require_once __DIR__ . "/../head.php"; ?>
<hr class="mt-4">
<section class="section-article-menu mt-5 ml-10">
  <div class="container mx-auto">
  <form action="list">
  <div class="mb-2">
<span>
검색어: 
<input placeholder="검색 내용을 적어주세요." type="search" name="searchKeyword" class="text-center underline hover:no-underline">
</span>
</div>
<div class="">
<span class="mr-4">게시판: </span>
<select class="article-list-choose-board text-pink-400" name="boardId">
<option value="0" class="text-pink-500">게시판 선택</option>
<?php foreach($boards as $board){?>
    <option value="<?=$board['id']?>"><?=$board['name']?></option>
<?php }?>
</select>
<input type="submit" value="검색" class="ml-4  cursor-pointer modify-delete-border">
</div>
</form>
  </div>
</section>



<br>



<!-- 사용자가 게시판 선택 (끝) -->

                                    
    <!-- 위에서 설정된 값으로 출력 여부 결정 및 출력 (시작) -->
    <hr>
    <section class="section-article-menu my-5 ml-10">
  <div class="container mx-auto">
  <i class="fab fa-wpforms -mr-4 article_board_write_font-size"></i>
    <a href="/board/add" class="btn btn-link article_board_write_font-size">게시판 생성</a>
  </div>
</section>
<hr>
    <section class="section-article-menu my-5 ml-10">
  <div class="container mx-auto">
    <i class="fas fa-feather-alt -mr-4 article_board_write_font-size"></i>
    <a href="write" class="btn btn-link article_board_write_font-size">글 작성</a>
  </div>
</section>
<hr>



<section class="section-articles mt-10">
  <div class="container mx-auto">
    <div class="con-pad">

      <div>
        <div class="badge badge-primary badge-outline">게시물 수</div>
        <?=$totalRecord?>
      </div>

      <hr class="mt-4">

      <div>
        <?php foreach ( $filteredArticles as $article ) { ?>
          <div class="py-5">
            <?php
            $detailUri = "detail?id=${article['id']}";
            $body = str_replace('<script', '<t-script>', $article['body']);
            $body = str_replace('</script>', '</t-script>', $article['body']);
            ?>
            <div>
              <div class="badge badge-primary badge-outline">번호</div>
              <a href="<?=$detailUri?>"><?=$article['id']?></a>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">제목</div>
              <a href="<?=$detailUri?>"><?=$article['title']?></a>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">작성자</div>
              <?=$article['nickname']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">수정날짜</div>
              <?=$article['updateDate']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">조회수</div>
              <?=$article['count']?>
            </div>
            <div class="mt-2">
              <script type="text/x-template"><?=$body?></script>
              <div class="toast-ui-viewer"></div>
            </div>
          </div>
          <hr>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

                    

                <!-- 위에서 설정된 값으로 출력 여부 결정 및 출력 (끝) -->

        <!-- 페이징 부분 (시작)-->
                <nav  class="page-items-cover">
                    <ul  class="page-items flex">
                        <?php
                            if ($page <= 1){
                                // 빈 값
                            } else {
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=1&boardId=$boardId&searchKeyword=$searchKeyword' aria-label='Previous'><b style='color:blue;'>처음</b></a></li>";
                            }
                            
                            if ($page <= 1){
                                // 빈 값
                            } else {
                                $pre = $page - 1;
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$pre&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'>◀이전</b></a></li>";
                            }
                            
                            for($i = $blockStart; $i <= $blockEnd; $i++){
                                if($page == $i){
                                    echo "<li class='page-item cell-left'><a disabled><b style='color: black; font-size:20px;'> $i </b></a></li>";
                                } else {
                                    echo "<li class='page-item cell-left'><a href='/usr/article/list?page=$i&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'> ($i) </b></a></li>";
                                }
                            }
                            
                            if($page >= $totalPage){
                                // 빈 값
                            } else {
                                $next = $page + 1;
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$next&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'> 다음▶</b></a></li>";
                            }
                            
                            if($page >= $totalPage){
                                // 빈 값
                            } else {
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$totalPage&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'>마지막</b></a>";
                            }
                        ?>                                        
                    </ul>                                                                  
                </nav>               
            </div>                                            
        </div>                                                                    
    </div>

<!-- 페이징 부분 (끝)-->

      
<?php 
require_once __DIR__.'/../foot.php';
?>