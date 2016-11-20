<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Please fill form below to edit your profile
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Your profile has been updated</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Your profile cant be updated, please try again later ( Make sure you make any changes to your profile when update )</p>
                            </div>
                            <div class=" form">
                                <form class="cmxform form-horizontal adminex-form" id="editForm" method="post" action="">
                                    
                                    <div class="form-group">
                                        <label for="upline" class="control-label col-lg-2">Upline </label>
                                        <div class="col-lg-10">
                                            
                                            <!--Temporary Code , should be removed shortly-->
                                            <?php
                                                $usr_name = $_SESSION["godmode"]["uname"] ;
                                                if($usr_name=="simon") {
                                                    
                                            ?>
                                            
                                            <!-- End of Temp Code -->
                                             <select  id='upline' name='upline' class='selectpicker' data-live-search='true'  >
                                                    <?php //echo ($_SESSION["role"]=="0"?"<option value='0'>ADMIN ( NEW NETWORK )</option>":""); ?>
                                                    <?php 
                                                        $din = get_parent($_SESSION["uid"], "int");
                                                        echo availPosition_only_for_edit_upline($din); 
                                                    ?>

                                            </select> 
                                            
                                            <?php 
                                                } else {

                                            ?>
                                            
                                            <select disabled  id='upline' name='upline' class='selectpicker' data-live-search='true'  >
                                                    <?php //echo ($_SESSION["role"]=="0"?"<option value='0'>ADMIN ( NEW NETWORK )</option>":""); ?>
                                                    <?php 
                                                        $din = get_parent($_SESSION["uid"], "int");
                                                        echo availPosition_only_for_edit_upline($din); 
                                                    ?>

                                            </select>
                                            
                                            
                                            <?php
                                                }
                                            ?>


                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="uname" class="control-label col-lg-2">DIN No (required)</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="uname" name="uname" minlength="2" type="text" required value="<?php echo getDin($_SESSION["uid"], "uname"); ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="control-label col-lg-2">First Name (required)</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="fname" name="fname" minlength="2" type="text" required value="<?php echo getProfileData($_SESSION["uid"], "first_name"); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lname" class="control-label col-lg-2">Last Name (required)</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="lname" name="lname" minlength="2" type="text" required value="<?php echo getProfileData($_SESSION["uid"], "last_name"); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fat_name" class="control-label col-lg-2">Father Name</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="fat_name" name="fat_name" minlength="2" type="text" value="<?php echo getProfileData($_SESSION["uid"], "fatname"); ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gender" class="control-label col-lg-2">Gender</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="MALE" <?php echo (getProfileData($_SESSION["uid"], "gender")=="MALE" ? "selected" : ""); ?> >Male</option>
                                                <option value="FEMALE" <?php echo (getProfileData($_SESSION["uid"], "gender")=="FEMALE" ? "selected" : ""); ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="mobile" name="mobile" placeholder="" data-mask="(+99) 9999-9999-999" class="form-control" value="<?php echo getProfileData($_SESSION["uid"], "mobile"); ?>" >
                                        <span class="help-inline">(+01) 1234-1234-121</span>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">Nominee</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="beneficiary" name="beneficiary" placeholder=""  class="form-control" value="<?php echo getProfileData($_SESSION["uid"], "beneficiary"); ?>" >
                                       
                                    </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="address" class="control-label col-lg-2">Address (required)</label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control " id="address" name="address" required><?php echo getProfileData($_SESSION["uid"], "address"); ?></textarea>
                                        </div>
                                    </div>

                                    <<!-- div class="form-group">
                                        <label for="city" class="control-label col-lg-2">City (required)</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="city" name="city" minlength="2" type="text" required value="<?php //echo getProfileData($_SESSION["uid"], "city"); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="zip" class="control-label col-lg-2">Zip (required)</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="zip" name="zip" minlength="2" type="text" required value="<?php //echo getProfileData($_SESSION["uid"], "zip"); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="state" class="control-label col-lg-2">State</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="state" name="state" minlength="2" type="text" required value="<?php //echo getProfileData($_SESSION["uid"], "state"); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="control-label col-lg-2">Country</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="country" name="country" minlength="2" type="text" required value="<?php //echo getProfileData($_SESSION["uid"], "country"); ?>"/>
                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" id='submitprofile' type="submit">SAVE PROFILE</button>
                                            <button class="btn btn-default" id="waiting" style="display:none;">Submitting data...</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </section>
                </div>
            </div>