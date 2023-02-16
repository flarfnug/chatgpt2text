<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $text = $_POST['text'];
  //Validate user input
  $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
  
  $file_path = __DIR__ . '/prompt.txt';
  //Validate file path
  if (file_exists($file_path) && is_writable($file_path)) {
    $file = fopen($file_path, 'w');
    //Set appropriate file permissions
    chmod($file_path, 0600);
    fwrite($file, $text);
    fclose($file);
    echo 'Text saved to prompt.txt';
  } else {
    error_log('Error saving text to prompt.txt: Invalid file path or file is not writable');
    http_response_code(500);
    echo 'An error occurred while saving the text. Please try again later.';
  }
  exit;
}
?>
