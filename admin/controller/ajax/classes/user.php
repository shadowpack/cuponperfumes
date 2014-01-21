<?php
if(!class_exists('webservice'))
{
	require_once('webservice.php');
}
class user extends webservice{
	public function login($data){
		$db = new db_core();
		$where['email'] = $data->user;
		$where['password'] = sha1($data->password);
		if($db->isExists_multi('users_admin', $where)){
			$token = $this->getToken('admin_log','token');
			@$_SESSION['token_admin'] = $token;
			$aux['token'] = $token;
			$aux['admin_log_id'] = $db->reg_one("SELECT id_user FROM users_admin WHERE email='".$data->user."'");
			$aux['admin_log_id'] = $aux['admin_log_id'][0]; 
			$aux['time'] = date('Y-m-d h:i:s');
			$aux['ip'] = $this->getIP();
			$db->insert('admin_log', $aux);
			$this->returnData(array("status"=>0));
		}
		else
		{
			$this->returnData(array("status"=>1));
		}
	}
	//METODO PARA REGISTRAR USUARIO
	public function reguser($data){
		
	}
	//METODO PARA LOGOUT USUARIO
	public function logout($data){
		unset($_SESSION['token_admin']);
	}
	//METODO PARA OBTENER INFO DEL USUARIO
	public function getinfo($data){
		$db = new db_core();
		$consulta = $db->reg_one("SELECT * FROM admin_log INNER JOIN users_admin ON admin_log.admin_log_id=users_admin.id_user WHERE admin_log.token='".$_SESSION['token_admin']."'");
		echo json_encode($consulta);
	}
	//METODO PARA DETERMINAR IP
	private function getIP(){
	    if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] )) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if( isset( $_SERVER ['HTTP_VIA'] ))  $ip = $_SERVER['HTTP_VIA'];
	    else if( isset( $_SERVER ['REMOTE_ADDR'] ))  $ip = $_SERVER['REMOTE_ADDR'];
	    else $ip = null ;
	    return $ip;
	}
}
?>