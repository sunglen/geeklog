function checkTable(num_table, v){
	for (i = 0; i < num_table; i ++) {
		document.getElementById("restore_structure" + String(i)).checked = v;
    }
}
function checkData(num_table, v){
	for (i = 0; i < num_table; i ++) {
		document.getElementById("restore_data" + String(i)).checked = v;
    }
}
