<?php

session_start();
include_once 'bd.php';
include_once 'validaUsuario.php';

if (!isset($_SESSION['id']))
{
	$unaBD = new bd();

	if (!isset($_POST['user']))
	{

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="icon" type="image/png" href="img/medico.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<title>-. Sistema de Servicio M&eacute;dico .-</title>
</head>
<body>
<div class="TablaPrincipal">
<table border="0" align="center" cellspacing="0">
	<tr>
    	<td><p><img src="img/logo.png"/></p></td>
    </tr>
    <tr>
    	<td><hr/></td>
    </tr>
    <tr>
    	<td width="601">
        	<form id="form1" name="form1" method="post" action="index.php">
				<table width="247" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D8D8D8">
					<tr>
						<td rowspan="2">
                    		<div align="center"><em><strong>Inicio de Sesi&oacute;n</strong></em></div>
							<table width="200" border="0" align="center" cellspacing="0">
								<tr>
									<td><strong>Usuario</strong></td>
									<td><input type="text" name="user" id="user" /></td>
								</tr>
								<tr>
									<td><strong>Contrase&ntilde;a</strong></td>
									<td><input type="password" name="pass" id="pass" /></td>
								</tr>
								<tr>
									<td colspan="2">
                                		<div align="center">
										<input type="submit" name="enviar" id="enviar" value="Ingresar" />
										</div>
                                	</td>
								</tr>
							</table>
                    	</td>
					</tr>
				</table>
        	</form>
        </td>
	</tr>
    <tr>
    	<td>
    		<hr />
        	<p align="right">
            <dfn>Administracion General de Puertos S.E. - AGP</dfn>
            <img src="img/AGP.JPG" width="20" height="23" />
            </p>
        </td>
    </tr>
</table>
</div>
</body>
</html>

<?php
		exit;
	}
	else
	{

		// Conectar con LDAP SERVER
		$pass = $_POST['pass'];
		$user = $_POST['user'];

		$ldapconn = ldap_connect('10.0.0.56',389) or die("Could not connect to LDAP server.");

		ldap_set_option($ldapconn,LDAP_OPT_PROTOCOL_VERSION,3) or die("Could not set ldap protocol version");

		$credencial = $user . '@ptobaires.gov.ar';

		if(!ldap_bind($ldapconn, $credencial, $pass) || $pass == "" || $user == "")
		{
			ldap_unbind($ldapconn);
			header("Location:errorlog.php");
			exit;
		}
		else {
			$query = "SELECT * FROM habagp.permisosmed WHERE usuario = '" . $user . "'";

			$unaBD->conectar();
			$unaBD->consultar($query);
			$unaBD->cerrarConexion();

			if ($unaBD->cantidad > 0)
			{
				$_SESSION['permisos'] = $unaBD->datos;
			}
			else {
				ldap_unbind($ldapconn);
				header("Location:errorlog.php");
				exit;
			}
		}

		$_SESSION['id']=$_POST['user'];
		$_SESSION['password']=$_POST['pass'];

	}
}

?>
