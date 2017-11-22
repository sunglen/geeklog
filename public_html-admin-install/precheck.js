/**
* Check DB settings as a part of Precheck for Geeklog
*
* @author   mystral-kk <geeklog AT mystral-kk DOT net>
* @date     2009-02-03
* @version  1.3.2
* @license  GPLv2 or later
* @note     This script (precheck.js) needs 'core.js' published
*           by SitePoint Pty. Ltd.
*/
var callback = {
	/**
	* Callback function when a database was selected
	*/
	showCountResult: function(req) {
		var install_submit = $('install_submit');
		var db_name_warning = $('db_name_warning');
		
		if ((req.responseText == '-ERR') || (parseInt(req.responseText) > 0)) {
			install_submit.disabled = true;
			Core.removeClass(db_name_warning, 'hidden');
			Core.addClass(db_name_warning, 'bad');
		} else {
			install_submit.disabled = false;
			Core.removeClass(db_name_warning, 'bad');
			Core.addClass(db_name_warning, 'hidden');
		}
	},
	
	/**
	* Callback function when db_name selection was changed
	*/
	dbSelected: function() {
		$('install_submit').disabled = true;
		$('db_name_warning').setAttribute('class', 'hidden');
		
		if ($('db_name').value != '--') {
			var type   = $('db_type').value;
			var host   = $('db_host').value;
			var user   = $('db_user').value;
			var pass   = $('db_pass').value;
			var name   = $('db_name').value;
			var prefix = $('db_prefix').value;
			var args = {
				'url': 'precheck.php',
				'method': 'get',
				'params': 'mode=counttable&type=' + type + '&host=' + host + '&user=' + user + '&pass=' + pass + '&name=' + name + '&prefix=' + prefix,
				'onSuccess': callback.showCountResult
			}
			
			// prefix could be an empty string, so we don't check it here
			if ((host != '') && (user != '') && (pass != '') && (name != '')) {
				if (!Core.Ajax(args)) {
					alert('サーバとの通信に失敗しました。');
				}
			}
		}
	},
	
	/**
	* Callback function for Ajax
	*/
	showLookupResult: function(req) {
		var db_name = $('db_name');
		var install_submit = $('install_submit');
		
		if (req.responseText.substring(0, 4) == '-ERR') {
			db_name.disabled = true;
			install_submit.disabled = true;
			if (req.responseText.length > 4) {
				$('db_err').innerHTML = req.responseText.substring(4);
				Core.addClass($('db_err'), 'bad');
			}
		} else {
			var dbs = req.responseText.split(';');
			while (db_name.length > 0) {
				db_name.removeChild(db_name.childNodes[0]);
			}
			
			var node = document.createElement('option');
			node.value = '--';
			node.appendChild(document.createTextNode('選択してください'));
			db_name.appendChild(node);
			
			for (i in dbs) {
				var db = dbs[i];
				if (db == 'mysql') {
					continue;
				}
				var node = document.createElement('option');
				node.value = db;
				node.appendChild(document.createTextNode(db));
				db_name.appendChild(node);
			}
			
			db_name.disabled = false;
			install_submit.disabled = true;
		}
	},
	
	/**
	* Callback function when <input> values were changed
	*/
	dataEntered: function() {
		var type = $('db_type').value;
		var host = $('db_host').value;
		var user = $('db_user').value;
		var pass = $('db_pass').value;
		var args = {
			'url': 'precheck.php',
			'method': 'get',
			'params': 'mode=lookupdb&type=' + type + '&host=' + host + '&user=' + user + '&pass=' + pass,
			'onSuccess': callback.showLookupResult
		}
		if ((host != '') && (user != '') && (pass != '')) {
			if (!Core.Ajax(args)) {
				alert('サーバとの通信に失敗しました。');
			}
		}
	},
	
	/**
	* Change <input type="text"> element into <select>
	*/
	modifyDbnameField: function() {
		var db_name_parent = $('db_name_parent');
		db_name_parent.removeChild($('db_name'));
		
		var select = document.createElement('select');
		select.setAttribute('id', 'db_name');
		select.setAttribute('name', 'db_name');
		select.setAttribute('disabled', true);
		db_name_parent.appendChild(select);
	},
	
	/**
	* Append event listeners
	*/
	init: function() {
		this.modifyDbnameField();
		$('install_submit').setAttribute('disabled', true);
		Core.addEventListener($('db_type'), 'change', this.dataEntered);
		Core.addEventListener($('db_host'), 'keyup', this.dataEntered);
		Core.addEventListener($('db_user'), 'keyup', this.dataEntered);
		Core.addEventListener($('db_pass'), 'keyup', this.dataEntered);
		Core.addEventListener($('db_name'), 'change', this.dbSelected);
	}
}

Core.start(callback);
