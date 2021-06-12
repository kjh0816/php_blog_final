<?php
class APP__UsrMemberController {
  private APP__MemberService $memberService;

  public function __construct() {
    global $App__memberService;
    $this->memberService = $App__memberService;
  }

  public function actionShowLogin() {
    require_once App__getViewPath("usr/member/login");
  }

  public function actionDoLogout() {
    // 조회수에도 세션을 이용하기 때문에 로그인 회원을 포함한 모든 세션 제거.
    session_unset(); 
    jsLocationReplaceExit("home");
  }

  public function actionDoLogin() {


    if (!isset($_REQUEST['loginId'])) {
      jsHistoryBackExit("loginId를 입력해주세요.");
    }
    
    if (!isset($_REQUEST['loginPw'])) {
      jsHistoryBackExit("loginPw를 입력해주세요.");
    }
    
    $loginId = $_REQUEST['loginId'];
    $loginPw = $_REQUEST['loginPw'];
    
    $member = $this->memberService->getForPrintMemberByLoginIdAndLoginPw($loginId, $loginPw);
    
    if ( empty($member) ) {
      jsHistoryBackExit("일치하는 회원이 존재하지 않습니다.");
    }
    
    $_SESSION['loginedMemberId'] = $member['id'];
    
    jsLocationReplaceExit("home", "{$member['nickname']}님 환영합니다.");    
  }

  public function actionShowJoin() {

    require_once App__getViewPath("usr/member/join");
  }

  public function actionDoJoin() {


    $loginId = getStrValueOr($_REQUEST['loginId'], "");
    if(empty($loginId)){
    jsHistoryBackExit("로그인 아이디를 입력해주세요.");
    }

    $loginPw = getStrValueOr($_REQUEST['loginPw'], "");
    if(empty($loginPw)){
    jsHistoryBackExit("로그인 비밀번호를 입력해주세요.");
    }

    $loginPwConfirm = getStrValueOr($_REQUEST['loginPwConfirm'], "");
    if(empty($loginPwConfirm)){
        jsHistoryBackExit("로그인 비밀번호를 한 번 더 입력해주세요.");
    }



    $name = getStrValueOr($_REQUEST['name'], "");
    if(empty($name)){
        jsHistoryBackExit("이름을 입력해주세요.");
    }

    $nickname = getStrValueOr($_REQUEST['nickname'], "");
    if(empty($nickname)){
        jsHistoryBackExit("닉네임을 입력해주세요.");
    }

    $cellphoneNo = getStrValueOr($_REQUEST['cellphoneNo'], "");
    if(empty($cellphoneNo)){
        jsHistoryBackExit("핸드폰 번호를 입력해주세요.");
    }

    $email = getStrValueOr($_REQUEST['email'], "");
    if(empty($email)){
        jsHistoryBackExit("이메일을 입력해주세요.");
    }

    
    $member = $this->memberService->getForPrintMemberByLoginId($loginId);
    if($member != null){
      jsHistoryBackExit("${loginId}는(은) 이미 존재하는 로그인 아이디입니다.");
    }
    

    $member2 = $this->memberService->getMemberByEmailAndName($email, $name);
    
    if($member2 !=  null){
      jsHistoryBackExit("이미 동일한 이름과 이메일로 가입한 계정이 존재합니다.");
    }

    if($loginPw != $loginPwConfirm){
      jsHistoryBackExit("입력하신 두 비밀번호가 다릅니다.");
    }

    
    $memberId = $this->memberService->join($loginId, $loginPw, $name, $nickname, $cellphoneNo, $email);

    jsLocationReplaceExit("login", "${nickname}님의 회원가입이 완료되었습니다.");

}
    public function actionShowModify() {
      
      $id = intval($_SESSION['loginedMemberId']);

      $loginPw = getStrValueOr($_POST['loginPw'], "");
      if(empty($loginPw)){
          jsHistoryBackExit("로그인 비밀번호를 입력해주세요.");
      }
      
      $member = $this->memberService->getForPrintMemberById($id);
      
      if($loginPw != $member['loginPw']){
          jsHistoryBackExit("비밀번호가 일치하지 않습니다.");
      }

      require_once App__getViewPath("usr/member/modify"); // 해당 함수가 modify.view에 해당하는 파일을 구분해서 실행.
    }

    public function actionDoModify() {
      
      $id = intval($_SESSION['loginedMemberId']);


      $loginPw = getStrValueOr($_REQUEST['loginPw'], "");
      if(empty($loginPw)){
          jsHistoryBackExit("로그인 비밀번호를 입력해주세요.");
      }

      $loginPwConfirm = getStrValueOr($_REQUEST['loginPwConfirm'], "");
      if(empty($loginPwConfirm)){
          jsHistoryBackExit("로그인 비밀번호를 한 번 더 입력해주세요.");
      }



      $name = getStrValueOr($_REQUEST['name'], "");
      if(empty($name)){
          jsHistoryBackExit("이름을 입력해주세요.");
      }

      $nickname = getStrValueOr($_REQUEST['nickname'], "");
      if(empty($nickname)){
          jsHistoryBackExit("닉네임을 입력해주세요.");
      }

      $cellphoneNo = getStrValueOr($_REQUEST['cellphoneNo'], "");
      if(empty($cellphoneNo)){
          jsHistoryBackExit("핸드폰 번호를 입력해주세요.");
      }

      $email = getStrValueOr($_REQUEST['email'], "");
      if(empty($email)){
          jsHistoryBackExit("이메일을 입력해주세요.");
      }

      if($loginPw != $loginPwConfirm){
          jsHistoryBackExit("입력하신 두 비밀번호가 일치하지 않습니다.");
      }

      $this->memberService->modifyMember($id, $loginPw, $name, $nickname, $cellphoneNo, $email);


      jsLocationReplaceExit("user", "${nickname}님의 회원정보가 수정되었습니다.");
    }

    public function actionShowUser() {

        $id = intval($_SESSION['loginedMemberId']);

        $member = $this->memberService->getForPrintMemberById($id);


        require_once App__getViewPath("usr/member/user");

    }

    public function actionShowHome() {

      require_once App__getViewPath("usr/member/home");
    }

    public function actionDoQuit() {


      $id = intval($_SESSION['loginedMemberId']);

      $member = $this->memberService->getForPrintMemberById($id);

      $loginPw = getStrValueOr($_REQUEST['loginPw'], "");
      if(empty($loginPw)){
          jsHistoryBackExit("로그인 비밀번호를 입력해주세요.");
      }



      if($member['loginPw'] != $loginPw){
          jsHistoryBackExit("비밀번호가 일치하지 않습니다.");

      }
      

      $this->memberService->deleteMember($id);

      session_unset();

      jsLocationReplaceExit("login", "회원탈퇴 되었습니다.");



      
    }









}