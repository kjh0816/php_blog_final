<?php
class APP__UsrBoardController {
  private APP__BoardService $boardService;

  public function __construct() {
    global $App__boardService;
    $this->boardService = $App__boardService;

    
  }

  public function actionShowAdd() {
    require_once App__getViewPath("usr/board/add");
}


public function actionDoAdd() {
  $memberId = intval($_SESSION['loginedMemberId']);



$name = getStrValueOr($_REQUEST['name'], "");
if(empty($name)){
    jsHistoryBackExit("게시판 이름을 입력해주세요.");
}


$code = getStrValueOr($_REQUEST['code'], "");
if(empty($code)){
    jsHistoryBackExit("게시판 코드를 입력해주세요.");
}

$board = $this->boardService->getForPrintBoardByName($name);
if ( $board != null ) {
  jsHistoryBackExit("${name} 게시판이 이미 존재합니다.");
}

$board2 = $this->boardService->getForPrintBoardByCode($code);
if ( $board2 != null ) {
  jsHistoryBackExit("${code} 게시판 코드가 이미 존재합니다.");
}

$boardId = $this->boardService->addBoard($memberId, $name, $code);


jsLocationReplaceExit("detail?id=${boardId}", "${boardId}번 게시판이 추가되었습니다.");
  
}


public function actionShowDetail() {

  $boardId = getIntValueOr($_REQUEST['id'], 0);
  if($boardId == 0){
      jsHistoryBackExit("게시판 번호를 입력해주세요.");
  }


  $board = $this->boardService->getBoardById($boardId);
  if($board == null){
    jsHistoryBackExit("${boardId}번 게시판이 존재하지 않습니다.");
  }
  
  $memberId = $board['memberId'];

  global $App__memberService;
  $member = $App__memberService->getForPrintMemberById($memberId);
  
  $nickname = $member['nickname'];

  

  require_once App__getViewPath("usr/board/detail");

}

public function actionShowList() {

  $boardList = $this->boardService->getForPrintBoardList();

  require_once App__getViewPath("usr/board/list");
  

}

public function actionDoDelete() {

  $boardId = getIntValueOr($_REQUEST['id'], 0);
  if($boardId == 0){
      jsHistoryBackExit("게시판 번호를 입력해주세요.");
  }

  $board = $this->boardService->getBoardById($boardId);
  if($board == null){
    jsHistoryBackExit("${boardId}번 게시판이 존재하지 않습니다.");
  }



 if($_SESSION['loginedMemberId'] == 1){ 

    $this->boardService->deleteBoard($boardId);

    jsLocationReplaceExit("list", "${boardId}번 게시판이 관리자 권한으로 삭제되었습니다.");


  }else { 

  if($board['memberId'] != $_SESSION['loginedMemberId']){ 

    jsHistoryBackExit("권한이 없습니다.");
    

   }else{
  
    $this->boardService->deleteBoard($boardId); 
    
     jsLocationReplaceExit("list", "${boardId}번 게시판이 삭제되었습니다.");
    }
 } 
  

}

public function actionShowModify() {

  $boardId = getIntValueOr($_REQUEST['id'], 0);
  if($boardId == 0){
      jsHistoryBackExit("게시판 번호를 입력해주세요.");
  }

  $board = $this->boardService->getBoardById($boardId);
  if($board == null){
     jsHistoryBackExit("${boardId}번 게시판이 존재하지 않습니다.");
  }

  if($board['memberId'] != $_SESSION['loginedMemberId']){ 

    jsHistoryBackExit("권한이 없습니다.");
    

   }

   require_once App__getViewPath("usr/board/modify");

}

public function actionDoModify() {

  $boardId = getIntValueOr($_REQUEST['id'], 0);
  if($boardId == 0){
      jsHistoryBackExit("게시판 번호를 입력해주세요.");
  }

  $board = $this->boardService->getBoardById($boardId);
  if($board == null){
    jsHistoryBackExit("${boardId}번 게시판이 존재하지 않습니다.");
  }

  if($board['memberId'] != $_SESSION['loginedMemberId']){ 

    jsHistoryBackExit("권한이 없습니다.");
    

   }

   $name = getStrValueOr($_REQUEST['name'], "");
    if(empty($name)){
        jsHistoryBackExit("게시판 이름을 입력해주세요.");
    }


  $code = getStrValueOr($_REQUEST['code'], "");
  if(empty($code)){
      jsHistoryBackExit("게시판 코드를 입력해주세요.");
  }

  
  
  $board2 = $this->boardService->getForPrintBoardByName($name);
  if($board2 != null){
    jsHistoryBackExit("${name} 게시판이 이미 존재합니다.");
  }
  $board3 = $this->boardService->getForPrintBoardByCode($code);
  if($board3 != null){
    jsHistoryBackExit("${code} 게시판 코드가 이미 존재합니다.");
  }


  $this->boardService->modifyBoard($boardId, $name, $code);
    
  jsLocationReplaceExit("detail?id=${boardId}", "${boardId}번 게시판이 수정되었습니다.");

}







}