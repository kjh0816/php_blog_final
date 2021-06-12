<?php

function App__runBeforActionInterceptor(string $action) {
  global $App__memberService;

  $_REQUEST['App__isLogined'] = false;
  $_REQUEST['App__loginedMemberId'] = 0;
  $_REQUEST['App__loginedMember'] = null;
  
  if ( isset($_SESSION['loginedMemberId']) ) {

    $_REQUEST['App__isLogined'] = true;
    $_REQUEST['App__loginedMemberId'] = intval($_SESSION['loginedMemberId']);
    $_REQUEST['App__loginedMember'] = $App__memberService->getForPrintMemberById($_REQUEST['App__loginedMemberId']);
  }
}

function App__runNeedLoginInterceptor(string $action) {
  
  // 로그인이 필요없는 페이지들
  switch ( $action ) {
    case 'usr/member/login':
    case 'usr/member/doLogin':
    case 'usr/member/doLogout':
    case 'usr/member/join':
    case 'usr/member/doJoin':
    case 'usr/member/home':
    case 'usr/article/list':
    case 'usr/article/detail':
    // case 'usr/home/aboutMe':
      return;
  }
  
  if ( $_REQUEST['App__isLogined'] == false ) {
 
    jsHistoryBackExit("로그인 후 이용해주세요.");
  }
 
}

function App__runNeedLogoutInterceptor(string $action) {
  // 로그인된 상태에서 접근하면 안 되는 페이지들
  switch ( $action ) {
    case 'usr/member/login':
    case 'usr/member/doLogin':
    case 'usr/member/join':
    case 'usr/member/doJoin':
      break;
    default:
      return;
  }

  if ( $_REQUEST['App__isLogined'] ) {
    jsHistoryBackExit("로그아웃 후 이용해주세요.");
  }
}

function App__runInterceptors(string $action) {
  App__runBeforActionInterceptor($action);
  App__runNeedLoginInterceptor($action);
  App__runNeedLogoutInterceptor($action);
}
