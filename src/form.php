<?php
namespace Devmount\TeleSend;

class TeleForm
{
	public String $token;
	public String $chat;
	public String $url;

	public function __construct($token, $chat, $url)
	{
		$this->token = $token;
		$this->chat = $chat;
		$this->url = $url;
	}

	public function do()
	{
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
			$resobj = json_decode($result);
			if (is_object($resobj) && $resobj->ok) {
				// reload to prevent resubmission
				header ('Location: ' . $_SERVER['REQUEST_URI'] . '?show=success');
				exit();
			} else {
				header ('Location: ' . $_SERVER['REQUEST_URI'] . '?show=error');
			}
		}

		$if = function ($condition, $true, $false='') {
			return $condition ? $true : $false;
		};

		$success = <<<HTML
			<sl-alert variant="success" open>
				<sl-icon slot="icon" name="check2-circle"></sl-icon>
				<strong>Dein Feedback wurde gesendet</strong><br />
				Vielen Dank für deine Zeit!
				<sl-button href="/" class="d-block w-fit-content mt-1" variant="default" outline>
					<sl-icon slot="suffix" name="arrow-counterclockwise"></sl-icon>
					Nochmal starten
				</sl-button>
			</sl-alert>
			HTML;
		
		$error = <<<HTML
			<sl-alert variant="danger" open>
				<sl-icon slot="icon" name="exclamation-octagon"></sl-icon>
				<strong>Es gab einen Fehler</strong><br />
				Bitte entschuldige, dein Feedback konnte nicht gesendet werden.
				<sl-button href="/" class="d-block w-fit-content mt-1" variant="default" outline>
					<sl-icon slot="suffix" name="arrow-counterclockwise"></sl-icon>
					Nochmal probieren
				</sl-button>
			</sl-alert>
			HTML;
		
		$form = <<<HTML
			<form action="" method="post">
				Wie bewertest du die Community Week 2022 insgesamt?<br />
				<sl-rating style="--symbol-size: 2rem;" precision="0.5"></sl-rating>
				<input type="hidden" name="rating" id="rating" />
				<sl-textarea name="highlight" label="Das sollte unbedingt so bleiben" maxlength="1000" required></sl-textarea>
				<sl-textarea name="challenge" label="Das sollte nächstes Mal besser laufen" maxlength="1000" required></sl-textarea>
				<sl-button type="submit" variant="primary">Ab damit!</sl-button>
			</form>
			HTML;

		return <<<HTML
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
					{$if(isset($_GET['show']) && $_GET['show'] == 'success', $success)}
					{$if(isset($_GET['show']) && $_GET['show'] == 'error', $error)}
					{$if(!isset($_GET['show']), $form)}
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
			HTML;
	}
}
?>
