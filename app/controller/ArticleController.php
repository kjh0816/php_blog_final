<?php
class APP__UsrArticleController {
  private APP__ArticleService $articleService;

  public function __construct() {
    global $App__articleService;
    $this->articleService = $App__articleService;
  }

  public function actionShowWrite() {

    
    $memberId = getIntValueOr($_REQUEST['App__loginedMember'], 0);

    // 사용자가 선택할 수 있는 board 리스트 호출(관리자가 아니면 1번(공지) 게시판에 글 쓸 수 없음.)
    global $App__boardService;
    $boards = $App__boardService->getForPrintBoards();

    require_once App__GetViewPath("usr/article/write");
  }

    public function actionDoWrite() {
    
    $memberId = getIntValueOr($_SESSION['loginedMemberId'], 0);
    $title = getStrValueOr($_REQUEST['title'], "");
    $body = getStrValueOr($_REQUEST['body'], "");
    $boardId = getStrValueOr($_REQUEST['boardId'], "");

    if ( !$title ) {
      jsHistoryBackExit("제목을 입력해주세요.");
    }

    if ( !$body ) {
      jsHistoryBackExit("내용을 입력해주세요.");
    }

    if ( !$boardId ) {
      jsHistoryBackExit("내용을 입력해주세요.");
    }
    
    

    
    

    $id = $this->articleService->writeArticle($title, $body, $boardId, $memberId);

    jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 생성되었습니다.");
  }

  

  public function actionDoDelete() {
    $id = getIntValueOr($_REQUEST['id'], 0);
    
    if ( !$id ) {
      jsHistoryBackExit("번호를 입력해주세요.");
    }

    $article = $this->articleService->getForPrintArticleById($id);

    if ( $article == null ) {
      jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
    }

    if($article['memberId'] != $_SESSION['loginedMemberId']){
      jsHistoryBackExit("권한이 없습니다.");
    }

    $this->articleService->deleteArticle($id);

    jsLocationReplaceExit("list", "${id}번 게시물이 삭제되었습니다.");
  }

  

  public function actionShowList() {
    // 페이지 번호 받아오기 (시작)
    if(isset($_REQUEST["page"])){
      $page = $_REQUEST["page"]; // 하단에서 다른 페이지 클릭하면 해당 페이지 값 가져와서 보여줌
  } else {
      $page = 1; // 게시판 처음 들어가면 1페이지로 시작
  }

  // 페이지 번호 받아오기 (끝)

    // 아래 두 변수는 boardId값이 입력됐을 경우, 값이 바뀜.
    
    $pageTitle = "모든 게시물 리스트";

    // 사용자가 게시물 리스트 조회 시, 선택할 수 있는 게시판 리스트 호출
    global $App__boardService;
    $boards = $App__boardService->getForPrintBoards();

//  게시판 선택 시 , 게시판 별 게시물을 불러오고, 미선택 시, 게시물 전체 리스트를 불러옴. (시작)


        //  boardId 필터링 (시작)
        
        if(isset($_REQUEST['boardId'])){
      
            if($_REQUEST['boardId'] != 0){
            
            $boardId = intval($_REQUEST['boardId']);
            
            $board = $App__boardService->getBoardById($boardId);

                // boardId에 따른 SQL문 추가
                if($board != null){  // boardId에 해당하는 게시판이 존재할 경우
                    $loginPage = true;
                    $pageTitle = "${board['name']}게시판의 게시물 리스트";
                }else{
                    $loginPage = true;
                    $pageTitle = "존재하지 않는 게시판";
                    
                    jsHistoryBackExit("${boardId}번 게시판은 존재하지 않습니다.");
                    jsLocationReplaceExit("list", "${boardId}번 게시판은 존재하지 않습니다.");
                }
            }else {
                $boardId = 0;
            }
            }else{
                $boardId = 0;
            }
            //  boardId 필터링 (끝)

            //  searchKeyword 필터링 (시작)        
            if(!empty($_REQUEST['searchKeyword'])){
                $searchKeyword = $_REQUEST['searchKeyword'];
            }else{
                $searchKeyword = "";
            }
            //  searchKeyword 필터링 (끝)
            

            
            // 최종적으로 출력될 게시물들을 카운팅하기 위한 쿼리

            $paging = false; 
            $articleStart = 0;
            $itemCountInAPage = 0;
            $filteredArticles = $this->articleService->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
            
            
           
            
            
              $arrayCount = $this->articleService->getArticleCount($searchKeyword, $boardId);  // 불러올 게시물 총 갯수 카운트
              $totalRecord = $arrayCount['articleCount'];
              
              
              $itemCountInAPage = 2; // 한 페이지에 보여줄 게시물 개수  >> itemCountInAPage
              $blockCount = 5; // 한 블록에 표시할 페이지 번호 갯수
              $blockNum = ceil($page / $blockCount); // 현재 페이지가 해당하는 블록 
              // 현재 페이지가 5씩 넘어갈 때마다 한 블록씩 넘어간다.
              $blockStart = (($blockNum - 1) * $blockCount) + 1; // 블록 내, 페이지 시작 번호
              // 현재 블록이 1이면, 블록 시작번호 = 1 , 2이면 , 시작번호 = 6
              $blockEnd = $blockStart + $blockCount - 1; // 블록의 마지막 번호
              // 1~5 / 6~10 ...

              $totalPage = ceil($totalRecord / $itemCountInAPage); // 게시물 갯수에 따른 총 페이지 수
              if($blockEnd > $totalPage){
                  $blockEnd = $totalPage; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
              }
              $totalBlock = ceil($totalPage / $blockCount); // 블록의 총 개수
              $articleStart = ($page - 1) * $itemCountInAPage; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

              // 최종적으로 출력될 게시물들을 불러오는 쿼리
              $paging = true;
              $filteredArticles = $this->articleService->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
              

//  게시판 선택 시 , 게시판 별 게시물을 불러오고, 미선택 시, 게시물 전체 리스트를 불러옴. (끝)
    

    require_once App__GetViewPath("usr/article/list");
  }

  public function actionShowDetail() {
    /* 게시물 상세페이지 필터링 (시작) */
    $id = getIntValueOr($_REQUEST['id'], 0);

    if ( $id == 0 ) {
      jsHistoryBackExit("게시물 번호를 입력해주세요.");
    }
    
    $article = $this->articleService->getForPrintArticleById($id);

    if ( $article == null ) {
      jsLocationReplaceExit("list", "${id}번 게시물은 존재하지 않습니다.");
    }

    /* 게시물 상세페이지 필터링 (끝) */

    // 조회수 관련 (시작)
   


    $articleIndex = strval($article['id']);
    $articleStr = "article".$articleIndex;  // articleId에 해당하는 고유 세션명 지정.

    


    if(isset($_SESSION['loginedMemberId']) && !isset($_SESSION['$articleStr']) ){


    


      // 로그인이 된 상태이고, 조회한 이력이 없을 경우에 조회수가 1 올라간다.
      
      
      $this->articleService->addArticleCount($id); // article 테이블의 조회수(count)를 1 올린다.
      
      
      $_SESSION['$articleStr'] = 1; // 로그인한 회원이 해당 article/detail을 조회했을 때, 1로 세팅. 중복 조회수 올리기 불가
      
      

      }
    
    // 조회수 관련 (끝)

    // 좋아요 관련 (시작)  ※ heart = 100, 회색 하트 / heart = 1, 빨간 하트
  

        if(isset($_SESSION['loginedMemberId'])){

        $loginedMemberId = intval($_SESSION['loginedMemberId']);
        
        
        // 현재 로그인된 유저가 좋아요를 이미 눌렀는지 확인하기 위해 테이블 조회
        $arrayForm = $this->articleService->getArticleHeart($loginedMemberId, $id);
        
        if(isset($arrayForm)){
          $array = intval($arrayForm['digitalCode']);
        }else{
          $array = 100;
        }
        
        
       
        
        if($array != null)  {
        
        // array가 빈 경우가 아니면, 좋아요를 눌렀거나, 눌렀다가 취소한적이 있는 경우로, 100 또는 1의 값을 heart로 한다.  
        $heart = $array;
        
        

        }else{
        
          // 로그인을 했지만, 좋아요를 누른 적이 없는 경우, 해당 유저 id 및 articleId에 해당하는 row에 100을 넣어주고, heart에 100을 준다.
          $this->articleService->insertZeroInArticleHeart($loginedMemberId, $id);
          $heart = 100;
          
        }
        
    }else{
        // 로그인이 안 된 경우, 회색 하트가 보이도록.
        $heart = 100;
    }

    //  좋아요 관련 (끝))  



    $articleDetail = $this->articleService->getForPrintArticleDetail($id);
    

    require_once App__GetViewPath("usr/article/detail");
  }

  public function actionDoLiked() {

    $articleId = getIntValueOr($_REQUEST['articleId'], 0);
    if($articleId == 0){
        jsHistoryBackExit("게시물 번호(id)가 존재하지 않습니다.");
    }

    $memberId = getIntValueOr($_REQUEST['memberId'], 0);
    if($memberId == 0){
        jsHistoryBackExit("회원이 존재하지 않습니다.");
    }


    $arrayDigitalCode = $this->articleService->checkLiked($memberId, $articleId);
    $digitalCode = intval($arrayDigitalCode['digitalCode']);
    

    

    
    
    
    if($digitalCode == 1){

        // digitalCode가 1인 경우, 좋아요를 눌렀던 상태이므로 좋아요를 해제한 것이다.
        
        $digitalCode = 100;
        $this->articleService->removeArticleLiked($articleId); // 좋아요 카운트 증가
        $this->articleService->changeHeart($digitalCode, $memberId, $articleId);
        $getArticleLikedCount = $this->articleService->getArticleLikedCount($articleId);
        $articleLikedCount = intval($getArticleLikedCount['liked']);
        ?>
        <div id="articleLiked" class="flex">
        <button><i class="far fa-heart"></i></button>
        <div class="ml-1"><?=$articleLikedCount;?></div>
        </div>
        <?php
        
        // jsLocationReplaceExit("detail?id=${articleId}", "좋아요를 눌렀습니다.");
        
        
        jsAlert("좋아요를 취소했습니다.");
        

     }else { 

        
        // digitalCode가 1이 아닌 경우(=0), 좋아요를 안 눌렀던 상태이므로 좋아요를 누른 것이다.
        $digitalCode = 1;
        $this->articleService->addArticleLiked($articleId); // 좋아요 카운트 감소
        $this->articleService->changeHeart($digitalCode, $memberId, $articleId);
        $getArticleLikedCount = $this->articleService->getArticleLikedCount($articleId);
        $articleLikedCount = intval($getArticleLikedCount['liked']);
        ?>
        <div id="articleLiked" class="flex">
        <button><i style="color:red;" class="fas fa-heart"></i></button>
        <div class="ml-1"><?=$articleLikedCount;?></div>
        </div>
        
        <?php
        
        // jsLocationReplaceExit("detail?id=${articleId}", "좋아요를 취소했습니다.");
        jsAlert("좋아요를 눌렀습니다.");
            
    }
    



  }

  public function actionShowModify() {


    $id = getIntValueOr($_REQUEST['id'], 0);

    if ( $id == 0 ) {
      jsHistoryBackExit("번호를 입력해주세요.");
    }

    $article = $this->articleService->getForPrintArticleById($id);

    if ( $article == null ) {
      jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
    }

    if($article['memberId'] != $_SESSION['loginedMemberId']){
      jsHistoryBackExit("권한이 없습니다.");
    }

    require_once App__GetViewPath("usr/article/modify");
  }

  public function actionDoModify() {

    
    $id = getIntValueOr($_REQUEST['id'], 0);
    $title = getStrValueOr($_REQUEST['title'], "");
    $body = getStrValueOr($_REQUEST['body'], "");

    if ( !$id ) {
      jsHistoryBackExit("번호를 입력해주세요.");
    }

    if ( !$title ) {
      jsHistoryBackExit("제목을 입력해주세요.");
    }

    if ( !$body ) {
      jsHistoryBackExit("내용을 입력해주세요.");
    }

    $article = $this->articleService->getForPrintArticleById($id);

    if ( $article == null ) {
      jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
    }
    if($article['memberId'] != $_SESSION['loginedMemberId']){
      jsHistoryBackExit("권한이 없습니다.");
    }

    $this->articleService->modifyArticle($id, $title, $body);

    jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 수정되었습니다.");
  }


}