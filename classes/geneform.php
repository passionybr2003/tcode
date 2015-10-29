<?php
error_reporting(0);
require_once 'EditForm.php';
class geneform {
	public function makeForm($post_data=array()) {
		$_SESSION['text'] = array();
		$_SESSION['pass'] = array();
		$_SESSION['radio'] = array();
		$_SESSION['checkbox'] = array();
		$_SESSION['textarea'] = array();
	
//		echo "<pre>";
//		print_r($post_data);
		$table_name = $post_data['data']['common']['table_name'];
		if(!empty($post_data['data']['text'])) $text_data = $this->makeText($post_data['data']['text']);
		if(!empty($post_data['data']['pass'])) $pass_data = $this->makePass($post_data['data']['pass']);
		if(!empty($post_data['data']['radio'])) $radio_data = $this->makeRadio($post_data['data']['radio']);
		if(!empty($post_data['data']['checkbox'])) $check_data = $this->makeCheck($post_data['data']['checkbox']);
		if(!empty($post_data['data']['select'])) $select_data = $this->makeSelect($post_data['data']['select']);
		if(!empty($post_data['data']['textarea'])) $textarea_data = $this->makeTextarea($post_data['data']['textarea']);
//		print_r($_SESSION);
		$insert_query = $this->makeQuery();
		foreach($insert_query as $f=>$v){
			$fieldNames .= $f.",";
			$fieldValues .= "'".$v."',";
			$post_values .= " $v = "."$"."_POST['$f'];\n ";
		}
		$post_values;
		$fieldNames = substr($fieldNames,0,-1).",created,modified";
		$fieldValues = substr($fieldValues,0,-1).",now(),now()";
		$db_connections = 
		"<?php 
			$"."db_host='';
			$"."db_username='';
			$"."db_pass='';
			$"."db_name='';
			if(isset($"."_POST['submit']) && $"."_SERVER['REQUEST_METHOD'] == 'POST'){
		";
		$qry = " $"."query = \"INSERT INTO $table_name ($fieldNames) VALUES ($fieldValues)\";
				mysql_query($"."query); 
				if(mysql_affected_rows() > '0') {
					echo 'successfully inserted';
				} else {
					echo 'Not inserted successfully';
				}
			} \n ?>"; 
		$form_start = "<html>\n<body>\n<form name='' action='<?php echo htmlspecialchars($"."_SERVER['PHP_SELF']);?>' method='post'>\n";
		$buttons = "\n<input type='submit' value='Submit' name='submit' id='submit'>\n<input type='reset' value='Cancel' name='reset' id='reset'>";
		$form_end = "\n</form>\n</body>\n</html>";
		$data = $db_connections.$post_values.$qry."\n".$form_start." ".$text_data."\n ".$pass_data.$radio_data.$check_data.$select_data.$textarea_data.$buttons.$form_end;

		$dir_path = USER_FLD_PATH.$_SESSION['user_id']."/".DATE."/";
		if(!file_exists($dir_path)){
			mkdir($dir_path, 0700, true);
		}
		if($post_data['data']['common']['file_name'] == ''){
			$filename = date('dmyHis');
		} else {
			$filename = $post_data['data']['common']['file_name'];
		}
		$file = $filename.".php";
		$download_file = $dir_path.$file;
		file_put_contents($download_file, $data);
		$fileNamesList[$file] = $file;
		
		$editForm = new EditForm();
		$editFormData = $editForm->makeForm($post_data);
		$editFile = "edit_".$filename.".php";
		$edit_download_file = $dir_path.$editFile;
		file_put_contents($edit_download_file, $editFormData);
		$fileNamesList[$editFile] = $editFile;
		
		// Save created filenames in downloads table.
		$userId = $_SESSION['user_id'];
		$created = DATE_TIME;
		foreach($fileNamesList as $fileName){
			$records .= "('$userId','$fileName', '$created'),"; 
		}
		$records = substr($records,0,-1); 
                $user->user_created_files($records);
                $a['file'] = $file;
                $a['status'] = 1;
                return $a;
	}
	private function makeText($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
				if($ftitle_fname[name] == '') $ftitle_fname[name] = "text$k";
				$text_data .= "<label>$ftitle_fname[title]</label><input type='text' name='$ftitle_fname[name]' id='$ftitle_fname[name]' ><br>";
				$_SESSION['text'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		return $text_data;
	}
	private function makePass($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
				if($ftitle_fname[name] == '') $ftitle_fname[name] = "pwd$k";
				$pass_data .= "<label>$ftitle_fname[title]</label><input type='password' name='$ftitle_fname[name]' id='$ftitle_fname[name]' ><br>";
				$_SESSION['pass'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		return $pass_data;
	}
	private function makeRadio($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
			if($ftitle_fname[name] == '') $ftitle_fname[name] = "radio$k";
			$radio_data .= "<div><br><label>$ftitle_fname[title]</label><br>";
			foreach($ftitle_fname[options] as $ky=>$op){
				$op = strtolower($op);
				$radio_data .= "<input type='radio' name='$ftitle_fname[name]' id='$ftitle_fname[name]' value='$op'> $op";
			}
			$_SESSION['radio'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		$radio_data .= "</div>";
		return $radio_data;
	}
	private function makeCheck($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
			if($ftitle_fname[name] == '') $ftitle_fname[name] = "check$k";
			$check_data .= "<div><br><label>$ftitle_fname[title]</label><br>";
			foreach($ftitle_fname[options] as $ky=>$op){
				$op = strtolower($op);
				$check_data .= "<input type='checkbox' name='$ftitle_fname[name]' id='$ftitle_fname[name]' value='$op'> $op";
			}
			$_SESSION['checkbox'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		$check_data .= "</div>";
		return $check_data;
	}
	private function makeSelect($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
			if($ftitle_fname[name] == '') $ftitle_fname[name] = "select$k";
			$select_data .= "<div><br><label>$ftitle_fname[title]</label>";
			$select_options = explode(",",$ftitle_fname[options]);
			$select_data .= "<select name='$ftitle_fname[name]' id='$ftitle_fname[name]'>";
			$options = '';
			foreach($select_options as $ky=>$option){
				list($k,$name) = explode("-",$option);
				$name = ucwords($name);
				$options .= "<option value='$k'>$name</option>";
			}
			$select_data .= $options;
			$select_data .= "</select><br>";
			$_SESSION['select'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		$select_data .= "</div>";
		return $select_data;
	}
	private function makeTextarea($txtArr = array()){
		foreach($txtArr as $k=>$ftitle_fname){
			if($ftitle_fname[name] == '') $ftitle_fname[name] = "textarea$k";
			$textarea_data .= "<div><br><label>$ftitle_fname[title]</label><textarea name='$ftitle_fname[name]' id='$ftitle_fname[name]' rows='5' cols='30' ></textarea></div><br>";
			$_SESSION['textarea'][$ftitle_fname[name]] = "$".$ftitle_fname[name];
		}
		return $textarea_data;
	}
	private function makeQuery(){
		$_SESSION['text'] = $_SESSION['text']?$_SESSION['text']:array();
		$_SESSION['pass'] = $_SESSION['pass']?$_SESSION['pass']:array();
		$_SESSION['radio'] = $_SESSION['radio']?$_SESSION['radio']:array();
		$_SESSION['checkbox'] = $_SESSION['checkbox']?$_SESSION['checkbox']:array();
		$_SESSION['textarea'] = $_SESSION['textarea']?$_SESSION['textarea']:array();
		return $names = array_merge($_SESSION['text'],$_SESSION['pass'],$_SESSION['radio'],$_SESSION['checkbox'],$_SESSION['textarea']);
	}
}
$gform = new geneform();