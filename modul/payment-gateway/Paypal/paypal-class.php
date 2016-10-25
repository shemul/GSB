<?php

use Omnipay\Tests\GatewayTestCase;
use Omnipay\PayPal\ExpressGateway;

/*
 * This Class is using for handling the Paypal Payment Gateway
 */

class PaypalExpress extends GatewayTestCase {

    /**
     * @var \Omnipay\PayPal\ExpressGateway
     */
    public $setting;

    /**
     * @var \Omnipay\PayPal\ExpressGateway
     */
    protected $gateway;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $voidOptions;

    public function loadSetting() {
        $setting = unserialize(getSetting('payment_gateway'));
        $setting = (isset($setting["ExpressCheckout"])?$setting["ExpressCheckout"]:"");
        $this->setting = $setting;
    }

    public function render_setting_form() {
        $setting = $this->setting;
        include 'settingform.php';
    }

    public function buildPayment($param) {
        $this->options = $param;
        $this->setUp();
    }

    public function setUp() {
        $this->loadSetting();
        $setting = $this->setting;
        parent::setUp();
        $this->gateway = new ExpressGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setUsername($setting["username"]);
        $this->gateway->setPassword($setting["password"]);
        $this->gateway->setSignature($setting["signature"]);
        $this->gateway->setTestMode($setting["testmode"]);
        $this->gateway->setLogoImageUrl($setting["logo"]);
        $this->gateway->setBrandName($setting["brandname"]);
        $this->gateway->setLandingPage("Login");
        $this->gateway->setSolutionType('SOLE');
    }

    public function purchase() {
        $_SESSION["purchase"]["options"] = $this->options;
        $response = $this->gateway->purchase($this->options)->send();
        $_SESSION["purchase"]["reference"] = $response->getTransactionReference();
        return $response->redirect();
        //return $response->getTransactionReference();
    }

    public function complete() {
        $opt = array(
            'token' => $_GET["token"],
            'transactionReference' => $_SESSION["purchase"]["reference"],
            'amount' => $_SESSION["purchase"]["options"]["amount"],
            'payer_id' => $_GET["PayerID"],
            'transactionId' => time(),
        );
        $response = $this->gateway->completePurchase($opt)->send();
        $response = $response->getData();
        // Record to DB
        $status = ($response["PAYMENTINFO_0_PAYMENTSTATUS"] == "Completed" ? "1" : "0");
        $data = array(
            "status" => $status,
            "amount" => $_SESSION["purchase"]["options"]["amount"],
            "idinvoice" => $response["PAYMENTINFO_0_TRANSACTIONID"],
            "gateway" => "Paypal Express Checkout",
            "notes" => $response["PAYMENTINFO_0_PAYMENTSTATUS"]
        );
        createInvoice($data);
        $this->buildMessage($data);
        $this->sendEmail();
        return true;
    }

    public function buildMessage($data) {
        $htmla = "Hello, thankyou for your purchase </br>";
        $html .= "INVOICE ID Is : <strong>" . $data["idinvoice"] . "</strong></br>";
        $html .= "AMOUNT : <strong>" . $data["amount"] . "</strong></br>";
        $html .= "PAYMENT GATEWAY : <strong>" . $data["gateway"] . "</strong></br>";
        $html .= "STATUS : <strong>" . ($data["status"] == "1" ? "SUCCESS" : $data["notes"]) . "</strong></br>";
        $_SESSION["datahtml"] = $htmla.$html;
        $_SESSION["dataemail"] = $html;
        return true;
    }

    public function sendEmail() {
        $email = getProfileData("0", 'email');
        // Konfigurasi Pesan Email
        $pesan .= "Hello There. </br></br>";
        $pesan .= "You have a new purchase, please check to system.</br>";
        $pesan .= $_SESSION["dataemail"];
        unset($_SESSION["dataemail"]);
        // Kirim Email
        sendMail($email, $pesan, "New Purchase");
    }

}
