/*
function getPath() {
	var path = window.location.href;
	return path.substring(0, path.lastIndexOf('/')) + '/';
}
  
function monitorPrinting() {
	var applet = document.jzebra;
	if (applet != null) {
		if (!applet.isDonePrinting()) {
			window.setTimeout('monitorPrinting()', 100);
		} else {
			var e = applet.getException();
			alert(e == null ? 'Printed Successfully' : 'Exception occured: ' + e.getLocalizedMessage());
		}
	} else {
		alert('Applet not loaded!');
    }
}

*/

RawPrintObj = function(params_){
	this.params=params_;	
	this.prefix = 'rawprint';
	this.charWidth = 96;

	this.repeatChar= function(c,x){
		var s = '';
		for(var i=0; i<x; i++){
			s += c;
		}
		return s;
	}
	this.addSpace = function(x,spc){
		if(spc == null )
	 	spc = ' ';
		return this.repeatChar(spc,x);
	}
	
	this.kiri = function(s, width,spc){ //cetak kiri
		var temp = s.replace(/\s{2,}/g, ' ');
		s= temp;
		var l =  s.length;
		if (width == null) width = this.charWidth;
		return s + this.addSpace(width-l,spc) ;	
	}
	this.kanan = function(s, width, spc){ //cetak rata kanan
		var temp = s.replace(/\s{2,}/g, ' ');
		s= temp;
		var l =  s.length;
		if (width == null) width = this.charWidth;
		return this.addSpace(width-l, spc) + s ;	
	}
	this.tengah = function(s, width, spc){ //cetak rata kanan
		var temp = s.replace(/\s{2,}/g, ' ');
		s= temp;
		var le =  s.length;
		if (width == null) width = this.charWidth;
		kiri = Math.ceil((width-le)/2);
		kanan = width - (kiri+le);
		return this.addSpace(kiri, spc) + s + this.addSpace(kanan, spc);	
	}
	this.justify = function(s, width){
		//var ll = s.length;
		var j = 0;
		var baris = Array();
		var arr = Array(s);
		var m = s.split(" ");
		var strtemp = '';
		if (width == null) width = this.charWidth;

		for(var i=0;i<m.length;i++){
			z= strtemp+m[i];
			if(z.length<=width){
				strtemp += m[i]+" ";
			}else{
				baris[j] = strtemp;
				j++;
				strtemp= m[i]+" ";
			}
		}
		if(strtemp != ''){
			baris[j] = strtemp;
		}
		return baris;

	}
	
	this.print = function(content) {
		var nama = 'nama nya';
		var noreg = '00123';
		var norm = '00234';
		var alamat1 = 'jl. alamat1'; //max 35
		var alamat2 = 'kec';
		var alamat3 = 'bandung';
		var tanggal ='1 Desember 2013';
		var carabayar= 'bpjs';
		var telp='0812321321';
		var penjamin='penjamin';
		var dokter = 'Dr. ';
		var nopenjamin='324';
		var judul = 'Kwitansi Rawat Jalan';
		
	     var applet = document.jzebra;
	     if (applet != null) {
	       applet.findPrinter('Generic Text');
		   applet.append("\x1B\x21\x08"); // 80 char bold
		   applet.append('RSUD AL IHSAN PROVINSI JAWA BARAT'+this.kanan(judul,47));
		   applet.append("\x1B\x21\x01"); //96 char
		   
		   applet.append('Jl. Kiastramanggala Baleendah Kab. Bandung\r\n');		   
		   applet.append('Telp. (022) 5940872, 5940875, 5941719\r\n');		   
		   applet.append('\r\n');
		   applet.append('Sudah diterima dari,\r\n');
		   applet.append(this.kanan('Nama Pasien',14)+' : '+this.kiri(nama,32)+'(L)'	+this.kanan('     No. Reg',13)+' : '+this.kiri(noreg,28));
		   applet.append(this.kanan('No. RM',14)+' : '+this.kiri(norm,35)    			+this.kanan('     Tanggal',13)+' : '+this.kiri(tanggal,28));
		   applet.append(this.kanan('Alamat Pasien',14)+' : '+this.kiri(alamat1,35)    	+this.kanan('      Dokter',13)+' : '+this.kiri(dokter,28));
		   applet.append(this.kanan(' ',14)+'   '+this.kiri(alamat2,35)    				+this.kanan('  Cara Bayar',13)+' : '+this.kiri(carabayar,28));
		   applet.append(this.kanan(' ',14)+' : '+this.kiri(alamat3,35)					+this.kanan('    Penjamin',13)+' : '+this.kiri(penjamin,28));
		   applet.append(this.kanan('Telp/Hp',14)+' : '+this.kiri(telp,35)     			+this.kanan('No. Penjamin',13)+' : '+this.kiri(nopenjamin,28));
		   
		   //header table
		   applet.append('123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456');		   
		   applet.append(this.repeatChar('-', 96));		   
		   applet.append('No.| Kode |                      Uraian                 | Qty | Harga Sat |      Jumlah(Rp)     ');
		   applet.append(this.repeatChar('-', 96));
		   
		   //body tabel
		   no = '1'; kode='kd1'; uraian = 'Pagi - Pemeriksaan'; qty='15'; hrgsat='100'; jml='1.500'; 
		   applet.append(this.kanan(no,3)+'|'+this.tengah(kode,6) +'|'+ this.kiri(uraian,45)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,11)+'|'+this.kanan(jml,21));
		   
		   //footer table
		   tot='1.500';
		   terbilang1 = 'Seribu Lima Ratus Rupiah';
		   terbilang2 = '';
		   namakiri = 'petugas1';
		   namakanan= 'kasir1';
		   
		   applet.append(this.kiri(' ',96));
		   applet.append(this.repeatChar('-', 96));	
		   	   
		   applet.append('                                                              Total (Rp)   '+ this.kanan(tot,21));
		   applet.append(this.kiri('Terbilang: '+terbilang1));
		   applet.append(this.kiri('           '+terbilang2));
		   
		   
		   //ttd
		   applet.append(this.tengah('Nama Petugas',36)+this.kiri(' ',24)+this.tengah('Nama Kasir',36));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.tengah('('+namakiri+')',36)+this.kiri(' ',24)+this.tengah('('+namakanan+')',36));
		   
		   //applet.append("\x1D\x56\x41"); // 4
		   //applet.append("\x1B\x40");
		   /*
		   applet.append("\x1B\x40"); // 1
			applet.append("\x1B\x21\x08");
			applet.append(" International \r\n");
applet.append(" Company \r\n");
applet.append("\x1B\x21\x01"); // 3
//applet.append(" ************************************************** \r\n");
applet.append("font a\r\n");
applet.append("\x1B\x21\x02"); // 3
applet.append("font b\r\n");
applet.append("\x1B\x21\x03"); // 3
applet.append("font c\r\n");
applet.append("\x1B\x21\x04"); // 3
applet.append("font d\r\n");
applet.append("\x1B\x21\x05"); // 3
applet.append("font e\r\n");
applet.append("\x1B\x21\x06"); // 3
applet.append("font f\r\n");
applet.append("\x1B\x21\x07"); // 3
applet.append("font g\r\n");
applet.append("\x1B\x21\x08"); // 3
applet.append("font 8\r\n");
applet.append("\x1B\x21\x09"); // 3
applet.append("font 9\r\n");
applet.append("\x1B\x21\x0A"); // 3
applet.append("font 10\r\n");
applet.append("\x1B\x21\x0B"); // 3
applet.append("font 11\r\n");
applet.append("\x1B\x21\x0C"); // 3
applet.append("font 12\r\n");
applet.append("\x1B\x21\x0D"); // 3
applet.append("font 13\r\n");
applet.append("\x1B\x21\x0E"); // 3
applet.append("font 14\r\n");
applet.append("\x1B\x21\x0F"); // 3
applet.append("font 15\r\n");
applet.append("\x1D\x56\x41"); // 4
applet.append("\x1B\x40"); // 5
*/
		   applet.print();
	    }
	}
	
	this.initial = function(){	
		//change param default	
		for (var name in this.params) {
			eval( 'if(this.params.'+name+' != null) this.'+name+'= this.params.'+name+'; ');
		}
	}
	this.initial();
}

 var printbil = new RawPrintObj({
	prefix : 'printbil',
	
	printkartu : function(content) {
		var nama = content.nama;//'nama nya';
		var norm = content.no_rm;
		var alamat = content.alamat;
		var tgl_lahir = content.tgl_lahir; //max 35
		var pekerjaan = content.pekerjaan;
		var gol_darah = content.gol_darah;
		
	     var applet = document.jzebra;
	     if (applet != null) {
	       applet.findPrinter('Generic Text');
		   //applet.append("\x1B\x21\x08"); // 80 char bold
		   //applet.append('RSUD AL IHSAN PROVINSI JAWA BARAT'+this.kanan(judul,47));
		   //applet.append("\x1B\x21\x01"); //96 char
		   //applet.append('\r\n');
		   applet.append('\r\n');		   
		   applet.append('\r\n');		   
		   applet.append('\r\n');
		   applet.append('\r\n');
		   applet.append(this.kanan('',15)+this.kiri(norm,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(noreg,28));
		   applet.append(this.kanan('',15)+this.kiri(nama,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(tanggal,28));
		   applet.append(this.kanan('',15)+this.kiri(tgl_lahir,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(dokter,28));
		   applet.append(this.kanan('',15)+this.kiri(alamat,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(carabayar,28));
		   applet.append(this.kanan('',15)+this.kiri(pekerjaan,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(penjamin,28));
		   applet.append(this.kanan('',15)+this.kiri(gol_darah,30));applet.append('\r\n');//+this.kanan('',13)+' : '+this.kiri(nopenjamin,28));
		   
		   //header table
		   /*applet.append('123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456');		   
		   applet.append(this.repeatChar('-', 96));		   
		  applet.append('No.| Kode |                      Uraian                 | Qty | Harga Sat |      Jumlah(Rp)     ');
		  applet.append(this.repeatChar('-', 96));
		   
		   body tabel
		  no = '1'; kode='kd1'; uraian = content.uraian; qty=content.qty; hrgsat=content.harga_sat; jml=content.total; 
		   applet.append(this.kanan(no,3)+'|'+this.tengah(kode,6) +'|'+ this.kiri(uraian,45)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,11)+'|'+this.kanan(jml,21));
		   	for(var i=0;i<content.rows.length;i++){
				no=content.rows[i].no;
				kode=content.rows[i].kode;
				uraian=content.rows[i].uraian;
				qty=content.rows[i].Qty;
				hrgsat=content.rows[i].hargasat;
				jml=content.rows[i].jml;
				applet.append(this.kanan(no,3)+'|'+this.tengah(kode,6) +'|'+ this.kiri(uraian,45)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,11)+'|'+this.kanan(jml,21));
				
				for(var x=0;x<content.rows[i].det.length;x++){
					no2=content.rows[i].det[x].no;
					kode2=content.rows[i].det[x].kode;
					uraian2=content.rows[i].det[x].uraian;
					qty2=content.rows[i].det[x].Qty;
					hrgsat2=content.rows[i].det[x].hargasat;
					jml2=content.rows[i].det[x].jml;
					applet.append(this.kanan(no2,3)+'|'+this.tengah(kode2,6) +'|'+ this.kiri(uraian2,45)+'|'+ this.kanan(qty2,5)+'|'+this.kanan(hrgsat2,11)+'|'+this.kanan(jml2,21));
				}
			}
		   //footer table
		   tot=content.total;
		   terbilang1 = content.bilang1;
		   terbilang2 = content.bilang2;
		   namakiri = content.nm_petugas;
		   namakanan= content.nm_petugas;
		   
		   applet.append(this.kiri(' ',96));
		   applet.append(this.repeatChar('-', 96));	
		   	   
		   applet.append('                                                              Total (Rp)   '+ this.kanan(tot,21));
		   applet.append(this.kiri('Terbilang: '+terbilang1));
		   applet.append(this.kiri('           '+terbilang2));
		   
		   
		   //ttd
		   applet.append(this.tengah('Nama Petugas',36)+this.kiri(' ',24)+this.tengah('Nama Kasir',36));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.tengah('('+namakiri+')',36)+this.kiri(' ',24)+this.tengah('('+namakanan+')',36));*/
		   
		   applet.append("\x1B\x21\x08"); // 3
		   //applet.append("\x1B\x40");
/*--------------------------------ini dicomment
		   applet.append("\x1B\x40"); // 1
			applet.append("\x1B\x21\x08");
			applet.append(" International \r\n");
applet.append(" Company \r\n");
applet.append("\x1B\x21\x01"); // 3
//applet.append(" ************************************************** \r\n");
applet.append("font a\r\n");
applet.append("\x1B\x21\x02"); // 3
applet.append("font b\r\n");
applet.append("\x1B\x21\x03"); // 3
applet.append("font c\r\n");
applet.append("\x1B\x21\x04"); // 3
applet.append("font d\r\n");
applet.append("\x1B\x21\x05"); // 3
applet.append("font e\r\n");
applet.append("\x1B\x21\x06"); // 3
applet.append("font f\r\n");
applet.append("\x1B\x21\x07"); // 3
applet.append("font g\r\n");
applet.append("\x1B\x21\x08"); // 3
applet.append("font 8\r\n");
applet.append("\x1B\x21\x09"); // 3
applet.append("font 9\r\n");
applet.append("\x1B\x21\x0A"); // 3
applet.append("font 10\r\n");
applet.append("\x1B\x21\x0B"); // 3
applet.append("font 11\r\n");
applet.append("\x1B\x21\x0C"); // 3
applet.append("font 12\r\n");
applet.append("\x1B\x21\x0D"); // 3
applet.append("font 13\r\n");
applet.append("\x1B\x21\x0E"); // 3
applet.append("font 14\r\n");
applet.append("\x1B\x21\x0F"); // 3
applet.append("font 15\r\n");
applet.append("\x1D\x56\x41"); // 4
applet.append("\x1B\x40"); // 5*/

		   applet.print();
	    }
	}
	
}); 

