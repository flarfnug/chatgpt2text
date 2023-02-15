# chatgpt2text

Welcome to the ChatGPT/OpenAI quote generator for streamer.bot!
This script outputs a text file to your default Download folder that streamer.bot can read.
To use, simply upload this file to a PHP-capable web server,
and create an action in streamer.bot with the "Network - Fetch URL" sub-action pointed at this file.
This will create the text file that you can read in using the "Read File" sub-action and assign to a variable of your choosing.
Finally, you can print the variable in a Twitch/Youtube Chat Message action to display a random quote based on your prompt below.
To make it easier for your viewers, create a command pointing at the action to retrieve a random quote.
Customize to your preferences, but please note that I am not sure how secure this script is.
It does not expose your API key simply by viewing the source, but please use at your own risk.
