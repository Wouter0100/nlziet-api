<?php
try {
    /**
     * Setup OAuth as nlziet app
     */
    $oauth = new OAuth('CONSUMER KEY', 'CONSUMER SECRET');
    //$oauth->enableDebug();

    /**
     * Request token from oAuth
     */
    $requestToken = $oauth->getRequestToken('http://www.nlziet.nl/OAuth/GetRequestToken', 'http://nlziet.rtlxl.nl/callback.html#nofetch');
    if(!empty($requestToken)) {

        /**
         * Execute login request using the App-way. (So we don't need to create a workaround for the CSRF protection)
         */
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.nlziet.nl/Account/AppLogin');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'username' => 'E-MAIL',
            'password' => 'PASSWORD'
        ]);

        curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {
            echo 'Login details seems to be incorrect. Received HTTP code: ' . $httpCode . PHP_EOL;
            exit();
        }

        curl_close($ch);

        /**
         * Authorize at OAuth and save the OAuth verifier
         */
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.nlziet.nl/OAuth/Authorize?layout=framed&oauth_token=' . $requestToken['oauth_token']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $line) {
            global $verifier;

            $lineHeader = explode(': ', $line);

            if ($lineHeader[0] == 'Location') {
                $verifier = explode('&oauth_verifier=', $lineHeader[1])[1];
            }

            return strlen($line);
        });

        curl_exec($ch);

        curl_close($ch);

        /**
         * Sets the request token to the OAuth instance
         */
        $oauth->setToken($requestToken['oauth_token'], $requestToken['oauth_token_secret']);

        /**
         * Request the access token
         */
        $accessToken = $oauth->getAccessToken('http://www.nlziet.nl/OAuth/GetAccessToken', null, $verifier, 'GET');
        if(!empty($accessToken)) {

            /**
             * We have our access token! :-)
             */
            print_r($accessToken);

        } else {
            echo 'Failed fetching access token, response was: ' . $oauth->getLastResponse() . PHP_EOL;
        }
    } else {
        echo 'Failed fetching request token, response was: ' . $oauth->getLastResponse() . PHP_EOL;
    }

} catch(OAuthException $e) {
    echo 'OAuthException: '. $e->lastResponse . PHP_EOL;
}
