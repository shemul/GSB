<?php global $prodid; 
?>

<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Fill form below to add new product
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Your new product has been created. Redirecting in few seconds..</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Add New Product been declined, make sure your PIN is correct</p>
                            </div>
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="addproduct" method="get" action="">
                                    <input type="hidden" name="id" id="id" value="<?php echo $prodid; ?>">
                                    <div class="form-group ">
                                        <label for="bank_name" class="control-label col-lg-2">Product Name</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="product_name" id="product_name" type="text" value="<?php echo productInfo($prodid, "product_name"); ?>" required/>
                                        </div>
                                    </div>
                                      <div class="form-group ">
                                        <label for="nominal" class="control-label col-lg-2">Point Value</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input name="value" id="value" type="text" class="form-control" value="<?php echo productInfo($prodid, "value"); ?>" required=""/>
                                                <span class="input-group-addon">
                                                    USD ( <i class="fa fa-dollar"></i> )
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                      <div class="form-group ">
                                        <label for="nominal" class="control-label col-lg-2">Price</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input name="max_pair" id="max_pair" type="text" class="form-control" value="<?php echo productInfo($prodid, "max_pairing"); ?>" required=""/>
                                                <span class="input-group-addon">
                                                    USD ( <i class="fa fa-dollar"></i> )
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                      <div class="form-group ">
                                        <label for="nominal" class="control-label col-lg-2">Description</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input name="ref" id="ref" type="text" class="form-control" value="<?php echo productInfo($prodid, "description"); ?>" required=""/>
                                                <span class="input-group-addon">
                                                 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  
                                      <div class="form-group ">
                                        <label for="dev" class="control-label col-lg-2">Devident Rate</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input name="devrate" id="devrate" type="text" class="form-control" value="<?php echo productInfo($prodid, "devident_rate"); ?>" required=""/>
                                                <span class="input-group-addon">
                                                    Devident Rate 1 / Devident Rate 2, ex : 1/3 , means that 1 is devident rate in day 1 till 100, and 3 is devident rate in day 101 till 270
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit" id='submitpin'>Add Product</button>
                                            <button class="btn btn-default" type="button" id='waitingpin' disabled style="display:none;">Please Wait...</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
