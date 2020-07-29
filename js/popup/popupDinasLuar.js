var popupDinasLuar = new DaftarObj2({
	prefix : 'popupDinasLuar',
	url : 'pages.php?Pg=popupDinasLuar',
	formName : 'popupDinasLuarForm',
	kodeProgram : 'p',
	namaProgram : 'program',
	filterAkun : '',

	loading:function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();

	},

	daftarRender:function(){
		var me =this; //render daftar
		addCoverPage2(
			'daftar_cover',	1, 	true, true,	{renderTo: this.prefix+'_cont_daftar',
			imgsrc: 'images/wait.gif',
			style: {position:'absolute', top:'5', left:'5'}
			}
		);
		$.ajax({
		  	url: this.url+'&tipe=daftar',
		 	type:'POST',
			data:$('#'+this.formName).serialize(),
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
				me.sumHalRender();
		  	}
		});
	},
	sumHalRender:function(){
		// var $table = $('.table.table-striped');
		// 	$table.floatThead({
		// 		top: 98,
		// 	    responsiveContainer: function($table){
		// 	        return $table.closest('.demo');
		// 	    }
		// 	});
		var me =this; //render sumha
			addCoverPage2(
				'daftar_cover',	1, 	true, 	true,{renderTo: this.prefix+'_cont_hal',
				imgsrc: 'images/wait.gif',
				style: {position:'absolute', top:'5', left:'5'}
				}
			);
			$.ajax({
			  url: this.url+'&tipe=sumhal',
			  type:'POST',
				data:$('#'+this.formName).serialize(),
			  success: function(data) {
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_hal').innerHTML = resp.content.hal;
				if (document.getElementById(me.prefix+'_cont_sum')){
					document.getElementById(me.prefix+'_cont_sum').innerHTML = resp.content.sums[0];
				}
				for (var i=1; i<resp.content.sums.length; i++){
					if (document.getElementById(me.prefix+'_cont_sum'+i))
						document.getElementById(me.prefix+'_cont_sum'+i).innerHTML = resp.content.sums[i];

				}

			  }
			});
	},

	Baru:function(){
		var me = this;
		var cover = this.prefix+'_formcover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize(),
		  	url: this.url+'&tipe=formBaru',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if (resp.err ==''){
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru(resp);
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}

		  	}
		});
	},

	windowShow: function(postPrefix){
		var me = this;
		var cover = this.prefix+'_cover';
		document.body.style.overflow='hidden';
		addCoverPage2(cover,13000,true,false);
		var postTambahan = "";
			postTambahan = "&postIdPegawai="+postPrefix.postIdPegawai;

		$.ajax({
			type:'POST',
			data:$('#'+this.formName).serialize()+postTambahan,
			url: this.url+'&tipe=windowshow',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				if(resp.err==''){
					document.getElementById(cover).innerHTML = resp.content;
					me.loading();
				}else{
					alert(resp.err);
					delElem(cover);
					document.body.style.overflow='auto';
				}
		  	}
		});
	},

	windowClose: function(){
		document.body.style.overflow='auto';
		delElem(this.prefix+'_cover');
	},

	windowSave: function(id){
		var cover = this.prefix+'_formcoverLoading';
		addCoverPage2(cover,400,true,false);
		var me = this;
			$.ajax({
				type : 'POST',
				data: {idLogAbsensi : id},
				url: this.url + "&tipe=windowSave",
				success: function(data) {
				var resp = eval('(' + data + ')');
					delElem(cover);
					if(resp.err == ''){
						$("#idLogAbsensi").val(id);
						$("#tanggalDinas").val(resp.content.tanggalDinas);
						me.windowClose();
					}else{
						alert(resp.err);
					}
				}
			});
	},

	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
	},

	checkSemua : function(  n, fldName ,elHeaderChecked, elJmlCek) {
			if (!fldName) {
				fldName = 'cb';
			}
			if (!elHeaderChecked) {
				elHeaderChecked = 'toggle';
			}
			var c = document.getElementById(elHeaderChecked).checked;
			var n2 = 0;
			for (i=0; i < n ; i++) {
			 cb = document.getElementById(fldName+i);
			 if (cb) {
				 cb.checked = c;
				  this.thisChecked($("#"+fldName+i).val(),fldName+i);
				 n2++;
			 }
			}
			if (c) {
			 document.getElementById(elJmlCek).value = n2;
			} else {
			 document.getElementById(elJmlCek).value = 0;
			}
	},
	thisChecked:function(idSource,idCheckBox){

		var status ="";
		if(document.getElementById(idCheckBox).checked ){
			status = "checked";
		}else{
			status = "";
		}
		$.ajax({
			type:'POST',
			data:{
					id : idSource,
					status : status
				 },
		  	url: this.url+'&tipe=checkboxChanged',
		  	success: function(data) {
				var resp = eval('(' + data + ')');

		  	}
		});
	},
});
