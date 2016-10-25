<div class="row">
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Withdrawal Request to your Bank account
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Withdrawal request sucess..</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Withdrawal has been declined, make sure your PIN is correct, also make sure you have sufficient balance. Please remember that minimum withdraw is <strong><?php echo $global_min_wd; ?></strong></p>
                            </div>
                            <div class="form">
                                <?php if(hasBank()){ ?>
                                <form class="cmxform form-horizontal adminex-form" id="wdfund" method="get" action="">
                                    <div class="form-group ">
                                        <label for="nominal" class="control-label col-lg-2">Nominal</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input name="nominal" id="nominal" type="text" class="form-control" required=""/>
                                                <span class="input-group-addon">
                                                    USD ( <i class="fa fa-dollar"></i> )
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="bank" class="control-label col-lg-2">Bank Account</label>
                                        <div class="col-lg-10">
                                            <select class="form-control " name="bank" id="bank" required/>
                                                <?php theBanks(); ?>
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
                                            <button class="btn btn-primary" type="submit" id='submitpin'>Withdraw</button>
                                            <button class="btn btn-default" type="button" id='waitingpin' disabled style="display:none;">Please Wait...</button>
                                        </div>
                                    </div>
                                </form>
                                <?php }else{ ?>
                                You didnt have any bank account, please make it one first by click this <a href="/account/bank/add">link</a>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class="panel panel-primary">
                        <header class="panel-heading">
                            Withdrawal Terms Information
                        </header>
                        <div class="panel-body">
                            <p>
                                We have ordinances and regulations in the conduct withdrawal. 
                                The rules are :
                            </p>
                            <p>
                                <ol>
                                    <li>
                                        Widthrawal ammount minimum is <strong><?php echo $global_min_wd; ?></strong>
                                    </li>
                                    <li>
                                        Withdrawal ammount will calculated using this terms. <strong><?php echo $global_wdable; ?>%</strong> will be transferable to your bank account, and <strong><?php echo $global_wdreg; ?>%</strong> will be converted into register fund.
                                    </li>
                                </ol>
                            </p>
                        </div>
                    </section>
                </div>
</div>
<div class="row">
    <div class="col-md-12">
       <div class="panel">
                                <header class="panel-heading">
                                    Withdrawal List
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                       <div class="col-md-3">
                                            <select class="form-control" id="status">
                                                <option value="">WITHDRAW STATUS</option>
                                                <option value="paid">PAID</option>
                                                <option value="pending">PENDING</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-md-4" style="text-align: right;">
                                            <a href="javascript:void()" id="filter" class="btn btn-info"><i class="fa fa-search"></i> FILTER</a>
                                            <a href="javascript:void()" id="clearfilter" class="btn btn-danger"><i class="fa fa-ban"></i> CLEAR FILTER</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="withdraw-tbl-wrap">
                                        <div class="tblwrap">
                                        <div id="loading"><p>Retireving Data From Server...</p></div>
                                        <table id="withdraw-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Status</th>
                                                    <th data-hide="phone,tablet">Request Date</th>
                                                    <th data-hide="phone,tablet">Payment Date</th>
                                                    <th data-hide="phone,tablet">Pay To</th>
                                                </tr>
                                            </thead>
                                            <tbody id="withdraw-tbl-content">
                                                <tr>
                                                    <td>Loading Data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
        
                                        </div>
                                     </div>
                                    </div>
                                </div>
        </div>
    </div>
</div>