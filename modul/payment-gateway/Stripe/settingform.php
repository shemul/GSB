<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Configure Stripe Setting
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form payment-gateway-form">
                                    <div class="form-group ">
                                        <label for="secret" class="control-label col-lg-2">Secret Key</label>
                                        <div class="col-lg-10">
                                           <input class="form-control " name="gateway[StripeCC][secret]" id="secret" type="text" value="<?php echo (isset($setting["secret"])?$setting["secret"]:""); ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="publishable" class="control-label col-lg-2">Publishable Key</label>
                                        <div class="col-lg-10">
                                           <input class="form-control " name="gateway[StripeCC][publishable]" id="publishable" type="text" value="<?php echo (isset($setting["publishable"])?$setting["publishable"]:""); ?>" required/>
                                        </div>
                                    </div>
                                   
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
