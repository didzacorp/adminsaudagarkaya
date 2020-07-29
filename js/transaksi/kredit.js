var transaksiKredit = new DaftarObj2({
	prefix : 'transaksiKredit',
	url : 'pages.php?Pg=transaksiKredit',
	formName : 'transaksiKreditForm',
	transaksiKredit_form : '0',//default js transaksiKredit
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();

	},

	detail: function(){
		//alert('detail');
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			//UserAktivitasDet.genDetail();

		}else{

			alert(errmsg);
		}

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
	Baru: function(){

		var me = this;
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);

			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru();
					$('#tanggalTransaksi').datepicker({
							format: 'mm-dd-yyyy'
					});
			  	}
			});

		}else{
		 	alert(err);
		}
	},
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();

			//this.Show ('formedit',{idplh:box.value}, false, true);
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		}else{
			alert(errmsg);
		}

	},

	bayarKomisi:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=bayarKomisi',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
					}
			});
		}else{
			alert(errmsg);
		}

	},
	addTestimoni:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=addTestimoni',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						me.AfterFormEdit(resp);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
					}
			});
		}else{
			alert(errmsg);
		}

	},


	upgradetransaksiKredit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){
			var box = this.GetCbxChecked();
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=upgradetransaksiKredit',
					success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						me.refreshList(true);
					}else{
						alert(resp.err);
					}
					}
			});
		}else{
			alert(errmsg);
		}

	},

	buktiTransferChanged: function(){
		var me= this;
		var filesSelected = document.getElementById("buktiTransfer").files;
		if (filesSelected.length > 0)
		{
			var fileToLoad = filesSelected[0];

			var fileReader = new FileReader();

			fileReader.onload = function(fileLoadedEvent)
			{
				var textAreaFileContents = document.getElementById
				(
					"baseOfFile"
				);

				textAreaFileContents.value = fileLoadedEvent.target.result;
				$("#nameOfFile").val(document.getElementById('buktiTransfer').value);
			};

			fileReader.readAsDataURL(fileToLoad);
		}
	},

	Simpan: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);

		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.transaksiKredit_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshCombotransaksiKredit();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	sendBroadCast: function(){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:{

				    subjectEmail : $("#subjectEmail").val(),
						listEmail : $("#listEmail").val(),
						isiEmail : CKEDITOR.instances['isiEmail'].getData(),
						},
			url: this.url+'&tipe=sendBroadCast',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.transaksiKredit_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshCombotransaksiKredit();
					}

				}else{
					alert(resp.err);
				}
		  	}
		});
	},

	savePembayaranKomisi: function(idtransaksiKredit){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idtransaksiKredit="+idtransaksiKredit,
			url: this.url+'&tipe=savePembayaranKomisi',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						me.Close();
						me.refreshList(true);
				}else{
					alert(resp.err);
				 }
		  	}
		});
	},
	saveTestimoni: function(idtransaksiKredit){
		var me= this;
		this.OnErrorClose = false
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);
		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize()+"&idtransaksiKredit="+idtransaksiKredit,
			url: this.url+'&tipe=saveTestimoni',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
						me.Close();
						me.refreshList(true);
				}else{
					alert(resp.err);
				 }
		  	}
		});
	},


	broadcastEmail : function(){
		var me =this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;
		}else{
			var jmlcek = '';
		}

		if(jmlcek ==0){
			alert('Data Belum Dipilih!');
		}else{

			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);
			document.body.style.overflow='hidden';
				$.ajax({
					type:'POST',
					data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=broadcastEmail',
				  	success: function(data) {
						var resp = eval('(' + data + ')');
						if(resp.err==''){
								document.getElementById(cover).innerHTML = resp.content;
								CKEDITOR.replace("isiEmail",
			{
			     height: 1000
			});
						}else{
							alert(resp.err);
							delElem(cover);
							document.body.style.overflow='auto';
						}

				  	}
				});


		}
	},

	// broadcastEmail:function(){
	// 	var me = this;
	// 	errmsg = this.CekCheckbox();
	// 	if(errmsg ==''){
	// 		var box = this.GetCbxChecked();
	// 		var cover = this.prefix+'_formcover';
	// 		addCoverPage2(cover,999,true,false);
	// 		document.body.style.overflow='hidden';
	// 		$.ajax({
	// 			type:'POST',
	// 			data:$('#'+this.formName).serialize(),
	// 			url: this.url+'&tipe=addTestimoni',
	// 				success: function(data) {
	// 				var resp = eval('(' + data + ')');
	// 				if (resp.err ==''){
	// 					document.getElementById(cover).innerHTML = resp.content;
	// 					me.AfterFormEdit(resp);
	// 				}else{
	// 					alert(resp.err);
	// 					delElem(cover);
	// 					document.body.style.overflow='auto';
	// 				}
	// 				}
	// 		});
	// 	}else{
	// 		alert(errmsg);
	// 	}
	//
	// },



});
