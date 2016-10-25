<div class="row">

    <div class="col-md-12">
        <div class="pan-container">
            <div id='treeview-pan' class='pan-wrap'>
               <div class="tree">
                    <ul style='min-width:2000px;'>
                        <li data-id='<?php echo $_SESSION['uid']; ?>'>
                            <a href="#">
                                <div>
                                    <h3><i class='fa fa-star'></i> <?php echo strtoupper($_SESSION["uname"]); ?></h3>
                                    <?php if($_SESSION["role"]=="1"){ ?>
                                    <p>
                                        Investations : $<?php echo theInvest($_SESSION["uid"]); ?>
                                    </p>
                                    <div class='col-md-12 nodes-info'>
                                        <div class='col-md-3'>
                                          <?php echo countNodes($_SESSION["uid"],"left"); ?>
                                        </div>
                                        <div class='col-md-6 midx'>
                                             Nodes
                                        </div>
                                        <div class='col-md-3'>
                                             <?php echo countNodes($_SESSION["uid"],"right"); ?>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>  
                                    <div class='col-md-12 invest-info'>
                                        <div class='col-md-6 linfest'>
                                            <strong>Left Invest</strong><br>
                                          $<?php echo countInvest($_SESSION["uid"],"left"); ?>
                                        </div>
                                        <div class='col-md-6 rinfest'>
                                            <strong>Right Invest</strong><br>
                                             $<?php echo countInvest($_SESSION["uid"],"right"); ?>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div> 
                                    <?php } ?>
                                </div>
                            </a>
                                <?php echo theTree(firstDownline($_SESSION["uid"])); ?>




                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id='tree-loading'>
            <h2 style="text-align: center;padding-top: 40px;">LOADING YOUR NETWORK TREE</h2>
        </div>
    </div>
</div>
