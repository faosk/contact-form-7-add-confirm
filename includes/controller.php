<?php
/**
 *
 *
 * Created by PhpStorm.
 * Author: Eyeta Co.,Ltd.(http://www.eyeta.jp)
 * 
 */


add_action( 'init', 'wpcf7c_control_init', 10 );
function wpcf7c_control_init() {
	wpcf7c_ajax_json_echo();
}


function wpcf7c_ajax_json_echo() {
	switch($_POST["_wpcf7c"]) {
		case "step1":
	//		$result = apply_filters( 'wpcf7_before_send_mail', $result );
			add_action("wpcf7_before_send_mail", "wpcf7c_before_send_mail_step1", 10, 2);

			//$items = apply_filters( 'wpcf7_ajax_json_echo', $items, $result );
			add_filter("wpcf7_ajax_json_echo", "wpcf7c_ajax_json_echo_step1", 10, 3);

			break;
		case "step2":
			//$items = apply_filters( 'wpcf7_ajax_json_echo', $items, $result );
			add_filter("wpcf7_ajax_json_echo", "wpcf7c_ajax_json_echo_step2", 10, 3);

			break;
	}


	return;
}

function wpcf7c_before_send_mail_step1(&$cls) {
	//eyeta_log("wpcf7c_before_send_mail_step1");
	$cls->skip_mail = true;
}

function wpcf7c_ajax_json_echo_step1($items, $result) {
	//eyeta_log("wpcf7c_ajax_json_echo_step1");
	if($result['mail_sent']) {
		if($items["onSubmit"] == null) {
			$items["onSubmit"] = array("wpcf7c_step1('" . $_POST['_wpcf7_unit_tag'] . "');");
		} else {
			$items["onSubmit"][] = "wpcf7c_step1('" . $_POST['_wpcf7_unit_tag'] . "');";
		}
		$items["message"] = "";
		$items["mailSent"] = false;
	}

	return $items;
}

function wpcf7c_ajax_json_echo_step2($items, $result) {
	//eyeta_log("wpcf7c_ajax_json_echo_step1");
	if($result['mail_sent']) {
		if($items["onSubmit"] == null) {
			$items["onSubmit"] = array("wpcf7c_step2('" . $_POST['_wpcf7_unit_tag'] . "');");
		} else {
			$items["onSubmit"][] = "wpcf7c_step2('" . $_POST['_wpcf7_unit_tag'] . "');";
		}
	}

	return $items;
}