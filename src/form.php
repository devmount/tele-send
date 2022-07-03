<?php
namespace Devmount\TeleSend;

class TeleForm
{
	protected
		$token = '',
		$chat = '',
		$url = '',
		$conf = null;

	public function __construct($token, $chat, $url, $conf)
	{
		$this->token = $token;
		$this->chat = $chat;
		$this->url = $url;
		$this->conf = $conf;
	}

	public function render()
	{
		// handle form data
		if (!empty($_POST)) {
			$fields = [
				'chat_id'    => $chat,
				'text'       => implode("\n", array_map(function($i) { return '<b>' . $i['title'] . ': </b> ' . $_POST[$i['id']]; }, $this->conf['fields'])),
				'parse_mode' => 'html',
			];

			// send data via curl
			$postdata = http_build_query($fields);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = json_decode(curl_exec($ch));

			if (is_object($result) && $result->ok) {
				// reload to prevent resubmission
				header ('Location: ' . $_SERVER['REQUEST_URI'] . '?show=success');
				exit();
			} else {
				header ('Location: ' . $_SERVER['REQUEST_URI'] . '?show=error');
			}
		}

		// generate input field markup
		$fieldMarkup = '';
		foreach ($this->conf['fields'] as $f) {
			switch ($f['type']) {
				case 'rating':
					$fieldMarkup .=
						$f['label'] . '<br />'
						. '<sl-rating id="' . $f['id'] . '" style="--symbol-size: 2rem;" precision="0.5"></sl-rating>'
						. '<input type="hidden" name="' . $f['id'] . '" />'
						. '<script>
								document.querySelector(#' . $f['id'] . ').addEventListener("sl-change", event => {
									document.querySelector("input[name="' . $f['id'] . '"]").value = event.target.value;
								});
							</script>';
					break;
				case 'textarea':
					$fieldMarkup .=
						'<sl-textarea name="' . $f['id'] . '" label="' . $f['label'] . '" maxlength="1000"></sl-textarea>';
					break;
				case 'text':
					$fieldMarkup .=
						'<sl-input name="' . $f['id'] . '" label="' . $f['label'] . '"></sl-input>';
					break;
				default:
					# code...
					break;
			}
		}

		// render markup
		include 'view.php';
	}
}
