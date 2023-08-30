<?php

define('OPENAI_API_KEY', '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');  // Replace with your actual API key

// Sanitize input
$prompt = isset($_POST['prompt']) ? filter_input(INPUT_POST, 'prompt', FILTER_SANITIZE_STRING) : '';
if (empty($prompt)) {
  $prompt = file_exists('prompt.txt') ? file_get_contents('prompt.txt') : 'Write a funny, witty, unique, and intelligent quote.';
} else {
  // Save the prompt to a file
  file_put_contents('prompt.txt', $prompt);
}

// Set the messages for the conversation
$messages = [
  ['role' => 'system', 'content' => 'You are a helpful assistant that keeps responses short.'],
  ['role' => 'user', 'content' => $prompt]
];

// Array to configure the model
$data = [
  'model' => 'gpt-3.5-turbo',
  'messages' => $messages
];

// Form the API call for the curl request
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'Authorization: Bearer ' . OPENAI_API_KEY
]);

// Execute the curl request
$response = curl_exec($ch);
if (curl_errno($ch)) {
  http_response_code(500);
  exit('Error calling OpenAI API: ' . curl_error($ch));
}
curl_close($ch);

// Validate response
$json = json_decode($response, true);
if (!$json || !isset($json['choices'][0]['message']['content'])) {
  http_response_code(500);
  exit('Invalid response from OpenAI API');
}

// Save the generated text to a file
$textResponse = $json['choices'][0]['message']['content'];
$text = substr($textResponse, 0, 189);
$text .= ' '; 

// Save the generated text to a file
file_put_contents('gptresponse.txt', $text);

// Output the file contents to streamer.bot/browser
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="gptresponse.txt"');
header('Content-Length: ' . filesize('gptresponse.txt'));
readfile('gptresponse.txt');
?>
