$(function(){
	$("input[name*=fecha_diagnostico]").datepicker();


	$("input[name=hipertension]").change(function(){
		if($(this).val() == 0){
			$("#hipertension_fecha_diagnostico").attr('readonly','readonly');
			$("#hipertension_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#hipertension_fecha_diagnostico").removeAttr('readonly');
			$("#hipertension_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=ulcera]").change(function(){
		if($(this).val() == 0){
			$("#ulcera_fecha_diagnostico").attr('readonly','readonly');
			$("#ulcera_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#ulcera_fecha_diagnostico").removeAttr('readonly');
			$("#ulcera_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=diabetes]").change(function(){
		if($(this).val() == 0){
			$("#diabetes_fecha_diagnostico").attr('readonly','readonly');
			$("#diabetes_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#diabetes_fecha_diagnostico").removeAttr('readonly');
			$("#diabetes_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=hipo_hipertiroidismo]").change(function(){
		if($(this).val() == 0){
			$("#hipo_hipertiroidismo_fecha_diagnostico").attr('readonly','readonly');
			$("#hipo_hipertiroidismo_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#hipo_hipertiroidismo_fecha_diagnostico").removeAttr('readonly');
			$("#hipo_hipertiroidismo_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=hiperlipidemia]").change(function(){
		if($(this).val() == 0){
			$("#hiperlipidemia_fecha_diagnostico").attr('readonly','readonly');
			$("#hiperlipidemia_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#hiperlipidemia_fecha_diagnostico").removeAttr('readonly');
			$("#hiperlipidemia_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=epoc]").change(function(){
		if($(this).val() == 0){
			$("#epoc_fecha_diagnostico").attr('readonly','readonly');
			$("#epoc_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#epoc_fecha_diagnostico").removeAttr('readonly');
			$("#epoc_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=coronaria]").change(function(){
		if($(this).val() == 0){
			$("#coronaria_fecha_diagnostico").attr('readonly','readonly');
			$("#coronaria_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#coronaria_fecha_diagnostico").removeAttr('readonly');
			$("#coronaria_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=rinitis]").change(function(){
		if($(this).val() == 0){
			$("#rinitis_fecha_diagnostico").attr('readonly','readonly');
			$("#rinitis_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#rinitis_fecha_diagnostico").removeAttr('readonly');
			$("#rinitis_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=acc_vascular]").change(function(){
		if($(this).val() == 0){
			$("#acc_vascular_fecha_diagnostico").attr('readonly','readonly');
			$("#acc_vascular_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#acc_vascular_fecha_diagnostico").removeAttr('readonly');
			$("#acc_vascular_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=asma]").change(function(){
		if($(this).val() == 0){
			$("#asma_fecha_diagnostico").attr('readonly','readonly');
			$("#asma_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#asma_fecha_diagnostico").removeAttr('readonly');
			$("#asma_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=gastritis]").change(function(){
		if($(this).val() == 0){
			$("#gastritis_fecha_diagnostico").attr('readonly','readonly');
			$("#gastritis_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#gastritis_fecha_diagnostico").removeAttr('readonly');
			$("#gastritis_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=cefaleas]").change(function(){
		if($(this).val() == 0){
			$("#cefaleas_fecha_diagnostico").attr('readonly','readonly');
			$("#cefaleas_fecha_diagnostico").attr('disabled','disabled');
		}
		else{
			$("#cefaleas_fecha_diagnostico").removeAttr('readonly');
			$("#cefaleas_fecha_diagnostico").removeAttr('disabled');
		}
	});
	$("input[name=alergia]").change(function(){
		if($(this).val() == 0){
			$("#alergia_desc").attr('readonly','readonly');
			$("#alergia_desc").attr('disabled','disabled');
		}
		else{
			$("#alergia_desc").removeAttr('readonly');
			$("#alergia_desc").removeAttr('disabled');
		}
	});
	$("input[name=tabaquismo]").change(function(){
		if($(this).val() == 0){
			$("#tabaquismo_desc").attr('readonly','readonly');
			$("#tabaquismo_desc").attr('disabled','disabled');
		}
		else{
			$("#tabaquismo_desc").removeAttr('readonly');
			$("#tabaquismo_desc").removeAttr('disabled');
		}
	});
	$("input[name=ingesta_alcohol]").change(function(){
		if($(this).val() == 0){
			$("#ingesta_alcohol_desc").attr('readonly','readonly');
			$("#ingesta_alcohol_desc").attr('disabled','disabled');
		}
		else{
			$("#ingesta_alcohol_desc").removeAttr('readonly');
			$("#ingesta_alcohol_desc").removeAttr('disabled');
		}
	});
	$("input[name=drogas]").change(function(){
		if($(this).val() == 0){
			$("#drogas_desc").attr('readonly','readonly');
			$("#drogas_desc").attr('disabled','disabled');
		}
		else{
			$("#drogas_desc").removeAttr('readonly');
			$("#drogas_desc").removeAttr('disabled');
		}
	});
	$("input[name=cirugia]").change(function(){
		if($(this).val() == 0){
			$("#cirugia_desc").attr('readonly','readonly');
			$("#cirugia_desc").attr('disabled','disabled');
		}
		else{
			$("#cirugia_desc").removeAttr('readonly');
			$("#cirugia_desc").removeAttr('disabled');
		}
	});
	$("input[name=donado_sangre]").change(function(){
		if($(this).val() == 0){
			$("#donado_sangre_desc").attr('readonly','readonly');
			$("#donado_sangre_desc").attr('disabled','disabled');
		}
		else{
			$("#donado_sangre_desc").removeAttr('readonly');
			$("#donado_sangre_desc").removeAttr('disabled');
		}
	});
	$("input[name=tratamiento_farma]").change(function(){
		if($(this).val() == 0){
			$("#tratamiento_farma_desc").attr('readonly','readonly');
			$("#tratamiento_farma_desc").attr('disabled','disabled');
		}
		else{
			$("#tratamiento_farma_desc").removeAttr('readonly');
			$("#tratamiento_farma_desc").removeAttr('disabled');
		}
	});
	$("input[name=suplemento_dietetico]").change(function(){
		if($(this).val() == 0){
			$("#suplemento_dietetico_desc").attr('readonly','readonly');
			$("#suplemento_dietetico_desc").attr('disabled','disabled');
		}
		else{
			$("#suplemento_dietetico_desc").removeAttr('readonly');
			$("#suplemento_dietetico_desc").removeAttr('disabled');
		}
	});
	$("input[name=alzheimer]").change(function(){
		if($(this).val() == 0){
			$("#alzheimer_desc").attr('readonly','readonly');
			$("#alzheimer_desc").attr('disabled','disabled');
		}
		else{
			$("#alzheimer_desc").removeAttr('readonly');
			$("#alzheimer_desc").removeAttr('disabled');
		}
	});
	$("input[name=morbido]").change(function(){
		if($(this).val() == 0){
			$("#morbido_desc").attr('readonly','readonly');
			$("#morbido_desc").attr('disabled','disabled');
		}
		else{
			$("#morbido_desc").removeAttr('readonly');
			$("#morbido_desc").removeAttr('disabled');
		}
	});
	
	/*--------------------------------------------------*/
	
	if($("input[name=hipertension]:checked").val() == 0){
		$("#hipertension_fecha_diagnostico").attr('readonly','readonly');
		$("#hipertension_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#hipertension_fecha_diagnostico").removeAttr('readonly');
		$("#hipertension_fecha_diagnostico").removeAttr('disabled');
	}
	
	if($("input[name=ulcera]:checked").val() == 0){
		$("#ulcera_fecha_diagnostico").attr('readonly','readonly');
		$("#ulcera_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#ulcera_fecha_diagnostico").removeAttr('readonly');
		$("#ulcera_fecha_diagnostico").removeAttr('disabled');
	}	

	if($("input[name=diabetes]").val() == 0){
		$("#diabetes_fecha_diagnostico").attr('readonly','readonly');
		$("#diabetes_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#diabetes_fecha_diagnostico").removeAttr('readonly');
		$("#diabetes_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=hipo_hipertiroidismo]").val() == 0){
		$("#hipo_hipertiroidismo_fecha_diagnostico").attr('readonly','readonly');
		$("#hipo_hipertiroidismo_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#hipo_hipertiroidismo_fecha_diagnostico").removeAttr('readonly');
		$("#hipo_hipertiroidismo_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=hiperlipidemia]").val() == 0){
		$("#hiperlipidemia_fecha_diagnostico").attr('readonly','readonly');
		$("#hiperlipidemia_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#hiperlipidemia_fecha_diagnostico").removeAttr('readonly');
		$("#hiperlipidemia_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=epoc]").val() == 0){
		$("#epoc_fecha_diagnostico").attr('readonly','readonly');
		$("#epoc_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#epoc_fecha_diagnostico").removeAttr('readonly');
		$("#epoc_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=coronaria]").val() == 0){
		$("#coronaria_fecha_diagnostico").attr('readonly','readonly');
		$("#coronaria_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#coronaria_fecha_diagnostico").removeAttr('readonly');
		$("#coronaria_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=rinitis]").val() == 0){
		$("#rinitis_fecha_diagnostico").attr('readonly','readonly');
		$("#rinitis_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#rinitis_fecha_diagnostico").removeAttr('readonly');
		$("#rinitis_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=acc_vascular]").val() == 0){
		$("#acc_vascular_fecha_diagnostico").attr('readonly','readonly');
		$("#acc_vascular_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#acc_vascular_fecha_diagnostico").removeAttr('readonly');
		$("#acc_vascular_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=asma]").val() == 0){
		$("#asma_fecha_diagnostico").attr('readonly','readonly');
		$("#asma_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#asma_fecha_diagnostico").removeAttr('readonly');
		$("#asma_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=gastritis]").val() == 0){
		$("#gastritis_fecha_diagnostico").attr('readonly','readonly');
		$("#gastritis_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#gastritis_fecha_diagnostico").removeAttr('readonly');
		$("#gastritis_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=cefaleas]").val() == 0){
		$("#cefaleas_fecha_diagnostico").attr('readonly','readonly');
		$("#cefaleas_fecha_diagnostico").attr('disabled','disabled');
	}
	else{
		$("#cefaleas_fecha_diagnostico").removeAttr('readonly');
		$("#cefaleas_fecha_diagnostico").removeAttr('disabled');
	}

	if($("input[name=alergia]").val() == 0){
		$("#alergia_desc").attr('readonly','readonly');
		$("#alergia_desc").attr('disabled','disabled');
	}
	else{
		$("#alergia_desc").removeAttr('readonly');
		$("#alergia_desc").removeAttr('disabled');
	}

	if($("input[name=tabaquismo]").val() == 0){
		$("#tabaquismo_desc").attr('readonly','readonly');
		$("#tabaquismo_desc").attr('disabled','disabled');
	}
	else{
		$("#tabaquismo_desc").removeAttr('readonly');
		$("#tabaquismo_desc").removeAttr('disabled');
	}

	if($("input[name=ingesta_alcohol]").val() == 0){
		$("#ingesta_alcohol_desc").attr('readonly','readonly');
		$("#ingesta_alcohol_desc").attr('disabled','disabled');
	}
	else{
		$("#ingesta_alcohol_desc").removeAttr('readonly');
		$("#ingesta_alcohol_desc").removeAttr('disabled');
	}

	if($("input[name=drogas]").val() == 0){
		$("#drogas_desc").attr('readonly','readonly');
		$("#drogas_desc").attr('disabled','disabled');
	}
	else{
		$("#drogas_desc").removeAttr('readonly');
		$("#drogas_desc").removeAttr('disabled');
	}

	if($("input[name=cirugia]").val() == 0){
		$("#cirugia_desc").attr('readonly','readonly');
		$("#cirugia_desc").attr('disabled','disabled');
	}
	else{
		$("#cirugia_desc").removeAttr('readonly');
		$("#cirugia_desc").removeAttr('disabled');
	}

	if($("input[name=donado_sangre]").val() == 0){
		$("#donado_sangre_desc").attr('readonly','readonly');
		$("#donado_sangre_desc").attr('disabled','disabled');
	}
	else{
		$("#donado_sangre_desc").removeAttr('readonly');
		$("#donado_sangre_desc").removeAttr('disabled');
	}

	if($("input[name=tratamiento_farma]").val() == 0){
		$("#tratamiento_farma_desc").attr('readonly','readonly');
		$("#tratamiento_farma_desc").attr('disabled','disabled');
	}
	else{
		$("#tratamiento_farma_desc").removeAttr('readonly');
		$("#tratamiento_farma_desc").removeAttr('disabled');
	}

	if($("input[name=suplemento_dietetico]").val() == 0){
		$("#suplemento_dietetico_desc").attr('readonly','readonly');
		$("#suplemento_dietetico_desc").attr('disabled','disabled');
	}
	else{
		$("#suplemento_dietetico_desc").removeAttr('readonly');
		$("#suplemento_dietetico_desc").removeAttr('disabled');
	}

	if($("input[name=alzheimer]").val() == 0){
		$("#alzheimer_desc").attr('readonly','readonly');
		$("#alzheimer_desc").attr('disabled','disabled');
	}
	else{
		$("#alzheimer_desc").removeAttr('readonly');
		$("#alzheimer_desc").removeAttr('disabled');
	}

	if($("input[name=morbido]").val() == 0){
		$("#morbido_desc").attr('readonly','readonly');
		$("#morbido_desc").attr('disabled','disabled');
	}
	else{
		$("#morbido_desc").removeAttr('readonly');
		$("#morbido_desc").removeAttr('disabled');
	}
	

});