
var TutupKas = new DaftarObj2({
	prefix : 'TutupKas',
	url : 'pages.php?Pg=tutupkas', 
	formName : 'TutupKasForm',// 'ruang_form',
	
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
			addCoverPage2(cover,1,true,false);	
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');			
					document.getElementById(cover).innerHTML = resp.content;
					me.nnn();			
					me.AfterFormBaru();
			  	}
			});
		
		}else{
		 	alert(err);
		}
	},


	
	Simpan: function(){
		var me= this;
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		/*this.sendReq(
			this.url,
			{ idprs: 0, daftarProses: new Array('simpan')},
			this.formDialog);*/
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				//document.getElementById(cover).innerHTML = resp.content;
				if(resp.err==''){
					me.Close();
					me.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	},

	cari:function(){
		var jml = 6 ;
		var isi = document.getElementById('fmCari2').value;
		var hasil = isi.length;
		if(hasil >= jml){
			Pembayaran.refreshList(true)
		}
 	},
	
	Batal:function(){	
		var me = this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		errmsg = this.CheckCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
		if(jmlcek ==0){
		alert('Data Belum Dipilih!');
		}else{
			if(confirm('Anda ingin membatalkan data ini ?')){
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=batal',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						alert("Sukses")
						me.Close();
						me.refreshList(true)
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});}}
		}else{
			alert(errmsg);
		}
 	},
	
	cmbDefault:function() {
		var kasir = document.getElementById('kasir').value;
		if(document.getElementById('default').checked) {
			document.getElementById('kasir').disabled = true;
			this.setCookie(this.prefix+'_LokasiKasir',kasir)
		}else{
			document.getElementById('kasir').disabled = false;
		}
	},
	
	nnn:function(){
		var kasir = document.getElementById('kasir').value;
			if(kasir != ''){
				document.getElementById('kasir').disabled = true;
				document.getElementById('default').checked = true;
			}else{
				document.getElementById('kasir').disabled = false;
				document.getElementById('default').checked = false;			}
	},
	/*CheckCheckbox:function(){//alert(this.elJmlCek);
		var errmsg = '';		
		//alert(document.getElementById(this.prefix+'_jmlcek').value );
		//if( document.getElementById(this.elJmlCek)){
		/*if( document.getElementById(this.prefix+'_jmlcek')){
			if((errmsg=='')  && (document.getElementById(this.prefix+'_jmlcek').value >1 )){	errmsg= 'Pilih Hanya Satu Data!'; }
		}*/
		/*if((errmsg=='') && ( (document.getElementById(this.prefix+'_jmlcek').value == 0)||(document.getElementById(this.prefix+'_jmlcek').value == '')  )){
			errmsg= 'Data belum dipilih!';
		}
		return errmsg;
	},*/
	Setor:function(){
		var me = this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		if(jmlcek ==0){
			alert("Data Belum Dipilih");
		}else{
			var box = this.GetCbxChecked();
			
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formBaru',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						document.getElementById(cover).innerHTML = resp.content;
						me.nnn();
						me.AfterFormEdit(resp);
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});
		}
		
	},
	
	Batal:function(){	
		var me = this;
		if(document.getElementById(this.prefix+'_jmlcek')){
			var jmlcek = document.getElementById(this.prefix+'_jmlcek').value ;	
		}else{
			var jmlcek = '';
		}
		if(jmlcek ==0){
		alert('Data Belum Dipilih!');
		}else{
			var box = this.GetCbxChecked();
			if(confirm('Anda ingin membatalkan data ini ?')){
			//this.Show ('formedit',{idplh:box.value}, false, true);			
			var cover = this.prefix+'_formcover';
			addCoverPage2(cover,999,true,false);	
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=batal',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if (resp.err ==''){		
						alert("Sukses")
						me.Close();
						me.refreshList(true)
					}else{
						alert(resp.err);
						delElem(cover);
						document.body.style.overflow='auto';
					}
			  	}
			});}}
 	}
});