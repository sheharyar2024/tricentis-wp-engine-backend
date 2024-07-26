<?php

/**
 * Restricting Wordpress Admin/Login By Internet Address (IP)
 * Place the folllowing code in wp-config.php so it runs before the WP bootstrap.
 */

function ip_in_list($ips) {
    foreach(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) as $check_ip) {
        foreach($ips as $ip) {
            // "STRIPOS = 0" is a simple "begins with" search.
            // Could be replaced with something more robust if necessary.
            if(stripos($check_ip, $ip) === 0) {
                //error_log("$ip matches on $check_ip");
                return true;
            }
        }
    }
    return false;
}

function is_from_trusted_ip() {
    /*
        Replace the IPs in this array with those you want to restrict access to.
        Since we're using a "begins with" search you can include simple prefixes
        such as "12.34.56". Do this with caution if you do not know the exact range
        the client's network provides, or you might give access to all of Xfinity's users lol
    */
    $trusted_ips = [
        'www.xxx.yyy.zzz', //etc
    ];

    return ip_in_list($trusted_ips);
}

// Only consider blocking if we're not running the PHP command line, AND the IP doesn't match.
if ((php_sapi_name() !== 'cli') && !is_from_trusted_ip()) {

    $to_lockdown = false;

    // These are the URIs we want to restrict (begin with search).
    // Make sure to include any alternate login endpoint established by the WPS Hide Login plugin.
    $disallow_uri = [ '/wp-login.php', '/wp-admin' ];

    foreach ($disallow_uri as $prefix) {
        if (stripos($_SERVER['REQUEST_URI'], $prefix) === 0) {
            $to_lockdown = true;
            break;
        }
    }

    // However, ensure that the form-submit and AJAX endpoints can be accessed (this is not REST API functionality)
    $allow_uri = [ '/wp-admin/admin-ajax.php', '/wp-admin/admin-post.php' ];

    foreach ($allow_uri as $prefix) {
        if (stripos($_SERVER['REQUEST_URI'], $prefix) === 0) {
            $to_lockdown = false;
            break;
        }
    }

    // If the URI is one we want to block (and we've already confirmed the IP isn't allowed), BYE.
    // If necessary, change the conditions to suit whatever environments (and host/domain) you need.
    if ($to_lockdown) {
        if (isset($_SERVER['PANTHEON_ENVIRONMENT']) /*&& ($_SERVER['PANTHEON_ENVIRONMENT'] == 'live')*/) {
            // However, we can give people an assisted backdoor to eventually get access.
            error_log('Should IP address '.$_SERVER['HTTP_X_FORWARDED_FOR'].' be whitelisted? '.($_REQUEST['secret'] ?? 'no secret provided'));
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied.';
            exit();
        }
    }
}
