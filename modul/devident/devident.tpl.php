<div class="row">
    <div class="col-md-12">
       <div class="panel">
           <header class="panel-heading" style="font-weight: normal;">
                                    
                                   <?php $a = floatval(number_format(getContentBar(),2)); 
                                  ?>
                                        <div class="progress progress-striped active progress-sm" style="height: 25px;">
                                            <div style="width: <?php echo $a; ?>%;padding-top:5px;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $a; ?>" role="progressbar" class="progress-bar progress-bar-success">
                                                <span><?php echo $a; ?>% Complete</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-3">
                                                    DEVIDENT ID #<strong><?php echo getActiveDevID(); ?></strong><br>
                                                    DEVIDENT POINT : <strong>$<?php echo InvestNominal(); ?></strong>
                                                </div>
                                                <div class="col-md-6">
                                                    OPENING DATE : <strong><?php echo date('F d, Y',strtotime(devDate())); ?></strong></br>
                                                    DAY <strong><?php echo xDDay(); ?></strong> of 270 - BONUS EARNING <strong>$<?php echo currentDevEarning(); ?></strong>
                                                </div>
                                                <div class="col-md-3" style="text-align: right;">
                                                    <a href="#closeDevModal" data-toggle="modal" class="btn btn-danger btn-extend"><i class="fa fa-times-circle"></i> ClOSE CURRENT DEVIDENT</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                 </header>
                                <div class="panel-body">
                                    
                                    <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="devident-tbl-wrap">
                                        <div class="tblwrap">
                                        <div id="loading"><p>Retireving Data From Server...</p></div>
                                        <table id="devident-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                            <thead>
                                                <tr>
                                                    <th>Devident Date</th>
                                                    <th>Devident Percentage Terms</th>
                                                    <th>Bonus Nominal</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="devident-tbl-content">
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
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="closeDevModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                    <h4 class="modal-title">Devident Closing</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure want to close your devident, if you close your active devident before day 270, you will be charged <strong>80%</strong> of your current investment 
                                                    as your penalty fee.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" id="closeDev" >Yes, Close Now</button>
                                                    <button type="button" class="btn btn-danger" id="waitya" disabled style="display:none;">Closing.. Please wait..</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>