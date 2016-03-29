function autocomplet_client() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#client_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_client.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#client_list_id').show();
				$('#client_list_id').html(data);
			}
		});
	} 
	else {
		$('#client_list_id').hide();
	}
}
//autocomplet ilot
function autocomplet_ilot() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#ilot').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_ilot.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#ilot_list').show();
				$('#ilot_list').html(data);
			}
		});
	} 
	else {
		$('#ilot_list').hide();
	}
}
//autocomplet lot
function autocomplet_lot() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#lot').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_lot.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#lot_list').show();
				$('#lot_list').html(data);
			}
		});
	} 
	else {
		$('#lot_list').hide();
	}
}
//autocomplet architecte
function autocomplet_architecte() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#architecte').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_architecte.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#architecte_list').show();
				$('#architecte_list').html(data);
			}
		});
	} 
	else {
		$('#architecte_list').hide();
	}
}
//autocomplet type
function autocomplet_type() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#type').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_type.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#type_list').show();
				$('#type_list').html(data);
			}
		});
	} 
	else {
		$('#type_list').hide();
	}
}
//autocomplet objet
function autocomplet_objet() {
	var min_length = 1; // min caracters to display the autocomplete
	var keyword = $('#objet').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh_objet.php',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#objet_list').show();
				$('#objet_list').html(data);
			}
		});
	} 
	else {
		$('#objet_list').hide();
	}
}
// set_item client : this function will be executed when we select an item
function set_item(item, item2, item3){
	// change input value
	$('#client_id').val(item);
	$('#numeroTelefon1').val(item2);
	$('#idClient').val(item3);
	// hide proposition list
	$('#client_list_id').hide();
}
// set_item architecte : this function will be executed when we select an item
function set_item_architecte(item){
	// change input value
	$('#architecte').val(item);
	//$('#idProvince').val(item2);
	// hide proposition list
	$('#architecte_list').hide();
}
// set_item ilot : this function will be executed when we select an item
function set_item_ilot(item){
	// change input value
	$('#ilot').val(item);
	// hide proposition list
	$('#ilot_list').hide();
}
// set_item lot : this function will be executed when we select an item
function set_item_lot(item){
	// change input value
	$('#lot').val(item);
	// hide proposition list
	$('#lot_list').hide();
}
// set_item type : this function will be executed when we select an item
function set_item_type(item){
	// change input value
	$('#type').val(item);
	// hide proposition list
	$('#type_list').hide();
}
// set_item objet : this function will be executed when we select an item
function set_item_objet(item){
	// change input value
	$('#objet').val(item);
	// hide proposition list
	$('#objet_list').hide();
}