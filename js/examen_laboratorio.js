$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_examen_laboratorio :input").attr('readonly','readonly');
			$("#form_examen_laboratorio :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});

			$("input[type=radio]").each(function(){
				if($(this).prop('name') != 'realizado'){
					$(this).prop('checked', false);
					$(this).prop('disabled', true);
				}
			});

			$("input[name=realizado]").prop('readonly', false);
			$("input[name=realizado]").prop('disabled', false);

		}else{
			$("#form_examen_laboratorio :input").removeAttr('readonly');
			
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});

			$("input[type=radio]").each(function(){				
				$(this).prop('disabled', false);
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_examen_laboratorio :input").attr('readonly','readonly');
		$("#form_examen_laboratorio :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[type=radio]").each(function(){
			if($(this).prop('name') != 'realizado'){
				$(this).prop('checked', false);
				$(this).prop('disabled', true);
			}
		});
			
		

	}else{

		$("#form_examen_laboratorio :input").removeAttr('readonly');
		
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});

		$("input[type=radio]").each(function(){				
			$(this).prop('disabled', false);
		});
		
	}


	$("select[name=hecho_1]").change(function(){
		if($(this).val() == 1){
			$("#hematocrito").prop('readonly', false);			
			$("input[name=hematocrito_nom_anom]").prop('disabled', false);			
		}
		else{
			$("#hematocrito").prop('readonly', true);
			$("#hematocrito").val('');
			$("input[name=hematocrito_nom_anom]").prop('disabled', true);
			$("input[name=hematocrito_nom_anom]").prop('checked', false);
		}
	});

	$("select[name=hecho_2]").change(function(){
	 	if($(this).val() == 1){
	 		$("#hemoglobina").prop('readonly', false);			
	 		$("input[name=hemoglobina_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#hemoglobina").prop('readonly', true);
	 		$("#hemoglobina").val('');
	 		$("input[name=hemoglobina_nom_anom]").prop('disabled', true);
			$("input[name=hemoglobina_nom_anom]").prop('checked', false);
	 	}
	 });
	
	$("select[name=hecho_3]").change(function(){
	 	if($(this).val() == 1){
	 		$("#eritocritos").prop('readonly', false);			
	 		$("input[name=eritocritos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#eritocritos").prop('readonly', true);
	 		$("#eritocritos").val('');
	 		$("input[name=eritocritos_nom_anom]").prop('disabled', true);
			$("input[name=eritocritos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_4]").change(function(){
	 	if($(this).val() == 1){
	 		$("#leucocitos").prop('readonly', false);			
	 		$("input[name=leucocitos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#leucocitos").prop('readonly', true);
	 		$("#leucocitos").val('');
	 		$("input[name=leucocitos_nom_anom]").prop('disabled', true);
			$("input[name=leucocitos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_5]").change(function(){
	 	if($(this).val() == 1){
	 		$("#neutrofilos").prop('readonly', false);			
	 		$("input[name=neutrofilos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#neutrofilos").prop('readonly', true);
	 		$("#neutrofilos").val('');
	 		$("input[name=neutrofilos_nom_anom]").prop('disabled', true);
			$("input[name=neutrofilos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_6]").change(function(){
	 	if($(this).val() == 1){
	 		$("#linfocitos").prop('readonly', false);			
	 		$("input[name=linfocitos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#linfocitos").prop('readonly', true);
	 		$("#linfocitos").val('');
	 		$("input[name=linfocitos_nom_anom]").prop('disabled', true);
			$("input[name=linfocitos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_7]").change(function(){
	 	if($(this).val() == 1){
	 		$("#monocitos").prop('readonly', false);			
	 		$("input[name=monocitos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#monocitos").prop('readonly', true);
	 		$("#monocitos").val('');
	 		$("input[name=monocitos_nom_anom]").prop('disabled', true);
			$("input[name=monocitos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_8]").change(function(){
	 	if($(this).val() == 1){
	 		$("#eosinofilos").prop('readonly', false);			
	 		$("input[name=eosinofilos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#eosinofilos").prop('readonly', true);
	 		$("#eosinofilos").val('');
	 		$("input[name=eosinofilos_nom_anom]").prop('disabled', true);
			$("input[name=eosinofilos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_9]").change(function(){
	 	if($(this).val() == 1){
	 		$("#basofilos").prop('readonly', false);			
	 		$("input[name=basofilos_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#basofilos").prop('readonly', true);
	 		$("#basofilos").val('');
	 		$("input[name=basofilos_nom_anom]").prop('disabled', true);
			$("input[name=basofilos_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_10]").change(function(){
	 	if($(this).val() == 1){
	 		$("#recuento_plaquetas").prop('readonly', false);			
	 		$("input[name=recuento_plaquetas_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#recuento_plaquetas").prop('readonly', true);
	 		$("#recuento_plaquetas").val('');
	 		$("input[name=recuento_plaquetas_nom_anom]").prop('disabled', true);
			$("input[name=recuento_plaquetas_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_11]").change(function(){
	 	if($(this).val() == 1){
	 		$("#glucosa_ayunas").prop('readonly', false);			
	 		$("input[name=glucosa_ayunas_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#glucosa_ayunas").prop('readonly', true);
	 		$("#glucosa_ayunas").val('');
	 		$("input[name=glucosa_ayunas_nom_anom]").prop('disabled', true);
			$("input[name=glucosa_ayunas_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_12]").change(function(){
	 	if($(this).val() == 1){
	 		$("#bun").prop('readonly', false);			
	 		$("input[name=bun_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#bun").prop('readonly', true);
	 		$("#bun").val('');
	 		$("input[name=bun_nom_anom]").prop('disabled', true);
			$("input[name=bun_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_13]").change(function(){
	 	if($(this).val() == 1){
	 		$("#creatinina").prop('readonly', false);			
	 		$("input[name=creatinina_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#creatinina").prop('readonly', true);
	 		$("#creatinina").val('');
	 		$("input[name=creatinina_nom_anom]").prop('disabled', true);
			$("input[name=creatinina_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_14]").change(function(){
	 	if($(this).val() == 1){
	 		$("#bilirrubina_total").prop('readonly', false);			
	 		$("input[name=bilirrubina_total_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#bilirrubina_total").prop('readonly', true);
	 		$("#bilirrubina_total").val('');
	 		$("input[name=bilirrubina_total_nom_anom]").prop('disabled', true);
			$("input[name=bilirrubina_total_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_15]").change(function(){
	 	if($(this).val() == 1){
	 		$("#proteinas_totales").prop('readonly', false);			
	 		$("input[name=proteinas_totales_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#proteinas_totales").prop('readonly', true);
	 		$("#proteinas_totales").val('');
	 		$("input[name=proteinas_totales_nom_anom]").prop('disabled', true);
			$("input[name=proteinas_totales_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_16]").change(function(){
	 	if($(this).val() == 1){
	 		$("#fosfatasas_alcalinas").prop('readonly', false);			
	 		$("input[name=fosfatasas_alcalinas_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#fosfatasas_alcalinas").prop('readonly', true);
	 		$("#fosfatasas_alcalinas").val('');
	 		$("input[name=fosfatasas_alcalinas_nom_anom]").prop('disabled', true);
			$("input[name=fosfatasas_alcalinas_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_17]").change(function(){
	 	if($(this).val() == 1){
	 		$("#ast").prop('readonly', false);			
	 		$("input[name=ast_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#ast").prop('readonly', true);
	 		$("#ast").val('');
	 		$("input[name=ast_nom_anom]").prop('disabled', true);
			$("input[name=ast_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_18]").change(function(){
	 	if($(this).val() == 1){
	 		$("#alt").prop('readonly', false);			
	 		$("input[name=alt_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#alt").prop('readonly', true);
	 		$("#alt").val('');
	 		$("input[name=alt_nom_anom]").prop('disabled', true);
			$("input[name=alt_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_19]").change(function(){
	 	if($(this).val() == 1){
	 		$("#calcio").prop('readonly', false);			
	 		$("input[name=calcio_nom_anom]").prop('disabled', false);

	 		$('select[name=calcio_unidad_medida] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			}); 		

	 	}
	 	else{
	 		$("#calcio").prop('readonly', true);
	 		$("#calcio").val('');
	 		$("input[name=calcio_nom_anom]").prop('disabled', true);
			$("input[name=calcio_nom_anom]").prop('checked', false);

			$('select[name=calcio_unidad_medida]').val('');
			$('select[name=calcio_unidad_medida] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	 	}
	 	//agregar unidad de medida
	 });

	$("select[name=hecho_20]").change(function(){
	 	if($(this).val() == 1){
	 		$("#sodio").prop('readonly', false);			
	 		$("input[name=sodio_nom_anom]").prop('disabled', false);
	 		$('select[name=sodio_unidad_medida] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			}); 
	 	}
	 	else{
	 		$("#sodio").prop('readonly', true);
	 		$("#sodio").val('');
	 		$("input[name=sodio_nom_anom]").prop('disabled', true);
			$("input[name=sodio_nom_anom]").prop('checked', false);
			$('select[name=sodio_unidad_medida]').val('');
			$('select[name=sodio_unidad_medida] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	 	}
	 });
	$("select[name=hecho_21").change(function(){
	 	if($(this).val() == 1){
	 		$("#potasio").prop('readonly', false);			
	 		$("input[name=potasio_nom_anom]").prop('disabled', false);
	 		$('select[name=potasio_unidad_medida] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
	 	}
	 	else{
	 		$("#potasio").prop('readonly', true);
	 		$("#potasio").val('');
	 		$("input[name=potasio_nom_anom]").prop('disabled', true);
			$("input[name=potasio_nom_anom]").prop('checked', false);
			$('select[name=potasio_unidad_medida]').val('');
			$('select[name=potasio_unidad_medida] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	 	}
	 });
	$("select[name=hecho_22]").change(function(){
	 	if($(this).val() == 1){
	 		$("#cloro").prop('readonly', false);			
	 		$("input[name=cloro_nom_anom]").prop('disabled', false);
	 		$('select[name=cloro_unidad_medida] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
	 	}
	 	else{
	 		$("#cloro").prop('readonly', true);
	 		$("#cloro").val('');
	 		$("input[name=cloro_nom_anom]").prop('disabled', true);
			$("input[name=cloro_nom_anom]").prop('checked', false);
			$('select[name=cloro_unidad_medida]').val('');
			$('select[name=cloro_unidad_medida] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	 	}
	 });
	$("select[name=hecho_23]").change(function(){
	 	if($(this).val() == 1){
	 		$("#acido_urico").prop('readonly', false);			
	 		$("input[name=acido_urico_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#acido_urico").prop('readonly', true);
	 		$("#acido_urico").val('');
	 		$("input[name=acido_urico_nom_anom]").prop('disabled', true);
			$("input[name=acido_urico_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_24]").change(function(){
	 	if($(this).val() == 1){
	 		$("#albumina").prop('readonly', false);			
	 		$("input[name=albumina_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#albumina").prop('readonly', true);
	 		$("#albumina").val('');
	 		$("input[name=albumina_nom_anom]").prop('disabled', true);
			$("input[name=albumina_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_25]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_ph").prop('readonly', false);			
	 		$("input[name=orina_ph_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#orina_ph").prop('readonly', true);
	 		$("#orina_ph").val('');
	 		$("input[name=orina_ph_nom_anom]").prop('disabled', true);
			$("input[name=orina_ph_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_26]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_glucosa").prop('readonly', false);			
	 		$("input[name=orina_glucosa_nom_anom]").prop('disabled', false);
	 		$('select[name=glucosa_unidad_medida] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
	 	}
	 	else{
	 		$("#orina_glucosa").prop('readonly', true);
	 		$("#orina_glucosa").val('');
	 		$("input[name=orina_glucosa_nom_anom]").prop('disabled', true);
			$("input[name=orina_glucosa_nom_anom]").prop('checked', false);
			$('select[name=glucosa_unidad_medida]').val('');
			$('select[name=glucosa_unidad_medida] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
	 	}
	 });
	$("select[name=hecho_27]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_proteinas").prop('readonly', false);			
	 		$("input[name=orina_proteinas_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#orina_proteinas").prop('readonly', true);
	 		$("#orina_proteinas").val('');
	 		$("input[name=orina_proteinas_nom_anom]").prop('disabled', true);
			$("input[name=orina_proteinas_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_28]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_sangre").prop('readonly', false);			
	 		$("input[name=orina_sangre_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#orina_sangre").prop('readonly', true);
	 		$("#orina_sangre").val('');
	 		$("input[name=orina_sangre_nom_anom]").prop('disabled', true);
			$("input[name=orina_sangre_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_29]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_cetonas").prop('readonly', false);			
	 		$("input[name=orina_cetonas_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#orina_cetonas").prop('readonly', true);
	 		$("#orina_cetonas").val('');
	 		$("input[name=orina_cetonas_nom_anom]").prop('disabled', true);
			$("input[name=orina_cetonas_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_30]").change(function(){
	 	if($(this).val() == 1){
	 		$("#orina_microscospia").prop('readonly', false);			
	 		$("input[name=orina_microscospia_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#orina_microscospia").prop('readonly', true);
	 		$("#orina_microscospia").val('');
	 		$("input[name=orina_microscospia_nom_anom]").prop('disabled', true);
			$("input[name=orina_microscospia_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_31]").change(function(){
	 	if($(this).val() == 1){
	 		$("#otros_sangre_homocisteina").prop('readonly', false);			
	 		$("input[name=otros_sangre_homocisteina_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#otros_sangre_homocisteina").prop('readonly', true);
	 		$("#otros_sangre_homocisteina").val('');
	 		$("input[name=otros_sangre_homocisteina_nom_anom]").prop('disabled', true);
			$("input[name=otros_sangre_homocisteina_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_32]").change(function(){
	 	if($(this).val() == 1){
	 		$("#otros_perfil_tiroideo").prop('readonly', false);			
	 		$("input[name=otros_perfil_tiroideo_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#otros_perfil_tiroideo").prop('readonly', true);
	 		$("#otros_perfil_tiroideo").val('');
	 		$("input[name=otros_perfil_tiroideo_nom_anom]").prop('disabled', true);
			$("input[name=otros_perfil_tiroideo_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_33]").change(function(){
	 	if($(this).val() == 1){
	 		$("#otros_nivel_b12").prop('readonly', false);			
	 		$("input[name=otros_nivel_b12_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#otros_nivel_b12").prop('readonly', true);
	 		$("#otros_nivel_b12").val('');
	 		$("input[name=otros_nivel_b12_nom_anom]").prop('disabled', true);
			$("input[name=otros_nivel_b12_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_34]").change(function(){
	 	if($(this).val() == 1){
	 		$("#otros_acido_folico").prop('readonly', false);			
	 		$("input[name=otros_acido_folico_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#otros_acido_folico").prop('readonly', true);
	 		$("#otros_acido_folico").val('');
	 		$("input[name=otros_acido_folico_nom_anom]").prop('disabled', true);
			$("input[name=otros_acido_folico_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_35]").change(function(){
	 	if($(this).val() == 1){
	 		$("#otros_hba1c").prop('readonly', false);			
	 		$("input[name=otros_hba1c_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#otros_hba1c").prop('readonly', true);
	 		$("#otros_hba1c").val('');
	 		$("input[name=otros_hba1c_nom_anom]").prop('disabled', true);
			$("input[name=otros_hba1c_nom_anom]").prop('checked', false);
	 	}
	 });
	$("select[name=hecho_36]").change(function(){
	 	if($(this).val() == 1){
	 		$("#sifilis").prop('readonly', false);			
	 		$("input[name=sifilis_nom_anom]").prop('disabled', false);
	 	}
	 	else{
	 		$("#sifilis").prop('readonly', true);
	 		$("#sifilis").val('');
	 		$("input[name=sifilis_nom_anom]").prop('disabled', true);
			$("input[name=sifilis_nom_anom]").prop('checked', false);
	 	}
	 });

	$("#no_aplica_hba1c").click(function(){
		if($(this).is(':checked')){
			$("#hecho_35").val('');
			$('select[name=hecho_35] option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});			

			$("#otros_hba1c").prop('readonly', true);
	 		$("#otros_hba1c").val('');
	 		$("input[name=otros_hba1c_nom_anom]").prop('disabled', true);
			$("input[name=otros_hba1c_nom_anom]").prop('checked', false);
		}
		else{
			
			$('select[name=hecho_35] option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
			$("#otros_hba1c").prop('readonly', false);			
	 		$("input[name=otros_hba1c_nom_anom]").prop('disabled', false);
		}

	});
});