<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Configure Mail Setting
                        </header>
                        <div class="panel-body">
                            <div id='suksesupdate' class="alert alert-success alert-block fade in" style='display:none;'>
                               <h4>
                                    <i class="icon-ok-sign"></i>
                                    Success!
                                </h4>
                                <p>Yehaa.. Mail Setting has been saved</p>
                            </div>
                            <div id='gagalupdate' class="alert alert-danger alert-block fade in" style='display:none;'>
                                <h4>
                                    <i class="icon-ok-sign"></i>
                                    Whoops!
                                </h4>
                                <p>Something Error</p>
                            </div>
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="mailsave" method="get" action="">
                                    <div class="form-group ">
                                        <label for="sender" class="control-label col-lg-2">Mail Sender</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="sender" id="sender" type="text" value="<?php echo $setting["sender"]; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="uname" class="control-label col-lg-2">Mail Username</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="uname" id="uname" type="text" value="<?php echo $setting["uname"]; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="pass" class="control-label col-lg-2">Mail Password</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="pass" id="pass" type="password" value="" />
                                            <p>If you dont want change password, leave it empty</p>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="signature" class="control-label col-lg-2">Mail HOST</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="host" id="host" value="<?php echo $setting["host"]; ?>" type="text" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="logouri" class="control-label col-lg-2">Mail Port</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " name="port" id="port" value="<?php echo $setting["port"]; ?>" type="text" required/>
                                        </div>
                                    </div>
                                     
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit" id='submit'>Save</button>
                                            <button class="btn btn-default" type="button" id='waiting' disabled style="display:none;">Please Wait...</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
