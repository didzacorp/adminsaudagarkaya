var printbil = new RawPrintObj({
	prefix : 'printbil',
	
	printt : function(content) {
		var nama = content.nama;//'nama nya';
		var noreg = content.norg;
		var norm = content.no_rm;
		var alamat1 = content.alamat; //max 35
		var alamat2 = content.kecamatan;
		var alamat3 = content.kota;
		var tanggal =content.tanggal;
		var carabayar= content.cara_bayar;
		var telp=content.telp;
		var penjamin=content.penjamin;
		var dokter = content.dokter;
		var nopenjamin=content.no_penjamin;
		var jml_cetak=content.jml_cetak;
		var judul = content.rows[0].judul;
		
	     var applet = document.jzebra;
	     if (applet != null) {
	       applet.findPrinter('Generic Text');
		   applet.append("\x1B\x21\x08"); // 80 char bold
		   applet.append('RSUD AL IHSAN PROVINSI JAWA BARAT'+this.kanan(judul,47));
		   applet.append("\x1B\x21\x01"); //96 char
		   
		   if(jml_cetak == '1'){
			   applet.append('Jl. Kiastramanggala Baleendah Kab. Bandung\r\n');		   
		   }else{
			   applet.append('Jl. Kiastramanggala Baleendah Kab. Bandung'+this.kanan('Salinan ke-'+jml_cetak,47));		   
		   }
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
		   //applet.append('123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456');		   
		   applet.append(this.repeatChar('-', 96));		   
		   applet.append('No.|   Kode   |                  Uraian                  | Qty | Harga Sat  |     Jumlah(Rp)    ');
		   applet.append(this.repeatChar('-', 96));
		   
		   //body tabel
		  // no = '1'; kode='kd1'; uraian = content.uraian; qty=content.qty; hrgsat=content.harga_sat; jml=content.total; 
		  // applet.append(this.kanan(no,3)+'|'+this.tengah(kode,6) +'|'+ this.kiri(uraian,45)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,11)+'|'+this.kanan(jml,21));
		   	for(var i=0;i<content.rows.length;i++){
				no=content.rows[i].no;
				kode=content.rows[i].kode;
				uraian=content.rows[i].uraian;
				qty=content.rows[i].Qty;
				hrgsat=content.rows[i].hargasat;
				jml=content.rows[i].jml;
				applet.append(this.kanan(no,3)+'|'+this.tengah(kode,10) +'|'+ this.kiri(uraian,42)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,12)+'|'+this.kanan(jml,19));
				
				if(content.rows[i].det){
					for(var x=0;x<content.rows[i].det.length;x++){
						no2=content.rows[i].det[x].no;
						kode2=content.rows[i].det[x].kode;
						uraian2=content.rows[i].det[x].uraian+' '+content.rows[i].det[x].uraian.length.toString();
						qty2=content.rows[i].det[x].Qty;
						hrgsat2=content.rows[i].det[x].hargasat;
						jml2=content.rows[i].det[x].jml;
						applet.append(this.kanan(no2,3)+'|'+this.tengah(kode2,10) +'|'+ this.kiri(uraian2,42)+'|'+ this.kanan(qty2,5)+'|'+this.kanan(hrgsat2,12)+'|'+this.kanan(jml2,19));
					}
				}
			}
		   //footer table
		   tot=content.rows[0].total;
		   terbilang1 = content.rows[0].bilang1;
		   terbilang2 = content.rows[0].bilang2;
		   namakiri = content.nama;
		   namakanan= content.nm_petugas;
		   
		   applet.append(this.kiri(' ',96));
		   applet.append(this.repeatChar('-', 96));	
		   	   
		   applet.append('                                                                Total (Rp)   '+ this.kanan(tot,19));
		   applet.append(this.kiri('Terbilang: '+terbilang1));
		   applet.append(this.kiri('           '+terbilang2));
		   
		   
		   //ttd
		   applet.append(this.tengah('Nama Pasien',36)+this.kiri(' ',24)+this.tengah('Nama Kasir',36));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.kiri(' '));
		   applet.append(this.tengah('('+namakiri+')',36)+this.kiri(' ',24)+this.tengah('('+namakanan+')',36));
		   
		   if(content.row_piutang != null){
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
			   applet.append(this.kanan(' ',14)+'   '+this.kiri(alamat2,35)    				+this.kanan('  Cara Bayar',13)+' : '+this.kiri(content.row_piutang[0].cara_bayar,28));
			   applet.append(this.kanan(' ',14)+' : '+this.kiri(alamat3,35)					+this.kanan('    Penjamin',13)+' : '+this.kiri(penjamin,28));
			   applet.append(this.kanan('Telp/Hp',14)+' : '+this.kiri(telp,35)     			+this.kanan('No. Penjamin',13)+' : '+this.kiri(nopenjamin,28));
			   
			   //header table
			   //applet.append('123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456789 123456');		   
			   applet.append(this.repeatChar('-', 96));		   
			   applet.append('No.|   Kode   |                  Uraian                  | Qty | Harga Sat  |     Jumlah(Rp)    ');
			   applet.append(this.repeatChar('-', 96));
			   
			   //body tabel
			  // no = '1'; kode='kd1'; uraian = content.uraian; qty=content.qty; hrgsat=content.harga_sat; jml=content.total; 
			  // applet.append(this.kanan(no,3)+'|'+this.tengah(kode,6) +'|'+ this.kiri(uraian,45)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,11)+'|'+this.kanan(jml,21));
			   	for(var i=0;i<content.row_piutang.length;i++){
					no=content.row_piutang[i].no;
					kode=content.row_piutang[i].kode;
					uraian=content.row_piutang[i].uraian;
					qty=content.row_piutang[i].Qty;
					hrgsat=content.row_piutang[i].hargasat;
					jml=content.row_piutang[i].jml;
					applet.append(this.kanan(no,3)+'|'+this.tengah(kode,10) +'|'+ this.kiri(uraian,42)+'|'+ this.kanan(qty,5)+'|'+this.kanan(hrgsat,12)+'|'+this.kanan(jml,19));
					
					if(content.row_piutang[i].det){
						for(var x=0;x<content.row_piutang[i].det.length;x++){
							no2=content.row_piutang[i].det[x].no;
							kode2=content.row_piutang[i].det[x].kode;
							uraian2=content.row_piutang[i].det[x].uraian+' '+content.row_piutang[i].det[x].uraian.length.toString();
							qty2=content.row_piutang[i].det[x].Qty;
							hrgsat2=content.row_piutang[i].det[x].hargasat;
							jml2=content.row_piutang[i].det[x].jml;
							applet.append(this.kanan(no2,3)+'|'+this.tengah(kode2,10) +'|'+ this.kiri(uraian2,42)+'|'+ this.kanan(qty2,5)+'|'+this.kanan(hrgsat2,12)+'|'+this.kanan(jml2,19));
						}
					}
				}
			   //footer table
			   tot=content.row_piutang[0].total;
			   terbilang1 = content.row_piutang[0].terbilang1;
			   terbilang2 = content.row_piutang[0].terbilang2;
			   namakiri = content.nama;
			   namakanan= content.nm_petugas;
			   
			   applet.append(this.kiri(' ',96));
			   applet.append(this.repeatChar('-', 96));	
			   	   
			   applet.append('                                                                Total (Rp)   '+ this.kanan(tot,19));
			   applet.append(this.kiri('Terbilang: '+terbilang1));
			   applet.append(this.kiri('           '+terbilang2));
			   
			   
			   //ttd
			   applet.append(this.tengah('Nama Pasien',36)+this.kiri(' ',24)+this.tengah('Nama Kasir',36));
			   applet.append(this.kiri(' '));
			   applet.append(this.kiri(' '));
			   applet.append(this.kiri(' '));
			   applet.append(this.tengah('('+namakiri+')',36)+this.kiri(' ',24)+this.tengah('('+namakanan+')',36));
		   }
		   
		   applet.print();
	    }
	},
	
	printpreview : function(content) {
		var judul = content.rows[0].judul;
		var nama = content.nama;//'nama nya';
		var noreg = content.norg;
		var norm = content.no_rm;
		var alamat1 = content.alamat; //max 35
		var alamat2 = content.kecamatan;
		var alamat3 = content.kota;
		var tanggal =content.tanggal;
		var carabayar= content.cara_bayar;
		var telp=content.telp;
		var penjamin=content.penjamin;
		var dokter = content.dokter;
		var nopenjamin=content.no_penjamin;
		

		   var str = '<B>'+'RSUD AL IHSAN PROVINSI JAWA BARAT'+this.kanan(judul,62,'&nbsp;')+'</B>'+'<br>' ;
		   str += 'Jl. Kiastramanggala Baleendah Kab. Bandung\r\n'+'<br>';		   
		   str += 'Telp. (022) 5940872, 5940875, 5941719\r\n'+'<br>';		   
		   str += '\r\n'+'<br>';
		   str += 'Sudah diterima dari,\r\n'+'<br>';
		   str += this.kanan('Nama Pasien',14,'&nbsp;')+' : '+this.kiri(nama,32,'&nbsp;')+'(L)'	+this.kanan('No. Faktur',13,'&nbsp;')+' : '+this.kiri(noreg,28,'&nbsp;')+'<br>';
		   str += this.kanan('No. RM',14,'&nbsp;')+' : '+this.kiri(norm,35,'&nbsp;')    			+this.kanan('Tanggal',13,'&nbsp;')+' : '+this.kiri(tanggal,28,'&nbsp;')+'<br>';
		   if(content.dokter.length != null){
		   		if(content.dokter.length == 1){
				   	str += this.kanan('Alamat Pasien',14,'&nbsp;')+' : '+this.kiri(alamat1,35,'&nbsp;')    	+this.kanan('Dokter',13,'&nbsp;')+' : '+this.kiri(content.dokter[0].dokter,28,'&nbsp;')+'<br>';
				   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat2,35,'&nbsp;')    				+this.kanan('Cara Bayar',13,'&nbsp;')+' : '+this.kiri(carabayar,28,'&nbsp;')+'<br>';
				   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat3,35,'&nbsp;')					+this.kanan('Penjamin',13,'&nbsp;')+' : '+this.kiri(penjamin,28,'&nbsp;')+'<br>';
				   	str += this.kanan('Telp/Hp',14,'&nbsp;')+' : '+this.kiri(telp,35,'&nbsp;')     			+this.kanan('No. Penjamin',13,'&nbsp;')+' : '+this.kiri(nopenjamin,28,'&nbsp;')+'<br>';
			   }else{
				   	str += this.kanan('Cara Bayar',14,'&nbsp;')+' : '+this.kiri(carabayar,35,'&nbsp;')    	+this.kanan('Dokter',13,'&nbsp;')+' : '+this.kiri(content.dokter[0].dokter,28,'&nbsp;')+'<br>';
				  	for(var a=1;a<content.dokter.length;a++){
						dok = content.dokter[a].dokter;
				   		str += this.kanan('',14,'&nbsp;')+'  '+this.kiri('',35,'&nbsp;')    	+this.kanan('',17,'&nbsp;')+'  '+this.kiri(dok,28,'&nbsp;')+'<br>';
					}
				   	str += this.kanan('Alamat Pasien',14,'&nbsp;')+' : '+this.kiri(alamat1,35,'&nbsp;')    	+this.kanan('Penjamin',13,'&nbsp;')+' : '+this.kiri(penjamin,28,'&nbsp;')+'<br>';
					str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat2,35,'&nbsp;')    				+this.kanan('No. Penjamin',13,'&nbsp;')+' : '+this.kiri(nopenjamin,28,'&nbsp;')+'<br>';
				   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat3,35,'&nbsp;')					+'<br>';
				   	str += this.kanan('Telp/Hp',14,'&nbsp;')+' : '+this.kiri(telp,35,'&nbsp;')     			+'<br>';
			   }
		   }
		   
		   
		  	

			
		   str += this.repeatChar('-', 96)+'<br>';		   
		   str += this.kanan('No',3,'&nbsp;')+'|'+this.tengah('kode',10,'&nbsp;') +'|'+ this.tengah('Uraian',42,'&nbsp;')+'|'+ this.kanan('Qty',5,'&nbsp;')+'|'+this.kanan('Harga Sat',12,'&nbsp;')+'|'+this.kanan('Jumlah(Rp)',19,'&nbsp;')+'<br>';
		   str += this.repeatChar('-', 96)+'<br>';
		   

		   	for(var i=0;i<content.rows.length;i++){
				no=content.rows[i].no;
				kode=content.rows[i].kode;
				uraian=content.rows[i].uraian;
				qty=content.rows[i].Qty;
				hrgsat=content.rows[i].hargasat;
				jml=content.rows[i].jml;
				str += this.kanan(no,3,'&nbsp;')+'|'+this.tengah(kode,10,'&nbsp;') +'|'+ this.kiri(uraian,42,'&nbsp;')+'|'+ this.kanan(qty,5,'&nbsp;')+'|'+this.kanan(hrgsat,12,'&nbsp;')+'|'+this.kanan(jml,19,'&nbsp;')+'<br>';
				
				if(content.rows[i].det){
					for(var x=0;x<content.rows[i].det.length;x++){
						no2=content.rows[i].det[x].no;
						kode2=content.rows[i].det[x].kode;
						uraian2=content.rows[i].det[x].uraian+' '+content.rows[i].det[x].uraian.length.toString();
						qty2=content.rows[i].det[x].Qty;
						hrgsat2=content.rows[i].det[x].hargasat;
						jml2=content.rows[i].det[x].jml;
						str += this.kanan(no2,3,'&nbsp;')+'|'+this.tengah(kode2,10,'&nbsp;') +'|'+ this.kiri(uraian2,42,'&nbsp;')+'|'+ this.kanan(qty2,5,'&nbsp;')+'|'+this.kanan(hrgsat2,12,'&nbsp;')+'|'+this.kanan(jml2,19,'&nbsp;')+'<br>';
					}
				}
			}
		   //footer table
		   tot=content.rows[0].total;
		   terbilang1 = content.rows[0].bilang1;
		   terbilang2 = content.rows[0].bilang2;
		   namakiri = content.nama;
		   namakanan= content.nm_petugas;
		   
		   str += this.kiri(' ',96,'&nbsp;')+'<br>';
		   str += this.repeatChar('-', 96)+'<br>';	
		   	   
		   //str += '                                                              Total (Rp)   '+ this.kanan(tot,21,'&nbsp;')+'<br>';
		   str += this.kanan('',3,'&nbsp;')+' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('',42,'&nbsp;')+' '+ this.kanan('',5,'&nbsp;')+' '+this.kanan('Total (Rp)',12,'&nbsp;')+' '+this.kanan(tot,19,'&nbsp;')+'<br>';
		   str += this.kiri('Terbilang: '+terbilang1)+'<br>';
		   str += this.kiri('           '+terbilang2)+'<br>';
		   
		   
		   //ttd
		   str += this.tengah('Nama Pasien',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('Nama Kasir',36,'&nbsp;')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.tengah('('+namakiri+')',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('('+namakanan+')',36,'&nbsp;')+'<br>';
		   
		   document.getElementById('divcontent').innerHTML = str;
		   
		   if(content.row_piutang != null){
				   var str = '<B>'+'RSUD AL IHSAN PROVINSI JAWA BARAT'+this.kanan(judul,62,'&nbsp;')+'</B>'+'<br>' ;
				   str += 'Jl. Kiastramanggala Baleendah Kab. Bandung\r\n'+'<br>';		   
				   str += 'Telp. (022) 5940872, 5940875, 5941719\r\n'+'<br>';		   
				   str += '\r\n'+'<br>';
				   str += 'Sudah diterima dari,\r\n'+'<br>';
				   str += this.kanan('Nama Pasien',14,'&nbsp;')+' : '+this.kiri(nama,32,'&nbsp;')+'(L)'	+this.kanan('No. Faktur',13,'&nbsp;')+' : '+this.kiri(noreg,28,'&nbsp;')+'<br>';
				   str += this.kanan('No. RM',14,'&nbsp;')+' : '+this.kiri(norm,35,'&nbsp;')    			+this.kanan('Tanggal',13,'&nbsp;')+' : '+this.kiri(tanggal,28,'&nbsp;')+'<br>';
				   if(content.dokter.length == 1){
					   	str += this.kanan('Alamat Pasien',14,'&nbsp;')+' : '+this.kiri(alamat1,35,'&nbsp;')    	+this.kanan('Dokter',13,'&nbsp;')+' : '+this.kiri(content.dokter[0].dokter,28,'&nbsp;')+'<br>';
					   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat2,35,'&nbsp;')    				+this.kanan('Cara Bayar',13,'&nbsp;')+' : '+this.kiri(carabayar,28,'&nbsp;')+'<br>';
					   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat3,35,'&nbsp;')					+this.kanan('Penjamin',13,'&nbsp;')+' : '+this.kiri(penjamin,28,'&nbsp;')+'<br>';
					   	str += this.kanan('Telp/Hp',14,'&nbsp;')+' : '+this.kiri(telp,35,'&nbsp;')     			+this.kanan('No. Penjamin',13,'&nbsp;')+' : '+this.kiri(nopenjamin,28,'&nbsp;')+'<br>';
				   }else{
					   	str += this.kanan('Cara Bayar',14,'&nbsp;')+' : '+this.kiri(carabayar,35,'&nbsp;')    	+this.kanan('Dokter',13,'&nbsp;')+' : '+this.kiri(content.dokter[0].dokter,28,'&nbsp;')+'<br>';
					  	for(var a=1;a<content.dokter.length;a++){
							dok = content.dokter[a].dokter;
					   		str += this.kanan('',14,'&nbsp;')+'  '+this.kiri('',35,'&nbsp;')    	+this.kanan('',17,'&nbsp;')+'  '+this.kiri(dok,28,'&nbsp;')+'<br>';
						}
					   	str += this.kanan('Alamat Pasien',14,'&nbsp;')+' : '+this.kiri(alamat1,35,'&nbsp;')    	+this.kanan('Penjamin',13,'&nbsp;')+' : '+this.kiri(penjamin,28,'&nbsp;')+'<br>';
						str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat2,35,'&nbsp;')    				+this.kanan('No. Penjamin',13,'&nbsp;')+' : '+this.kiri(nopenjamin,28,'&nbsp;')+'<br>';
					   	str += this.kanan('',16,'&nbsp;')+'   '+this.kiri(alamat3,35,'&nbsp;')					+'<br>';
					   	str += this.kanan('Telp/Hp',14,'&nbsp;')+' : '+this.kiri(telp,35,'&nbsp;')     			+'<br>';
				   }
				   

				   str += this.repeatChar('-', 96)+'<br>';		   
				   str += this.kanan('No',3,'&nbsp;')+'|'+this.tengah('kode',10,'&nbsp;') +'|'+ this.tengah('Uraian',42,'&nbsp;')+'|'+ this.kanan('Qty',5,'&nbsp;')+'|'+this.kanan('Harga Sat',12,'&nbsp;')+'|'+this.kanan('Jumlah(Rp)',19,'&nbsp;')+'<br>';
				   str += this.repeatChar('-', 96)+'<br>';
				   

				   	for(var i=0;i<content.row_piutang.length;i++){
						no=content.row_piutang[i].no;
						kode=content.row_piutang[i].kode;
						uraian=content.row_piutang[i].uraian;
						qty=content.row_piutang[i].Qty;
						hrgsat=content.row_piutang[i].hargasat;
						jml=content.row_piutang[i].jml;
						str += this.kanan(no,3,'&nbsp;')+'|'+this.tengah(kode,10,'&nbsp;') +'|'+ this.kiri(uraian,42,'&nbsp;')+'|'+ this.kanan(qty,5,'&nbsp;')+'|'+this.kanan(hrgsat,12,'&nbsp;')+'|'+this.kanan(jml,19,'&nbsp;')+'<br>';
						
						if(content.row_piutang[i].det){
							for(var x=0;x<content.row_piutang[i].det.length;x++){
								no2=content.row_piutang[i].det[x].no;
								kode2=content.row_piutang[i].det[x].kode;
								uraian2=content.row_piutang[i].det[x].uraian+' '+content.row_piutang[i].det[x].uraian.length.toString();
								qty2=content.row_piutang[i].det[x].Qty;
								hrgsat2=content.row_piutang[i].det[x].hargasat;
								jml2=content.row_piutang[i].det[x].jml;
								str += this.kanan(no2,3,'&nbsp;')+'|'+this.tengah(kode2,10,'&nbsp;') +'|'+ this.kiri(uraian2,42,'&nbsp;')+'|'+ this.kanan(qty2,5,'&nbsp;')+'|'+this.kanan(hrgsat2,12,'&nbsp;')+'|'+this.kanan(jml2,19,'&nbsp;')+'<br>';
							}
						}
					}
					
				   //footer table
				   tot=content.row_piutang[0].total;
				   terbilang1 = content.row_piutang[0].terbilang1;
				   terbilang2 = content.row_piutang[0].terbilang2;
				   namakiri = content.nama;
				   namakanan= content.nm_petugas;
				   
				   str += this.kiri(' ',96,'&nbsp;')+'<br>';
				   str += this.repeatChar('-', 96)+'<br>';	
				   	   
				   str += this.kanan('',3,'&nbsp;')+' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('',42,'&nbsp;')+' '+ this.kanan('',5,'&nbsp;')+' '+this.kanan('Total (Rp)',12,'&nbsp;')+' '+this.kanan(tot,19,'&nbsp;')+'<br>';
				   str += this.kiri('Terbilang: '+terbilang1)+'<br>';
				   str += this.kiri('           '+terbilang2)+'<br>';
				   
				   
				   //ttd
				   str += this.tengah('Nama Pasien',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('Nama Kasir',36,'&nbsp;')+'<br>';
				   str += this.kiri(' ')+'<br>';
				   str += this.kiri(' ')+'<br>';
				   str += this.kiri(' ')+'<br>';
				   str += this.tengah('('+namakiri+')',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('('+namakanan+')',36,'&nbsp;')+'<br>';
		   
		   document.getElementById('divcontent2').innerHTML = str;
		  
		   }

	},

	transaksirjpreview : function(content) {
		var judul = 'RSUD AL-IHSAN';
		var tgl1 = content.tgl1;
		var bln1 = content.bln1;
		var thn1 = content.thn1;
		var tgl2 = content.tgl2;
		var bln2 = content.bln2;
		var thn2 = content.thn2;
		var jam1 = content.jam1;
		var jam2 = content.jam2;
		var menit1 = content.menit1
		var menit2 = content.menit2;
		var kelompok = content.kelompok;
		var jns_kunj = content.jns_kunjungan;
		var kunj = jns_kunj.toUpperCase();
		if(kunj == 'RAWAT INAP'){
			var uraian = 'RUANG';
		}else{
			uraian = 'KLINIK';
		}
		
		//kop table
		var str = '<B>'+'Lap. Transaksi Kasir '+this.kiri(jns_kunj,11)+' (Non Pasien AsKes)'+this.kanan(judul,40,'&nbsp;')+'</B>'+'<br>' ;
		str += 'Berdasarkan Nama Kelompok\r\n'+'<br>';		   
		str += 'Per Tanggal & Jam : Tanggal :'+this.kiri(tgl1+'/'+bln1+'/'+thn1,11,'&nbsp;')+this.kiri('Jam',4,'&nbsp;')+this.kiri(jam1+':'+menit1+':00 s/d',13,'&nbsp;')+this.kiri(jam2+':'+menit2+':00',39,'&nbsp;')+'<br>';		   
		str += '\r\n'+'<br>';

		//table
		if(content.rows != null){
			//header table
			carabayar1=content.rows[0].cara_bayar;
			str += this.repeatChar('-', 96)+'<br>';		   
			str += this.kiri(kelompok,14,'&nbsp;')+' : '+this.kiri(carabayar1,32,'&nbsp;')+'<br>';
			str += this.repeatChar('-', 96)+'<br>';
		    str += this.kiri('NO',3,'&nbsp;')+' '+this.kiri('NO FAKTUR',10,'&nbsp;') +' '+this.tengah('NO MEDREK',10,'&nbsp;') +' '+ this.kiri('NAMA PASIEN',25,'&nbsp;')+' '+ this.tengah('RUPIAH(RP)',13,'&nbsp;')+' '+this.kiri(uraian,12,'&nbsp;')+'<br>';
		    str += this.repeatChar('-', 96)+'<br>';		   
			
				for(var i=0;i<content.rows.length;i++){
					no=content.rows[i].no;
					faktur=content.rows[i].no_faktur;
					norm=content.rows[i].no_rm;
					nama=content.rows[i].nama_pasien;
					jml=content.rows[i].jml;
					klinik=content.rows[i].klinik;

				   str += this.kiri(no,3,'&nbsp;')+' '+this.kiri(faktur,10,'&nbsp;') +' '+this.tengah(norm,10,'&nbsp;') +' '+ this.kiri(nama,25,'&nbsp;')+' '+ this.kanan(jml,13,'&nbsp;')+' '+this.kiri(klinik,12,'&nbsp;')+'<br>';

				}
				
			//footer table
			tot1=content.rows[0].total;

			str += this.repeatChar('-', 96)+'<br>';	
			str += this.kiri('',3,'&nbsp;')+' '+this.kiri('',10,'&nbsp;') +' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('TOTAL '+content.rows[0].cara_bayar,25,'&nbsp;')+':'+ this.kanan(tot1,13,'&nbsp;')+' '+this.kiri('',12,'&nbsp;')+'<br>';
		}	

		if(content.rows2 != null){
			//header table
			carabayar2=content.rows2[0].cara_bayar;
			str += this.repeatChar('-', 96)+'<br>';		   
			str += this.kiri(kelompok,14,'&nbsp;')+' : '+this.kiri(carabayar2,32,'&nbsp;')+'<br>';
			str += this.repeatChar('-', 96)+'<br>';
			str += this.kiri('NO',3,'&nbsp;')+' '+this.kiri('NO FAKTUR',10,'&nbsp;') +' '+this.tengah('NO MEDREK',10,'&nbsp;') +' '+ this.kiri('NAMA PASIEN',25,'&nbsp;')+' '+ this.tengah('RUPIAH(RP)',13,'&nbsp;')+' '+this.kiri(uraian,12,'&nbsp;')+'<br>';
			str += this.repeatChar('-', 96)+'<br>';		   
				
				for(var i=0;i<content.rows2.length;i++){
					no=content.rows2[i].no;
					faktur=content.rows2[i].no_faktur;
					norm=content.rows2[i].no_rm;
					nama=content.rows2[i].nama_pasien;
					jml=content.rows2[i].jml;
					klinik=content.rows2[i].klinik;
	
					str += this.kiri(no,3,'&nbsp;')+' '+this.kiri(faktur,10,'&nbsp;') +' '+this.tengah(norm,10,'&nbsp;') +' '+ this.kiri(nama,25,'&nbsp;')+' '+ this.kanan(jml,13,'&nbsp;')+' '+this.kiri(klinik,12,'&nbsp;')+'<br>';
	
				}
				
			//footer table
			tot2=content.rows2[0].total;

			str += this.repeatChar('-', 96)+'<br>';	
			str += this.kiri('',3,'&nbsp;')+' '+this.kiri('',10,'&nbsp;') +' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('TOTAL '+content.rows2[0].cara_bayar,25,'&nbsp;')+':'+ this.kanan(tot2,13,'&nbsp;')+' '+this.kiri('',12,'&nbsp;')+'<br>';
		}
		    
		if(content.rows3 != null){
			//header table
			carabayar3 = content.rows3[0].cara_bayar;
			str += this.repeatChar('-', 96)+'<br>';		   
			str += this.kiri(kelompok,14,'&nbsp;')+' : '+this.kiri(carabayar3,32,'&nbsp;')+'<br>';
			str += this.repeatChar('-', 96)+'<br>';
			str += this.kiri('NO',3,'&nbsp;')+' '+this.kiri('NO FAKTUR',10,'&nbsp;') +' '+this.tengah('NO MEDREK',10,'&nbsp;') +' '+ this.kiri('NAMA PASIEN',25,'&nbsp;')+' '+ this.tengah('RUPIAH(RP)',13,'&nbsp;')+' '+this.kiri(uraian,12,'&nbsp;')+'<br>';
			str += this.repeatChar('-', 96)+'<br>';		   
			
				for(var i=0;i<content.rows3.length;i++){
					no=content.rows3[i].no;
					faktur=content.rows3[i].no_faktur;
					norm=content.rows3[i].no_rm;
					nama=content.rows3[i].nama_pasien;
					jml=content.rows3[i].jml;
					klinik=content.rows3[i].klinik;
	
					str += this.kiri(no,3,'&nbsp;')+' '+this.kiri(faktur,10,'&nbsp;') +' '+this.tengah(norm,10,'&nbsp;') +' '+ this.kiri(nama,25,'&nbsp;')+' '+ this.kanan(jml,13,'&nbsp;')+' '+this.kiri(klinik,12,'&nbsp;')+'<br>';
	
				}
				
			//footer table
			tot3=content.rows3[0].total;
					   
			str += this.repeatChar('-', 96)+'<br>';	
			str += this.kiri('',3,'&nbsp;')+' '+this.kiri('',10,'&nbsp;') +' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('TOTAL '+content.rows3[0].cara_bayar,25,'&nbsp;')+':'+ this.kanan(tot3,13,'&nbsp;')+' '+this.kiri('',12,'&nbsp;')+'<br>';
		}
			
		if(content.rows4 != null){
			for(var i=0; i<content.rows4.length;i++){
				//header table
				str += this.repeatChar('-', 96)+'<br>';		   
				str += this.kiri(kelompok,14,'&nbsp;')+' : '+this.kiri(content.rows4[i].jenis,32,'&nbsp;')+'<br>';
				str += this.repeatChar('-', 96)+'<br>';
				str += this.kiri('NO',3,'&nbsp;')+' '+this.kiri('NO FAKTUR',10,'&nbsp;') +' '+this.tengah('NO MEDREK',10,'&nbsp;') +' '+ this.kiri('NAMA PASIEN',25,'&nbsp;')+' '+ this.tengah('RUPIAH(RP)',13,'&nbsp;')+' '+this.kiri(uraian,12,'&nbsp;')+'<br>';
				str += this.repeatChar('-', 96)+'<br>';		   
					
					if(content.rows4[i].det){
						for(var x=0;x<content.rows4[i].det.length;x++){
							no=content.rows4[i].det[x].no;
							faktur=content.rows4[i].det[x].no_faktur;
							norm=content.rows4[i].det[x].no_rm;
							nama=content.rows4[i].det[x].nama_pasien;
							jml=content.rows4[i].det[x].jml;
							klinik=content.rows4[i].det[x].klinik;
							
							str += this.kiri(no,3,'&nbsp;')+' '+this.kiri(faktur,10,'&nbsp;') +' '+this.tengah(norm,10,'&nbsp;') +' '+ this.kiri(nama,25,'&nbsp;')+' '+ this.kanan(jml,13,'&nbsp;')+' '+this.kiri(klinik,12,'&nbsp;')+'<br>';
						}
					}
					
				//footer table
				tot4=content.rows4[i].total;
					   
				str += this.repeatChar('-', 96)+'<br>';	
				str += this.kiri('',3,'&nbsp;')+' '+this.kiri('',10,'&nbsp;') +' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('TOTAL',25,'&nbsp;')+':'+ this.kanan(tot4,13,'&nbsp;')+' '+this.kiri('',12,'&nbsp;')+'<br>';
				
				}
				
			}
			
			//TOTAL
			str += this.repeatChar('-', 96)+'<br>';
			str += this.kiri(' ')+'<br>';
			
			if(content.rows4 != null){
				var jmltot = 0;
				
				for(var a=0; a<content.rows4.length;a++){
				
					t = content.rows4[a].t;
					jmltot = parseFloat(t)+jmltot;
					total=content.rows4[a].total;
					jenis = content.rows4[a].jenis;
					
					str += this.kiri('TOTAL '+jenis,40,'&nbsp;')+' : '+this.kanan(t,17,'&nbsp;')+'<br>';

				}	
				
				jml = String(jmltot);
				
				str += this.repeatChar('-', 60)+'<br>';
				str += this.kiri('TOTAL TRANSAKSI (RP)',40,'&nbsp;')+' : '+this.kanan(jml+'.00',17,'&nbsp;')+'<br>';
				
			}else{
			
				
				if(content.rows != null){
					t1 = content.rows[0].t;
					carabayar1=content.rows[0].cara_bayar;
					str += this.kiri('TOTAL '+carabayar1,32,'&nbsp;')+' : '+this.kanan(t1,17,'&nbsp;')+'<br>';
				}else{
					t1 = 0;
				}
				
				if(content.rows2 != null){
					t2 = content.rows2[0].t;
					carabayar2=content.rows2[0].cara_bayar;
					str += this.kiri('TOTAL '+carabayar2,32,'&nbsp;')+' : '+this.kanan(t2,17,'&nbsp;')+'<br>';
				}else{
					t2 = 0;
				}
				
				if(content.rows3 != null){
					t3 = content.rows3[0].t;
					carabayar3=content.rows3[0].cara_bayar;
					str += this.kiri('TOTAL '+carabayar3,32,'&nbsp;')+' : '+this.kanan(t3,17,'&nbsp;')+'<br>';
				}else{
					t3 = 0;
				}
				
				jumlah = parseFloat(t1)+parseFloat(t2)+parseFloat(t3);
				jml = String(jumlah);
				str += this.repeatChar('-', 60)+'<br>';
				str += this.kiri('TOTAL TRANSAKSI (RP)',32,'&nbsp;')+' : '+this.kanan(jml+'.00',17,'&nbsp;')+'<br>';
			}
			
			//namakiri = content.nama;
			//namakanan= content.nm_petugas;
		    //ttd
			str += this.kiri(' ')+'<br>';
		    str += this.tengah('KEPALA KASIR',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('KASIR '+kunj,36,'&nbsp;')+'<br>';
		  	str += this.kiri(' ')+'<br>';
		  	str += this.kiri(' ')+'<br>';
		  	str += this.kiri(' ')+'<br>';
		  	str += this.tengah('('+'..........'+')',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('('+'.........'+')',36,'&nbsp;')+'<br>';
		   
		   document.getElementById('divcontent').innerHTML = str;

	},

	rincianpreview : function(content) {
		var nama = content.nama;//'nama nya';
		var norm = content.no_rm;
		var alamat1 = content.alamat; //max 35
		var alamat2 = content.kecamatan;
		var alamat3 = content.kota;
		var kunjungan = content.kunjungan;
		var klinik = content.klinik;
		var ruang = content.ruang;
		var kelas = content.kelas;
		var cara_bayar = content.cara_bayar;
		var penjamin = content.penjamin;
		var dokter = content.dokter;
		var judul = content.judul;
		var rekap = content.rekap;		

		   var str = this.kiri('',14,'&nbsp;')+this.tengah(judul,62,'&nbsp;')+'<br>' ;
		   str += this.kiri('No. RM',14,'&nbsp;')+' : '+this.kiri(norm,35,'&nbsp;')+this.kanan('Dokter',13,'&nbsp;')+' : '+this.kiri(dokter,28,'&nbsp;')+'<br>';
		   str += this.kiri('Nama Pasien',14,'&nbsp;')+' : '+this.kiri(nama,32,'&nbsp;')+'<br>';
		   str += this.kiri('Alamat Pasien',14,'&nbsp;')+' : '+this.kiri(alamat1,35,'&nbsp;')+'<br>';
		   str += this.kiri('',16,'&nbsp;')+'   '+this.kiri(alamat2,35,'&nbsp;')+'<br>';
		   str += this.kiri('',16,'&nbsp;')+'   '+this.kiri(alamat3,35,'&nbsp;')+'<br>';
		   str += this.kiri('Kunjungan',14,'&nbsp;')+' : '+this.kiri(kunjungan,35,'&nbsp;')+'<br>';
		   if(content.kunj == 2){
		   str += this.kiri('Ruang/Kelas',14,'&nbsp;')+' : '+this.kiri(ruang+'/'+kelas,35,'&nbsp;')+'<br>';
		   }else{
		   str += this.kiri('Klinik',14,'&nbsp;')+' : '+this.kiri(klinik,35,'&nbsp;')+'<br>';
		   }
		   str += this.kiri('Cara Bayar',14,'&nbsp;')+' : '+this.kiri(cara_bayar,35,'&nbsp;')+'<br>';
		   str += this.kiri('Nama Penjamin',14,'&nbsp;')+' : '+this.kiri(penjamin,35,'&nbsp;')+'<br>';
		   
		   str += this.repeatChar('-', 96)+'<br>';	
		   if(rekap != 2){
		   		str += this.tengah('No',3,'&nbsp;')+'|'+this.tengah('No.Registrasi',17,'&nbsp;') +'|'+this.tengah('Tanggal',10,'&nbsp;') +'|'+ this.kiri('Pelayanan/Pemeriksaan',28,'&nbsp;')+'|'+ this.tengah('Qty',3,'&nbsp;')+'|'+this.tengah('Harga Satuan',12,'&nbsp;')+'|'+this.tengah('Jumlah (Rp)',17,'&nbsp;')+'<br>';
		   }else{   
		   		str += this.tengah('No',3,'&nbsp;')+'|'+this.tengah('No.Registrasi',17,'&nbsp;') +'|'+this.tengah('Tanggal',10,'&nbsp;') +'|'+ this.kiri('Pelayanan/Pemeriksaan',45,'&nbsp;')+'|'+this.tengah('Jumlah (Rp)',17,'&nbsp;')+'<br>';
		   }
		   str += this.repeatChar('-', 96)+'<br>';
		   
		   for(var i=0;i<content.rows.length;i++){
			   no = content.rows[i].no;
			   norg = content.rows[i].norg;
			   tgl = content.rows[i].tgl;
			   uraian = content.rows[i].uraian;
			   qty = content.rows[i].Qty;
			   hargasat = content.rows[i].hargasat;
			   jml = content.rows[i].jml;
			   
			   if(rekap != '2'){
			   		str += this.tengah(no,3,'&nbsp;')+'|'+this.tengah(norg,17,'&nbsp;') +'|'+this.tengah(tgl,10,'&nbsp;') +'|'+ this.kiri(uraian,28,'&nbsp;')+'|'+ this.tengah(qty,3,'&nbsp;')+'|'+this.kanan(hargasat,12,'&nbsp;')+'|'+this.kanan(jml,17,'&nbsp;')+'<br>';
			   }else{
			   		str += this.tengah(no,3,'&nbsp;')+'|'+this.tengah(norg,17,'&nbsp;') +'|'+this.tengah(tgl,10,'&nbsp;') +'|'+ this.kiri(uraian,45,'&nbsp;')+'|'+this.kanan(jml,17,'&nbsp;')+'<br>';
			   }
		   		
				if(content.rows[i].det){
					for(var x=0;x<content.rows[i].det.length;x++){
						no2 = content.rows[i].det[x].no;
						norg2 = content.rows[i].det[x].norg;
						tgl2 = content.rows[i].det[x].tgl;
						uraian2 = content.rows[i].det[x].uraian;
						qty2 = content.rows[i].det[x].Qty;
						hargasat2 = content.rows[i].det[x].hargasat;
						jml2 = content.rows[i].det[x].jml;
			   			
						str += this.tengah(no2,3,'&nbsp;')+'|'+this.tengah(norg2,17,'&nbsp;') +'|'+this.tengah(tgl2,10,'&nbsp;') +'|'+ this.kiri(uraian2,28,'&nbsp;')+'|'+ this.tengah(qty2,3,'&nbsp;')+'|'+this.kanan(hargasat2,12,'&nbsp;')+'|'+this.kanan(jml2,17,'&nbsp;')+'<br>';
					}
				}
		   }
		   
		   total = content.total;
		   tanggal = content.tanggal;
		   namakiri = '............';
		   namakanan = '............';
		   
		   str += this.kiri(' ',96,'&nbsp;')+'<br>';
		   str += this.repeatChar('-', 96)+'<br>';	
		   str += this.kanan('',3,'&nbsp;')+' '+this.tengah('',17,'&nbsp;') +' '+this.tengah('',10,'&nbsp;') +' '+ this.tengah('Total Harga (Rp.)',28,'&nbsp;')+' '+ this.tengah('',3,'&nbsp;')+' '+this.kanan('',12,'&nbsp;')+'|'+this.kanan(total,17,'&nbsp;')+'<br>';
		   str += this.repeatChar('-', 96)+'<br>';
		   
		   //footer ttd
		   str += this.kiri(' ')+'<br>';
		   str += this.tengah('',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('Bandung, '+tanggal,36,'&nbsp;')+'<br>';
		   str += this.tengah('Nama Pasien',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('Nama Kasir',36,'&nbsp;')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.tengah('('+namakiri+')',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('('+namakanan+')',36,'&nbsp;')+'<br>';
			
			/*
		   //footer table
		   tot=content.rows[0].total;
		   terbilang1 = content.rows[0].bilang1;
		   terbilang2 = content.rows[0].bilang2;
		   namakiri = content.nama;
		   namakanan= content.nm_petugas;
		   
		   str += this.kiri(' ',96,'&nbsp;')+'<br>';
		   str += this.repeatChar('-', 96)+'<br>';	
		   	   
		   //str += '                                                              Total (Rp)   '+ this.kanan(tot,21,'&nbsp;')+'<br>';
		   str += this.kanan('',3,'&nbsp;')+' '+this.tengah('',10,'&nbsp;') +' '+ this.kiri('',42,'&nbsp;')+' '+ this.kanan('',5,'&nbsp;')+' '+this.kanan('Total (Rp)',12,'&nbsp;')+' '+this.kanan(tot,19,'&nbsp;')+'<br>';
		   str += this.kiri('Terbilang: '+terbilang1)+'<br>';
		   str += this.kiri('           '+terbilang2)+'<br>';
		   
		   
		   //ttd
		   //str += '                                                              Total (Rp)   '+ this.kanan('Bandung,',21,'&nbsp;')+'<br>';
		   str += this.tengah('Nama Pasien',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('Nama Kasir',36,'&nbsp;')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.kiri(' ')+'<br>';
		   str += this.tengah('('+namakiri+')',36,'&nbsp;')+this.kiri(' ',24,'&nbsp;')+this.tengah('('+namakanan+')',36,'&nbsp;')+'<br>';*/
		   
		   document.getElementById('divcontent').innerHTML = str;
		   
	},


});
