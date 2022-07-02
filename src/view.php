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
				<sl-button href="/" class="d-block w-fit-content mt-1" variant="default" outline>
					<sl-icon slot="suffix" name="arrow-counterclockwise"></sl-icon>
					Nochmal starten
				</sl-button>
			</sl-alert>
		<?php elseif (isset($_GET['show']) && $_GET['show'] == 'error'): ?>
			<sl-alert variant="danger" open>
				<sl-icon slot="icon" name="exclamation-octagon"></sl-icon>
				<strong>Es gab einen Fehler</strong><br />
				Bitte entschuldige, dein Feedback konnte nicht gesendet werden.
				<sl-button href="/" class="d-block w-fit-content mt-1" variant="default" outline>
					<sl-icon slot="suffix" name="arrow-counterclockwise"></sl-icon>
					Nochmal probieren
				</sl-button>
			</sl-alert>
		<?php else: ?>
			<form action="" method="post">
				Wie bewertest du die Community Week 2022 insgesamt?<br />
				<sl-rating style="--symbol-size: 2rem;" precision="0.5"></sl-rating>
				<input type="hidden" name="rating" id="rating" />
				<sl-textarea name="highlight" label="Das sollte unbedingt so bleiben" maxlength="1000" required></sl-textarea>
				<sl-textarea name="challenge" label="Das sollte nächstes Mal besser laufen" maxlength="1000" required></sl-textarea>
				<sl-button type="submit" variant="primary">Ab damit!</sl-button>
			</form>
		<?php endif; ?>
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
