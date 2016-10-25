<?php global $bankid; ?>
<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Fill form below to add new bank account
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Your bank account has been updated. Redirecting in few seconds..</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Update Bank Account been declined, make sure your PIN is correct</p>
                            </div>
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="editbank" method="get" action="">
                                    <input type="hidden" id="bankid" value="<?php echo $bankid;?>">
                                    <div class="form-group ">
                                        <label for="bank_name" class="control-label col-lg-2">Bank Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="bank_name" id="bank_name" type="text" value="<?php echo bankInfo($bankid, "bank_name"); ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="branchname" class="control-label col-lg-2">Branch Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="branchname" id="branchname" type="text" value="<?php echo bankInfo($bankid, "branch_name"); ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="holder" class="control-label col-lg-2">Holder Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="holder" id="holder" type="text" value="<?php echo bankInfo($bankid, "bankholder"); ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="acnumber" class="control-label col-lg-2">Account Number</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="acnumber" id="acnumber" type="text" value="<?php echo bankInfo($bankid, "acnumber"); ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="swiftcode" class="control-label col-lg-2">Swift Code</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="swiftcode" id="swiftcode" type="text" value="<?php echo bankInfo($bankid, "swiftcode"); ?>" required/>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label for="pin" class="control-label col-lg-2">Transaction PIN</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="pin" id="pin" type="password" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit" id='submitpin'>Update Bank</button>
                                            <button class="btn btn-default" type="button" id='waitingpin' disabled style="display:none;">Please Wait...</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
