
<div class="row">
    <div class="col-md-12">
       <div class="panel">
                                <header class="panel-heading">
                                   INVOICE / PURCHASING
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                       <div class="col-md-3">
                                            <select class="form-control" id="status">
                                                <option value="">PURCHASE STATUS</option>
                                                <option value="1">APPROVED</option>
                                                <option value="0">PENDING</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" size="16" class="form-control" placeholder="ORDER ID" id="wdid">
                                        </div>
                                        
                                            
                                        </div>
                                        <div class="col-md-4" style="text-align: right;">
                                            <a href="javascript:void()" id="filter" class="btn btn-info"><i class="fa fa-search"></i> FILTER</a>
                                            <a href="javascript:void()" id="clearfilter" class="btn btn-danger"><i class="fa fa-ban"></i> CLEAR FILTER</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="invoice-tbl-wrap">
                                        <div class="tblwrap">
                                        <div id="loading"><p>Retireving Data From Server...</p></div>
                                        <table id="invoice-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Status</th>
                                                    <th data-hide="phone,tablet">Purchase Date</th>
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