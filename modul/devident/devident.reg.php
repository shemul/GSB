<div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Fill in form below to make new Devident Registration
                        </header>
                        <div class="panel-body">
                        <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. You have successfully make a new devident.. Reloading page.</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Cannot register devident, make sure your PIN is correct, also make sure you have sufficient balance. 
                                    </p>
                            </div>    
                      <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="registerdev" method="get" action="">
                                    <div class="form-group ">
                                        <label for="nominal" class="control-label col-lg-2">Nominal</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" id="nominal">
                                                <option value="100">$100</option>
                                                <option value="500">$500</option>
                                                <option value="1000">$1000</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10,000</option>
                                                <option value="50000">$50,000</option>
                                            </select>
                                            
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
                                            <button class="btn btn-primary" type="submit" id='submitpin'>Register Dedivent</button>
                                            <button class="btn btn-default" type="button" id='waitingpin' disabled style="display:none;">Please Wait...</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        </div>
                    </section>
                </div>
            </div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

