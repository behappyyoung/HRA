<style>

    .form-tabs {height: 50px; vertical-align: middle;text-align: center;}
    .form-tabs div{color:white; height: 31px; width: 152px; font-weight: bolder;float: left;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .basic-form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .basic-form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .basic-form-table .label {width: 100px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .basic-form-table .input { text-align: left; padding-left: 40px; }
    .basic-form-table .smallinput  {width:100px; height: 20px; margin: 5px; }
    .basic-form-table .checkbox  {width:20px; }

    .first.active {color:white; height: 31px; width: 152px; font-weight: bolder;
        background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstactive.png")}
    .first.inactive {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstinactive.png")}
    .second.inactive {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstinactive.png")}
    .third.inactive {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstinactive.png")}

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}


</style>
<form class="form" id="patient-hra-form" title="Patient hra"
              action="<?php echo elgg_add_action_tokens_to_url("/action/provider/save_patient"); ?>">
        <div class="form-tabs" id="form-tabs">
                <div class="first active">Basic Information</div>
                <div class="second inactive">Life Style</div>
                <div class="third inactive">Finish and Save</div>
        </div>
         <div id="tabs-basic" class="basic-form">
              <div class="basic-form-table">
                <!-- Gender & Marital Status -->
                <div>
                    <div  class="label">
                        <span class="number"> 1 </span> <span> Age </span>
                    </div>
                    <div class="input">

                        <input type="text" class="smallinput" name="age"  />
                    </div>
                </div>
                <div>
                    <div class="label">
                        <span class="number"> 2 </span> <span class="required-label">Sex</span>
                    </div>
                    <div class="input">

                        <input type="radio" name="gender" value="1"  class="checkbox" > Female
                        <input type="radio" name="gender" value="2"  class="checkbox"> Male
                    </div>

                </div>
                  <div>
                      <div  class="label">
                          <span class="number"> 3 </span> <span> Height </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="feet"  />(feet)
                          <input type="text" class="smallinput" name="inches"  />(inches)
                      </div>
                  </div>
                  <div>
                      <div  class="label">
                          <span class="number"> 4 </span> <span> Weight </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="pounds"  />(Pounds)
                      </div>
                  </div>
                  <div>
                      <div  class="label">
                          <span class="number"> 5 </span> <span> Ethnicity </span>
                      </div>
                      <div class="input">
                          <?php echo elgg_view("shn/input/races",array(
                              "type" => "radio",
                              "name" => "race",
                              "class" =>"checkbox",
                              "required" => ""
                          ));
                          ?>

                      </div>
                  </div>


            </div>
                <div class="buttons">
                    <button class="cancel" > Cancel </button>
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

