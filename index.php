<?php

/**
 * redirect theme entry page
 * Author: Mohamed Riyas KP
 */
$redirection_url = get_option('redirection_url');
$isRedirectEnabled = get_option('redirect_frontend');
$redirection_method = get_option('redirect_method');
if ($isRedirectEnabled && $redirection_url && $redirection_method) {
    header("Location: $redirection_url", true, $redirection_method);
} else {
    echo "<h1>Access Denied</h1>";
}
