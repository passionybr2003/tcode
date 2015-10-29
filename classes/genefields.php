<?php
error_reporting(1);
class generateFields {
	public function genTextFields($max_placeholder=NULL){
		$text_data = "<div class='text_css'><strong>Text Field Options</strong><br>";
		for($i = 0;$i < $max_placeholder; $i++){
			$str = "<div class='col-sm-6'><input type='text' class='form-control' name='data[text][$i][title]' placeholder='Label Name (Field Title)' ></div> <div class='col-sm-6'><input class='form-control' type='text' name='data[text][$i][name]' placeholder='Field Name'></div><br>";
			$text_data .= $str;
		}
		$text_data .= "</div>";
		return $text_data;
	}
	public function genPassFields($max_placeholder=NULL){
		$pass_data = "<div class='pass_css'><strong>Password Field Options</strong><br>";
		for($i = 0;$i < $max_placeholder; $i++){
			$str = "<div class='col-sm-6'><input type='text' class='form-control' name='data[pass][$i][title]' placeholder='Label Name (Field Title)' ></div> <div class='col-sm-6'> <input class='form-control' type='text' name='data[pass][$i][name]' placeholder='Field Name'></div><br>";
			$pass_data .= $str;
		}
		$pass_data .= "</div>";
		return $pass_data;
	}
	public function genRadioFields($max_placeholder=NULL,$radioFvOps=NULL){
		$radio_data = "<div class='radio_css'><strong>Radio Button Options</strong><br>";
		$radioFvOps = substr($radioFvOps,0,-1);
		$radioFvOps_arr = explode(",",$radioFvOps);
		for($i = 0;$i < $max_placeholder; $i++){
			$sno = $i+1;
			$str = "<strong>$sno - Radio Button Fields</strong><br><div class='col-sm-6'><input type='text' class='form-control' name='data[radio][$i][title]' placeholder='Label Name (Field Title)' ></div> <div class='col-sm-6'><input class='form-control' type='text' name='data[radio][$i][name]' placeholder='Field Name'></div><br>";
			$radio_data .= $str;
			for($j=0;$j<$radioFvOps_arr[$i];$j++){
				$k = $j+1;
				$radio_options = "<div class='form-group form-group-sm'><label class='col-sm-6 control-label'>Option $k </label><div class='col-sm-6'><input class='form-control' type='text' name='data[radio][$i][options][$j]'></div></div>";
				$radio_data .= $radio_options;	
			}
			$radio_data .= "<br>";
		}
		$radio_data .= "</div>";
		return $radio_data;
	}
	
	public function genCheckFields($max_placeholder=NULL,$checkFvOps=NULL){
		$check_data = "<div class='checkbox_css'><strong>Checkbox Options</strong><br>";
		$checkFvOps = substr($checkFvOps,0,-1);
		$checkFvOps_arr = explode(",",$checkFvOps);
		for($i = 0;$i < $max_placeholder; $i++){
			$str = "<div class='col-sm-6'><input type='text' class='form-control' name='data[checkbox][$i][title]' placeholder='Label Name (Field Title)' ></div> <div class='col-sm-6'> <input class='form-control' type='text' name='data[checkbox][$i][name]' placeholder='Field Name'></div><br>";
			$check_data .= $str;
			for($j=0;$j<$checkFvOps_arr[$i];$j++){
				$k = $j+1;
				$check_options = "<div class='form-group form-group-sm'><label class='col-sm-6 control-label'>Option $k</label><div class='col-sm-6'><input class='form-control' type='text' name='data[checkbox][$i][options][$j]'></div></div><br>";
				$check_data .= $check_options;	
			}
			$check_data .= "<br>";	
		}
		$check_data .= "</div>";
		return $check_data;
	}
	public function genSelectFields($max_placeholder=NULL){
		$select_data = "<div class='select_css'><strong>Select Field Options</strong><br>";
		for($i = 0;$i < $max_placeholder; $i++){
			$str = "<div class='col-sm-6'><input type='text' class='form-control' name='data[select][$i][title]' placeholder='Label Name (Field Title)' > </div>
					<div class='col-sm-6'><input type='text' class='form-control' name='data[select][$i][name]' placeholder='Field Name'></div><br>
					<span>Enter Option placeholder-Option Name <br> E.g: 1-Orange,2-Blue,3-Green</span><br>
					<textarea class='form-control' name='data[select][$i][options]' rows='5' cols='50'></textarea><br><br>
					";
			$select_data .= $str;
		}
		$select_data .= "</div>";
		return $select_data;
	}
	public function genTextareaFields($max_placeholder=NULL){
		$textarea_data = "<div class='textarea_css'><strong>Textarea Options</strong><br>";
		for($i = 0;$i < $max_placeholder; $i++){
			$str = "<div class='col-sm-6'><input type='text' class='form-control' name='data[textarea][$i][title]' placeholder='Label Name (Field Title)' > </div>
					<div class='col-sm-6'><input type='text' class='form-control' name='data[textarea][$i][name]' placeholder='Field Name'></div><br>
					";
			$textarea_data .= $str;
		}
		$textarea_data .= "</div><br>";
		return $textarea_data;
	}
}
$g = new generateFields();

