<?php
class APP__MemberService {
  private APP__MemberRepository $memberRepository;

  public function __construct() {
    global $App__memberRepository;
    $this->memberRepository = $App__memberRepository;
  }

  public function getForPrintMemberByLoginIdAndLoginPw(string $loginId, string $loginPw): array|null {
    return $this->memberRepository->getForPrintMemberByLoginIdAndLoginPw($loginId, $loginPw);
  }

  public function getForPrintMemberById(int $id): array|null {
    return $this->memberRepository->getForPrintMemberById($id);
  }

  public function getForPrintMemberByLoginId(string $loginId): array|null {
    return $this->memberRepository->getForPrintMemberByLoginId($loginId);
  }

  public function getMemberByEmailAndName(string $email, string $name){
    return $this->memberRepository->getMemberByEmailAndName($email, $name);
  }

  public function join(string $loginId, string $loginPw, string $name, string $nickname, string $cellphoneNo, string $email){
    return $this->memberRepository->join($loginId, $loginPw, $name, $nickname, $cellphoneNo, $email);
  }

  public function modifyMember(int $id, string $loginPw, string $name, string $nickname, string $cellphoneNo, string $email){
    return $this->memberRepository->modifyMember($id, $loginPw, $name, $nickname, $cellphoneNo, $email);
  }

  public function deleteMember(int $id){
    return $this->memberRepository->deleteMember($id);
  }

}