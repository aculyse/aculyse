<div id="overlay"></div>
<div class="panel panel-primary dialog" id="report">
    <div class="panel-heading">
        <h3 class="panel-title">Feedback or Report problem</h3>
    </div>
    <div class="panel-body">
        <div class="input-box col-lg-12">
            <label class="labels">Message</label>
            <textarea id="descriptionTXT" class="input" rows=5 placeholder="Tell us something here?"/>
        </div>
        <div class="input-box col-lg-12">
            <label class="labels">Url</label>
            <input type="text" class="input" id="current_url" placeholder="optional" value="" readonly="" />
        </div>
    </div>
    <div class="panel-heading panel-bottom">

        <button class="btn btn-action btn-sm" id="submit_error">Submit</button>
        <button class="btn btn-default btn-sm" onclick="destroyDialog('feedback_form')">Close</button>

    </div>
</div>

<style type="text/css">
    #overlay,#report{
        display: block;
    }
</style>

<script>
    $("#submit_error").click(function() {
        desc = $("#descriptionTXT").val();
        url=$("#current_url").val()
        Feedback.send(desc,url);
    });
</script>
