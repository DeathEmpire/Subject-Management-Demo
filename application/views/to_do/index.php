<legend style='text-align:center;'>To Do List (<?= $this->session->userdata('perfil_name');?>)</legend>

<?php
	if(isset($to_do) AND !empty($to_do)){

		#Pendig demography_form_verify
		if(isset($to_do['demography_form_verify']) AND !empty($to_do['demography_form_verify'])){ ?>
			<b>Pending Verify a Form: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Form</th>					
					<th>Subject</th>
					<th>Link</th>					
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_verify'] as $verify) {?>
					<tr>
						<td>Demography</td>
						<td><?= $verify->code; ?></td>
						<td><?= anchor('subject/demography/'. $verify->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }

		#Pendig demography_form_lock
		if(isset($to_do['demography_form_lock']) AND !empty($to_do['demography_form_lock'])){ ?>
			<b>Pending Lock a Form: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Form</th>					
					<th>Subject</th>
					<th>Link</th>					
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_lock'] as $lock) {?>
					<tr>
						<td>Demography</td>
						<td><?= $lock->code; ?></td>
						<td><?= anchor('subject/demography/'. $lock->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }

		#Pendig demography_form_sign
		if(isset($to_do['demography_form_sign']) AND !empty($to_do['demography_form_sign'])){ ?>
			<b>Pending Sign a Form: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Form</th>					
					<th>Subject</th>
					<th>Link</th>					
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_sign'] as $sign) {?>
					<tr>
						<td>Demography</td>
						<td><?= $sign->code; ?></td>
						<td><?= anchor('subject/demography/'. $sign->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }

		#Pending Querys
		if(isset($to_do['querys']) AND !empty($to_do['querys'])){
			#List of pending querys in all forms?>
			<b>Pending Querys: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Form</th>
					<th>Subject</th>
					<th>Link</th>					
				</thead>
				<tbody>

			<?php
			foreach ($to_do['querys'] as $query) { 

					#make de links for diferents form
					if($query->form == 'Demography'){
						$link = '';
					}
					
					elseif($query->form == 'Adverse Event'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Adverse Event';
					}
					elseif($query->form == 'Protocol Deviation'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Protocol Deviation';
					}
					elseif($query->form == 'Concomitant Medication'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Concomitant Medication';
					}

			?>

				<tr>
					<td><?= $query->form;?></td>
					<td><?= $query->code;?></td>
					<td><?= anchor($link, 'Ver', array('class'=>'btn'));?></td>
				</tr>	
				
			<?php }?>
			
				</tbody>
			</table>
  <?php }

	}
?>