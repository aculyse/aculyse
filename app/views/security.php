<div id="overlay"></div>
<div class="panel panel-primary dialog col-lg-4 no-padding" id="report">
    <div class="panel-heading">
        <h3 class="panel-title">Change Password</h3>
    </div>
    <div class="panel-body">
        <div class="input-box col-lg-12">
            <label class="labels">Old Password</label>
            <input type="password" class="input" id="op" placeholder="old password"/>
        </div>
        <div class="input-box col-lg-12">
            <label class="labels">New Password</label>
            <input type="password" class="input"  id="np" placeholder="new password"/>
        </div>
        <div class="input-box col-lg-12">
            <label class="labels">Confirm New Password</label>
            <input type="password" class="input"  id="cnp" placeholder="confirm new password"/>
        </div>

        <!--loading-->
        <div class="col-md-12 clear-fix no-float nope" id="progress-el">
            <center><label>Please wait...</label></center>
            <div class="progress progress-striped active">

                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 100%">

                </div>
            </div>
        </div>

        <!--errors-->
        <div class="alert alert-danger clear-fix no-float nope" id="errors-el">
            <strong id="error-msg"></strong>
        </div>

    </div>
    <div class="panel-heading panel-bottom">
        <button class="btn btn-action btn-sm" onclick="changePassword();">Change Password</button>
        <button class="btn btn-default btn-sm" onclick="destroyDialog('security')">Cancel</button>
    </div>

</div>

<style type="text/css">
    #overlay,#report{
        display: block;
    }
</style>
