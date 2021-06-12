<?php
class APP__ArticleService {
  private APP__ArticleRepository $articleRepository;

  public function __construct() {
    global $App__articleRepository;
    $this->articleRepository = $App__articleRepository;
  }

  public function getForPrintArticles(): array {
    return $this->articleRepository->getForPrintArticles();
  }

  public function getForPrintArticleById(int $id): array|null {
    return $this->articleRepository->getForPrintArticleById($id);
  }

  public function writeArticle(string $title, string $body, int $boardId, int $memberId): int {
    return $this->articleRepository->writeArticle($title, $body, $boardId, $memberId);
  }

  public function modifyArticle(int $id, string $title, string $body) {
    $this->articleRepository->modifyArticle($id, $title, $body);
  }

  public function deleteArticle(int $id) {
    $this->articleRepository->deleteArticle($id);
  }

  public function getForPrintArticleDetail(int $id):array {
    return $this->articleRepository->getForPrintArticleDetail($id);
  }

  public function addArticleCount(int $id) {
    $this->articleRepository->addArticleCount($id);
  }

  public function getArticleHeart(int $loginedMemberId, int $id): array|null {
    return $this->articleRepository->getArticleHeart($loginedMemberId, $id);
  }

  public function insertZeroInArticleHeart(int $loginedMemberId, int $id) {
    $this->articleRepository->insertZeroInArticleHeart($loginedMemberId, $id);
  }

  public function changeHeart(int $digitalCode, int $memberId, int $articleId){
    $this->articleRepository->changeHeart($digitalCode, $memberId, $articleId);
  }

  public function addArticleLiked(int $articleId){
    $this->articleRepository->addArticleLiked($articleId);
  }

  public function removeArticleLiked(int $articleId){
    $this->articleRepository->removeArticleLiked($articleId);
  }

  public function getSearchKeywordAndBoardIdFilteredArticles(string $searchKeyword, int $boardId, bool $paging, int $articleStart, int $itemCountInAPage): array|null{
    return $this->articleRepository->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
  }

  public function getArticleCount(string $searchKeyword, int $boardId): array {
    return $this->articleRepository->getArticleCount($searchKeyword, $boardId);
  }

  
  
}