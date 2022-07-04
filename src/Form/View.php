<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link
		rel="stylesheet"
		media="(prefers-color-scheme:light)"
		href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.77/dist/themes/light.css"
	/>
	<link
		rel="stylesheet"
		media="(prefers-color-scheme:dark)"
		href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.77/dist/themes/dark.css"
		onload="document.documentElement.classList.add('sl-theme-dark');"
	/>
	<link rel="stylesheet" href="style.css" />
	<script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.77/dist/shoelace.js"></script>
	<title><?= $this->conf['title'] ?> - <?= $this->conf['subtitle'] ?></title>
</head>
<body>
	<header>
		<h1><?= $this->conf['title'] ?></h1>
		<h2><?= $this->conf['subtitle'] ?></h2>
	</header>
	<main>
		<?php if (isset($_GET['show']) && $_GET['show'] == 'success'): ?>
			<sl-alert variant="success" open>
				<sl-icon slot="icon" name="check2-circle"></sl-icon>
				<strong>Dein Input wurde gesendet</strong><br />
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
				Bitte entschuldige, dein Input konnte nicht gesendet werden.
				<sl-button href="/" class="d-block w-fit-content mt-1" variant="default" outline>
					<sl-icon slot="suffix" name="arrow-counterclockwise"></sl-icon>
					Nochmal probieren
				</sl-button>
			</sl-alert>
		<?php else: ?>
			<form action="" method="post">
				<?= $fieldMarkup ?>
				<sl-button type="submit" variant="primary" class="mt-1"><?= $this->conf['submit'] ?></sl-button>
			</form>
		<?php endif; ?>
	</main>
</body>
</html>
