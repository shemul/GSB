<div class="row">
    <div class="col-md-12">
       <div class="panel">
                                <header class="panel-heading">
                                    Bank Accounts
                                </header>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="/account/bank/add" class="btn btn-info"><i class="fa fa-plus"></i> ADD NEW BANK ACCOUNT</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="bank-tbl-wrap">
                                        <div class="tblwrap">
                                        <div id="loading"><p>Retireving Data From Server...</p></div>
                                        <table id="bank-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                            <thead>
                                                <tr>
                                                    <th>BANK NAME</th>
                                                    <th>ACC NUMBER</th>
                                                    <th data-hide="phone,tablet">HOLDER</th>
                                                    <th data-hide="phone,tablet">BRANCH</th>
                                                    <th data-hide="phone,tablet">SWIFTCODE</th>
                                                   
                                                    <th data-hide="phone,tablet">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bank-tbl-content">
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