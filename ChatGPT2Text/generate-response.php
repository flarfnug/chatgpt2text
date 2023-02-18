<?php

// Define your API key
// *IMPORTANT* You must enter your OpenAI API key here.
define('OPENAI_API_KEY', 'pleasetypeyourAPIkeyorthisallwontwork');

// Sanitize input
$prompt = isset($_POST['prompt']) ? filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_STRING) : '';
if (empty($prompt)) {
  $prompt = file_exists('prompt.txt') ? file_get_contents('prompt.txt') : 'Write a funny, witty, unique, and intelligent quote.';
} else {
  // Save the prompt to a file
  file_put_contents('prompt.txt', $prompt);
}

// Validate the API key (replace $OPENAI_API_KEY$ with your actual API key)
if (!defined('OPENAI_API_KEY')) {
  define('OPENAI_API_KEY', '$OPENAI_API_KEY$');
}

// Set access controls
$allowed_ips = ['127.0.0.1']; // Example: allow only localhost
$remote_ip = $_SERVER['REMOTE_ADDR'];
if (!in_array($remote_ip, $allowed_ips)) {
  http_response_code(403);
  exit('Access denied');
}

// Array to configure the model
$data = array(
  'model' => 'text-davinci-001',
  'prompt' => $prompt,
  'temperature' => 0.8,
  'max_tokens' => 64,
  'top_p' => 1,
  'frequency_penalty' => 0,
  'presence_penalty' => 0
);

// Form the API call for the curl request. 
$ch = curl_init('https://api.openai.com/v1/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . OPENAI_API_KEY
));

// Execute the curl request
$response = curl_exec($ch);
if (curl_errno($ch)) {
  http_response_code(500);
  exit('Error calling OpenAI API: ' . curl_error($ch));
}
curl_close($ch);

// Validate response
$json = json_decode($response, true);
if (!$json || !isset($json['choices']) || !isset($json['choices'][0]) || !isset($json['choices'][0]['text'])) {
  http_response_code(500);
  exit('Invalid response from OpenAI API');
}
$text = $json['choices'][0]['text'];

// Save the generated text to a file
file_put_contents('gptresponse.txt', $text);

// Output the file contents to streamer.bot/browser
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="gptresponse.txt"');
header('Content-Length: ' . filesize('gptresponse.txt'));
$fp = fopen('gptresponse.txt', 'rb');
fpassthru($fp);
fclose($fp);
?>
