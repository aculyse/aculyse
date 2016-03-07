<!--class manager -->
<div class="panel panel-primary dialo col-lg-4 col-lg-offset-2 no-padding npe" id="class-creator">

    <div class="progress progress-striped active nope" id="class-progress">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        </div>
    </div>

    <div class="panel-heading">
        <h3 class="panel-title"><strong>Create a class</strong> </h3>

    </div>
    <div class="panel-body">
        <div class="col-md-12 input-box">
            <label class="labels">Class Name<span class="required">*</span></label>
            <input type="text" maxlength="50" id="new-class-name" class="input" placeholder='name of the class'>
        </div>
        <div class="col-md-12 input-box">
            <label class="labels">Level<span class="required">*</span></label>
            <select name="levelTXT" class="input selector selecter_1" required="" id="new-class-level">
                <option value="null">select level</option>
                <optgroup label="Primary Level">
                    <option>Grade 0</option>
                    <option>Grade 1</option>
                    <option>Grade 2</option>
                    <option>Grade 3</option>
                    <option>Grade 4</option>
                    <option>Grade 5</option>
                    <option>Grade 6</option>
                    <option>Grade 7</option>
                </optgroup>
                <optgroup label="Juniour Level">
                    <option>Form 1</option>
                    <option>Form 2</option>
                </optgroup>
                <optgroup label="Ordinary Level">
                    <option>Form 3</option>
                    <option>Form 4</option>
                </optgroup>
                <optgroup label="Advanced Level">
                    <option>Lower 6th</option>
                    <option>Upper 6th</option>
                </optgroup>

            </select>
        </div>
        <div class="col-md-12 input-box">
            <label class="labels">Description</label>
            <textarea class="input ta" id="new-class-desc" placeholder='give a short description of this class'></textarea>
        </div>
    </div>

    <div class="panel-heading panel-bottom">
        <button class='btn btn-action' onclick="ClassAllocator.addClass();">save</button>
    </div>



</div>
