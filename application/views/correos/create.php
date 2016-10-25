<?= form_open('correos/insert', array('class'=>'form-horizontal')); ?>

    <legend> Crear Lista de Correos </legend>



    <?= my_validation_errors(validation_errors()); ?>



    <div class="control-group">

        <?= form_label('Nombre', 'name', array('class'=>'control-label')); ?>

        <?= form_input(array('type'=>'text', 'name'=>'nombre', 'id'=>'nombre', 'value'=>set_value('nombre'))); ?>

    </div>



    <div class="control-group">

        <?= form_label('Descripcion', 'descripcion', array('class'=>'control-label')); ?>

        <?= form_textarea(array('name'=>'descripcion', 'id'=>'descripcion', 'rows'=>'3', 'cols'=>'20', 'value'=>set_value('descripcion'))); ?>

    </div>

	 <div class="control-group">
	 
	 <?php $centros = array("Todos"=>"Todos","01"=>"01","02"=>"02","03"=>"03","04"=>"04"); ?>
	 
		<?= form_label('Centro', 'centro', array('class'=>'control-label')); ?>
		
		<?= form_dropdown('centro',$centros); ?>
	 </div>


    <div class="control-group">

        <?= form_label('Lista de Correos', 'correos', array('class'=>'control-label')); ?>

        <?= form_textarea(array('name'=>'correos', 'id'=>'correos', 'rows'=>'3', 'cols'=>'20', 'value'=>set_value('correos'))); ?>

    </div>

    <div class="form-actions">

        <?= form_button(array('type'=>'submit', 'content'=>'Aceptar', 'class'=>'btn btn-primary')); ?>

        <?= anchor('correos/index', 'Cancelar', array('class'=>'btn')); ?>

    </div>

<?= form_close(); ?>

