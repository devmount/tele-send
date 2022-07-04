<?php
namespace TeleSend\Form;

class Form
{
	protected
		$token = '',
		$chat = '',
		$url = '',
		$conf = null;

	public function __construct($token, $chat, $url, $conf)
	{
		// init attributes
		$this->token = $token;
		$this->chat = $chat;
		$this->url = $url;
		$this->conf = $conf;
		// create field ids
		foreach ($this->conf['fields'] as $i => $f) {
			$f['id'] = 'f' . $i;
			$this->conf['fields'][$i] = $f;
		}
		
	}

	public function render()
	{
		// handle form data
		if (!empty($_POST)) {
			$fields = [
				'chat_id'    => $chat,
				'text'       => implode("\n", array_map(fn($i) => '<b>' . $i['title'] . ': </b> ' . $_POST[$i['id']], $this->conf['fields'])),
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
					$fieldMarkup .= Elements::rating($f);
					break;
				case 'textarea':
					$fieldMarkup .= Elements::textarea($f);
					break;
				case 'text':
				default:
					$fieldMarkup .= Elements::text($f);
					break;
			}
		}

		// render markup
		include 'view.php';
	}
}
