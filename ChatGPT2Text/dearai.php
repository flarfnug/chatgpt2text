<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $text = $_POST['text'];
  $file = fopen('prompt.txt', 'w');
  fwrite($file, $text);
  fclose($file);
  echo 'Text saved to prompt.txt';
  exit;
}
?>