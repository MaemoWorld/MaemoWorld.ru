<?php
/**
 * @file German/openid.php
 * @brief Contains PunBB language information for OpenID extension (German).
 */

/*
 *      Copyright 2009 Alexander Steffen <devel.20.webmeister@spamgourmet.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


if (!defined('FORUM')) die();

/**
 * @brief German language strings.
 */
$lang_openid = array(
	'OpenID'					=> 'OpenID',
	'OpenID login'				=> 'Sie können zur Anmeldung wahlweise Ihre OpenID oder Benutzername und Passwort verwenden.',
	'OpenID registration'			=> '<a href="%s">Melden Sie sich mit Ihrer OpenID an</a>, um automatisch ein Benutzerkonto zu erstellen.',
	'OpenID password change'		=> 'Um Ihr Passwort zu ändern, müssen Sie entweder Ihr altes Passwort angeben oder sich mit Ihrer OpenID authentifizieren.',
	'OpenID email change'			=> 'Um Ihre E-Mail-Adresse zu ändern, müssen Sie entweder Ihr Passwort angeben oder sich mit Ihrer OpenID authentifizieren.',
	'OpenID update profile'			=> 'Daten per OpenID anfordern',
	'OpenID manage'					=> 'Um Ihren Account zu schützen, muss das Hinzufügen einer neuen oder das Entfernen einer bestehenden OpenID entweder mit Ihrem Passwort oder einer anderen zu Ihrem Account gehörenden OpenID bestätigt werden.',
	'override data'					=> 'Vorhandene Daten werden überschrieben.',
	'Manage your OpenIDs'			=> 'Ändern Sie die mit Ihrem Account verknüpften OpenIDs',
	'Manage user OpenIDs'			=> 'Ändern Sie die mit mit dem Account von %s verknüpften OpenIDs',
	'New OpenID'					=> 'Neue OpenID',
	'Existing OpenID'				=> 'Bestehende OpenID',
	'Add OpenID'					=> 'Hinzufügen',
	'Remove OpenID'					=> 'Entfernen',
	'Authentication failure'		=> 'OpenID-Authentifizierung fehlgeschlagen: %s',
	'Unknown failure'				=> 'Unbekannter Fehler.',
	'Invalid identifier'			=> 'Die angegebene OpenID \'%s\' ist ungültig.',
	'Identifier already registered'	=> 'Die angegebene OpenID \'%s\' ist bereits registriert.',
	'Choose another OpenID'			=> 'Sie können sich nicht mit der OpenID authentifizieren, die Sie entfernen möchten.',
	'Error inexistent directory'	=> 'Das Verzeichnis \'%s\' konnte nicht angelegt werden.',
	'Error not a directory'			=> 'Die Datei \'%s\' ist kein Verzeichnis.',
	'Error not writable'			=> 'In das Verzeichnis \'%s\' kann nicht geschrieben werden.',
);
?>
