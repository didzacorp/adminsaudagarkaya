<?phpfunction setShadowForm2($theform){	/*$str = 				"<div id='".$formID."_shadow' class='dialogstyle' style='z-index:99;width:$width;height:$height;			position:absolute;top:$top;left:$left;'>				"<table id='formshadow' CELLSPACING='0' CELLPADDING='0'><tr><td><!--the form-->"+		theform+		"</td><td width=4 height='100%' valign=top>"+		//kanan	"<table style='width:100%;height:100%;'  CELLSPACING='0' CELLPADDING='0'><tr><td height=8></td></tr> <tr>"+		"<td style='background-color:gray;opacity:0.5;"+		//"border-right-color: silver;border-right-style: solid;border-right-width: 1px;"+	" '> </td></tr></table>"+			"</td></tr>"+	"<tr><td height=4 colspan=2>"+		//bawah	"<table width='100%' height='100%' CELLSPACING='0' CELLPADDING='0'><tr><td width=8> </td>"+	"<td style='background-color:gray;opacity:0.5;'> </td></tr></table>"+		"</td></tr>"+		"</table>";*/		$str = 		"	<table  id='formshadow' CELLSPACING='0' CELLPADDING='0'>		<tr>			<td>					$theform			</td>			<td width=4 height='100%' valign=top>						<table style='width:100%;height:100%;'  CELLSPACING='0' CELLPADDING='0'>				<tr>					<td height=4>&nbsp</td>				</tr> 				<tr>					<td style='background-color:gray;opacity:0.5;'> </td>				</tr>				</table>					</td></tr>			<tr><td height=4 colspan=2>					<table width='100%' height='100%' CELLSPACING='0' CELLPADDING='0'><tr><td width=8> </td>					<td style='background-color:gray;opacity:0.5;'> </td></tr>				</table>				</td></tr>				</table>		";			return $str;}function setCenterPage($aForm){	return "							<table id='formcenter' width=100% height=100% ><tr><td align='center' style='padding:0;'>											$aForm												</td></tr></table>				";	}function setBackTransparan($aForm, $params=''){	return "<div class='transparan' style='position:fixed;top:0;left:0;right:0;bottom:0;z-index:100' $params'>			$aForm		</div>";}function FormContainer($aForm, $top=0, $left=0, $params="onclick='cancelbbl(event)'" ){		return "		<table id='contain_wrapper' cellspacing='0' cellpadding='0' style=''>		<tr><td style='padding:0;'>			<div id='contain_style' $params style='z-index:99;display:block;background-color:white; border-color: #99AABD;   border-style: solid;  border-width: 1px 2px 2px; padding:6'>				$aForm			</div>		</td></tr></table>";}?>
