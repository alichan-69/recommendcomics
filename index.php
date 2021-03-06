<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/Quiz.php');
require_once(__DIR__ . '/Token.php');

$quiz = new MyApp\Quiz();
$comics = $quiz->getAll();

if (!($quiz->isFinished())) {
$data = $quiz->getCurrentQuiz();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>漫画診断</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php if ($quiz->isStart()) : ?>
    <div id="container">
      <div id="result">
        <div class="text1">漫画診断</div>
      </div>
      <a href=""><div id="btn2">START</div></a>
    </div>
    <?php $quiz->start();?>
  <?php elseif ($quiz->isFinished()) : ?>
    <?php $quiz->reset();?>
    <div id="container">
      <div id="result">
        <div class="text3">あなたにお勧めの漫画は</div>
        <img src="images/<?= $comics[$_SESSION['answer_num']-1]->image ?>">
        <a href="<?= $comics[$_SESSION['answer_num']-1]->url ?>"><div class="text4">出典：amazon</div></a>
        <div class="text2"><?= $comics[$_SESSION['answer_num']-1]->title ?></div>
      </div>
      <a href=""><div id="btn2">Replay?</div></a>
    </div>
  <?php else : ?>
    <div id="container">
      <h1>Q. <?= h($data['q']); ?></h1>
      <ul>
        <?php foreach ($data['a'] as $a) : ?>
          <li class="answer"><?= h($a); ?></li>
        <?php endforeach; ?>
      </ul>
      <div id="btn" class="disabled"><?= $quiz->isLast() ? 'Show Result' : 'Next Question'; ?></div>
      <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="quiz.js"></script>
  <?php endif; ?>
</body>
</html>
