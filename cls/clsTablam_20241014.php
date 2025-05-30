<?php
class Tabla {  // ver. mysql   
	public $nomTabla;
	public $cn;
	public $Tit = array();
	public $Cam = array();
	public $Tip = array();
	public $Tam = array();
	public $Tam_dec = array();
	public $numCampos;
	public $titTabla;
	public $sel = array();
	public $llave;
	public $llave2 = "N";
	public $llave3 = "N";
	public $posib = array();
	public $Key = array();
	public $sel_dep = array();  //select dependientes.
	public $tab_pri = array();  // tabla con llave primaria.
	public $NNull = array(); // NOT NULL
	public $comentario = "";
	public $nomDb = "";
 	public $Dfl = array();   // valores por defecto.

    public function __construct($odb,$ntabla){
		$this->cn = $odb->cn; 
		$this->nomTabla=$ntabla;
		$this->nomDb = $odb->db;
		if(!$this->existe()){
			exit("Tabla ".$this->nomTabla." NO EXISTE");
		}else{
			$this->trae();
		}
		
	}
	private function existe(){
		if($this->ejec("SHOW TABLES LIKE '".$this->nomTabla."'","S")){
			return true;
		}else{
			return false;
		}
	}
	public function ejec($sql,$op,$op2='C'){  // op2 = Numerico, Asociativo, Combinado.
		//echo "<br>SQL:".$sql;
		try{
			$arreglo = array();
			if(!$r = mysqli_query($this->cn,$sql) ){
				die("Error ".$this->cn->error." en sql: ".$sql);
			}else{
				if($op=='S'){
					$son = mysqli_num_rows( $r );
					//echo "son:".$son;
					for ( $x = 0; $x < $son ; $x++ ){
						switch( $op2 ){
						case 'C' : $arreglo[$x] = mysqli_fetch_array($r,MYSQLI_BOTH);break;
						case 'N' : $arreglo[$x] = mysqli_fetch_array($r,MYSQLI_NUM);break;
						case 'A' : $arreglo[$x] = mysqli_fetch_array($r,MYSQLI_ASSOC);break;
						}
					}
					mysqli_free_result( $r );
					return $arreglo;
				}else{
					return $r;
				}
			}
	
		}catch (PDOException $e) {
            echo $e->getTraceAsString();
		}
	}
	
	public function trae(){
		try{
			$sql = "SELECT column_name AS nombre,data_type AS formato,
			is_nullable AS nulo, column_key AS llave, character_maximum_length AS tamano_var,
			numeric_precision AS tamano_num, numeric_scale AS tamano_dec, column_default AS defecto,  
			column_comment AS coment FROM diccionario_tablas
			WHERE table_name = '".$this->nomTabla."'";
			$a = $this->ejec($sql,"S");
			$this->numCampos = count( $a );
			for($x=0; $x < count ( $a );$x++ ){
				$this->Cam[$x] = $a[$x]['nombre'];
				$this->Tip[$x] = $a[$x]['formato'];
				$this->Tam_dec[$x] = "";
				$this->Dfl[$x] = NULL;
				switch($a[$x]['formato']){
					case 'varchar' :
					case 'char'    : $this->Tam[$x] = $a[$x]['tamano_var'];
						break;
					case 'date'    : $this->Tam[$x] = 10;
						break;
						case 'datetime' : $this->Tam[$x] = 20;  // 2024-03-06 12:27
						break;
					case 'timestamp':$this->Tam[$x] = 19;  // 2023-10-16 15:20:00
						break;
					case 'int'     : 
					case 'tinyint' : $this->Tam[$x] = $a[$x]['tamano_num'];
						break;
					case 'decimal' : $this->Tam[$x] = $a[$x]['tamano_num'];
									$this->Tam_dec[$x] = $a[$x]['tamano_dec'];
						break;
					case 'text'	   : $this->Tam[$x] = $a[$x]['tamano_var'];
						break;
				}	
				$this->NNull[$x] = $a[$x]['nulo'];
				$this->sel[$x] = "S"; 
				if($a[$x]['defecto'] !='' && $a[$x]['defecto'] !=0 ){
					//$this->sel[$x] = "N";
					$this->Dfl[$x] = $a[$x]['defecto'];
				}  
				$this->Tit[$x] = $this->Cam[$x];
				$this->Key[$x] = $a[$x]['llave'];
				$this->sel_dep[$x] = "N";
				$this->tab_pri[$x] = "";
				if($a[$x]['llave'] == 'PRI'){
					$this->llave = $a[$x]['nombre'];
				}
				if($a[$x]['llave'] == 'MUL'){
					$this->sel_dep[$x] = "S";
					$this->tab_pri[$x] = $this->trae_foranea($a[$x]['nombre'],$this->nomDb);
				}
				if(strlen($a[$x]['coment']) > 0 ){  
					$this->Tit[$x] = $a[$x]['coment'];
				} 
							
			}
			$a = $this->ejec("SHOW TABLE STATUS WHERE name='".$this->nomTabla."'","S");
			//echo "Tabla:".$this->nomTabla;
			if($a[0]['Comment'] == "" || $a[0]['Comment'] == NULL ){ 
				$this->titTabla = "Sin Titulo";
			}else{
				$this->titTabla = $a[0]['Comment'];
			}
		}catch(Exception $e){
			echo "Error: ".$e->getMessage();
		}
	}
	
	public function trae_foranea($campo,$base){
		$a = $this->ejec("SELECT id,for_col_name FROM diccio_foreign_cols WHERE for_col_name='$campo'
		 AND id LIKE '%".$base."%'","S","A"); 
		 //echo "Campo $campo <pre>";print_r($a);echo "</pre>";
		if(count($a)<1){ echo "Sin dato Foraneo BASE: $base TABLA: ".$this->nomTabla." CAMPO: $campo ";print_r($a);}
		$b = $this->ejec("SELECT id ,for_name AS tablaori, ref_name AS tablapri 
			FROM diccio_foreign WHERE id = '".$a[0]['id']."' ","S","A");
		$separa = $base."/";
		
		$a_t_pri =explode($separa,$b[0]['tablapri']);
		return $a_t_pri[1];
	}

	public function ver_campos(){
		echo "<table border='1'><caption>".$this->titTabla." (".$this->nomTabla.")</caption><tr><th>Campo</th>
		<th>Tipo</th><th>Tamano</th><th>Nulo</th><th>Llave</th><th>Selec</th><th>Dep</th><th>Coment</th><th>Tabla_Pri</th></tr>";
		for( $x=0; $x < $this->numCampos; $x++ ){
			$decimales = "";
			if($this->Tam_dec[$x] != "" ) $decimales = "(".$this->Tam_dec[$x].")";
			echo "<tr><td>".$this->Cam[$x]."</td><td>".$this->Tip[$x]."</td>
			      <td>".$this->Tam[$x]." ".$decimales."</td><td>".$this->NNull[$x]."</td>
				  <td>".$this->Key[$x]."</td><td>".$this->sel[$x]."</td>
				  <td>".$this->sel_dep[$x]."</td>
				  <td>".$this->Tit[$x]."</td>
				  <td>".$this->tab_pri[$x]."</td></tr>";
		}
		echo "</table>";
	}
	
	/* adicion de tabla gemela a information_schema */
	public function trael(){
		$sql = "SELECT column_name AS nombre,data_type AS formato,
		is_nullable AS nulo, column_key AS llave, character_maximum_length AS tamano_var,
		numeric_precision AS tamano_num, numeric_scale AS tamano_dec, column_default AS defecto,  
		column_comment AS coment FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = '".$this->nomDb."' and table_name = '".$this->nomTabla."'";
		$a = $this->ejec($sql,"S");
		$this->numCampos = count( $a );
		for($x=0; $x < count ( $a );$x++ ){
			$this->Cam[$x] = $a[$x]['nombre'];
			$this->Tip[$x] = $a[$x]['formato'];
			$this->Tam_dec[$x] = "";

			switch($a[$x]['formato']){
				case 'varchar' :
				case 'char'    : $this->Tam[$x] = $a[$x]['tamano_var'];
					break;
				case 'date'    : $this->Tam[$x] = 10;
					break;
				case 'timestamp':$this->Tam[$x] = 19;  // 2023-10-16 15:20:00
					break;
				case 'int'     : 
				case 'tinyint' : $this->Tam[$x] = $a[$x]['tamano_num'];
					break;
				case 'decimal' : $this->Tam[$x] = $a[$x]['tamano_num'];
								 $this->Tam_dec[$x] = $a[$x]['tamano_dec'];
					break;
				case 'text'	   : $this->Tam[$x] = $a[$x]['tamano_var'];
					break;
			}	
			$this->NNull[$x] = $a[$x]['nulo'];
			$this->sel[$x] = "S"; 
			if($a[$x]['defecto'] !='' && $a[$x]['defecto'] !=0 ) $this->sel[$x] = "N"; 
			$this->Tit[$x] = $this->Cam[$x];
			$this->Key[$x] = $a[$x]['llave'];
			$this->sel_dep[$x] = "N";
			$this->tab_pri[$x] = "";
			if($a[$x]['llave'] == 'PRI'){
				$this->llave = $a[$x]['nombre'];
			}
			if($a[$x]['llave'] == 'MUL'){
				$this->sel_dep[$x] = "S";
				$this->tab_pri[$x] = $this->trae_foranea($a[$x]['nombre'],$this->nomDb);
			}
			if(strlen($a[$x]['coment']) > 0 ){  
				$this->Tit[$x] = $a[$x]['coment'];
			} 
						
		}
		$a = $this->ejec("SHOW TABLE STATUS WHERE name='".$this->nomTabla."'","S");
 		if($a[0]['Comment'] == "" || $a[0]['Comment'] == NULL ){ 
			$this->titTabla = "Sin Titulo";
		}else{
			$this->titTabla = $a[0]['Comment'];
		}
	}
	
	public function trae_foraneal($campo,$base){
		$a = $this->ejec("SELECT id FROM information_schema.INNODB_SYS_FOREIGN_COLS WHERE for_col_name='$campo'
		 AND id LIKE '%".$base."%'","S","A"); 
		 // echo "<pre>";print_r($a);echo "</pre>";
		$b = $this->ejec("SELECT id ,for_name AS tablaori, ref_name AS tablapri 
			FROM information_schema.INNODB_SYS_FOREIGN WHERE id = '".$a[0]['id']."'","S","A");
		$separa = $base."/";
		$a_t_pri =explode($separa,$b[0]['tablapri']);
		return $a_t_pri[1];   
	}

	/*  fin de la adicion */

	public function lee( $where,$op=0,$op2="C" ){
		$sql = "SELECT * FROM ".$this->nomTabla." ";
		if( $op == 1 ){
			//echo "VIENE op: ".$op." where: ".$where ;
			$w = $this->adicom( $this->llave,$where );
			$where = " WHERE ".$this->llave."=".$w."";
		}
		$sql = $this->addWhere( $sql, $where );
		//echo "SQL:".$sql;
		/* $arf = fopen("salidasql","a");
		fwrite($arf,$sql."\n");
		fclose($arf); */
		return $this->ejec( $sql, 'S',$op2 );
	}

	public function lee1( $where,$op=0,$op2="C" ){
		$a = $this->lee( $where,$op,$op2 );
		if( count( $a ) < 1 ){
			return false;
		}else{
			return $a[0];
		}
	}
	
	public function leec( $campos,$where,$op=0, $op2="C" ){
		$a_vie = explode(",",$campos);
		if( !is_array( $a_vie ) || $a_vie[0] == "" ){
			return $this->lee( $where,$op,$op2 );
		}else{
			$sql = "SELECT ".$campos." FROM ".$this->nomTabla." ";
			if( $op == 1 ){
				$w = $this->adicom( $this->Cam[$this->llave],$where );
				$where = " WHERE ".$this->Cam[$this->llave]."=".$w."";
			}
			$sql = $this->addWhere( $sql, $where );
			//echo "<br>Pasa:".$sql;
			return $this->ejec( $sql, 'S', $op2 );				
		}
	}
	
	public function addWhere( $sql, $where ){
		if ( $where > "" ){
			$sql .= $where;
		}
		$sql .= ";";
		return $sql;
	}

	private function adicom($clave,$valor){
		for( $x = 0; $x < $this->numCampos; $x++ ){
			if( $this->Cam[$x] == $clave ){
				if( !$this->es_num( $x ) ){
					if( $valor == null && $this->Tip[$x] == "D" ){
						$valor = " NULL ";
					}else{
						$valor = "'".$valor."'";
					}
				}
				return $valor;
			}
		}
	}
   
	public function es_num($campo){
		if( $this->Tip[$campo] == "I" || $this->Tip[$campo] == "S" || $this->Tip[$campo] == "N" ){
			return true;
		}else{
			return false;
		}
	}

	public function inst( $datos,$sale="" ){
		$n = count( $datos );  // $m = 0;
		$s1 = " INSERT INTO ".$this->nomTabla." ( ";
		$s2 = " VALUES ( ";
		//$son = array();
		for( $x=0; $x < $this->numCampos; $x++ ){
			if( $x > 0 ){
				$s1 .= ",";
				$s2 .= ",";
			}
			$s1 .= $this->Cam[$x];
			if( strpos($datos[ $this->Cam[$x] ],"'") !== false ){
				$datos[ $this->Cam[$x] ] = preg_replace("/'/", "-", $datos[ $this->Cam[$x] ]);

			}
			$valor = $this->adicom( $this->Cam[$x],$datos[ $this->Cam[$x] ]);
			if( $valor == NULL ){
				$s2 .= " NULL ";
			}else{
				$s2 .= $valor;
			}
		}
		$s1 .= " ) ";$s2 .= " ) ";
		$s = $s1.$s2;
		if( $sale > "" ){
			$s .= " RETURNING ".$sale;
			$sale = "S";
		}else{
			$sale = "N";
		}
		//echo "sql: ".$s." <BR>";
		return $this->ejec($s,$sale);
	}

	public function ins( $datos, $sale="" ){  // $datos trae campo, valor
		//print_r( $datos );
		$n = count( $datos );
		$s0 = " INSERT INTO ".$this->nomTabla."(";
		$s1 = " VALUES (";
		$x = 0;
		foreach ( $datos as $Campo => $valor ){
			$s0 .= $Campo;
			for( $y=0; $y < $this->numCampos; $y++ ){
				if( $this->Cam[$y] == $Campo ){  // Integer,Smallint,Numeric, Bigint
					if( $this->Tip[$y] == "I" || $this->Tip[$y] == "S" || $this->Tip[$y] == "N"  || $this->Tip[$y] == "B" ){ 
						if( $valor == null ){
							$s1 .= " NULL ";
						}else{
							$s1 .= "".$valor."";
						}
					} else{
						if( $valor == null && $this->Tip[$y] == "D" ){
							$s1 .= " NULL ";
						}else{
							$s1 .= "'".$valor."'";
						}
					}
				}
			}
			if ( $x < ( $n - 1 ) ){
				$s0 .= ", ";
				$s1 .= ", ";
			}
			$x += 1;
		}
		$s0 .= ")";
		$s1 .= ")";
		$s = $s0.$s1;
		if( $sale > "" ){
			$s .= " RETURNING ".$sale;
			$sale = "S";
		}else{
			$sale = "N";
		}
		//echo $s ; //exit;
		/* $arf = fopen("salidasql","a");
		fwrite($arf,$s."\n");
		fclose($arf);  */ 
		return $this->ejec( $s, $sale );
	}

	public function limp(){
		$sql = " TRUNCATE TABLE ".$this->nomTabla;
		return $this->ejec( $sql, 'N' );
	}
   
	public function qt( $where ){
		$sql = " SELECT COUNT(*) FROM ".$this->nomTabla." ";
		$sql = $this->addWhere($sql,$where);
		$a = $this->ejec( $sql, 'S');
		return $a[0][0];
	}

   public function sm($Campo,$where){
     $sql = " SELECT SUM($Campo) FROM ".$this->nomTabla." ";
     $sql = $this->addWhere($sql,$where);
	 //echo $sql;
     return $this->ejec( $sql, 'S');
   }
   
   public function soloIndex($a){
     $b = array();
     for($x=0; $x < $this->numCampos; $x++ ){
        $b[$x] = $a[$x];
     }
     return $b;
   }

   public function soloAsoc($a){
     $b = array();
     for($x=0; $x < $this->numCampos; $x++ ){
        $b[ $this->Cam[$x] ] = $a[ $this->Cam[$x] ];
     }
     return $b;
   }

   public function IndexAsoc( $a ){
     $b = array();
     for($x=0; $x < $this->numCampos; $x++ ){
        $b[ $this->Cam[$x] ] = $a[$x];
     }
     return $b;

   }
   
   public function max_tabla( $campo, $where ){
     $sql = "SELECT MAX(".$campo.") FROM ".$this->nomTabla." ";
     $sql = $this->addWhere($sql,$where);
     //echo $sql;
     return $this->ejec( $sql, 'S' );
   }


   public function ultimos($campo1,$campo2){
      $s = "SELECT ".$campo1.",MAX(".$campo2.") FROM ".$this->nomTabla." GROUP BY ".$campo1." ORDER BY ".$campo1."";
      $this->ejec($s,"S");
   }

   public function last_id(){
	$a_a = $this->ejec("select last_insert_id()","S");
	return $a_a[0]['last_insert_id()'];
   }
   public function bor( $where ){
     $sql  = "DELETE FROM ".$this->nomTabla." ";
	 if( strlen( $where ) == 0 ){
		exit("BORRADO SIN CONDICIONES.");
	 }
     $sql  = $this->addWhere( $sql, $where );
	 //echo $sql;
     return $this->ejec( $sql, 'N' );
   }

   	public function mod( $datos, $where ){
		//print_r($datos );
		if( strlen( $where ) == 0 ){
			exit("MODIFIC SIN CONDICIONES.");
		}
		$sql = " UPDATE ".$this->nomTabla." SET ";
		//$n = $this->numCampos;  //echo "Tiene $n campos <BR>";
		$x = 0;
		foreach ( $datos as $clave => $valor ){
			//echo "Clave: $clave  Valor: $valor";
			if( !is_numeric( $clave ) ){   // intento saltar el indice numerico.
				$existe = false;
				for($j=0; $j< $this->numCampos;$j++){
					if( trim($this->Cam[$j]) == trim($clave) ){
						$y = $j;
						$existe = true;
					}
				}
				if( !$existe ){
					continue;
				}
				if( $x > 0 ){
					$sql .= ", ";
				}
				// echo "Tipo:".$this->Tip[$y];
				$tipo = strtoupper(substr($this->Tip[$y],0,1));
				//echo "Tipo: $tipo";  
				if( $tipo == "I" || $tipo == "F" || $tipo == "S" || $tipo == "N" || $tipo == "B"){
					if( $valor == NULL ){
						$sql .= " ".$clave." = 0 ";
					}else{
						$sql .= " ".$clave." = ".$valor." ";
					}
				}else{
					if( $tipo == "D" && $valor == NULL ){
						$sql .= " ".$clave." = NULL ";
					}else{
						$sql .= " ".$clave." = '".$valor."' ";
					}
				}
				$x += 1;
			}
		}
		$sql = $this->addWhere( $sql, $where );
		// exit( $sql );
		return $this->ejec( $sql, 'N' );
   	}
   
   public function selecc($campo,$clase="",$opcion="",$where="",$formato="",$estilo=""){
     $s  = " SELECT ";
     $s2 = "";
     $tope = 0;
     $y = 0;
     for( $x = 0; $x < $this->numCampos; $x++ ){
        if( $this->sel[$x] == 'S' ){
          $tope += 1;
        }
     }
     for( $x = 0; $x < $this->numCampos; $x++ ){
        if( $this->sel[$x] == 'N' ){
        }else{
          $s .= $this->Cam[$x];
          $y += 1;
          if( $y < ( $tope ) ){
            $s .= ",";
          }
        }
     } 
     if( $where != "" ){
       $where = " WHERE ".$where;
     }
     $s .= " FROM ".$this->nomTabla." ".$where." ORDER BY ".$this->Cam[0];
     //echo "<br>SQL : ".$s;
     $r = $this->ejec($s,'S');
	 if(strlen($clase) > 0 ){$clase = "class='".$clase."'";}
	 if(strlen($estilo) > 0 ){ $estilo = " style='".$estilo."'";}
     $sale = "<SELECT name='".$campo."' id='".$campo."' $clase $estilo onchange=\"cambia('".$campo."');\">
			<option value=''>Sin elegir </option>
	 ";
     for( $x=0; $x < count( $r ); $x++ ){
        $sale .= "<option value='".$r[$x][0]."'";
        if( $opcion != "" && $opcion == $r[$x][0] ){
          $sale .= " selected='selected' ";
        }
		$separador = " - ";
		if( $formato != "" ){ // viene campo | tipo | cuantos | relleno
			$a_for = explode("|",$formato );
			switch( $a_for[1] ){
				case 'N' : $campo1 = str_pad( $r[$x][ $a_for[0] ],$a_for[2],$a_for[3],STR_PAD_LEFT);
						break;
				default : $campo1 = "";$separador = "";break;
			}
			$sale .= ">".$campo1.$separador.$r[$x][1]."</option>
			";			
		}else{
			$sale .= ">".$r[$x][0].$separador.$r[$x][1]."</option>
			";
		}
     }
     $sale .= "</SELECT>
	 ";
     return $sale;
   }

	public function menu($d,$campo){
		/* echo "VIENE ";print_r( $d );
		<TABLE border='1' bgcolor='#C0C0C0' width='70%' cellpadding='3' cellspacing='0' ><TR><TD colspan=3></td></tr>
		<tr><td></td><td>
		cellpadding:3;cellspacing:0;
		*/
		echo  "
		<div style='background:#C0C0C0;width:80%;margin:auto;border:#666 solid 1px;' >
		<TABLE border='0' bgcolor='#C0C0C0' width='100%'>
		";
		$enfoque = "";
		if( is_numeric( $this->llave2 ) ){ $llave2 = true; }else{ $llave2 = false; } 
		if( is_numeric( $this->llave3 ) ){ $llave3 = true; }else{ $llave3 = false; } 
		for ( $x=0; $x < $this->numCampos; $x++ ){
			$c = $this->Cam[$x];
			if( $this->sel[$x] == 'S' ){
				echo "<TR>";
				echo "<TH>".$this->Tit[$x]."</TH>";
				echo "<TD>";
				if( isset( $this->posib[$x] ) && $this->posib[$x] == "S" ){
					$depen = "";$depencam = "";
					if( isset( $this->sel_dep ) && count( $this->sel_dep ) > 0 ){
						if( $this->sel_dep[0]['de'] == $x ){ 
							$depen = " onchange=\"cambia(this,'".$this->Cam[ $this->sel_dep[0]['campo'] ]."');\" ";
						}
						if( $this->sel_dep[0]['campo'] == $x && !isset( $_REQUEST[ $this->Cam[ $x ] ] ) ){
							$depencam = " disabled ";
						}
					}
					echo "<select name='".$c."' ".$depen.">
					";
					//$a = $this->daposib($x);
					$a = $this->posib[$x];
					for($n=0; $n < count( $a ); $n++ ){
						echo "<option value='".$a[$n][0]."' ";
						if( trim( $a[$n][0] ) == trim( $d[$c] ) ){
							echo " selected='selected' ";
						}else{
							echo $depencam;
						}
						echo "> ".$a[$n][1]."</option>
						";
					}
					echo "</select>
					";
				}else{
					if( $this->Tam[$x] > 50 ){
						echo "<textarea name='".$c."' cols='60' rows='2'>".$d[ $c ]."</textarea>";				
					}else{
						echo "<INPUT type='text' name='".$c."' size='".$this->Tam[$x]."' maxlength='".$this->Tam[$x]."' value='".$d[ $c ]."'";
						if( $x == (int)$this->llave ){
							//echo " linea: ".$x." campo: ".$this->llave;
							if( $campo == $this->Cam[ $this->llave ] && !$llave2 ){
								echo " onchange='submit();' ";
							//}else{
							//	echo " readOnly='readonly' ";
							}
						}
						if( $llave2 && $campo == $this->Cam[ $this->llave2 ] ){
							echo " onchange='submit();' ";
						}
						if( $llave3 && $campo == $this->Cam[ $this->llave3 ] ){
							echo " onchange='submit();' ";
						}
						echo ">";
					}
				}
				echo "</TD>";
				echo "</TR>";
				if( $enfoque == "" && $this->Cam[$x] != $this->llave ){
					//echo "Campo ".$this->Cam[$x];
					$enfoque = $this->Cam[$x];
				}
			}else{
				echo "<INPUT type='hidden' name='".$c."' size='".$this->Tam[$x]."' maxlength='".$this->Tam[$x]."'";
				switch( $this->Tip[$x] ){
					case 'D' :
							if( $this->Tam[$x] == 10 ){
								echo " value='".date('Y-m-d')."' ";
							}else{
								echo " value='".date('Y-m-d H:i:s')."' ";
							}
							break;
					case 'U' :
							echo " value='".$_SESSION['usuario']."' ";
							break;
					default  :
							echo " value='".$d[ $c ]."'";
							break;
				}
				echo ">";
			}
		}
		//echo "<script language='JavaScript'>alert('ENFOQUE ".$enfoque."');</script>";
		if( $enfoque == "" ){
			$enfoque = $this->Cam[0];
		}
		echo "</TABLE>";
		echo "</div>";
		return $enfoque;
	}
   
	public function lis($where=""){
		$arr = $this->lee($where);
		echo "<H2>Listado de ".$this->titTabla."</H2>";
		$ancho = 0;$a_ancho = array();
		$a_tit = array();
		$titular = "	<tr style='background-color:#0099CC; color:#FFFFFF;'>
		";
		for($x=0; $x < $this->numCampos; $x++ ){
			if( $this->sel[$x] == 'S' ){
				if( strlen( trim( $this->Tit[$x] ) ) > $this->Tam[$x] ){
					$a_ancho[$x] = strlen( trim( $this->Tit[$x] ) ) + 100 ;
				}else{
					$a_ancho[$x] = ( $this->Tam[$x] + 100 );
				}
				$ancho += $a_ancho[$x];

			}
		}
		$ancho2 = $ancho + 20;
		$anchot = ( $ancho2 + 20 ); // adiciono otros 20 para la columna del #.
		$titular .= "		<th width='20px'>#</th>
			";
		for($x=0; $x < $this->numCampos;$x++){
			if( $this->sel[$x] == 'S' ){
				$titular .= "	<th style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>".trim( $this->Tit[$x] )."</th>
			";
			}
		}
		$titular .= "	</tr>
		";
		
		?>
		
		<div  align='left' style="width:<?php echo $anchot."px" ?>;position:relative;left:0px;border:#666 solid 0px;font-size:10pt;">
			<table border='1' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' style="font-size:12px;width:<?php echo $ancho2."px"?>;table-layout:fixed;"> 
			<?php
			echo $titular;
			?>
			</table>
		</div>
		
		<div align=left style="width:<?php echo $anchot."px" ?>;overflow:auto;position:relative;left:0px;height:300px;border:#666 solid 0px;font-size:12px;">
		<?php
		echo "<table border=1 cellpadding=0 cellspacing=0 style='font-size:12px; width:".$ancho2."px;table-layout:fixed;'>
			";
		//echo $titular;
		$co = "#DFDFDF";
		for($r=0; $r < count( $arr ); $r++ ){
			if( $co == "#DFDFDF" ){ $co = "#FFFFFF";}else{ $co = "#DFDFDF";}
			echo "<tr bgcolor='".$co."'>
			";
			echo "<td width='20px' align='right'>".( $r + 1 )."</td>
			";
			for($x=0; $x<$this->numCampos;$x++){
				if( $this->sel[$x] == 'S' ){
					if( $x == $this->llave ){
						echo "<td style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>&nbsp;
								<a href=\"".basename($_SERVER['PHP_SELF'])."?opcion=0&".$this->Cam[$x]."=".trim( $arr[$r][ $this->Cam[$x] ] )."\">
									".trim( $arr[$r][ $this->Cam[$x] ] )."</a>
							  </td>
							";					
					}else{
						echo "<td style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>&nbsp;".trim( $arr[$r][ $this->Cam[$x] ] )."</td>
							";
					}
				}
			}
			echo "</tr>
			";
		}
		?></table>
		</div>
		<br>
		<input type='button' value='Regresar' onclick='history.back();'>
		<!-- </div>  //-->
		<?php
		exit;
	}
	
	public function lisn($where="",$o_dep = ""){
		$arr = $this->lee($where);
		echo "<H2>Listado de ".$this->titTabla."</H2>";
		echo "  </div>";
		$ancho = 0;$a_ancho = array();
		$a_tit = array();
		$titular = "	<tr style='background-color:#0099CC; color:#FFFFFF;'>
		";
		for($x=0; $x < $this->numCampos; $x++ ){
			if( $this->sel[$x] == 'S' ){
				if( strlen( trim( $this->Tit[$x] ) ) > $this->Tam[$x] ){
					$a_ancho[$x] = strlen( trim( $this->Tit[$x] ) ) + 100 ;
				}else{
					$a_ancho[$x] = ( $this->Tam[$x] + 100 );
				}
				$ancho += $a_ancho[$x];
			}
		}
		$ancho2 = $ancho + 20;
		$anchot = ( $ancho2 + 20 ); // adiciono otros 20 para la columna del #.
		$titular .= "		<th width='20px'>#</th>
			";
		for($x=0; $x < $this->numCampos;$x++){
			if( $this->sel[$x] == 'S' ){
				$titular .= "	<th style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>".trim( $this->Tit[$x] )."</th>
			";
			}
		}
		$titular .= "	</tr>
		";
		?>
		<div  align='left' style="width:95%;position:relative;left:0px;border:#666 solid 0px;font-size:10pt;">
			<table border='1' bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' style="font-size:12px;width:100%;table-layout:fixed;text-overflow: '-';">
			<?php
			echo $titular;
			?>
			</table>
		</div>
		
		<!-- <div align=left style="width:97%;overflow:auto;position:relative;left:0px;height:300px;border:#666 solid 0px;font-size:12px;"> -->
		<div align=left style="width:95%;position:relative;left:0px;border:#666 solid 0px;font-size:12px;">
		<?php
		echo "<table border=1 cellpadding=0 cellspacing=0 style='font-size:12px; width:100%;table-layout:fixed;word-wrap:break-word;text-overflow: \'-\';'>
			";
		//echo $titular;
		$co = "#DFDFDF";
		for($r=0; $r < count( $arr ); $r++ ){
			$dep = "";
			//if( isset($this->dep) ){
			//	$a_dep = $this->daProce($arr[$r]['cod_dpto'],$arr[$r]['cod_prd']);
			//	$dep = "<tr>  </tr>";
			//}
			if( $co == "#DFDFDF" ){ $co = "#FFFFFF";}else{ $co = "#DFDFDF";}
			echo "<tr bgcolor='".$co."'>
			";
			echo "<td width='20px' align='right'>".( $r + 1 )."</td>
			";
			for($x=0; $x<$this->numCampos;$x++){
				if( $this->sel[$x] == 'S' ){
					if( $x == $this->llave ){
						echo "<td style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>&nbsp;
								<a href=\"".basename($_SERVER['PHP_SELF'])."?opcion=0&".$this->Cam[$x]."=".trim( $arr[$r][ $this->Cam[$x] ] )."\">
									".trim( $arr[$r][ $this->Cam[$x] ] )."</a>
							  </td>
							";					
					}else{
						echo "<td style='width:".round( ( $a_ancho[$x]/$ancho2 * 100 ), 2 )."%;'>&nbsp;".trim( $arr[$r][ $this->Cam[$x] ] )."</td>
						";
					}
				}
			}
			echo "</tr>
			";
			
		}
		?></table>
		</div>
		<br>
		<input type='button' value='Regresar' onclick='history.back();'>
		<!-- </div>  //-->
		<?php
		exit;
	}
}
 
// genera objeto a partir de la clase Tabla. recibe el nombre y objeto base.
function crea_t($n,$odb){ 
	$o = new Tabla($odb,$n);
	/*$o->nomTabla=$n;
	$o->cn=$l;
	$o->trae();*/
	return $o;
}  
	
function val_prg($u,$p,$odb){
	$o = crea_t("nue_perpro",$odb);
	$a_p = explode(".",$p);
	$p = strtoupper( $a_p[0] );
	$a_x = $o->lee(" WHERE usuario='$u' AND programa='".$p."'");
	if( count( $a_x ) > 0 ){ return true;}else{ return false;}
} 

?>