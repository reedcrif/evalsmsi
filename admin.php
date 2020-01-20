<?php
/*=========================================================
// File:        admin.php
// Description: administrator page of EvalSMSI
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
include("funct_admin.php");
session_start();
$authorizedRole = array('1');
isSessionValid($authorizedRole);
headPage($appli_titre, "Administration");
$script = basename($_SERVER['PHP_SELF']);

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
	case 'new_user':
		createUser();
		footPage();
		break;

	case 'record_user':
		if ($id=recordUser('add')) {
			linkMsg($script, "Utilisateur ajouté dans la base", "ok.png");
		} else {
			linkMsg($script, "Erreur d'enregistrement", "alert.png");
		}
		footPage();
		break;

	case 'select_user':
		selectUserModif();
		footPage();
		break;

	case 'modif_user':
		modifUser($_POST['user']);
		footPage();
		break;

	case 'update_user':
		if ($id=recordUser('update')) {
		linkMsg($script, "Utilisateur modifié dans la base", "ok.png");
	} else {
		linkMsg($script, "Erreur de modification", "alert.png");
	}
	footPage();
	break;

	case 'new_regroup':
		createEtablissement('regroup');
		footPage();
		break;

	case 'maintenance':
		maintenanceBDD();
		footPage($script, "Accueil");
		break;

	case 'modif_etab':
		if (empty($_POST['etablissement'])) {
			selectEtablissementModif();
		} else {
			modifEtablissement($_POST['etablissement']);
		}
		footPage();
		break;

	case 'update_etab':
		if ($id=recordEtablissement('update')) {
			linkMsg($script, "Etablissement modifié dans la base", "ok.png");
		} else {
			linkMsg($script, "Erreur de modification", "alert.png");
		}
		footPage();
		break;

	case 'update_regroup':
		if ($id=recordEtablissement('update_regroup')) {
			linkMsg($script, "Etablissement modifié dans la base", "ok.png");
		} else {
			linkMsg($script, "Erreur de modification", "alert.png");
		}
		footPage();
		break;

	case 'new_etab':
		createEtablissement();
		footPage();
		break;

	case 'record_etab':
		if ($id=recordEtablissement('add')) {
			linkMsg($script, "Etablissement créé dans la base", "ok.png");
		} else {
			linkMsg($script, "Erreur d'enregistrement", "alert.png");
		}
		footPage();
		break;

	case 'record_regroup':
		if (recordEtablissement('add_regroup')) {
			linkMsg($script, "Etablissement créé dans la base", "ok.png");
		} else {
			linkMsg($script, "Erreur d'enregistrement", "alert.png");
		}
		footPage();
		break;

	case 'add_par':
		addParagraphs();
		footPage();
		break;

	case 'new_par':
		recordParagraph($_POST, 'add');
		footPage($script, "Accueil");
		break;

	case 'add_sub_par':
		addSubParagraphs();
		footPage();
		break;

	case 'new_sub_par':
		recordSubParagraph($_POST, 'add');
		footPage($script, "Accueil");
		break;

	case 'add_quest':
		addQuestion();
		footPage();
		break;

	case 'new_question':
		recordQuestion($_POST, 'add');
		footPage($script, "Accueil");
		break;

	case 'modifications':
		modifications();
		footPage($script, "Accueil");
		break;

	default:
		menuAdmin();
		footPage();
		break;
	}
} else {
	menuAdmin();
	footPage();
}

?>

<script type='text/javascript' src='js/evalsmsi.js'></script>
