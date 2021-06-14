<?php
class App__Application {
  public function getEnvCode(): string {
    if ( $_SERVER['DOCUMENT_ROOT'] == '/web/2021_04_full/site03/public' ) {
      return 'prod';
    }

    return "dev";
  }

  public function getProdSiteDomain() {
    return "bbb.oa.gg";
  }

  public function getDbConnectionByEnv(): mysqli {
    $envCode = $this->getEnvCode();

    if ( $envCode == 'dev' ) {
      $dbHost = "jua.oa.gg";
      $dbId = "st__2021_04_full__site03";
      $dbPw = "sbs123414";
      $dbName = "st__2021_04_full__site03";
    }
    else if ( $envCode == 'prod' ) {
      $dbHost = "127.0.0.1";
      $dbId = "st__2021_04_full__site03";
      $dbPw = "1234";
      $dbName = "st__2021_04_full__site03";
    }

    $dbConn = mysqli_connect($dbHost, $dbId, $dbPw, $dbName) or die("DB CONNECTION ERROR");
    
    return $dbConn;
  }
}