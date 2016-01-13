<?php

/**
 * Description of Paypal Advance
 *
 * @author turi
 */
class PaypalAdvance extends CComponent {

    const PARTNER = 'PayPal';
    const VENDOR = 'stanleyr15';
    const USER = 'stanleyr15';
    const PWD = 'stanley123';
    const MODE = 'TEST';
    
//    const PARTNER = "PayPalCA";
//    const VENDOR = "Marjeantine495";
//    const USER = "AureVass495";
//    const PWD = "AureVass2015%88";
//    const MODE = 'LIVE';

    // Set this to "live" for the live server, "pilot" for the test server, or "sandbox"
// for Payflow accounts created through a Website Payments Pro account on the Sandbox.
    public $environment;

    public function __construct() {
        global $environment;
        $this->environment = 'pilot'; //live
    }

//// Helper functions
    public function pre($arr, $heading = NULL) {
        if (!empty($heading)) {
            echo "<p><b>$heading</b></p>";
        }
        echo "<pre><code>\n" . print_r($arr, true) . "\n</pre></code>";
    }

    public function script_url() {
        return (@$_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    }

// parse_payflow_string: Parses a response string from Payflow and returns an
// associative array of response parameters.
    public function parse_payflow_string($str) {
        $workstr = $str;
        $out = array();

        while (strlen($workstr) > 0) {
            $loc = strpos($workstr, '=');
            if ($loc === FALSE) {
// Truncate the rest of the string, it's not valid
                $workstr = "";
                continue;
            }

            $substr = substr($workstr, 0, $loc);
            $workstr = substr($workstr, $loc + 1); // "+1" because we need to get rid of the "="

            if (preg_match('/^(\w+)\[(\d+)]$/', $substr, $matches)) {
// This one has a length tag with it.  Read the number of characters
// specified by $matches[2].
                $count = intval($matches[2]);

                $out[$matches[1]] = substr($workstr, 0, $count);
                $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
            } else {
// Read up to the next "&"
                $count = strpos($workstr, '&');
                if ($count === FALSE) { // No more "&"'s, read up to the end of the string
                    $out[$substr] = $workstr;
                    $workstr = "";
                } else {
                    $out[$substr] = substr($workstr, 0, $count);
                    $workstr = substr($workstr, $count + 1); // "+1" because we need to get rid of the "&"
                }
            }
        }

        return $out;
    }

// run_payflow_call: Runs a Payflow API call.  $params is an associative array of
// Payflow API parameters.  Returns FALSE on failure, or an associative array of response
// parameters on success.
    public function run_payflow_call($params) {
        $paramList = array();
        foreach ($params as $index => $value) {
            $paramList[] = $index . "[" . strlen($value) . "]=" . $value;
        }

        $apiStr = implode("&", $paramList);

// Which endpoint will we be using?
        if ($this->environment == "pilot" || $this->environment == "sandbox")
            $endpoint = "https://pilot-payflowpro.paypal.com/";
        else
            $endpoint = "https://payflowpro.paypal.com";

// Initialize our cURL handle.
        $curl = curl_init($endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

// If you get connection errors, it may be necessary to uncomment
// the following two lines:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $apiStr);

        $result = curl_exec($curl);
        if ($result === FALSE) {
            echo curl_error($curl);
            return FALSE;
        } else
            return $this->parse_payflow_string($result);
    }

}
