<?php
class APP__BoardRepository {
  public function getForPrintBoards(): array {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM board AS B");
    $sql->add("ORDER BY B.id DESC");
    return DB__getRows($sql);
  }

  public function getForPrintBoardByName(string $name): array|null {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM board AS B");
    $sql->add("WHERE `name` = ?", $name);
    return DB__getRow($sql);
  }

  public function getForPrintBoardByCode(string $code): array|null {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM board AS B");
    $sql->add("WHERE `code` = ?", $code);
    return DB__getRow($sql);
  }

  public function addBoard(int $memberId, string $name, string $code): int {
    $sql = DB__secSql();
    $sql->add("INSERT INTO board");
    $sql->add("SET regDate = NOW()");
    $sql->add(", updateDate = NOW()");
    $sql->add(", memberId = ?", $memberId);
    $sql->add(", `name` = ?", $name);
    $sql->add(", `code` = ?", $code);
    $boardId = DB__insert($sql);
    return $boardId;
  }

  public function getBoardById(int $id): array|null {
    $sql = DB__secSql();
    $sql->add("SELECT *");
    $sql->add("FROM board");
    $sql->add("WHERE id = ?", $id);
    return DB__getRow($sql);
  }

  public function getForPrintBoardList(): array|null {
    $sql = DB__secSql();
    $sql->add("SELECT board.id `id`");
    $sql->add(", board.regDate `regDate`");
    $sql->add(", board.updateDate `updateDate`");
    $sql->add(", board.name `name`");
    $sql->add(", board.code `code`");
    $sql->add(", member.nickname `nickname`");
    $sql->add("FROM board");
    $sql->add("INNER JOIN `member`");
    $sql->add("ON board.memberId = member.id");
    return DB__getRows($sql);
  }

  public function deleteBoard(int $boardId) {
    $sql = DB__secSql();
    $sql->add("DELETE FROM board");
    $sql->add("WHERE id = ?", $boardId);
    DB__delete($sql);
  }

  public function modifyBoard(int $boardId, string $name, string $code){
    $sql = DB__secSql();
    $sql->add("UPDATE board");
    $sql->add("SET updateDate = NOW()");
    $sql->add(", name = ?", $name);
    $sql->add(", code = ?", $code);
    $sql->add("WHERE id = ?", $boardId);
    DB__update($sql);
  }

  

}