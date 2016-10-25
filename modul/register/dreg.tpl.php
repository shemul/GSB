

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>


<style type="text/css">
    

.btn dropdown-toggle btn-info {
    background-color: green;
}

</style>
<div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Follow wizard below to register new Account / Downline
                        </header>
                        <div class="panel-body">
                        <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. New user has been created.. Reloading page.</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Cannot register member, make sure your PIN is correct, also make sure you have sufficient register balance. 
                                    </p>
                            </div>    
                    <div class="box-widget">
                        <div class="widget-head clearfix">
                            <div id="top_tabby" class="block-tabby pull-left">
                            </div>
                        </div>
                        <div class="widget-container">
                            <div class="widget-block">
                                <div class="widget-content box-padding">
                                    <form id="stepy_form" class=" form-horizontal left-align form-well" method="POST">
                                        
                                    <fieldset title="Step 1">
                                        <legend>user information</legend>

                                        
                                    

                                        <div class="form-group">
                                            <label for="set_info" class="control-label col-lg-2">Form no</label>
                                            <div class="col-lg-10">
                                                <select  id='set_info' name='set_info' class='selectpicker' data-live-search='true'  >
                                                        <?php echo getDins(); ?>
                                                </select> 
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="fname" class="control-label col-lg-2">Form no</label>
                                            <div class="col-lg-10">
                                                <input class=" form-control" id="fno" name="fno" minlength="2" type="number" required />
                                            </div>
                                       </div>


                                       <div class="form-group">
                                            <label for="fname" class="control-label col-lg-2">First Name</label>
                                            <div class="col-lg-10">
                                                <input class=" form-control" id="fname" name="fname" minlength="2" type="text" required />
                                            </div>
                                       </div>

                                       <div class="form-group">
                                            <label for="mname" class="control-label col-lg-2">Middle Name </label>
                                            <div class="col-lg-10">
                                                <input class=" form-control" id="mname" name="mname" minlength="2" type="text" />
                                            </div>
                                       </div>


                                        <div class="form-group">
                                            <label for="lname" class="control-label col-lg-2">Last Name</label>
                                            <div class="col-lg-10">
                                                <input class=" form-control" id="lname" name="lname" minlength="2" type="text" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="lname" class="control-label col-lg-2">Father Name</label>
                                            <div class="col-lg-10">
                                                <input class=" form-control" id="fatName" name="fatName" minlength="2" type="text" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="lname" class="control-label col-lg-2">Mother Name</label>
                                            <div class="col-lg-10">
                                                <input class="form-control" id="motName" name="motName" minlength="2" type="text" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="lname" class="control-label col-lg-2">Date of Birth</label>
                                            <div class="col-lg-10">
                                               <input type="text" id="dob" class="form-control datepicker" placeholder="Date..."  name="dob">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="gender" class="control-label col-lg-2">Gender</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" id="gender" name="gender" required>
                                                    <option value="MALE" >Male</option>
                                                    <option value="FEMALE">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">Nominee/Beneficiary</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="beneficiary" name="beneficiary" placeholder="" class="form-control" >
                                            <span class="help-inline"></span>
                                        </div>
                                        </div>  

                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">Relation</label>
                                        <div class="col-sm-10">
                                            
                                            <select id='relation' name='relation'  data-live-search='true' class="form-control">
                                                        <option value="Father">Father</option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Brother">Brother</option>
                                                        <option value="Father">Father</option>
                                                        <option value="Sister">Sister</option>
                                                        <option value="Son ">Son </option>
                                                        <option value="Daughter">Daughter</option>
                                                        <option value="uncle">uncle</option>
                                                        <option value="mother in law">mother in law</option>
                                                        <option value="father in law">father in law</option>
                                                        <option value="sister in law">sister in law</option>
                                                        <option value="brother in law">brother in law</option>
                                                        <option value="Sister">Sister</option>
                                                        <option value="aunt">aunt</option>
                                                        <option value="wife">wife</option>
                                                        <option value="cousin">cousin</option>
                                                        <option value="friend">Friend</option>
                                                        <option value="other">Other</option>
                                            </select>

                                            <span class="help-inline">Friend, Brother, Sisters, Etc</span>
                                        </div>
                                        </div>  
                                                
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="mobile" name="mobile" placeholder="" class="form-control" >
                                            
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="address" name="address" placeholder="" class="form-control" >
                                            
                                        </div>
                                        </div>

                                        

                                        <div class="form-group">
                                            <label for="cin" class="col-md-2 col-sm-2 control-label">CIN</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="cin" id="cin" type="text" value="01"  />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-2 control-label">DIN</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="uname" id="uname" type="text" readonly="true" />
                                            </div>
                                        </div>
                                        
                                        
                                       


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Photo</label>
                                            <div class="col-sm-2">
                                                <label class="btn btn-primary" for="my-file-selector">
                                                    <input name="fileToUpload" id="fileToUpload" type="file" style="color : #ffffff ; display: none;">
                                                    Upload a photo
                                                </label>
                                            </div>
                                        </div>


                                        

                                    </fieldset>
                                  
                                        <fieldset title="Step 2">
                                            <legend>position & package</legend>
                                            <?php if(have2Leg($_SESSION["uid"])){ ?>
                                            <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Join Value</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id='product' name='product' class="form-control">
                                                        <?php echo thePackage(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Sponsor Username</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input class="form-control " name="sponsor" id="sponsor" type="text" value="<?php echo strtoupper($_SESSION["uname"]); ?>" required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Upline / Placement</label>
                                                <div class="col-md-6 col-sm-6">
                                                

                                                    <select  id='position' name='position' class='selectpicker' data-live-search='true'  >
                                                        <?php echo ($_SESSION["role"]=="0"?"<option value='0'>ADMIN ( NEW NETWORK )</option>":""); ?>
                                                        <?php echo availPosition(); ?>
                                                    </select> 

                                                    

                                                    
                                                    <span class="help-inline">Please make sure your decide first by looking your genealogy tree for help. Click <a href="/genealogy/tree">here</a></span>
                                                </div>
                                            </div>
                                           
                                            <?php }else{ ?>
                                            <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Join Value</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id='product' name='product' class="form-control">
                                                        <?php echo thePackage(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Sponsor Username</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input class="form-control " name="sponsor" id="sponsor" type="text" value="<?php echo strtoupper($_SESSION["uname"]); ?>" required/>
                                                    <span class="help-inline">You can change the username to another username, please make user that the username is exist</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Upline / Placement</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <?php echo ($_SESSION["role"]!="0"?"You <strong>WILL BE ABLE</strong> to <strong>SELECT PLACEMENT</strong> if you already <strong>HAVE 2 LEG</strong>, otherwise it will automatically be your downline.<br>"
                                                            . "Keep in mind that you can also ask for user above you to help you make a placement <strong>IF</strong> they already have 2 LEG ( Right & Left )":" IT WILL BECOME YOUR DOWNLINE ( CREATE NEW NETWORK )"); ?>
                                                </div>
                                            </div>
                                            <input type='hidden' id='position' name='position' val="1">
                                            <?php } ?>
                                            
                                        </fieldset>
                                        <fieldset title="Step 3">
                                            <legend>security confirmation</legend>
                                            <div class="form-group">
                                                <label class="col-md-2 col-sm-2 control-label">Transaction PIN</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input type="password" id="pin" name="pin" class="form-control">
                                                    <div>
                                                         You need to verify your account ownership, please fill the PIN above to verify.
                                                    </div>       
                                                </div>
                                            </div>
                                            
                                        </fieldset>
                                        <button type="submit" class="finish btn btn-info btn-extend" id="finish"> Finish!</button>
                                        <button type="submit" class="finish btn btn-info btn-extend" id="wait" style="display:none;" disabled>Registering User.. Please Wait</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </section>
                </div>
            </div>

<script type="text/javascript">
    
    $(function(){
       $('.datepicker').datepicker({
          format: 'mm-dd-yyyy'
        });
    });

    $('#fno, #fname, #lname,#cin').bind('keypress blur', function() {
            $('#uname').val(
                 $('#fno').val().toUpperCase()+
                 $('#lname').val().substring(0,3).toUpperCase() +
                 $('#fname').val().substring(0,3).toUpperCase() +
                 $('#cin').val()
             );

    });

    $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 4
    });


    $("#set_info").change(function(event) {
        /* Act on the event */
        var id = $("#set_info").val();
        console.log(id);
        
        $.post('http://128.199.201.52/json.php?search=' + id, {param1: 'value1'}, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
            console.log(data.events[0]);
            
            $("#fno").val(data.events[0].fno);
            $("#fname").val(data.events[0].first_name);
            $("#mname").val(data.events[0].mname);
            $("#lname").val(data.events[0].last_name);
            $("#fatName").val(data.events[0].fatname);
            $("#motName").val(data.events[0].motname);
            $("#dob").val(data.events[0].dob);

            $("#dob").val(data.events[0].dob);
            $("#gender").val(data.events[0].gender);
            $("#beneficiary").val(data.events[0].beneficiary);
            $("#relation").val(data.events[0].relation);

            $("#mobile").val(data.events[0].mobile);
            $("#address").val(data.events[0].address);


            
            


        });

    });

</script>