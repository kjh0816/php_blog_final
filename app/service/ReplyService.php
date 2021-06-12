<?php
class APP__ReplyService {
  private APP__ReplyRepository $replyRepository;

  public function __construct() {
    global $App__replyRepository;
    $this->replyRepository = $App__replyRepository;
  }

  public function getReplyById(int $replyId):array|null {
      return $this->replyRepository->getReplyById($replyId);
  }

  public function deleteReply(int $replyId){
      $this->replyRepository->deleteReply($replyId);
  }

  public function writeReply(int $relId, int $memberId, string $body): int {
    return $this->replyRepository->writeReply($relId, $memberId, $body);
  }

  public function modifyReply(int $replyId, string $body) {
      $this->replyRepository->modifyReply($replyId, $body);
  }

  public function getRepliesAsUnloginedMember(int $articleId, ):array|null {
      return $this->replyRepository->getRepliesAsUnloginedMember($articleId);
  }

  public function getRepliesAsLoginedMember(int $articleId, int $loginedMemberId): array|null {
    return $this->replyRepository->getRepliesAsLoginedMember($articleId, $loginedMemberId);
  }

  public function changeReplyHeart(int $articleId, int $memberId, int $replyId, int $digitalCode){
    $this->replyRepository->changeReplyHeart($articleId, $memberId, $replyId, $digitalCode);
  }

  public function updateReplyLiked(int $replyId, int $isLiked){
    $this->replyRepository->updateReplyLiked($replyId, $isLiked);
  }

  public function getReplyHeart(int $articleId, int $memberId, int $replyId): array|null{
    return $this->replyRepository->getReplyHeart($articleId, $memberId, $replyId);
  }

  public function insertReplyHeart(int $articleId, int $memberId, int $replyId, int $digitalCode): int {
    return $this->replyRepository->insertReplyHeart($articleId, $memberId, $replyId, $digitalCode);
  }

  public function getRowTest(int $articleId, int $loginedMemberId, int $replyId): array|null {
    return $this->replyRepository->getRowTest($articleId, $loginedMemberId, $replyId);
  }




}