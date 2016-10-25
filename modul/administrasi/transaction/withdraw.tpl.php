
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
                                        <div class="col-md-3">
                                            <input type="text" size="16" class="form-control" placeholder="Withdrawal ID" id="wdid">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" size="16" class="form-control" placeholder="Username" id="uname">
                                        </div>
                                            <div class="col-md-3">
                                              <div class="input-append date dpYears">
                                                <input type="text" readonly=""  size="16" class="form-control tgl" placeholder="FROM DATE" id="from" style="cursor:pointer;">
                                                    <span class="input-group-btn add-on">
                                                        <button onclick="clearDate();" class="btn btn-primary tooltips" type="button" data-toggle="tooltip " data-placement="bottom" title="" data-original-title="Click to clear date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                             </div>
                                             <div class="input-append date dpYears">
                                                <input type="text" readonly=""  size="16" class="form-control tgl" placeholder="TO DATE" id="to" style="cursor:pointer;">
                                                    <span class="input-group-btn add-on">
                                                        <button onclick="clearDate();" class="btn btn-primary tooltips" type="button" data-toggle="tooltip " data-placement="bottom" title="" data-original-title="Click to clear date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                            </div>   
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
                                                    <th data-hide="phone,tablet">Action</th>
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