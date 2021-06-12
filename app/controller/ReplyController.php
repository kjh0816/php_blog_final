<?php
class APP__UsrReplyController {
  private APP__ReplyService $replyService;

  public function __construct() {
    global $App__replyService;
    $this->replyService = $App__replyService;
  }

  public function actionShowList(){



    
    $articleId = getIntValueOr($_REQUEST['id'], 0);

    
    if($articleId == 0){
      jsLocationReplaceExit("../article/list", "게시물 번호가 입력되지 않았습니다.");
    }

    

    

    global $App__articleService;
    $article = $App__articleService->getForPrintArticleById($articleId);
    if($article == null){
      jsLocationReplaceExit("../article/list", "${articleId}번 게시물이 존재하지 않습니다.");
    }

    
    
      
    
    
      if(isset($_SESSION['loginedMemberId'])){

      
        
        $loginedMemberId = intval($_SESSION['loginedMemberId']);
        
        
        // 로그인된 사용자인 경우,
        

        $replies = $this->replyService->getRepliesAsLoginedMember($articleId, $loginedMemberId);
        
        


        
      }else{
        

        // 로그인된 사용자가 아닌 경우, 
        $replies = $this->replyService->getRepliesAsUnloginedMember($articleId);
        $replyHeart = 100; // 회색 하트만 보인다.

        
        
      }

      require_once App__getViewPath("usr/reply/list");

  }

  public function actionDoLiked() {

    $memberId = $_SESSION['loginedMemberId'];

    $articleId = getIntValueOr($_REQUEST['articleId'], 0);
    if($articleId == 0){
        jsHistoryBackExit('게시물이 존재하지 않습니다.');
    }

    

    $replyId = getIntValueOr($_REQUEST['replyId'], 0);
    if($replyId == 0){
        jsHistoryBackExit('댓글이 존재하지 않습니다.');
    }

    $digitalCode = getIntValueOr($_REQUEST['digitalCode'], 3);
    if($digitalCode == 3){
        jsHistoryBackExit('잘못된 접근입니다.');
    }



    $isHeartNull = $this->replyService->getReplyHeart($articleId, $memberId, $replyId);
    
    // user2 의 경우, 처음 좋아요를 눌렀으므로, 당연히 insert가 실행됨.
    
    if(!empty($isHeartNull)){
      
      
      $this->replyService->changeReplyHeart($articleId, $memberId, $replyId, $digitalCode);
      // $isHeartNull = $this->replyService->getReplyHeart($articleId, $memberId, $replyId);
      
      
    }else{

      $this->replyService->insertReplyHeart($articleId, $memberId, $replyId, $digitalCode);
      // 값이 없을 경우, INSERT

    }
    




    if($digitalCode == 1){

        $isLiked = 1;
        $this->replyService->updateReplyLiked($replyId, $isLiked);
        
        jsLocationReplaceExit("/usr/article/detail?id=${articleId}", "좋아요를 눌렀습니다.");
        
        
        
      }else { 

        
        $isLiked = -1;
        $this->replyService->updateReplyLiked($replyId, $isLiked);

        jsLocationReplaceExit("/usr/article/detail?id=${articleId}", "좋아요를 취소했습니다.");

      }

  }

  public function actionDoDelete() {



    $replyId = getIntValueOr($_REQUEST['id'], 0);
    if($replyId == 0){
        jsHistoryBackExit('댓글이 존재하지 않습니다.');
    }



    $reply = $this->replyService->getReplyById($replyId);
    if($reply == null){
        jsHistoryBackExit('댓글이 존재하지 않습니다.');
    }

    if($_SESSION['loginedMemberId'] == $reply['memberId'] || $_SESSION['loginedMemberId'] == 1){
    
    $this->replyService->deleteReply($replyId);

    if($_SESSION['loginedMemberId'] == 1){
        jsHistoryBackExit('관리자 권한으로 댓글을 삭제했습니다.');
        
    }else{
        jsHistoryBackExit('댓글을 삭제했습니다.');
    }

    }else{
        jsHistoryBackExit('권한이 없습니다.');
    }



  }

  public function actionDoWrite() {


    $memberId = $_SESSION['loginedMemberId'];

    $relId = getIntValueOr($_REQUEST['relId'], 0);
    if($relId == 0){
      jsHistoryBackExit('게시물이 존재하지 않습니다.');
    }

    $body = getStrValueOr($_REQUEST['body'], "");
    if(empty($body)){
        jsHistoryBackExit('댓글을 입력해주세요.');
    }

    $replyId = $this->replyService->writeReply($relId, $memberId, $body);


    jsLocationReplaceExit("/usr/article/detail?id=${relId}", "댓글이 등록되었습니다.");


  }

  public function actionDoModify() {


    $replyId = getIntValueOr($_REQUEST['id'], 0);
    if($replyId == 0){
      jsHistoryBackExit('댓글이 존재하지 않습니다.');
    }


    $body = getStrValueOr($_REQUEST['body'], "");
    if(empty($body)){
      jsHistoryBackExit('수정할 댓글을 입력해주세요.');
    }

      $reply = $this->replyService->getReplyById($replyId);
      if($reply == null){
          jsHistoryBackExit('댓글이 존재하지 않습니다.');
      }

      if($_SESSION['loginedMemberId'] == $reply['memberId']){
    


        $this->replyService->modifyReply($replyId, $body);

    
          jsHistoryBackExit('댓글을 수정했습니다.');
          
      }else{
          jsHistoryBackExit('권한이 없습니다.');
      }


    

  }



  



}