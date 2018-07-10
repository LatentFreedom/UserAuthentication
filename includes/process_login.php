<?php 
// sanitize form from malicious attacks
$suspect = false;
$pattern = '/Content-type:|Bcc:|Cc:/i';

// Check value for malicious patterns
function isSuspect($value, $pattern, &$suspect) {
    if (is_array($value)) {
        foreach ($value as $item) {
            isSuspect($item, $pattern, $suspect);
        } 
    } else {
        if (preg_match($pattern, $value)) {
            $suspect = true;
        }
    }
}

isSuspect($_POST, $pattern, $suspect);

// Check form for required inputs
if (!$suspect) {
    // Form Validation 
    foreach ($_POST as $key => $value) {
        $value = is_array($value) ? $value : trim($value); // remove white spaces
        if (empty($value) && in_array($key, $fields_required)) {
            $missing[] = $key;
            $$key = '';
        } elseif (in_array($key, $fields_expected)) {
            $$key = $value;
        }
    }
}