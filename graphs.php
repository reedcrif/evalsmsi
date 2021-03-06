<?php
/*=========================================================
// File:        graphs.php
// Description: graphs with chart.js page of EvalSMSI
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
$authorizedRole = array('2', '3', '4');
isSessionValid($authorizedRole);
header('Content-Type: application/json');


$annee = $_SESSION['annee'];
$name_etab = getEtablissement($_SESSION['id_etab']);
$labels = getAllDomAbstract();
$regroup = isRegroupEtab();
$scores = [];

if ($regroup) {
	$reponses = getRegroupAnswers();
	$scores[$annee] = array_values(calculNotes($reponses[$annee]));
} else {
	$reponses = getAnswers();
	$first_year = key($reponses);
	for ($i=0; $i<count($reponses); $i++) {
		$current_year = $i + $first_year;
		$scores[$current_year] = array_values(calculNotes($reponses[$current_year]));
	}
}

$goal = getObjectives();

$rawdata = [];
for ($i=0; $i<count($labels); $i++) {
	$cpt = $i+1;
	$table = extractSubDomRep($cpt, $reponses[$annee]);
	$titles = getSubParLibelle($cpt);
	$notes = array_values(calculNotesDetail($table, $cpt.'1'));
	$temp['domain'] = $labels[$i];
	$temp['subdomain'] = $titles;
	$temp['notes'] = $notes;
	$rawdata[] = $temp;
}

$results = [];
$results['etablissement'] = $name_etab;
$results['labels'] = $labels;
$results['goals'] = $goal;
$results['results'] = $scores;
$results['data'] = $rawdata;

echo json_encode($results);

?>
