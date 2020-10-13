<?php
    if (isset($_GET['code'])) {
      if (strlen($_GET['code']) != 0) {
        $authcode = $_GET['code'];

        // Callback from Widen DAM to complete OAuth authorization
        $raw_response = widendam_api_authenticate($authcode);

        $http_status = $raw_response['response']['code'];
        $response_body = $raw_response['body'];
        $response = json_decode($response_body);

        if ($http_status == '200' && isset($response->username) && isset($response->access_token)) {
            update_option('widen_username' , $response->username);
            update_option('widen_access_token' , $response->access_token);
            ?>
                <div class="updated"><p><strong>Authorization Successful</strong></p></div>
            <?php
        }
        else {
            ?>
            <div class="updated"><p><strong><?php echo('Authorization Failure: [' . $http_status . '] ' . $response_body); ?></strong></p></div>
            <?php
        }
      }
    }

    if (isset($_POST['widen_hidden']) && $_POST['widen_hidden'] == 'Y')
    {
        $domain = $_POST['widen_domain'];
        update_option('widen_domain', $domain);

        $http_status = widendam_validate_collective_ping();
        $ok = ($http_status == '200');
        if (!$ok)
        {
            ?>
            <div class="updated"><p><strong>Validating Widen DAM Domain: HTTP Error Code <?php echo($http_status) ?> </strong></p></div>
<?php
        }
        else
        {
            ?>
            <div class="updated"><p><strong>Validating Widen DAM Domain: OK</strong></p></div>
<?php
        }

        $http_status = widendam_validate_rest_post();
        $ok = ($http_status == '200');
        if (!$ok)
        {
            ?>
            <div class="updated"><p><strong>Validating API call: HTTP Error Code <?php echo($http_status) ?> </strong></p></div>
<?php
        }
        else
        {
            ?>
            <div class="updated"><p><strong>Validating API call: OK</strong></p></div>
<?php
        }

        $deauth = $_POST['widen_deauth'];
        if (isset($deauth) && (strlen($deauth) != 0))
        {
            update_option('widen_username', null);
            update_option('widen_access_token', null);
            widendam_api_deauthorize();
        }

    ?>

    <div class="updated"><p><strong>Options Saved</strong></p></div>
<?php
    }
    else
    {
        // Initialize form fields with saved values
        $domain = get_option('widen_domain');
        $username = get_option('widen_username');
        $authcode = "";
    }
    ?>

<div class="wrap">
    <h2>Widen Collective Settings</h2>

    <form name="widen_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="widen_hidden" value="Y">
        <p>Domain: <input placeholder="ex: demo.widencollective.com" type="text" name="widen_domain" size="50" value="<?php echo $domain; ?>" size="20">
        <input type="submit" name="Submit" value="Submit" />
        <?php
            $domain = get_option('widen_domain');
            $token = get_option('widen_access_token');
            if (isset($domain) && (strlen($domain) != 0))
            {
                if (isset($token) && (strlen($token) != 0))
                {
                    ?>
                    <p>You are currently Authorized to Widen Collective as: <?php echo get_option('widen_username') ?> </p>
                    <input type="hidden" name="widen_deauth" value="1">
                    <input type="submit" name="Submit" value="Deauthorize" />
                <?php
                }
                else
                {
                    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
                    $return_url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "&response_type=code";
                    $login_url = widendam_api_get_login_link($return_url);
                ?>
        </p>
    <br/>

                    <a href='<?php echo widendam_api_get_login_link($return_url) ?>'>Authorize with Widen Collective</a>
                <?php
                }
            }
        ?>

    </form>
</div>
