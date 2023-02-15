<?php

// Welcome to the ChatGPT quote generator for streamer.bot!
// This script outputs a text file that streamer.bot can read.
// To use, simply upload this file to a PHP-capable web server,
// and create an action in streamer.bot with the "Network - Fetch URL" sub-action pointed at this file.
// This will create the text file that you can read in using the "Read File" sub-action and assign to a variable of your choosing.
// Finally, you can print the variable in a Twitch/Youtube Chat Message action to display a random quote based on your prompt below.
// To make it easier for your viewers, create a command pointing at the action to retrieve a random quote.
// Customize to your preferences, but please note that I am not sure how secure this script is.
// It does not expose your API key simply by viewing the source, but please use at your own risk.

// Array to hold the ChatGPT model settings
$data = array(
  'model' => 'text-davinci-001',
  'prompt' => 'Write a witty, intelligent, and funny quote.',
  'temperature' => 0.8,
  'max_tokens' => 64,
  'top_p' => 1,
  'frequency_penalty' => 0,
  'presence_penalty' => 0
);


// Put together the API call for curl to use
// Replace $OPENAI_APIKEY with YOUR key!
$ch = curl_init('https://api.openai.com/v1/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Authorization: Bearer $OPENAI_APIKEY'
));

// Execute the curl command
$response = curl_exec($ch);
curl_close($ch);

// Interpret the response from JSON
// and place it into a variable
$json = json_decode($response, true);
$text = $json['choices'][0]['text'];

// Save the generated text to a file
file_put_contents('gptresponse.txt', $text);

// Output the file contents to the browser
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="gptresponse.txt"');
header('Content-Length: ' . filesize('gptresponse.txt'));
$fp = fopen('gptresponse.txt', 'rb');
fpassthru($fp);
fclose($fp);
?>
