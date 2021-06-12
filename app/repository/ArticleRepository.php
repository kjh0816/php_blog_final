<?php
class APP__ArticleRepository {
  public function getForPrintArticles(): array {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM article AS A");
    $sql->add("ORDER BY A.id DESC");
    return DB__getRows($sql);
  }

  public function getForPrintArticleById(int $id): array|null {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM article AS A");
    $sql->add("WHERE id = ?", $id);
    return DB__getRow($sql);
  }

  public function writeArticle(string $title, string $body, int $boardId, int $memberId):int {
    $sql = DB__secSql();
    $sql->add("INSERT INTO article");
    $sql->add("SET regDate = NOW()");
    $sql->add(", updateDate = NOW()");
    $sql->add(", memberId = ?", $memberId);
    $sql->add(", boardId = ?", $boardId);
    $sql->add(", liked = 0");
    $sql->add(", count = 0");
    $sql->add(", title = ?", $title);
    $sql->add(", `body` = ?", $body);
    $id = DB__insert($sql);

    return $id;
  }

  public function modifyArticle(int $id, string $title, string $body) {
    $sql = DB__secSql();
    $sql->add("UPDATE article");
    $sql->add("SET updateDate = NOW()");
    $sql->add(", title = ?", $title);
    $sql->add(", `body` = ?", $body);
    $sql->add("WHERE id = ?", $id);
    DB__update($sql);
  }

  public function deleteArticle(int $id) {
    $sql = DB__secSql();
    $sql->add("DELETE FROM article");
    $sql->add("WHERE id = ?", $id);
    DB__delete($sql);
  }

  public function getForPrintArticleDetail(int $id):array {
    $sql = DB__secSql();
    $sql->add("SELECT A.id `id`");
    $sql->add(", A.regDate `regDate`");
    $sql->add(", A.updateDate `updateDate`");
    $sql->add(", A.liked `liked`");
    $sql->add(", A.count `count`");
    $sql->add(", A.title `title`");
    $sql->add(", A.body `body`");
    $sql->add(", B.name `name`");
    $sql->add(", M.nickname `nickname`");
    $sql->add("FROM board `B`");
    $sql->add("INNER JOIN article `A`");
    $sql->add("ON B.id = A.boardId");
    $sql->add("INNER JOIN `member` `M`");
    $sql->add("ON A.memberId = M.id");
    $sql->add("WHERE A.id = ?", $id);
    return DB__getRow($sql);
  }

  public function addArticleCount(int $id){
    $sql = DB__secSql();
    $sql->add("UPDATE article");
    $sql->add("SET `count` = `count`+1");
    $sql->add("WHERE id = ?", $id);
    DB__update($sql);
  }

  public function getArticleHeart(int $loginedMemberId, int $id){
    $sql = DB__secSql();
    $sql->add("SELECT digitalCode");
    $sql->add("FROM articleLiked");
    $sql->add("WHERE memberId = ?", $loginedMemberId);
    $sql->add("AND articleId = ?", $id);
    return DB__getRow($sql);
  }

  public function insertZeroInArticleHeart(int $loginedMemberId, int $id){
    $sql = DB__secSql();
    $sql->add("INSERT INTO articleLiked");
    $sql->add("SET memberId = ?", $loginedMemberId);
    $sql->add(", articleId = ?", $id);
    $sql->add(", digitalCode = 100");
    DB__insert($sql);
  }

  public function changeHeart(int $digitalCode, int $memberId, int $articleId){
    echo $digitalCode;
    echo $memberId;
    echo $articleId;
    $sql = DB__secSql();
    $sql->add("UPDATE articleLiked");
    $sql->add("SET digitalCode = ?", $digitalCode);
    $sql->add("WHERE memberId = ?", $memberId);
    $sql->add("AND articleId = ?", $articleId);
    DB__update($sql);
  }

  public function addArticleLiked(int $articleId){
    $sql = DB__secSql();
    $sql->add("UPDATE article");
    $sql->add("SET liked = liked + 1");
    $sql->add("WHERE id = ?", $articleId);
    DB__update($sql);
  }

  public function removeArticleLiked(int $articleId){
    $sql = DB__secSql();
    $sql->add("UPDATE article");
    $sql->add("SET liked = liked - 1");
    $sql->add("WHERE id = ?", $articleId);
    DB__update($sql);
  }

  public function getSearchKeywordAndBoardIdFilteredArticles(string $searchKeyword, int $boardId, bool $paging, int $articleStart, int $itemCountInAPage): array|null{
    
    $sql = DB__secSql();
    $sql->add("SELECT A.id `id`");
    $sql->add(", A.regDate `regDate`");
    $sql->add(", A.liked `liked`");
    $sql->add(", A.count `count`");
    $sql->add(", A.title `title`");
    $sql->add(", B.name `name`");
    $sql->add(", M.nickname `nickname`");
    $sql->add(", (SELECT COUNT(*) FROM reply WHERE relId = A.id) AS `replyCount`");
    $sql->add("FROM board `B`");
    $sql->add("INNER JOIN article `A`");
    $sql->add("ON B.id = A.boardId");
    $sql->add("INNER JOIN `member` `M`");
    $sql->add("ON A.memberId = M.id");
    $sql->add("WHERE 1 = 1");

    if($boardId != 0){
      $sql->add("AND A.boardId = ?", $boardId);
    }

    if(!empty($searchKeyword)){
      
      $sql->add("AND A.title like ?", "%".$searchKeyword."%");
      $sql->add("OR A.body like ?", "%".$searchKeyword."%");
    }
  

    if($paging == true){
      $sql->add("ORDER BY A.id DESC");
      $sql->add("LIMIT ${articleStart}");
      $sql->add(", ${itemCountInAPage}");
    }
    
    

    return DB__getRows($sql);
    
    
  }

  public function getArticleCount(string $searchKeyword, int $boardId): array{
    $sql = DB__secSql();
    $sql->add("SELECT count(*) AS `articleCount`");
    $sql->add("FROM article");
    $sql->add("WHERE 1 = 1");

    if($boardId != 0){
      $sql->add("AND boardId = ?", $boardId);
    }

    if(!empty($searchKeyword)){
      $sql->add("AND title like ?", "%".$searchKeyword."%");
      $sql->add("OR `body` like ?", "%".$searchKeyword."%");
    }

    
    
    return DB__getRow($sql);
  }

    


  


}