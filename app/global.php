<?php
// 리포지터리
$App__memberRepository = new APP__MemberRepository();
$App__articleRepository = new APP__ArticleRepository();
$App__boardRepository = new APP__BoardRepository();
$App__replyRepository = new APP__ReplyRepository();

// 서비스 전역변수
$App__memberService = new APP__MemberService();
$App__articleService = new APP__ArticleService();
$App__boardService = new APP__BoardService();
$App__replyService = new APP__ReplyService();

// 어플리케이션
$application = new App__Application();