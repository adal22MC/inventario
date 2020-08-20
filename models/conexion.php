<?php

require_once "../config.php";

class Conexion
{

	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $bd_name = "inventario";
	private $conn;

	public function __construct()
	{

		try {

			$this->conn = new PDO("mysql:host=$this->servername;dbname=$this->bd_name;", $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES utf8"));

			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// echo "CONECTADO CORRECTAMENTE";

		} catch (PDOException $e) {
			return "Connection failed: " . $e->getMessage();
		}
	}

	public function getConexion()
	{
		return $this->conn;
	}

	public function closeConexion()
	{
		$this->conn = null;
	}


	public function backup_tables($tables = "*")
	{
		
		$fecha = date("d-m-Y");
		$ruta = BACKUPS."backups_{$fecha}.sql";
		$nombre_backups = "backups_{$fecha}.sql";

		$return = '';
		$link = new mysqli("localhost", "root", "", "inventario");
		// mysql_select_db($name,$link);

		//get all of the tables
		if ($tables == '*') {
			$tables = array();
			$result = $link->query('SHOW TABLES');
			while ($row = mysqli_fetch_row($result)) {
				$tables[] = $row[0];
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
		}

		//cycle through
		foreach ($tables as $table) {
			$result = $link->query('SELECT * FROM ' . $table);
			$num_fields = mysqli_num_fields($result);


			//$return.= 'DROP TABLE '.$table.';';
			$row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE ' . $table));
			$return .= "\n\n" . $row2[1] . ";\n\n";

			for ($i = 0; $i < $num_fields; $i++) {
				while ($row = mysqli_fetch_row($result)) {
					$return .= 'INSERT INTO ' . $table . ' VALUES(';
					for ($j = 0; $j < $num_fields; $j++) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
						if (isset($row[$j])) {
							$return .= '"' . $row[$j] . '"';
						} else {
							$return .= '""';
						}
						if ($j < ($num_fields - 1)) {
							$return .= ',';
						}
					}
					$return .= ");\n";
				}
			}
			$return .= "\n\n\n";
		}

		//save file
		$handle = fopen($ruta, 'w+');

		fwrite($handle, $return);
		fclose($handle);
		
		echo "<a id='descargar' href='../models/backups/{$nombre_backups}' download='{$nombre_backups}'>...</a>";
		echo "
			<script>
				document.getElementById('descargar').click();
				window.location = 'admin.php';
			</script>
		";
		
	}
}
