<?php /*** get dynamic form fields for registration using json rpc ***/
require_once("functions.php");
$id = 123;
$website = wpss_get_hostname();
if (!$website) $website = "test.peterbaylies.com";
$response = wpss_json2_func_call("cPlugin.hello", $id, $website);
if (wpss_json2_is_error($response))
	$wsd_form_fields = json_encode(Array(Array('name' => 'error', 'type' => 'hidden', 'label' => 'Error',
	 								'descr' => wpss_json2_get_error($response))));
else
if (is_array($response)) {
	$result = $response["result"];
	$captcha = $result["captcha"];
	$fields = $result["fields"];
	$desc = Array("url" => "Website", "email" => "E-Mail", "name" => "First Name", "surname" => "Last Name", "pass" => "Password");
	$prefix = "account_";
	$wsd_form_fields = Array();
	foreach ($fields as $k => $v) {
		if ($k != 'pass') /*** skip password field; already implemented on the static form ***/
			array_push($wsd_form_fields, Array("name" => $prefix . $k,
				"type" => $v,
				"label" => $desc[$k],
				"descr" => ''));
	}
	$wsd_form_fields = json_encode($wsd_form_fields);
}
?>var wsd_form_fields=<?php echo $wsd_form_fields; ?>
