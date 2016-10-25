<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Change Your password
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Your pasword has been updated. Reload page in few seconds..</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Cant update your Password, please make sure that you enter correct password & Token</p>
                            </div>
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="chpwd" method="get" action="">
                                    <div class="form-group ">
                                        <label for="newpass" class="control-label col-lg-2">New Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="newpass" name="newpass" type="password" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="confirm_newpass" class="control-label col-lg-2">Confirm New Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="confirm_newpass" name="confirm_newpass" required type="password" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="oldpass" class="control-label col-lg-2">Current Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="oldpass" name="oldpass" type="password" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="token" class="control-label col-lg-2">Secret Token</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="token" name="token" type="password" required />
                                        </div>
                                    </div>
                                    <?php if($_GET["success"]!="1"){ ?>
                                    <div class="alert alert-info">
                                            <strong>Please Check Your Email INBOX.</strong> Your secret token access code has been sent to your email inbox. Also please check your spam folder.
                                        </div>
                                    <?php }else{ ?>
                                    <div class="alert alert-info">
                                            <strong>Congratulations.</strong> Your password has been updated.
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit" id='submitpass'>Update password</button>
                                            <button class="btn btn-default" type="button" id='waitingpass' disabled style="display:none;">Please Wait...</button>
                                            <a href="/profile/chpwd?resend=1" class="btn btn-danger">Resend Token</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
