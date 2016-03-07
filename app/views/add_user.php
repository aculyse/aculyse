<div class="col-lg-12 nope" id="new-user-div">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <button class="btn btn-default btn-sm" onclick="backToUserList();">Back</button>
                Account Wizard</h3>
        </div>

        <div class="panel-body">
            <div class="col-lg-4">
                <fieldset>
                    <legend>Personal Details</legend>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Firstname <span class='required'>*</span></label>
                        <input type="text" maxlength="50" id="fnTXT" class="input" />
                    </div>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Middlename(s)</label>
                        <input type="text" maxlength="50" id="mnTXT" class="input" />
                    </div>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Surname <span class='required'>*</span></label>
                        <input type="text" maxlength="50" id="snTXT" class="input" />
                    </div>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Sex <span class='required'>*</span></label>
                        <select class="selecter_1 input" id="sexTXT">
                            <option>SEX (required)</option>
                            <option>MALE</option>
                            <option>FEMALE</option>
                        </select>
                    </div>
                </fieldset>
            </div>

            <div class="col-lg-4">
                <fieldset>
                    <legend>Contacts</legend>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Contact Number</label>
                        <input type="text" maxlength="50" id="contact_numTXT" class="input" />
                    </div>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Email</label>
                        <input type="text" maxlength="50" id="emailTXT" class="input" />
                    </div>
                </fieldset>
            </div>


            <div class="col-lg-4">
                <fieldset>
                    <legend>Access and Security</legend>
                    <div class="col-md-12 input-box">
                        <label class="labels" >Access Level<span class='required'>*</span></label>
                        <select id="accessTXT" class="input selecter_1" onchange="toggleAccessLevelUI();">
                            <option value=0>--choose user level--</option>
                            <option value=5>Admin</option>
                            <option value=1>Teacher</option>
                            <option value=2>Students Records Personel</option>
                            <option value=3>Principal</option>
                        </select>
                    </div>
                
                    <div class="col-md-12 input-box">
                        <label class="labels" >Auto Generate Credentials<span class='required'>*</span></label>
                        <select class="input selecter_1" id="auTXT" onchange="toggleAutoLoadCredentialsUI();">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>


                    <div class="col-md-12 input-box nope au-trigger">
                        <label class="labels" >Username<span class='required'>*</span></label>
                        <input type="text" maxlength="50" id="usernameTXT" class="input" />
                    </div>

                    <div class="col-md-12 input-box nope au-trigger">
                        <label class="labels" >Password<span class='required'>*</span></label>
                        <input type="password" maxlength="50" class="input" id="pwdTXT" />
                    </div>

                </fieldset>


            </div>
        </div>
        <div class="panel-heading panel-bottom">
            <input type="button" value="create account" class="btn btn-action btn-sm" onclick="UserWriter.save();" />
            <input type="button" value="cancel" class="btn btn-sm btn-default"/>
        </div>
    </div>
</div>