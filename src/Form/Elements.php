<?php
namespace TeleSend\Form;

class Elements
{
	/**
	 * generate rating field markup
	 */
	public static function rating($conf)
	{
		// process configuration
		$id  = $conf['id'];
		$lbl = $conf['label'] ? $conf['label'] : '';
		$prc = $conf['precision'] ? $conf['precision'] : 0.5;
		$max = $conf['max'] ? $conf['max'] : 5;
		$req = $conf['required'] ? 'required' : '';
		$ind = $conf['required'] ? '*' : '';
		// provide HTML markup
		return <<<HTML
			{$lbl} {$ind}<br />
			<sl-rating
				id="{$id}"
				style="--symbol-size: 2rem;"
				precision="{$prc}"
				max="{$max}"
				{$req}
			></sl-rating>
			<input type="hidden" name="{$id}" />
			<script>
				document.querySelector("#{$id}").addEventListener("sl-change", event => {
					document.querySelector("input[name='{$id}']").value = event.target.value;
				});
			</script>
		HTML;
	}

	/**
	 * generate text field markup
	 */
	public static function text($conf)
	{
		// process configuration
		$id  = $conf['id'];
		$lbl = $conf['label'] ? $conf['label'] : '';
		$plh = $conf['placeholder'] ? $conf['placeholder'] : '';
		$req = $conf['required'] ? 'required' : '';
		// provide HTML markup
		return <<<HTML
			<sl-input
				name="{$id}"
				label="{$lbl}"
				placeholder="{$plh}"
				{$req}
			></sl-input>
		HTML;
	}

	/**
	 * generate textarea field markup
	 */
	public static function textarea($conf)
	{
		// process configuration
		$id  = $conf['id'];
		$lbl = $conf['label'] ? $conf['label'] : '';
		$plh = $conf['placeholder'] ? $conf['placeholder'] : '';
		$mxl = $conf['maxlength'] ? $conf['maxlength'] : 1000;
		$req = $conf['required'] ? 'required' : '';
		// provide HTML markup
		return <<<HTML
			<sl-textarea
				name="{$id}"
				label="{$lbl}"
				placeholder="{$plh}"
				maxlength="{$mxl}"
				resize="auto"
				{$req}
			></sl-textarea>
		HTML;
	}
}
