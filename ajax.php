<?php
/*=========================================================
// File:        ajax.php
// Description: AJAX exchange for EvalSMSI
// Created:     2009-01-01
// Licence:     GPL-3.0-or-later
// Copyright 2009-2019 Michel Dubois

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
=========================================================*/

include("functions.php");
startSession();
$authorizedRole = array('2');
isSessionValid($authorizedRole);
header("Content-type: text/html; charset=utf-8");



$id_etab = intval($_GET['query']);

if (isRegroupEtabbyId($id_etab)) {
	$base = dbConnect();
	$request = sprintf("SELECT * FROM quiz");
	$result = mysqli_query($base, $request);
	dbDisconnect($base);
	if (mysqli_num_rows($result)) {
		$return = "Choisissez un questionnaire:&nbsp;<select name='id_quiz' id='id_quiz' required><option value=''>&nbsp;</option>";
		while ($row = mysqli_fetch_object($result)) {
			$return .= sprintf("<option value='%s'>%s</option>", $row->id, $row->nom);
		}
		$return .= "</select>";
	}else {
		$return = "Pas de questionnaire";
	}
} else {
	$annee = $_SESSION['annee'];
	$base = dbConnect();
	$request = sprintf("SELECT * FROM assess WHERE etablissement='%d' AND annee='%d' ", $id_etab, $annee);
	$result = mysqli_query($base, $request);
	if (mysqli_num_rows($result)) {
		$return = "Questionnaire:&nbsp;<select name='id_quiz' id='id_quiz' required><option value=''>&nbsp;</option>";
		while ($row = mysqli_fetch_object($result)) {
			$req_quiz = sprintf("SELECT * FROM quiz WHERE id='%d' LIMIT 1", $row->quiz);
			$res_quiz = mysqli_query($base, $req_quiz);
			$row_quiz = mysqli_fetch_object($res_quiz);
			$return .= sprintf("<option value='%s'>%s</option>", $row_quiz->id, $row_quiz->nom);
		}
		$return .= "</select>";
	} else {
		$return = "Pas de questionnaire";
	}
	dbDisconnect($base);
}

echo $return;

?>
