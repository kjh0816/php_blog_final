<?php
require_once __DIR__ . '/repository/MemberRepository.php';
require_once __DIR__ . '/repository/ArticleRepository.php';
require_once __DIR__ . '/repository/BoardRepository.php';
require_once __DIR__ . '/repository/ReplyRepository.php';

require_once __DIR__ . '/service/MemberService.php';
require_once __DIR__ . '/service/ArticleService.php';
require_once __DIR__ . '/service/BoardService.php';
require_once __DIR__ . '/service/ReplyService.php';

require_once __DIR__ . '/controller/MemberController.php';
require_once __DIR__ . '/controller/ArticleController.php';
require_once __DIR__ . '/controller/BoardController.php';
require_once __DIR__ . '/controller/ReplyController.php';

require_once __DIR__ . '/Application.php';
require_once __DIR__ . '/interceptor.php';
require_once __DIR__ . '/vo.php';

require_once __DIR__ . '/global.php';

function App__getViewPath($viewName) {


  return __DIR__ . '/view/' . $viewName . '.php';
}

function App__runAction(string $action) {
  
  list($controllerTypeCode, $controllerName, $actionFuncName) = explode('/', $action);

  $controllerClassName = "APP__" . ucfirst($controllerTypeCode) . ucfirst($controllerName) . "Controller";
  $actionMethodName = "action";

  if ( str_starts_with($actionFuncName, "do") ) {
    $actionMethodName .= ucfirst($actionFuncName);
  }
  else {
    $actionMethodName .= "Show" . ucfirst($actionFuncName);
  }

  $usrArticleController = new $controllerClassName();
  $usrArticleController->$actionMethodName();
}

function App__run(string $action) {
  App__runInterceptors($action);
  App__runAction($action);  
}