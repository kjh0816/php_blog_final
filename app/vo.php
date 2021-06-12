<?php
class ResultData {
  public function __construct(
    private string $resultCode, 
    private string $msg
  ) { }

  public function isSuccess():bool {
    return str_starts_with($this->resultCode, "S-");
  }

  public function isFail():bool {
    return !$this->isSuccess();
  }

  public function getMsg():string {
    return $this->msg;
  }
}