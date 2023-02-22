# chatgpt2text

Welcome to the ChatGPT/OpenAI quote generator for Streamer.bot!
This script outputs a text file that streamer.bot can read.

Now with the actions/command import code included. Copy/Paste the code into Import for the associated actions/command.

To use, simply upload this folder to a PHP-capable web server,
and create an action in streamer.bot with the "Network - Fetch URL" sub-action pointed at generate-response.php.

This will create the text file that Streamer.bot automatically reads into a variable.

Print the variable in a Twitch/Youtube Chat Message action to display a random quote based on your prompt.

To make it easier for your viewers, create a command pointing at the action to retrieve a random quote.

Load index.php in your browser to change the prompt and display a response.

Now with more interactivity, newly added dearai.php and the Streamer.bot action/command to set the prompt from your Youtube live chat.
point the subactions in the chatgpt-prompt action to the dearai.php script on your webserver, set the location of the local text file that streamer.bot writes the message out to and it's ready to use.

You will still be able to use the webpage to create a prompt if you do not want to use this.

Customize to your preferences, but please note that I am not sure how secure this script is.
It does not expose your API key simply by viewing the source, but please use at your own risk.

You *must* set the file permission for the php scripts and text files on your webserver for this to work correctly.

You *must* edit generate-response.php and enter your [OpenAI API key](https://platform.openai.com/account/api-keys) instead of the placeholder or this script will not work. Or set an environment variable on your webserver with the API key in it.

You *must* also edit the Fetch URL sub-action/s to point at your URL.
