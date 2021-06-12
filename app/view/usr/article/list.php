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
<section class = "article-list-bar row">
<div class="article-list-write cell-right">
<i class="fas fa-feather-alt"></i>
<a href="write"><span>글 작성</span></a>
</div>
<form action="list">
<div class="article-list-board cell-left">
<span>게시판 선택>
<select class="article-list-choose-board" name="boardId">
<option value="0">게시판 전체</option>
<?php foreach($boards as $board){?>
    <option value="<?=$board['id']?>"><?=$board['name']?></option>
<?php }?>
</select>
</span>
</div>
<div class="article-list-search float-left">
<span>
검색어>
<input placeholder="검색 키워드" type="search" name="searchKeyword">
</span>
<input type="submit" value="검색">
</div>
</form>
</section>
<hr>

<!-- 사용자가 게시판 선택 (끝) -->
                    
                                    
    <!-- 위에서 설정된 값으로 출력 여부 결정 및 출력 (시작) -->


                    <?php
                    if($totalRecord != 0){  // 불러온 게시물이 존재할 경우
                      
                      foreach($filteredArticles as $article){
                      
                      /* 제목 글자수가 30이 넘으면 ... 표시로 처리해주기 */
                      $title = $article['title'];
                      if(strlen($title) > 30){
                          $title=str_replace($article['title'],mb_substr($article['title'], 0, 30, "utf-8")."...", $article['title']);
                      }?>
                      <nav>
                        <a href="detail?id=<?=$article['id']?>" class="article_section">
                          <div>번호: <?=$article['id']?></div>
                          <div>
                            <div>제목: <?=$title?>
                            <span style="color:blue;">(<?=$article['replyCount']?>)</span>
                            </div>
                            <div>
                              <div>게시판: <?=$article['name']?></div>
                              <div>작성날짜: <?=$article['regDate']?></div>
                              <div>작성자: <?=$article['nickname']?></div>
                              <div>조회수: <?=$article['count']?></div>
                            </div>
                          </div>
                        </a>
                      </nav>
                      <hr class="article-list-hr">

                  <?php  }  
      
                }else{
                  echo "검색 결과와 일치하는 게시물이 없습니다.";
                }?>

                <!-- 위에서 설정된 값으로 출력 여부 결정 및 출력 (끝) -->

        <!-- 페이징 부분 (시작)-->
                <nav  class="page-items-cover">
                    <ul  class="page-items row">
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