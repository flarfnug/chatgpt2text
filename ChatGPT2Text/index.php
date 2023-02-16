<!DOCTYPE html>
<html>
<head>
	<title>ChatGPT2Text</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="box">
		<img src="chatgpt2text.png" alt="ChatGPT2Text logo">
	</div>

	<form action="generate-response.php" method="post">
		<label for="prompt"><h2>Enter your prompt here:</h2></label>
		<input type="text" id="prompt" name="prompt">

		<input type="submit" value="Generate Response">
	</form>

	<div class="response" id="response-container">
  <h2>Response:</h2>
  <p>
    <?php
      $response = file_get_contents("gptresponse.txt");
      echo $response;
    ?>
  </p>
</div>

<script>
  const form = document.querySelector('form');
  const responseContainer = document.getElementById('response-container');

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          responseContainer.innerHTML = `<h2>Response:</h2><p>${xhr.responseText}</p>`;
        } else {
          console.error('Failed to load response:', xhr.status, xhr.statusText);
        }
      }
    };
    xhr.open('POST', 'generate-response.php');
    xhr.send(formData);
  });
</script>


</body>
</html>
