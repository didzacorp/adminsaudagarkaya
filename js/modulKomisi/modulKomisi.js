var modulKomisi = new DaftarObj2({
	prefix : 'modulKomisi',
	url : 'pages.php?Pg=modulKomisi',
	formName : 'modulKomisiForm',
	modulKomisi_form : '0',//default js modulKomisi
	loading: function(){
		//alert('loading');
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		this.sumHalRender();

	},
	filterRenderAfter: function(){
		$('#filterPeriode').datepicker({
			uiLibrary: 'bootstrap3',
			format: 'mm-yyyy',
		});
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
				me.setTableHeader();
		  	}
		});
	},
	Baru: function(){

		var me = this;
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.modulKomisi_form==0){//baru dari modulKomisi
				addCoverPage2(cover,999,true,false);
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);
			}

			$("#"+cover).css("top", "50");
			$("#"+cover).css("left", "200");
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;
					me.AfterFormBaru();
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
			$("#"+cover).css("top", "50");
			$("#"+cover).css("left", "200");
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

	Konfirmasi: function() {
    var me = this;
    errmsg = this.CekCheckbox();
    if (errmsg == "") {
      var box = this.GetCbxChecked();
      var cover = this.prefix + "_formcover";
      addCoverPage2(cover, 999, true, false);
      // document.body.style.overflow = "hidden";
      $.ajax({
        type: "POST",
        data: $("#" + this.formName).serialize(),
        url: this.url + "&tipe=Konfirmasi",
        success: function(data) {
          var resp = eval("(" + data + ")");
          if (resp.err == "") {
            document.getElementById(cover).innerHTML = resp.content;
            // $( "#tanggaldetailSPJ" ).datepicker({
  					// 		dateFormat: "dd-mm-yy",
  					// 		showAnim: "slideDown",
  					// 		inline: true,
  					// 		showOn: "button",
  					// 		buttonImage: "datepicker/calender1.png",
  					// 		buttonImageOnly: true,
  					// 		changeMonth: true,
  					// 		changeYear: false,
  					// 		yearRange: resp.cek.yearRange,
  					// 		buttonText : "",
  					// 	});

          } else {
            alert(resp.err);
            delElem(cover);
            document.body.style.overflow = "auto";
          }
        }
      });
    } else {
      alert(errmsg);
    }
  },

	showDirectTeam: function(idMember){

		var me = this;
		var err='';

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);


			// $("#"+cover).css("top", "50");
			// $("#"+cover).css("left", "200");
			$.ajax({
				type:'POST',
				data: {
					idMember : idMember
				},
	  		url: this.url+'&tipe=showDirectTeam',
		  	success: function(data) {
						var resp = eval('(' + data + ')');
						document.getElementById(cover).innerHTML = resp.content;
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
		addCoverPage2(cover,9999,true,false);

		$.ajax({
			type:'POST',
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.modulKomisi_form==0){
						me.Close();
						me.AfterSimpan();
					}else{
						me.Close();
						barang.refreshCombomodulKomisi();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	saveKonfirmasi: function(idEdit) {
    var me = this;
    this.OnErrorClose = false;
    document.body.style.overflow = "hidden";
    var cover = this.prefix + "_formsimpan";
    addCoverPage2(cover, 9999, true, false);
    $.ajax({
      type: "POST",
      data: $("#" + this.prefix + "_form").serialize()+"&idEdit="+idEdit,
      url: this.url + "&tipe=saveKonfirmasi",
      success: function(data) {
        var resp = eval("(" + data + ")");
        delElem(cover);
        if (resp.err == "") {
          me.Close();
          me.refreshList();
        } else {
          alert(resp.err);
        }
      }
    });
  },
	Laporan: function(){

		var me = this;
		var err='';
		if($("#filterJenisTransaksi").val() ==''){
			errmsg = "Pilih Bank / Kas";
		}else if($("#filterBankKas").val() ==''){
			errmsg = "Pilih Bank / Kas";
		}

		if (err =='' ){
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			addCoverPage2(cover,999,true,false);
			$("#"+cover).css("top", "150");
			$("#"+cover).css("left", "400");
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
					url: this.url+'&tipe=Laporan',
					success: function(data) {
						var resp = eval('(' + data + ')');
						document.getElementById(cover).innerHTML = resp.content;
						$('#tanggalCetak').datepicker({
								uiLibrary: 'bootstrap3',
								format: 'dd-mm-yyyy',
						});
						me.AfterFormBaru();
					}
			});

		}else{
			alert(err);
		}
	},
	viewLaporan: function() {
    var me = this;
    errmsg = "";
    if($("#jenisLaporan").val() ==''){
      errmsg = "Pilih Jenis Laporan";
    }

    if (errmsg == "") {
      var me = this;
      var aForm = document.getElementById(this.prefix + "_form");
      aForm.action = me.url + "&tipe=viewLaporan";
      aForm.target = "_blank";
      aForm.submit();
      aForm.target = "";
    } else {
      alert(errmsg);
    }
  },



});
