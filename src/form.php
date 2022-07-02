<?php
namespace Devmount\TeleSend;

class TeleForm
{
	protected
		$token = '',
		$chat = '',
		$url = '';

	public function __construct($token, $chat, $url)
	{
		$this->token = $token;
		$this->chat = $chat;
		$this->url = $url;
	}

	public function render()
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

		// render markup
		include 'view.php';
	}
}
