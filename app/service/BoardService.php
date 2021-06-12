<?php
class APP__BoardService {
  private APP__BoardRepository $boardRepository;

  public function __construct() {
    global $App__boardRepository;
    $this->boardRepository = $App__boardRepository;
  }


  public function getForPrintBoardByName(string $name): array|null {
    return $this->boardRepository->getForPrintBoardByName($name);
  }

  public function getForPrintBoardByCode(string $code): array|null {
    return $this->boardRepository->getForPrintBoardByCode($code);
  }

  public function addBoard(int $memberId, string $name, string $code): int {
    return $this->boardRepository->addBoard($memberId, $name, $code);
  }

  public function getBoardById(int $id): array|null {
    return $this->boardRepository->getBoardById($id);
  }
  
  public function getForPrintBoards(): array|null{
    return $this->boardRepository->GetForPrintBoards();
  }

  public function getForPrintBoardList(): array|null{
    return $this->boardRepository->GetForPrintBoardList();
  }

  public function deleteBoard(int $boardId) {
    return $this->boardRepository->deleteBoard($boardId);
  }

  public function modifyBoard(int $boardId, string $name, string $code){
    return $this->boardRepository->modifyBoard($boardId, $name, $code);
  }


}