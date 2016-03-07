<div id="outlay">
</div>
<div class="panel panel-danger no-padding col-lg-6" id="del_dialog">
    <div class="panel-heading">
        <h3 class="panel-title">Delete</h3>
    </div>
    <div class="panel-body">
        Delete this student including academic perfomances. This action cannot be undone, are you sure you want to proceed!!
    </div>
    <div class="panel-heading panel-bottom">
        <button class="btn btn-action btn-sm" onclick="deleteStudent();">Yes, Proceed</button>
        <button class="btn btn-default btn-sm" onclick="closeDelDialog();">Cancel</button>

        <input type="text" value="" id="rec_to_del">
        <p id="progress-msg"></p>
    </div>
</div>
