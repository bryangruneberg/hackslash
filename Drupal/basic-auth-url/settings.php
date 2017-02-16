<?php

# Pop the following function at the bottom of settings.php
if (! empty($_SERVER['REDIRECT_SET_PASSWORD']))  {

  $username = 'someuser';
  $password = 'thepass';
 
  // PHP-CGI fix.
  $a = base64_decode(substr($_SERVER["REMOTE_USER"], 6));
  if ((strlen($a) == 0) || (strcasecmp($a, ":") == 0)) {
    header('WWW-Authenticate: Basic realm="Private"');
    header('HTTP/1.0 401 Unauthorized');
  }
  else {
    list($name, $pass) = explode(':', $a);
    $_SERVER['PHP_AUTH_USER'] = $name;
    $_SERVER['PHP_AUTH_PW'] = $pass;
  }
 
  if (!(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $password))) {
    header('WWW-Authenticate: Basic realm="Sign in to access"');
    header('HTTP/1.0 401 Unauthorized');
    // Fallback page when the user presses cancel.
    echo '<html><head><script>setTimeout(function() { window.location = "/"; }, 2500);</script></head><body><h1 style="text-align: center; color: red;">Access Denied</h1></body></html>';
    exit;
  }
}
