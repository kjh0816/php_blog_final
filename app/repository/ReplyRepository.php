<?php
class APP__ReplyRepository {

    public function getReplyById(int $replyId):array|null {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM reply");
        $sql->add("WHERE id = ?", $replyId);
        return DB__getRow($sql);
    }

    public function deleteReply(int $replyId) {
        $sql = DB__secSql();
        $sql->add("DELETE FROM reply");
        $sql->add("WHERE id = ?", $replyId);
        DB__delete($sql);
    }

    public function writeReply(int $relId, int $memberId, string $body): int {
        $sql = DB__secSql();
        $sql->add("INSERT INTO reply");
        $sql->add("SET regDate = NOW()");
        $sql->add(", updateDate = NOW()");
        $sql->add(", memberId = $memberId");
        $sql->add(", relTypeCode = 'article'");
        $sql->add(", relId = ?", $relId);
        $sql->add(", liked = 0");
        $sql->add(", `body` = ?", $body);
        $replyId = DB__insert($sql);
        return $replyId;
    }

    public function modifyReply(int $replyId, string $body) {
        $sql = DB__secSql();
        $sql->add("UPDATE reply");
        $sql->add("SET body = ?", $body);
        $sql->add("WHERE id = ?", $replyId);
        DB__update($sql);
    }

    public function getRepliesAsUnloginedMember(int $articleId): array|null {
        $sql = DB__secSql();
        $sql->add("SELECT R.body `body`");
        $sql->add(", R.liked `liked`");
        $sql->add(", R.id `replyId`");
        $sql->add(", R.relId `articleId`");
        $sql->add(", M.nickname `nickname`");
        $sql->add(", M.id `memberId`");
        $sql->add("FROM reply `R`");
        $sql->add("INNER JOIN `member` `M`");
        $sql->add("ON M.id = R.memberId");
        $sql->add("WHERE R.relId = ?", $articleId);
        $sql->add("ORDER BY R.liked DESC");
        return DB__getRows($sql);
    }

    public function getRepliesAsLoginedMember(int $articleId, int $loginedMemberId): array|null {
        $sql = DB__secSql();
        $sql->add("SELECT DISTINCT R.body `body`");
        $sql->add(", R.liked `liked`");
        $sql->add(", R.id `replyId`");
        $sql->add(", R.relId `articleId`");
        $sql->add(", M.nickname `nickname`");
        $sql->add(", M.id `memberId`");
        $sql->add(", IFNULL((SELECT digitalCode FROM replyLiked `L`");
        $sql->add("WHERE L.articleId = ?", $articleId);
        $sql->add("AND L.memberId = ?", $loginedMemberId);
        $sql->add("AND L.replyId = R.id");
        $sql->add("), 100) AS `digitalCode`");
        $sql->add("FROM reply `R`");
        $sql->add("LEFT JOIN replyLiked `L`");
        $sql->add("ON R.id = L.replyId");
        $sql->add("LEFT JOIN `member` `M`");
        $sql->add("ON M.id = R.memberId");
        $sql->add("LEFT JOIN article `A`");
        $sql->add("ON A.id = L.articleId");
        $sql->add("WHERE R.relId = ?", $articleId);
        $sql->add("ORDER BY R.liked DESC");
        
        return DB__getRows($sql);
    }

    public function getReplyHeart(int $articleId, int $memberId, int $replyId): array|null {
        $sql = DB__secSql();
        $sql->add("SELECT digitalCode");
        $sql->add("FROM replyLiked");
        $sql->add("WHERE articleId = ?", $articleId);
        $sql->add("AND memberId = ?", $memberId);
        $sql->add("AND replyId = ?", $replyId);
        return DB__getRow($sql);

    }

    public function insertReplyHeart($articleId, $memberId, $replyId, $digitalCode): int {
        $sql = DB__secSql();
        $sql->add("INSERT INTO replyLiked");
        $sql->add("SET memberId = ?", $memberId);
        $sql->add(", articleId = ?", $articleId);
        $sql->add(", replyId = ?", $replyId); 
        $sql->add(", digitalCode = ?",$digitalCode);
        $isHeartNull = DB__insert($sql);
        return $isHeartNull;
    }

    public function changeReplyHeart(int $articleId, int $memberId, int $replyId, int $digitalCode) {
        $sql = DB__secSql();
        $sql->add("UPDATE replyLiked");
        $sql->add("SET digitalCode = ?", $digitalCode);
        $sql->add("WHERE articleId = ?", $articleId);
        $sql->add("AND memberId = ?", $memberId);
        $sql->add("AND replyId = ?", $replyId);
        DB__update($sql);
    }
    
    public function updateReplyLiked(int $replyId, int $isLiked){
        $sql = DB__secSql();
        $sql->add("UPDATE reply");
        $sql->add("SET liked = liked + ?", $isLiked);
        $sql->add("WHERE id = ?", $replyId);
        DB__update($sql);
    }


    public function getRowTest(int $articleId, int $loginedMemberId, int $replyid): array|null {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM replyLiked");
        $sql->add("WHERE articleId = ?", $articleId);
        $sql->add("AND memberId = ?", $loginedMemberId);
        $sql->add("AND replyId = ?", $replyid);
        return DB__getRow($sql);
    }
}