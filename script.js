function autocomplet() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#nomClient').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#client_list').show();
				$('#client_list').html(data);
			}
		});
	} 
	else {
		$('#client_list').hide();
	}
}
//autocomplet nature
function autocomplet_nature() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#natureTravail').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_nature.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#nature_list').show();
				$('#nature_list').html(data);
			}
		});
	} 
	else {
		$('#nature_list').hide();
	}
}
//autocomplet province
function autocomplet_province() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#province_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_province.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#province_list_id').show();
				$('#province_list_id').html(data);
			}
		});
	} 
	else {
		$('#province_list_id').hide();
	}
}
//autocomplet municipalite
function autocomplet_municipalite() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#municipalite_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_municipalite.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#municipalite_list_id').show();
				$('#municipalite_list_id').html(data);
			}
		});
	} 
	else {
		$('#municipalite_list_id').hide();
	}
}
//autocomplet commune
function autocomplet_commune() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#commune_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_commune.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#commune_list_id').show();
				$('#commune_list_id').html(data);
			}
		});
	} 
	else {
		$('#commune_list_id').hide();
	}
}
//autocomplet quartier
function autocomplet_quartier() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#quartier_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_quartier.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#quartier_list_id').show();
				$('#quartier_list_id').html(data);
			}
		});
	} 
	else {
		$('#quartier_list_id').hide();
	}
}
//autocomplet quartier
function autocomplet_sousquartier() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#sousquartier_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_sous_quartier.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#sousquartier_list_id').show();
				$('#sousquartier_list_id').html(data);
			}
		});
	} 
	else {
		$('#sousquartier_list_id').hide();
	}
}
//autocomplet topographes
function autocomplet_topographe() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#nomTopographe').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_topographe.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#topographe_list').show();
				$('#topographe_list').html(data);
			}
		});
	} 
	else {
		$('#topographe_list').hide();
	}
}
//autocomplet services
function autocomplet_service() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#nomService').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_service.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#service_list').show();
				$('#service_list').html(data);
			}
		});
	} 
	else {
		$('#service_list').hide();
	}
}
//autocomplet sources
function autocomplet_source() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#nomSource').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_source.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#source_list').show();
				$('#source_list').html(data);
			}
		});
	} 
	else {
		$('#source_list').hide();
	}
}
//autocomplet zone
function autocomplet_zone() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#zone_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_zone.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#zone_list_id').show();
				$('#zone_list_id').html(data);
			}
		});
	} 
	else {
		$('#zone_list_id').hide();
	}
}
// set_item client : this function will be executed when we select an item
function set_item(item, item2, item3){
	// change input value
	$('#nomClient').val(item);
	$('#cinClient').val(item2);
	$('#telephoneClient').val(item3);
	// hide proposition list
	$('#client_list').hide();
}
// set_item nature : this function will be executed when we select an item
function set_item_nature(item){
	// change input value
	$('#natureTravail').val(item);
	// hide proposition list
	$('#nature_list').hide();
}
// set_item province : this function will be executed when we select an item
function set_item_province(item, item2){
	// change input value
	$('#province_id').val(item);
	$('#idProvince').val(item2);
	// hide proposition list
	$('#province_list_id').hide();
}
// set_item municipalite : this function will be executed when we select an item
function set_item_municipalite(item, item2){
	// change input value
	$('#municipalite_id').val(item);
	$('#idMp').val(item2);
	// hide proposition list
	$('#municipalite_list_id').hide();
}
// set_item commune : this function will be executed when we select an item
function set_item_commune(item, item2){
	// change input value
	$('#commune_id').val(item);
	$('#idCr').val(item2);
	// hide proposition list
	$('#commune_list_id').hide();
}
// set_item quartier : this function will be executed when we select an item
function set_item_quartier(item, item2){
	// change input value
	$('#quartier_id').val(item);
	$('#idQuartier').val(item2);
	// hide proposition list
	$('#quartier_list_id').hide();
}
// set_item quartier : this function will be executed when we select an item
function set_item_sousquartier(item, item2){
	// change input value
	$('#sousquartier_id').val(item);
	$('#idSousQuartier').val(item2);
	// hide proposition list
	$('#sousquartier_list_id').hide();
}
// set_item_topo : this function will be executed when we select an item
function set_item_topographe(item1){
	// change input value
	$('#nomTopographe').val(item1);
	// hide proposition list
	$('#topographe_list').hide();
}
// set_item_service : this function will be executed when we select an item
function set_item_service(item1){
	// change input value
	$('#nomService').val(item1);
	// hide proposition list
	$('#service_list').hide();
}
// set_item_source : this function will be executed when we select an item
function set_item_source(item1, item2){
	// change input value
	$('#nomSource').val(item1);
	$('#telephoneSource').val(item2);
	// hide proposition list
	$('#source_list').hide();
}
// set_item_zone : this function will be executed when we select an item
function set_item_zone(item){
	// change input value
	$('#zone_id').val(item);
	// hide proposition list
	$('#zone_list_id').hide();
}