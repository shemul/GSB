<?php

use Omnipay\Tests\GatewayTestCase;

class StripeCC extends GatewayTestCase {

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
        $setting = (isset($setting["StripeCC"]) ? $setting["StripeCC"] : "");
        $this->setting = $setting;
    }

    public function render_setting_form() {
        $setting = $this->setting;
        include 'settingform.php';
    }

    public function buildPayment($param) {
        $this->options = $param;
        $this->loadSetting();
    }
    public function setUp(){
        return true;
    }
    public function cc_page() {
        global $hooks;
        $order = $this->options;
        $setting = $this->setting;
        var_dump($setting);
        $hooks->add_action('the_title', function() {
            echo "STRIPE PAYMENT GATEWAY";
        });
        $hooks->add_action('global_css', function() {
            ?>
            <style>
                .xjc{
                    display: inline-block;
                    float: left;
                    padding: 18px;
                    font-weight: bold;   
                }
                .panel-default > .panel-heading {
                    background-color: #F4F4F4;
                    border-color: #FFFFFF;
                    color: #747474;
                }
                .payment-errors{
                    color: #DC1D1D;
                    font-weight: bold;
                    margin-top: 20px;
                }
            </style>
            <?php
        });
        $hooks->add_action('global_js', function() {
            ?>
            <!--If you're using Stripe for payments -->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
            <script>
                var $form = $('#payment-form');
                $form.on('submit', payWithStripe);

                /* If you're using Stripe for payments */
                function payWithStripe(e) {
                    e.preventDefault();

                    /* Visual feedback */
                    $form.find('[type=submit]').html('Validating <i class="fa fa-spinner fa-pulse"></i>');

                    var PublishableKey = $('#pkey').val(); // Replace with your API publishable key
                    Stripe.setPublishableKey(PublishableKey);

                    /* Create token */
                    var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
                    var ccData = {
                        name: $form.find('[name=cardholder]').val(),
                        number: $form.find('[name=cardNumber]').val().replace(/\s/g, ''),
                        cvc: $form.find('[name=cardCVC]').val(),
                        exp_month: expiry.month,
                        exp_year: expiry.year
                    };

                    Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
                        if (response.error) {
                            /* Visual feedback */
                            $form.find('[type=submit]').html('Try again');
                            /* Show Stripe errors on the form */
                            $form.find('.payment-errors').text(response.error.message);
                            $form.find('.payment-errors').closest('.row').show();
                        } else {
                            /* Visual feedback */
                            $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
                            /* Hide Stripe errors on the form */
                            $form.find('.payment-errors').closest('.row').hide();
                            $form.find('.payment-errors').text("");
                            // response contains id and card, which contains additional card details            
                            console.log(response.id);
                            console.log(response.card);
                            var token = response.id;
                            // AJAX - you would send 'token' to your server here.
                            $.post('/stripe-validation', {
                                stripetoken: token
                            })
                                    // Assign handlers immediately after making the request,
                                    .done(function (data, textStatus, jqXHR) {
                                        $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                                        location.href = '/buypoints/success/StripeCC'
                                    })
                                    .fail(function (jqXHR, textStatus, errorThrown) {
                                        $form.find('[type=submit]').html('Please Try Again').removeClass('btn-success').addClass('btn-danger');
                                        /* Show Stripe errors on the form */
                                        $form.find('.payment-errors').text(jqXHR.responseText);
                                        $form.find('.payment-errors').closest('.row').show();
                                    });
                        }
                    });
                }
                /* Fancy restrictive input formatting via jQuery.payment library*/
                $('input[name=cardNumber]').payment('formatCardNumber');
                $('input[name=cardCVC]').payment('formatCardCVC');
                $('input[name=cardExpiry').payment('formatCardExpiry');

                /* Form validation using Stripe client-side validation helpers */
                jQuery.validator.addMethod("cardNumber", function (value, element) {
                    return this.optional(element) || Stripe.card.validateCardNumber(value);
                }, "Please specify a valid credit card number.");

                jQuery.validator.addMethod("cardExpiry", function (value, element) {
                    /* Parsing month/year uses jQuery.payment library */
                    value = $.payment.cardExpiryVal(value);
                    return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
                }, "Invalid expiration date.");

                jQuery.validator.addMethod("cardCVC", function (value, element) {
                    return this.optional(element) || Stripe.card.validateCVC(value);
                }, "Invalid CVC.");

                validator = $form.validate({
                    rules: {
                        cardNumber: {
                            required: true,
                            cardNumber: true
                        },
                        cardExpiry: {
                            required: true,
                            cardExpiry: true
                        },
                        cardCVC: {
                            required: true,
                            cardCVC: true
                        }
                    },
                    highlight: function (element) {
                        $(element).closest('.form-control').removeClass('success').addClass('error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-control').removeClass('error').addClass('success');
                    },
                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').append(error);
                    }
                });

                paymentFormReady = function () {
                    if ($form.find('[name=cardNumber]').hasClass("success") &&
                            $form.find('[name=cardExpiry]').hasClass("success") &&
                            $form.find('[name=cardCVC]').val().length > 1) {
                        return true;
                    } else {
                        return false;
                    }
                }

                $form.find('[type=submit]').prop('disabled', true);
                var readyInterval = setInterval(function () {
                    if (paymentFormReady()) {
                        $form.find('[type=submit]').prop('disabled', false);
                        clearInterval(readyInterval);
                    }
                }, 250);
            </script>
            <?php
        });
        $uniq = new DateTime();
        $_SESSION["purchase"]["options"] = $this->options;
        $_SESSION["purchase"]["options"]["transid"] = $_SESSION["uname"] . $uniq->getTimestamp();
        //echo "<script>location.href='".$_SESSION["purchase"]["options"]["returnUrl"]."'</script>";
        //return $response->getTransactionReference();
        the_head();
        include 'payment.php';
        the_footer();
    }

    public function final_purchase($token) {
        parent::setUp();
        $this->loadSetting();
        $setting = $this->setting;
        $this->gateway = new Omnipay\Stripe\Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize(array(
            'apiKey' => $setting['secret'],
        ));
        
        $response = $this->gateway->purchase(['amount' => $_SESSION["purchase"]["options"]["amount"], 'currency' => 'USD', 'token' => $token])->send();
        $data = $response->getData();
        $_SESSION['purchase']['options']['notes'] = 'PAYMENT FOR POINT, REFERENCE ID : #'.$data['id'];
        if ($response->isSuccessful()) {
            return array(
                'status' => '1',
                'message' => $response->getMessage()
            );
        } else {
            return array(
                'status' => '0',
                'message' => $response->getMessage()
            );
        }
    }

    public function purchase() {
        $this->cc_page();
    }

    public function complete() {
        $setting = $this->setting;
        $data = array(
            "status" => "1",
            "amount" => $_SESSION["purchase"]["options"]["amount"],
            "idinvoice" => $_SESSION["purchase"]["options"]["transid"],
            "gateway" => "Stripe CC",
            "notes" => $_SESSION['purchase']['options']['notes']
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
        $_SESSION["datahtml"] = $htmla . $html;
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
