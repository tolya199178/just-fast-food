<?php


	class database
	{
		var $db_HOST = "localhost";
		var $db_USER = "justfast_view";
		var $db_PASS = "General!";
		var $database = "justfast_food_old";

		/*var $db_HOST = "localhost";
		var $db_USER = "root";
		var $db_PASS = "";
		var $database = "justfast";*/

		var $sqlerror = "SQL IS OUT!!";
		var $con ;

		//connection
		function database()
		{
			$this->connect_db();
		}

		function show() {
			return 'WORKING...';
		}

		function connect_db()
		{
			$this->con = mysql_connect($this->db_HOST,$this->db_USER,$this->db_PASS) or die(mysql_error());
			$m = mysql_select_db($this->database,$this->con) or die(mysql_error());
			return($this->con);
		}

		//query method
		function query_db($query,$print = false)
		{
			$sql = $query;
			if((!empty($sql)) && ($print == true))
			{
				echo $sql;
			}
			return(mysql_query($sql,$this->con));
		}

		//close db
		function close_db()
		{
			mysql_close($this->con);
		}

		//last insert id created
		function id_db()
		{
			return mysql_insert_id($this->con);
		}

		//get number affected rows from last query
		function affecte_db()
		{
		    $tmp = mysql_affected_rows();
		    return($tmp);
		}

		//get number of rows
		function num_rows($q)
		{
			$tmp = mysql_num_rows($q);
			return($tmp);
		}

		//get number of fields
		function num_fields($q)
		{
			$tmp = mysql_num_fields($q);
			return($tmp);
		}

		//get mysql info
		function db_info()
		{
			return mysql_info($this->con);
		}

		//fetch methods
		function fetch_db_row($fetched)
		{
			return mysql_fetch_row($fetched);
		}

		function fetch_db_array($fetched)
		{
			return mysql_fetch_array($fetched);
		}


		function fetch_db_assoc($fetched)
		{
			return mysql_fetch_assoc($fetched);
		}

		function fetch_db_object($fetched)
		{
			return mysql_fetch_object($fetched);
		}

		function show_column_names($table)
		{
			$str = "";
			$get = mysql_query("SHOW COLUMNS FROM ". $table,$this->con);
			while($arr = $this -> fetch_db_assoc($get)) {
				$str .= "`". $arr['Field'] . "`, ";
			}

			return substr($str,0,-2);
		}



		//makeup from query to table view
		// class.inc.css must be declaired in docuement
		function get_table($query,$names='',$url='',$extrafields='') //names array of fieldnames | $url array 1. fieldindex 2. url
		{
			if($_GET['line']=="1")
			{
				$lijn = "DESC";
			}
			else
			{
				$lijn = "ASC";
			}

			if(isset($_GET['orderby']))
			{
				$order = " ORDER BY `".$_GET['orderby']."` ".$lijn;
			}
			else
			{
				$order = "";
			}
			//" ORDER BY ".$_GET['orderby']." ".$lijn

			$query = str_replace(";","",$query.$order);


			$sql = mysql_query($query);
			if(!$sql)
			{
				echo "query could not be executed<pre>".$query."</pre>";
				die();
			}

			unset($code);
			$code .= "<table class=\"sqltable\" cellspacing=\"1\">\n";
			$code .= "	<tr>\n";


			//sortable by url
			$replace = array("?orderby=".$_GET["orderby"]."&","&orderby=".$_GET["orderby"]."&","line=".$_GET['line'],"?");
			$replace1 = array("?orderby=".$_GET["orderby"]."&","&orderby=".$_GET["orderby"]."&","line=".$_GET['line']);
			$with = array("","","","");
			$with1 = array("","","");
			if($uri = str_replace($replace,$with,"?".$_SERVER['QUERY_STRING']))	{
				if(strlen($uri)>0)	{
					$replaced = "1";
				}
				else	{
					$replaced = "2";
				}
			}


			$fw_uri = str_replace($replace1,$with1,$_SERVER['REQUEST_URI']);

			if($replaced == "1")
				$order = "&amp;orderby=";
			else
				$order = "?orderby=";

			if($_GET['line']=='0')
				$lijn = "1";
			else
				$lijn = "0";



			//fieldnames
			if($extrafields!='')
			{
				$code .= str_repeat("<td>&nbsp;</td>",count($extrafields));
			}

			if($names === '')
			{
				for($i=0;$i<=(mysql_num_fields($sql)-1);$i++)
				{
					$meta = mysql_fetch_field($sql,$i);
					$code .= "		<td><a href=\"".$fw_uri.$order.str_replace(" ","+",$meta->name)."&amp;line=".$lijn."\">".$meta->name."</a></td>\n";
				}
			}
			else
			{
				for($i=0;$i<=(mysql_num_fields($sql)-1);$i++)
				{


					$meta = mysql_fetch_field($sql,$i);
					$code .= "		<td><a href=\"".$fw_uri.$order.str_replace(" ","+",$meta->name)."&amp;line=".$lijn."\">".$names[$i]."</a></td>\n";
				}
			}
			$code .= "	</tr><tr>\n";


			//datafields
			while($row_data = mysql_fetch_row($sql))
			{
				if($extrafields!='')
				{
					for($q=0;$q<=(count($extrafields)-1);$q++)
					{
						if($extrafields[$q][2]==1)
						{
							$id = $row_data[$extrafields[$q][3]];
						}
						else
						{
							$id = "";
						}

						if(substr_count($url[1],"?")===1) {
							$ch = "&amp;";
						}
						else {
							$ch = "?";
						}

						$code .= "<td><a href=\"".$extrafields[$q][1].$id."\">".$extrafields[$q][0]."</a></td>\n";
					}
				}

				for($k=0;$k<=(mysql_num_fields($sql)-1);$k++)
				{
					if(!empty($url[1]))
					{
						if($url[0]==$k)
						{
							if(substr_count($url[1],"?")===1) {
								$ch = "&amp;";
							}
							else {
								$ch = "?";
							}
							$code .= "		<td><a href=\"".$url[1].$ch.$url[3]."=".$row_data[$url[2]]."\">".$row_data[$k]."</a></td>\n";
						}
						else
						{
							$code .= "		<td>".$row_data[$k]."</td>\n";
						}
					}
					else
					{
						$code .= "		<td>".$row_data[$k]."</td>\n";
					}
				}
				if($l<(mysql_num_rows($sql)-1))
				{
					$code .= "	</tr><tr>\n";
				}
				$l++;
			}


			$code .= "</tr>\n";
			$code .= "</table>\n";

			return($code);
		}

		//makeup from query to table view (one record)
		// class.inc.css must be declaired in docuement
		function overview_table($query,$fieldnames='')
		{
			$sql = mysql_query(str_replace(";"," ",$query)."LIMIT 1;");

			if(!$sql)
			{
				echo "Cant preform query";
				die();
			}

			if(!empty($fieldnames))
			{
				if(((mysql_num_fields($sql)) != (count($fieldnames))))
				{
					echo "array not equal to query";
					die();
				}
			}



			$code = "";
			$code .= "<table class=\"sqloverview\" cellspacing=\"1\">\n";

			if($fieldnames==='')
			{
				while($data_row = $data_row = mysql_fetch_row($sql))
				{
					for($k=0;$k<=(mysql_num_fields($sql)-1);$k++)
					{
						unset($meta);
						$meta = mysql_fetch_field($sql,$k);
						$code .= "	<tr>\n		<td class=\"sqloverview_namefield\">".$meta->name."</td>\n		<td class=\"sqloverview_datafield\">".$data_row[$k]."</td>\n	</tr>\n";
					}
				}
			}
			else
			{
				while($data_row = $data_row = mysql_fetch_row($sql))
				{
					for($k=0;$k<=(count($fieldnames)-1);$k++)
					{
						$code .= "	<tr>\n		<td class=\"sqloverview_namefield\">".$fieldnames[$k]."</td><td class=\"sqloverview_datafield\">".$data_row[$k]."</td></tr>\n";
					}
				}
			}

			$code .= "</table>\n";
			return($code);
		}





};


/*function md5s($md_hash)
{
	$md_hash = md5(md5($md_hash)."_SAFE");
	return $md_hash;
}*/


?>
