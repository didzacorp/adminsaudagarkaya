var refProduk = new DaftarObj2({
	prefix : 'refProduk',
	url : 'pages.php?Pg=refProduk',
	formName : 'refProdukForm',
	refProduk_form : '0',//default js refProduk
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
			if(me.refProduk_form==0){//baru dari refProduk
				addCoverPage2(cover,999,true,false);
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);
			}

			// $("#"+cover).css("top", "50");
			// $("#"+cover).css("left", "200");
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=formBaru',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					document.getElementById(cover).innerHTML = resp.content;
					if ($("#deskripsiProduk").length) {
            var quill = new Quill('#deskripsiProduk', {
              modules: {
                toolbar: [
                  [{
                    header: [1, 2, false]
                  }],
                  ['bold', 'italic', 'underline'],
                  ['image', 'code-block']
                ]
              },
              placeholder: 'Compose an epic...',
              theme: 'snow' // or 'bubble'
            });
          }
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
			// $("#"+cover).css("top", "50");
			// $("#"+cover).css("left", "200");
			document.body.style.overflow='hidden';
			$.ajax({
				type:'POST',
				data:$('#'+this.formName).serialize(),
				url: this.url+'&tipe=formEdit',
			  	success: function(data) {
					var resp = eval('(' + data + ')');
					if (resp.err ==''){
						document.getElementById(cover).innerHTML = resp.content;
						if ($("#deskripsiProduk").length) {
	            var quill = new Quill('#deskripsiProduk', {
	              modules: {
	                toolbar: [
	                  [{
	                    header: [1, 2, false]
	                  }],
	                  ['bold', 'italic', 'underline'],
	                  ['image', 'code-block']
	                ]
	              },
	              placeholder: 'Compose an epic...',
	              theme: 'snow' // or 'bubble'
	            });
	          }
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
			data:$('#'+this.prefix+'_form').serialize()+"&deskripsiProduk="+$("#deskripsiProduk").html(),
			url: this.url+'&tipe=simpan',
		  	success: function(data) {
				var resp = eval('(' + data + ')');
				delElem(cover);
				if(resp.err==''){
					if(me.refProduk_form==0){
						me.Close();
						me.refreshList();
					}else{
						me.Close();
						me.refreshList();
					}
				}else{
					alert(resp.err);
				}
		  	}
		});
	},

	addMedia: function() {
	 var me = this;
	 var cover = this.prefix + "_formCoverLoading";
	 addCoverPage2(cover, 99999, true, false);
	 $.ajax({
		 type: "POST",
		 data: $("#" + this.prefix + "_form").serialize(),
		 url: this.url + "&tipe=addMedia",
		 success: function(data) {
			 delElem(cover);
			 var resp = eval("(" + data + ")");
			 if (resp.err == "") {
				 document.getElementById("tableMedia").innerHTML =
					 resp.content.tableMedia;
			 } else {
				 alert(resp.err);
			 }
		 }
	 });
	},
	saveNewMedia: function() {
	 var me = this;
	 var cover = this.prefix + "_formCoverLoading";
	 addCoverPage2(cover, 99999, true, false);
	 $.ajax({
		 type: "POST",
		 data: {
			 sourceMedia : $("#sourceMedia").val(),
			 typeMedia : $("#typeMedia").val(),
		 },
		 url: this.url + "&tipe=saveNewMedia",
		 success: function(data) {
			 delElem(cover);
			 var resp = eval("(" + data + ")");
			 if (resp.err == "") {
				 document.getElementById("tableMedia").innerHTML =
					 resp.content.tableMedia;
			 } else {
				 alert(resp.err);
			 }
		 }
	 });
 },
 batalMedia: function() {
	 var me = this;
	 var cover = this.prefix + "_formCoverLoading";
	 addCoverPage2(cover, 99999, true, false);
	 $.ajax({
		 type: "POST",
		 // data: {
		 //   sourceMedia : $("#sourceMedia").val(),
		 //   typeMedia : $("#typeMedia").val(),
		 // },
		 url: this.url + "&tipe=batalMedia",
		 success: function(data) {
			 delElem(cover);
			 var resp = eval("(" + data + ")");
			 if (resp.err == "") {
				 document.getElementById("tableMedia").innerHTML =
					 resp.content.tableMedia;
			 } else {
				 alert(resp.err);
			 }
		 }
	 });
 },
 editMedia: function(idEdit) {
    var me = this;
    var cover = this.prefix + "_formCoverLoading";
    addCoverPage2(cover, 99999, true, false);
    $.ajax({
      type: "POST",
      data: $("#" + this.prefix + "_form").serialize()+"&idEdit="+idEdit,
      url: this.url + "&tipe=editMedia",
      success: function(data) {
        delElem(cover);
        var resp = eval("(" + data + ")");
        if (resp.err == "") {
          document.getElementById("tableMedia").innerHTML =
            resp.content.tableMedia;
        } else {
          alert(resp.err);
        }
      }
    });
  },

	saveEditMedia: function(idEdit) {
	 var me = this;
	 var cover = this.prefix + "_formCoverLoading";
	 addCoverPage2(cover, 99999, true, false);
	 $.ajax({
		 type: "POST",
		 data: {
			 sourceMedia : $("#sourceMedia").val(),
			 typeMedia : $("#typeMedia").val(),
			 idEdit : idEdit,
		 },
		 url: this.url + "&tipe=saveEditMedia",
		 success: function(data) {
			 delElem(cover);
			 var resp = eval("(" + data + ")");
			 if (resp.err == "") {
				 document.getElementById("tableMedia").innerHTML =
					 resp.content.tableMedia;
			 } else {
				 alert(resp.err);
			 }
		 }
	 });
 },



});
