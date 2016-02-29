<script type="text/javascript">
$(function(){
    $("input[name^=selection_criteria]").change(function(){
        
        if($(this).val() == 0) {
            $(".waiver").show();
            $(".buttons_form").hide();

        }else{
            $(".waiver").hide();            
            $(".buttons_form").show();
            $(".error").hide();
        }

    });

    $("input[name^=waiver_approving]").change(function(){

        if($(this).val() == 0) {
            $(".error").show();
            $(".buttons_form").hide();

        }else{
            $(".error").hide();
            $(".buttons_form").show();            
        }

    });

    $("#screening_date").datepicker();

    /*inicialice radio buttons*/
    if($("input[name^=selection_criteria]:checked").val() == 0){
        $(".waiver").show();
        $(".buttons_form").hide();

    }
    else{
         $(".waiver").hide();            
            $(".buttons_form").show();
            $(".error").hide();
    }

    if($("input[name^=waiver_approving]:checked").val() == 0){
        $(".error").show();
        $(".buttons_form").hide();
    }
    else{
        $(".error").hide();
        $(".buttons_form").show(); 
    }

    

});
</script>
<?= form_open('subject/insert', array('class'=>'form-horizontal')); ?>
    <legend style='text-align:center;'> New Subject (Screening)</legend>

    <?= my_validation_errors(validation_errors()); ?>
     <?php
            $data = array(
                'name'        => 'sign_consent',                
                'value'       => '1',            
                'checked'     => set_radio('sign_consent', 1),
                );
            $data2 = array(
                'name'        => 'sign_consent',                
                'value'       => '0',
                'checked'     => set_radio('sign_consent', 0),           
                );
            $data3 = array(
                'name'        => 'selection_criteria',                
                'value'       => '1',            
                'checked'     => set_radio('selection_criteria', 1),
                );
            $data4 = array(
                'name'        => 'selection_criteria',                
                'value'       => '0',
                'checked'     => set_radio('selection_criteria', 0),           
                );
            $data5 = array(
                'name'        => 'waiver_approving',                
                'value'       => '1',            
                'checked'     => set_radio('waiver_approving', 1),
                );
            $data6 = array(
                'name'        => 'waiver_approving',                
                'value'       => '0',
                'checked'     => set_radio('waiver_approving', 0),           
                );
              
        ?>
    <table class="table table-condensed table-bordered">        
        <tr>
            <td>Did subject sign Informed Consent?: </td>
            <td><?= form_radio($data); ?> Yes <?= form_radio($data2); ?> No</td>
        </tr>

        <tr>
            <td>Date: </td>
            <td><?= form_input(array('type'=>'text', 'name'=>'screening_date', 'id'=>'screening_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('screening_date'))); ?></td>
        </tr> 

        <tr>
            <td>Subject Initials: </td>
            <td><?= form_input(array('type'=>'text', 'name'=>'initials', 'id'=>'initials', 'value'=>set_value('initials'))); ?></td>
        </tr>
        
        <tr>
            <td>Does subject comply with selection criteria? : </td>
            <td><?= form_radio($data3); ?> Yes <?= form_radio($data4); ?> No</td>
        </tr>
           
        <tr class='waiver'>
            <td>Do you have a waiver approving to include this subject in the trial? :</td>
            <td><?= form_radio($data5); ?> Yes <?= form_radio($data6); ?> No</td>
        </tr>

        <tr class='error' style='display:none'>
            <td colspan='2'>You cannot create a subject not complying with trial criteria without having a sponsor waiver.</td>
        </tr>

        <tr class='buttons_form' style='display:none'>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/index', 'Cancel', array('class'=>'btn')); ?></td>
        </tr>
    </table>
<?= form_close(); ?>