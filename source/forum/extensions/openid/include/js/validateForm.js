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


openid_validateForm = Forum.validateForm;

openid_match = function(x)
{
	return x.name && x.name.indexOf('req_')==0;
}

Forum.validateForm = function(form)
{
	var nodes = Forum.arrayOfMatched(openid_match, form.elements);

	for (key in nodes)
	{
		nodes[key].name = '_' + nodes[key].name;
	}

	result = openid_validateForm(form);

	for (key in nodes)
	{
		nodes[key].name = nodes[key].name.substr(1);
	}

	return result;
}
