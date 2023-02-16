<?php

// Check to see if a prompt file exists, if no create one, if no text is entered use a default prompt
$prompt = isset($_POST['prompt']) ? $_POST['prompt'] : '';
if (empty($prompt)) {
  $prompt = file_exists('prompt.txt') ? file_get_contents('prompt.txt') : 'Write a funny, witty, unique, and intelligent quote.';
} else {
  // Save the prompt to a file
  file_put_contents('prompt.txt', $prompt);
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
// *IMPORTANT*: You must enter your OpenAI API key here.
$ch = curl_init('https://api.openai.com/v1/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer $OPENAI_API_KEY$'
));

// Execute the curl request
$response = curl_exec($ch);
curl_close($ch);

// Get the generated text from the response
$json = json_decode($response, true);
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
