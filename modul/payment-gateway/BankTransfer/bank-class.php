<?php

use Omnipay\Tests\GatewayTestCase;
use Omnipay\PayPal\ExpressGateway;

/*
 * This Class is using for handling the Paypal Payment Gateway
 */

class BankTransfer {

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
    
    public function __construct() {
        $this->loadSetting();
    }
    public function loadSetting() {
        $setting = unserialize(getSetting('payment_gateway'));
        $setting = (isset($setting["BankTransfer"])?$setting["BankTransfer"]:"");
        $this->setting = $setting;
    }
    public function setup(){
        return true;
    }
    public function render_setting_form() {
        $setting = $this->setting;
        include 'settingform.php';
    }

    public function buildPayment($param) {
        $this->options = $param;
    }

    public function purchase() {
        $uniq = new DateTime();
        $_SESSION["purchase"]["options"] = $this->options;
        $_SESSION["purchase"]["options"]["transid"] = $_SESSION["uname"].$uniq->getTimestamp();
        echo "<script>location.href='".$_SESSION["purchase"]["options"]["returnUrl"]."'</script>";
        //return $response->getTransactionReference();
    }

    public function complete() {
        $setting = $this->setting;
        $data = array(
            "status" => "0",
            "amount" => $_SESSION["purchase"]["options"]["amount"],
            "idinvoice" => $_SESSION["purchase"]["options"]["transid"],
            "gateway" => "Bank Transfer",
            "notes" => $setting['message']
        );
        createInvoice($data);
        $this->buildMessage($data);
        $this->sendEmail();
        return true;
    }

    public function buildMessage($data) {
        $htmla = "Hello, thankyou for your purchase </br>";
        $html = "INVOICE ID Is : <strong>" . $data["idinvoice"] . "</strong></br>";
        $html .= "AMOUNT : <strong>" . $data["amount"] . "</strong></br>";
        $html .= "PAYMENT GATEWAY : <strong>" . $data["gateway"] . "</strong></br>";
        $htmlb = "PAYMENT INSTRUCTION : <br><strong>" . $data["notes"] . "</strong></br>";
        $_SESSION["datahtml"] = $htmla.$html.$htmlb;
        $_SESSION["dataemail"] = $html;
        return true;
    }

    public function sendEmail() {
        $email = getProfileData("0", 'email');
        // Konfigurasi Pesan Email
        $pesan = "Hello There. </br></br>";
        $pesan .= "You have a new purchase, please check to system.</br>";
        $pesan .= $_SESSION["dataemail"];
        unset($_SESSION["dataemail"]);
        // Kirim Email
        sendMail($email, $pesan, "NEW PURCHASE");
    }

}
