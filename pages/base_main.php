<?php

$Main->Base =
"
 <h2> ADMIN SAUDAGAR KAYA </h2>
<link rel='stylesheet' type='text/css' href='css/styleMetro.css'>
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>

<ul class='metro' style='width: 83%;'>

<li><i class='fa fa-dashboard' linkPage='pages.php?Pg=dashboard'></i><span>DASHBOARD</span></li>
<li><i class='fa fa-link' linkPage='pages.php?Pg=refFunnel'></i><span>FUNNEL / LANDING PAGE</span></li>
<li><i class='fa fa-user' linkPage='pages.php?Pg=refUser'></i><span>USER</span></li>
<li><i class='fa fa-copy' linkPage='pages.php?Pg=refCopyWriting'></i><span>COPYWRITING</span></li>
<li><i class='fa fa-users' linkPage='pages.php?Pg=refMember'></i><span>MEMBER</span></li>
<li><i class='fa fa-file-video-o' linkPage='pages.php?Pg=refTraining'></i><span>TRAINING</span></li>
<li><i class='fa fa-gift' linkPage='pages.php?Pg=refProduk'></i><span>PRODUK</span></li>

<li><i class='fa fa-newspaper-o' linkPage='pages.php?Pg=refNews'></i><span>NEWS</span></li>
<li><i class='fa fa-dollar' linkPage='pages.php?Pg=modulTransaksi'></i><span>TRANSAKSI</span></li>
<li><i class='fa fa-money' linkPage='pages.php?Pg=modulKomisi'></i><span>KOMISI</span></li>
<li><i class='fa fa-inbox' linkPage='pages.php?Pg=modulInbox'></i><span>INBOX</span></li>

</ul>
<!--
NEWS
TRANSAKSI
KOMISI
INBOX -->

<div class='box'>
<span class='close'></span>
<p></p>
</div>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js'></script>

<script type='text/javascript'>
	$(document).ready(function() {

	var sbox = $('.box');

	$('.metro li').each(function(){
		var color = $(this).css('backgroundColor');
		var content = $(this).html();
		$(this).click(function() {
			sbox.css('backgroundColor', color);
			sbox.addClass('open');
			sbox.find('p').html(content);

      setTimeout(
              function(){
                  window.location = $(content).attr('linkPage')
              },
          300);
		});

		$('.close').click(function() {
			sbox.removeClass('open');
			sbox.css('backgroundColor', 'transparent');
		});
	});

	});
</script>

";
?>
