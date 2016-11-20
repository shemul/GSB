
<div class="row">
    <div class="col-md-12">
       <div class="panel">
                                <header class="panel-heading">
                                    Transaction Summary
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                        <div class="col-md-3">
                                            <input type="text" size="16" class="form-control" placeholder="Transaction ID" id="transid">
                                             <input type="text" size="16" class="form-control" placeholder="Username" id="user">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" id="transflow">
                                                <option value="">TRANSACTION Flow</option>
                                                <option value="in">INCOME</option>
                                                <option value="out">EXPENSE</option>
                                            </select>
                                            <select class="form-control" id="model">
                                                <option value="">TRANSACTION MODEL</option>
                                                <option value="adm">ADMIN ONLY</option>
                                                <option value="all">ALL USER</option>
                                            </select>
                                        </div>
                                            <div class="col-md6">
                                                <div class="col-md-3">
                                            <select id="transtype" class="form-control valid">
                                                <option value="">TRANSACTION TYPE</option>
                                                <?php transType(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-append date dpYears">
                                                <input type="text" readonly=""  size="16" class="form-control" placeholder="TRANSACTION DATE" id="date" style="cursor:pointer;">
                                                    <span class="input-group-btn add-on">
                                                        <button onclick="clearDate();" class="btn btn-primary tooltips" type="button" data-toggle="tooltip " data-placement="bottom" title="" data-original-title="Click to clear date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <select id='week' name='week' class="form-control" >
                                                
                                                <?php echo theWeeks(); ?>
                                            </select>
                                        </div>

                                                <div class="col-md-6">
                                                    USERNAME Filter cant be used on the same time with TRANSACTION MODEL
                                                </div>
                                            </div>    
                                        
                                        </div>
                                        <div class="col-md-4" style="text-align: right;">
                                            <a href="javascript:void();" id="filter" class="btn btn-info"><i class="fa fa-search"></i> FILTER</a>
                                            <a href="#" id="clearfilter" class="btn btn-danger"><i class="fa fa-ban"></i> CLEAR FILTER</a>
                                            <!-- <a href="#" id="genPdf" class="btn btn-primary"><i class="fa fa-save"></i> PDF</a> -->
                                            
                                            <!--Temporary Code , should be removed shortly-->
                                            <?php
                                                $usr_name = $_SESSION["uname"] ;
                                                if($usr_name=="simon") {
                                                ?>
                                                
                                            <!-- End of Temp Code -->
                                            
                                            
                                            <a href="#" id="btnFlush" class="btn btn-primary"><i class="fa fa-star"></i> FLUSH GENERATE</a>
                                            <a href="#" id="btnGenerate" class="btn btn-success"><i class="fa fa-star"></i> GENERATE</a>
                                            
                                            <?php 
                                            
                                                } else {
                                                    
                                                }
                                            ?>
                                        </div>



                                    </div>
                                    <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="trans-tbl-wrap">
                                        <div class="tblwrap">
                                        <div id="loading"><p>Retireving Data From Server...</p></div>
                                        <table id="trans-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Type</th>
                                                    <th data-hide="phone,tablet">Flow</th>
                                                    <th data-hide="phone,tablet">Date</th>
                                                    <th data-hide="phone,tablet">From</th>
                                                    <th data-hide="phone,tablet">To</th>
                                                    <th data-hide="phone,tablet">Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody id="trans-tbl-content">
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



                                    <div id="dialog" title="ATTENTION !" style="background-color : red;color:white">
                                        CAUTION : <br><br>

                                        <h3>Wait.. Did you download the bill sheet yet ???????????????????</h3> <br><br>

                                        ARE YOU REALLY SURE TO DO THIS ! THERES IS NOT TURN BACK !! <br>

                                        <h2>IT WILL TAKE 7 MIN ,PLEASE DON'T DO ANYTHING</h2>

                                    </div>​
        </div>
    </div>
</div>