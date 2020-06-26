<?php

namespace MyApp;

class Quiz {
  private $_quizSet=[];
  private $_db;

  public function __construct() {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
    $this->_setup();
    Token::create();
    if (!isset($_SESSION["current_num"])) {
      $_SESSION["current_num"] = 8;
    }
  }

  public function getAll() {
    $stmt = $this->_db->query("select * from comics");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function checkAnswer(){
    //質問を一つ進める、配列を一つ増やす
    Token::validate('token');
    if (!isset($_POST['answer'])) {
      throw new \Exception('answer not set!');
    }
    if($_SESSION["current_num"]===0 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=1;
      return;
    }
    if($_SESSION["current_num"]===0 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=4;
      return;
    }
    if($_SESSION["current_num"]===1 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=2;
      return;
    }
    if($_SESSION["current_num"]===1 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=3;
      return;
    }
    if($_SESSION["current_num"]===2 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 1;
      return;
    }
    if($_SESSION["current_num"]===2 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 2;
      return;
    }
    if($_SESSION["current_num"]===3 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 3;
      return;
    }
    if($_SESSION["current_num"]===3 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 4;
      return;
    }
    if($_SESSION["current_num"]===4 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=5;
      return;
    }
    if($_SESSION["current_num"]===4 && $_POST["answer"]==="NO"){
    $_SESSION["current_num"]=6;
    return;
    }
    if($_SESSION["current_num"]===5 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 5;
      return;
    }
    if($_SESSION["current_num"]===5 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 6;
      return;
    }
    if($_SESSION["current_num"]===6 && $_POST["answer"]==="YES"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 7;
      return;
    }
    if($_SESSION["current_num"]===6 && $_POST["answer"]==="NO"){
      $_SESSION["current_num"]=7;
      $_SESSION['answer_num'] = 8;
      return;
    }
  }

  public function isStart(){
    return $_SESSION["current_num"]===8;
  }

  public function isFinished(){
    return $_SESSION["current_num"]===7;
  }

  public function isLast(){
    return $_SESSION["current_num"]===2 || $_SESSION["current_num"]===3 || $_SESSION["current_num"]===5 || $_SESSION["current_num"]===6;
  }
  
  public function start(){
    $_SESSION["current_num"]=0;
  }

  public function reset(){
    $_SESSION["current_num"]=8;
  }
  
  public function getAnswer(){
    return $_SESSION['answer_num'];
  }

  public function getCurrentQuiz() {
    return $this->_quizSet[$_SESSION["current_num"]];
  }
  
  private function _setup(){
    $this->_quizSet[] = [
      'q' => 'スリルのある漫画が読みたい？',
      'a' => ['YES', "NO"]
    ];
    $this->_quizSet[] = [
      'q' => 'バトル漫画が読みたい？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      'q' => '狂った世界観は好き？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      'q' => 'ミステリーは好き？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      'q' => '芯の強い女の子は好き？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      'q' => '時代物は好き？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      'q' => '恋愛漫画は好き？',
      'a' => ['YES', 'NO']
    ];
    $this->_quizSet[] = [
      "isFinished" => "isFinished"
    ];
    $this->_quizSet[] = [
      "isStart" => "isStart"
    ];
  }
}