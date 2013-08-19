<style>

    .form-tabs {height: 50px; vertical-align: middle;text-align: center;}
    .form-tabs div{color:white; height: 31px; width: 152px; font-weight: bolder;float: left;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form .space{ padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .basic-form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .basic-form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .basic-form-table .label {width: 200px;font-weight: bolder;text-align: left; padding-left: 20px; }
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
              <table class="basic-form-table">
                <!-- Gender & Marital Status -->
                <tr>
                    <td  class="label">
                        <span class="number"> 6 </span> <span> Physical Activity </span>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <span class="space">  </span> <span class="required-label"> A. Type of day job </span>
                    </td>
                    <td class="input">

                        <input type="radio" name="gender" value="1"  class="checkbox" > Sedentary<br />
                        <input type="radio" name="gender" value="2"  class="checkbox"> Light Work<br />
                        <input type="radio" name="gender" value="2"  class="checkbox"> Medium Work<br />
                    </td>

                </tr>
                  <tr>
                      <td class="label">
                          <span class="space">  </span> <span class="required-label"> B.  </span>
                      </td>
                      <td class="input">

                          <input type="radio" name="gender" value="1"  class="checkbox" > Less than 1 hour per week<br />
                          <input type="radio" name="gender" value="2"  class="checkbox"> 1-2 hour per week<br />
                          <input type="radio" name="gender" value="2"  class="checkbox"> 3+ hours per week<br />
                      </td>

                  </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 8 </span> <span> Allergies & Aversions </span>
                      </td>
                      <td class="input">
                          <input type="radio" name="allergy" value="1"  class="checkbox" > Dairy <br />
                          <input type="radio" name="allergy" value="1"  class="checkbox" > Soy <br />
                          <input type="radio" name="allergy" value="1"  class="checkbox" > Shellfish <br />
                      </td>
                  <tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 8 </span> <span> Stress Level </span>
                      </td>
                      <td class="input">
                          <input type="radio" name="gender" value="1"  class="checkbox" > Low
                          <input type="radio" name="gender" value="2"  class="checkbox"> Medium
                          <input type="radio" name="gender" value="2"  class="checkbox"> High
                      </td>
                  <tr>
                      <td  class="label">
                          <span class="number"> 9 </span> <span> Sleep </span>
                      </td>
                      <td class="input">
                          <input type="radio" name="gender" value="1"  class="checkbox" > 6 hours or less
                          <input type="radio" name="gender" value="2"  class="checkbox"> 6-7 hours
                          <input type="radio" name="gender" value="2"  class="checkbox"> 7-8 hours
                          <input type="radio" name="gender" value="2"  class="checkbox"> 9+ hours

                      </td>
                  </tr>                  </tr>




            </table>
                <div class="buttons">
                    <button class="cancel" > Cancel </button>
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

