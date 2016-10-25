<?php
class MyPayPal {

    function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode) {
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode($PayPalApiUsername);
        $API_Password = urlencode($PayPalApiPassword);
        $API_Signature = urlencode($PayPalApiSignature);

        $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';

        $API_Endpoint = "https://api-3t" . $paypalmode . ".paypal.com/nvp";
        $version = urlencode('109.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

}
class IpnListener {
    
    /**
     *  If true, the recommended cURL PHP library is used to send the post back 
     *  to PayPal. If flase then fsockopen() is used. Default true.
     *
     *  @var boolean
     */
    public $use_curl = true;     
    
    /**
     *  If true, explicitly sets cURL to use SSL version 3. Use this if cURL
     *  is compiled with GnuTLS SSL.
     *
     *  @var boolean
     */
    public $force_ssl_v3 = true;     
   
    /**
     *  If true, cURL will use the CURLOPT_FOLLOWLOCATION to follow any 
     *  "Location: ..." headers in the response.
     *
     *  @var boolean
     */
    public $follow_location = false;     
    
    /**
     *  If true, an SSL secure connection (port 443) is used for the post back 
     *  as recommended by PayPal. If false, a standard HTTP (port 80) connection
     *  is used. Default true.
     *
     *  @var boolean
     */
    public $use_ssl = true;      
    
    /**
     *  If true, the paypal sandbox URI www.sandbox.paypal.com is used for the
     *  post back. If false, the live URI www.paypal.com is used. Default false.
     *
     *  @var boolean
     */
    public $use_sandbox = false; 
    
    /**
     *  The amount of time, in seconds, to wait for the PayPal server to respond
     *  before timing out. Default 30 seconds.
     *
     *  @var int
     */
    public $timeout = 30;       
    
    private $post_data = array();
    private $post_uri = '';     
    private $response_status = '';
    private $response = '';
    const PAYPAL_HOST = 'www.paypal.com';
    const SANDBOX_HOST = 'www.sandbox.paypal.com';
    
    /**
     *  Post Back Using cURL
     *
     *  Sends the post back to PayPal using the cURL library. Called by
     *  the processIpn() method if the use_curl property is true. Throws an
     *  exception if the post fails. Populates the response, response_status,
     *  and post_uri properties on success.
     *
     *  @param  string  The post data as a URL encoded string
     */
    protected function curlPost($encoded_data) {
        if ($this->use_ssl) {
            $uri = 'https://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        } else {
            $uri = 'http://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        }
        
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, 
		            dirname(__FILE__)."/cert/api_cert_chain.crt");
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->follow_location);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        if ($this->force_ssl_v3) {
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        }
        
        $this->response = curl_exec($ch);
        $this->response_status = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        
        if ($this->response === false || $this->response_status == '0') {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
    }
    
    /**
     *  Post Back Using fsockopen()
     *
     *  Sends the post back to PayPal using the fsockopen() function. Called by
     *  the processIpn() method if the use_curl property is false. Throws an
     *  exception if the post fails. Populates the response, response_status,
     *  and post_uri properties on success.
     *
     *  @param  string  The post data as a URL encoded string
     */
    protected function fsockPost($encoded_data) {
    
        if ($this->use_ssl) {
            $uri = 'ssl://'.$this->getPaypalHost();
            $port = '443';
            $this->post_uri = $uri.'/cgi-bin/webscr';
        } else {
            $uri = $this->getPaypalHost(); // no "http://" in call to fsockopen()
            $port = '80';
            $this->post_uri = 'http://'.$uri.'/cgi-bin/webscr';
        }
        $fp = fsockopen($uri, $port, $errno, $errstr, $this->timeout);
        
        if (!$fp) { 
            // fsockopen error
            throw new Exception("fsockopen error: [$errno] $errstr");
        } 
        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Host: ".$this->getPaypalHost()."\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".strlen($encoded_data)."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        
        fputs($fp, $header.$encoded_data."\r\n\r\n");
        
        while(!feof($fp)) { 
            if (empty($this->response)) {
                // extract HTTP status from first line
                $this->response .= $status = fgets($fp, 1024); 
                $this->response_status = trim(substr($status, 9, 4));
            } else {
                $this->response .= fgets($fp, 1024); 
            }
        } 
        
        fclose($fp);
    }
    
    private function getPaypalHost() {
        if ($this->use_sandbox) return self::SANDBOX_HOST;
        else return self::PAYPAL_HOST;
    }
    
    /**
     *  Get POST URI
     *
     *  Returns the URI that was used to send the post back to PayPal. This can
     *  be useful for troubleshooting connection problems. The default URI
     *  would be "ssl://www.sandbox.paypal.com:443/cgi-bin/webscr"
     *
     *  @return string
     */
    public function getPostUri() {
        return $this->post_uri;
    }
    
    /**
     *  Get Response
     *
     *  Returns the entire response from PayPal as a string including all the
     *  HTTP headers.
     *
     *  @return string
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     *  Get Response Status
     *
     *  Returns the HTTP response status code from PayPal. This should be "200"
     *  if the post back was successful. 
     *
     *  @return string
     */
    public function getResponseStatus() {
        return $this->response_status;
    }
    
    /**
     *  Get Text Report
     *
     *  Returns a report of the IPN transaction in plain text format. This is
     *  useful in emails to order processors and system administrators. Override
     *  this method in your own class to customize the report.
     *
     *  @return string
     */
    public function getTextReport() {
        
        $r = '';
        
        // date and POST url
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n[".date('m/d/Y g:i A').'] - '.$this->getPostUri();
        if ($this->use_curl) $r .= " (curl)\n";
        else $r .= " (fsockopen)\n";
        
        // HTTP Response
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n{$this->getResponse()}\n";
        
        // POST vars
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n";
        
        foreach ($this->post_data as $key => $value) {
            $r .= str_pad($key, 25)."$value\n";
        }
        $r .= "\n\n";
        
        return $r;
    }
    
    /**
     *  Process IPN
     *
     *  Handles the IPN post back to PayPal and parsing the response. Call this
     *  method from your IPN listener script. Returns true if the response came
     *  back as "VERIFIED", false if the response came back "INVALID", and 
     *  throws an exception if there is an error.
     *
     *  @param array
     *
     *  @return boolean
     */    
    public function processIpn($post_data=null) {
        $encoded_data = 'cmd=_notify-validate';
        
        if ($post_data === null) { 
            // use raw POST data 
            if (!empty($_POST)) {
                $this->post_data = $_POST;
                $encoded_data .= '&'.file_get_contents('php://input');
            } else {
                throw new Exception("No POST data found.");
            }
        } else { 
            // use provided data array
            $this->post_data = $post_data;
            
            foreach ($this->post_data as $key => $value) {
                $encoded_data .= "&$key=".urlencode($value);
            }
        }
        if ($this->use_curl) $this->curlPost($encoded_data); 
        else $this->fsockPost($encoded_data);
        
        if (strpos($this->response_status, '200') === false) {
            throw new Exception("Invalid response status: ".$this->response_status);
        }
        
        if (strpos($this->response, "VERIFIED") !== false) {
            return true;
        } elseif (strpos($this->response, "INVALID") !== false) {
            return false;
        } else {
            throw new Exception("Unexpected response from PayPal.");
        }
    }
    
    /**
     *  Require Post Method
     *
     *  Throws an exception and sets a HTTP 405 response header if the request
     *  method was not POST. 
     */    
    public function requirePostMethod() {
        // require POST requests
        if ($_SERVER['REQUEST_METHOD'] && $_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Allow: POST', true, 405);
            throw new Exception("Invalid HTTP request method.");
        }
    }
}
function generateppdata($return, $cancel, $itemname, $price, $qty, $hcost, $grandtotal, $currency, $logo) {
    $padata = '&METHOD=SetExpressCheckout' .
            '&RETURNURL=' . urlencode($return) .
            '&CANCELURL=' . urlencode($cancel) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($itemname) .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($price) .
            '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($qty) .
            /*
              //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
              '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
              '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
              '&L_PAYMENTREQUEST_0_DESC1='.urlencode($ItemDesc2).
              '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
              '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
             */

            /*
              //Override the buyer's shipping address stored on PayPal, The buyer cannot edit the overridden address.
              '&ADDROVERRIDE=1'.
              '&PAYMENTREQUEST_0_SHIPTONAME=J Smith'.
              '&PAYMENTREQUEST_0_SHIPTOSTREET=1 Main St'.
              '&PAYMENTREQUEST_0_SHIPTOCITY=San Jose'.
              '&PAYMENTREQUEST_0_SHIPTOSTATE=CA'.
              '&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=US'.
              '&PAYMENTREQUEST_0_SHIPTOZIP=95131'.
              '&PAYMENTREQUEST_0_SHIPTOPHONENUM=408-967-4444'.
             */

            '&NOSHIPPING=0' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping

            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($price) .
            '&PAYMENTREQUEST_0_HANDLINGAMT=' . urlencode($hcost) .
            '&PAYMENTREQUEST_0_AMT=' . urlencode($grandtotal) .
            '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($currency) .
            '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
            '&LOGOIMG=' . $logo . //site logo
            '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
            '&ALLOWNOTE=1';
    return $padata;
}
function generateppreturn($token, $payer_id, $itemname, $price, $qty, $hcost, $grandtotal, $currency, $notif,$tipe,$uid){
    $custom = base64_encode($tipe."|".$uid);
    $padata = '&TOKEN=' . urlencode($token) .
                '&PAYERID=' . urlencode($payer_id) .
                '&PAYMENTREQUEST_0_NOTIFYURL=' . urlencode($notif) .
                '&PAYMENTREQUEST_0_CUSTOM=' .urlencode($custom) .
                '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                //set item info here, otherwise we won't see product details later	
                '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($itemname) .
                '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($price) .
                '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($qty) .
                /*
                  //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
                  '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
                  '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
                  '&L_PAYMENTREQUEST_0_DESC1=Description text'.
                  '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
                  '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
                 */
                '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($price) .
                '&PAYMENTREQUEST_0_HANDLINGAMT=' . urlencode($hcost) .
                '&PAYMENTREQUEST_0_AMT=' . urlencode($grandtotal) .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($currency);
    return $padata;
}

?>