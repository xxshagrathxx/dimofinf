<?php
    function currencyConversion($amount, $from = 'EGP', $to = 'USD') {
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$from;
        $response_json = file_get_contents($req_url);

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

            // Decoding
            $response_object = json_decode($response_json);

            // YOUR APPLICATION CODE HERE, e.g.
            $base_price = $amount;
            $amount = round(($base_price * $response_object->rates->$to), 5);

            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        }

        return $amount;
    }
