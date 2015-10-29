<?php
require_once 'classes/genefields.php';
require_once 'libs/config.php';
$textFv = $_REQUEST['textFv'];
$passFv = $_REQUEST['passFv'];
$radioFv = $_REQUEST['radioFv'];
$radioFvOps = $_REQUEST['radioFvOps'];
$checkFv = $_REQUEST['checkboxFv'];
$checkboxFvOps = $_REQUEST['checkboxFvOps'];
$selectFv = $_REQUEST['selectFv'];
$textareaFv = $_REQUEST['textareaFv'];

$form_start = "<form name='' action=dashboard.php method='post'>";
$fileAndtableNames = "<div class='col-lg-6'><input type='text' class='form-control' placeholder='File Name' value='' name='data[common][file_name]' id='file_name'></div>
					<div class='col-lg-6'><input class='form-control' type='text' placeholder='Table Name' value='' name='data[common][table_name]' id='table_name'></div><br>";
$buttons = "<input type='submit' class='btn btn-success ' value='Submit' name='submit' id='submit'>
			<input type='reset' class='btn btn-success ' value='Cancel' name='reset' id='reset'>";
$form_end = "</form>";
if($textFv !='' && DEMO_MAX_INPUT_FIELD_VALUE >= $textFv)  $text_data = $g->genTextFields($textFv); 
if($passFv !='' && DEMO_MAX_INPUT_FIELD_VALUE >= $passFv) $pass_data = $g->genPassFields($passFv);
if($radioFv !='' && $radioFvOps != '' && DEMO_MAX_INPUT_FIELD_VALUE >= $radioFv) $radio_data = $g->genRadioFields($radioFv,$radioFvOps);
if($checkFv !=''&& $checkboxFvOps != '' && DEMO_MAX_INPUT_FIELD_VALUE >= $checkFv) $checkbox_data = $g->genCheckFields($checkFv,$checkboxFvOps);
if($selectFv !='' && DEMO_MAX_INPUT_FIELD_VALUE >= $selectFv) $select_data = $g->genSelectFields($selectFv);
if($textareaFv !='' && DEMO_MAX_INPUT_FIELD_VALUE >= $textareaFv) $textarea_data = $g->genTextareaFields($textareaFv);

$data = $form_start;
$data .= $fileAndtableNames;
$data .= $text_data;
$data .= $pass_data;
$data .= $radio_data;
$data .= $checkbox_data;
$data .= $select_data;
$data .= $textarea_data;
$data .= $buttons;
$data .= $form_end;
echo $data;
?>
