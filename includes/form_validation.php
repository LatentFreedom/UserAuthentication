<?php
// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function present($value) {
	return isset($value) && $value !== "";
}

function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function has_min_length($value, $min) {
	return strlen($value) >= $min;
}

// Validation
foreach ($fields_required as $field) {
	$value = trim($_POST[$field]);
	if(!present($value)) {
		$errors[$field] = ucfirst($field) . " cannot be blank.";
	}
}

// Check maximum length of fields
function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	foreach ($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if (!has_max_length($value, $max)) {
			$errors[$field] = ucfirst($field) . " is too long.";
		}
	}
}

// Check minimum length of fields
function validate_min_lengths($fields_with_min_lengths) {
	global $errors;
	foreach ($fields_with_min_lengths as $field => $min) {
		$value = trim($_POST[$field]);
		if (!has_min_length($value, $min) && present($value)) {
			$errors[$field] = ucfirst($field) . " is too short.";
		}
	}
}
?>