<?php
namespace Devmount\TeleSend;

// get environment variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// config
$token = $_ENV['TOKEN']; // telegram bot token
$chat  = $_ENV['CHAT'];  // telegram chat id to post to
$url   = 'https://api.telegram.org/bot' . $token . '/sendMessage';

// handle form data
if (!empty($_POST)) {
	$rating = $_POST['rating'];
	$highlight = $_POST['highlight'];
	$challenge = $_POST['challenge'];
	
	$fields = [
		'chat_id'    => $chat,
		'text'       => '<b>Bewertung: </b> ' . $rating . "\n<b>Beibehalten: </b>" . $highlight .  "\n<b>Verbessern: </b>" . $challenge,
		'parse_mode' => 'html',
	];

	// send data via curl
	$postdata = http_build_query($fields);
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	$result = json_decode($result);
	if ($result->ok) {
		// reload to prevent resubmission
		header ('Location: ' . $_SERVER['REQUEST_URI'] . '?show=success');
    exit();
	};
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link
		rel="stylesheet"
		media="(prefers-color-scheme:light)"
		href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.76/dist/themes/light.css"
	/>
	<link
		rel="stylesheet"
		media="(prefers-color-scheme:dark)"
		href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.76/dist/themes/dark.css"
		onload="document.documentElement.classList.add('sl-theme-dark');"
	/>
	<link rel="stylesheet" href="style.css" />
	<script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.76/dist/shoelace.js"></script>
	<title>Feedback</title>
</head>
<body>
	<header>
		<h1>Feedback</h1>
		<h2>Community Week 2022</h2>
	</header>
	<main>
		<?php if (isset($_GET['show']) && $_GET['show'] == 'success'): ?>
			<sl-alert variant="success" open>
				<sl-icon slot="icon" name="check2-circle"></sl-icon>
				<strong>Dein Feedback wurde gesendet</strong><br />
				Vielen Dank für deine Zeit!
			</sl-alert>
		<?php endif; ?>
		<form action="" method="post">
			Wie bewertest du die Community Week 2022 insgesamt?<br />
			<sl-rating style="--symbol-size: 2rem;" precision="0.5"></sl-rating>
			<input type="hidden" name="rating" id="rating" />
			<sl-textarea name="highlight" label="Das sollte unbedingt so bleiben" maxlength="1000" required></sl-textarea>
			<sl-textarea name="challenge" label="Das sollte nächstes Mal besser laufen" maxlength="1000" required></sl-textarea>
			<sl-button type="submit" variant="primary">Ab damit!</sl-button>
		</form>
	</main>
	<script>
		// send rating when submitting form via hidden input
		const rating = document.querySelector('sl-rating');
		rating.addEventListener('sl-change', event => {
			document.querySelector('#rating').value = event.target.value;
		});
	</script>
</body>
</html>
