<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Configure Paypal Express Checkout Setting
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form payment-gateway-form">
                                    <div class="form-group ">
                                        <label for="testmode" class="control-label col-lg-2">Paypal Mode ?</label>
                                        <div class="col-lg-10">
                                            <select id="testmode" name="gateway[ExpressCheckout][testmode]" class="form-control">
                                                <option value="true" <?php echo ($setting["testmode"]=="true"?"selected":""); ?>>SANDBOX MODE</option>
                                                <option value="false" <?php echo ($setting["testmode"]=="false"?"selected":""); ?>>LIVE MODE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="username" class="control-label col-lg-2">Paypal API Username</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="gateway[ExpressCheckout][username]" id="uname" type="text" value="<?php echo $setting["username"]; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="password" class="control-label col-lg-2">Paypal API Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="gateway[ExpressCheckout][password]" id="password" type="password" value="<?php echo $setting["password"]; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="signature" class="control-label col-lg-2">Paypal API Signature</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="gateway[ExpressCheckout][signature]" id="signature" value="<?php echo $setting["signature"]; ?>" type="text" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="logo" class="control-label col-lg-2">Paypal Logo Image URL</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="gateway[ExpressCheckout][logo]" id="logo" value="<?php echo $setting["logo"]; ?>" type="text" required/>
                                        </div>
                                    </div>
                                     <div class="form-group ">
                                        <label for="brandname" class="control-label col-lg-2">Brand Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="gateway[ExpressCheckout][brandname]" id="brandname" value="<?php echo $setting["brandname"]; ?>" type="text" required/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
