# chatgpt2text

Welcome to the ChatGPT/OpenAI quote generator for streamer.bot!
This script outputs a text file that streamer.bot can read.

Now with the actions/command import code included. Copy/Paste the code into Import for the associated actions/command.

To use, simply upload this folder to a PHP-capable web server,
and create an action in streamer.bot with the "Network - Fetch URL" sub-action pointed at generate-response.php.

This will create the text file that streamer.bot automatically reads into a variable.

Finally, you can print the variable in a Twitch/Youtube Chat Message action to display a random quote based on your prompt below.

To make it easier for your viewers, create a command pointing at the action to retrieve a random quote.

Load index.php in your browser to change the prompt and display a response.

Customize to your preferences, but please note that I am not sure how secure this script is.
It does not expose your API key simply by viewing the source, but please use at your own risk.

You *must* edit generate-response.php and enter your [OpenAI API key](https://platform.openai.com/account/api-keys) instead of the placeholder or this script will not work. Or set an environment variable on your webserver with the API key in it.

You *must* also edit the Fetch URL action to point at your URL.
