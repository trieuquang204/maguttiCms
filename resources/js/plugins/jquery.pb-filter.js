/***************************************************/
/* PB Filter                                      */
/* Version: 1.1                                    */
/* Author: Paolo Bonacina                          */
/***************************************************/

// UTILIZZO:
// 1.	Associare la classe "pbf-group" al contenitore di un gruppo di input o select
// 2.	Allo stesso elemento associare l'attributo "data-filter" contenente il selettore jquery degli elementi del dom che si desidera filtrare
// 3.	Associare ad ogni input o select una delle seguenti classi:
// 			pbf-filter			-	Filtro per valore esatto
//			pbf-text			-	Ricerca nel contenuto dell'elemento
// 			pbf-like		-	Filtro per somiglianza (come %like%)
// 			pbf-checked	-	Filtro per checkbox
// 			pbf-limit	-	Filtro per tutti i valori superiori o inferiori a una soglia
// 		Gli input con "pbf-limit" necessitano anche del'attributo "data-limit" con valore "min" o "max" a seconda se si vuole filtrare per valori superiori o inferiori al valore inserito, rispettivamente
// 		Ogni input deve avere anche l'attributo "name".
// 4.	Facoltativo - se l'operazione richiesta dal filtro non è un "and" ma un "or", è sufficiente aggiungere l'attributo "data-pbf-operation" con valore "or"
// 5.	Tutti gli elementi del dom che devono essere filtrati devono avere un data attribute formattato come segue: data-[nome filtro]="[valore-filtro]".
//	 	Ad esempio, se l'input ha name="description", ogni elemento dovrà avere un attributo data-description contenente il testo nel quale si vuole cercare la descrizione digitata dall'utente.
//	 	I filter limit funzionano in modo analogo, ma accettano solo valori numerici.
// 6.	Associare ad un elemento che funge da "invio" la classe "pbf-button"
// 7.	Facoltativo - un elemento con la classe "pbf-reset" causa la pulizia di tutti i filtri, se cliccato
//
// Quando il filtro viene avviato, per la pressione del controllo dedicato o perché vengono cambiati i valori nei campi di input, il sistema nasconde tutti gli elementi e mostra solo quelli che rispondono ai valori inseriti dall'utente

//	costanti di configurazione
const DEFAULT_FILTERS = '.pbf-filter',
	DEFAULT_FILTER_TEXT = '.pbf-text',
	DEFAULT_FILTER_LIKE = '.pbf-like',
	DEFAULT_FILTER_CHECKED = '.pbf-checked',
	DEFAULT_FILTER_LIMIT = '.pbf-limit',
	DEFAULT_BUTTONS = '.pbf-button',
	DEFAULT_RESETS = '.pbf-reset',
	DEFAULT_HIDE_CLASS = 'd-none',
	DEFAULT_ON_COMPLETE = false;

let default_config = {
	hide_class: DEFAULT_HIDE_CLASS,
	on_complete: DEFAULT_ON_COMPLETE
};

// returns a config value, or its default
function pbfConfigDefault(var_value, default_value) {
	return (var_value) ? var_value : default_value;
}

// used to print errors in console
function pbfError(content, check) {
	check = check || false;
	if (!check) {
		console.error('PB Filter - ERROR:');
		console.error(content);
	}
}

// reads a configuration object and fires errors for required parameters
function pbfReadConfig(config_object) {
	let config = {};
	config = $.extend(config, default_config, config_object);

	pbfError('Filter group missing', config.group);
	pbfError('Filter target missing', config.target);

	return config;
}

function pbfAddEvents(config, group) {
	//	trovo il pulsante che attiva il filtro
	var buttons = group.find(DEFAULT_BUTTONS);
	//	trovo il pulsante che reimposta il filtro
	var resets = group.find(DEFAULT_RESETS);

	buttons.on('click.pbf', function (e) {
		e.preventDefault();
		pbfFilterElements(config, group);
	});

	group.find(DEFAULT_FILTERS + ',' + DEFAULT_FILTER_CHECKED + ',' + DEFAULT_FILTER_LIMIT).on('change.pbf input.pbf', function () {
		group.find(DEFAULT_BUTTONS).trigger('click.pbf');
	});

	group.find(DEFAULT_FILTER_LIKE).on('keyup.pbf', function () {
		group.find(DEFAULT_BUTTONS).trigger('click.pbf');
	});

	resets.on('click.pbf', function (e) {
		e.preventDefault();
		group.find(DEFAULT_FILTERS).val('');
		group.find(DEFAULT_FILTER_LIKE).val('');
		group.find(DEFAULT_FILTER_LIMIT).val('');
		group.find(DEFAULT_FILTER_CHECKED).prop('checked', false).trigger('change.pbf');
		group.find(DEFAULT_BUTTONS).trigger('click.pbf');
	});
}

function pbfInit(config) {
	//	recupero i gruppi
	let group = $(config.group);

	if (!group.length) {
		pbfError('Filter group not found');
	}
	pbfAddEvents(config, group);
}

function pbfFilterElements(config, group) {
	let values = {};
	let values_or = {};

	//	costruisco una lista di classi da filtrare
	group.find(DEFAULT_FILTERS).each(function () {
		if ($(this).val() != '') {
			if ($(this).data('pbf-operation') == 'or')
				values_or[$(this).attr('name')] = $(this).val();
			else {
				values[$(this).attr('name')] = $(this).val();
			}
		}
	});

	group.find(DEFAULT_FILTER_CHECKED).each(function () {
		if ($(this).is(':checked')) {
			if ($(this).data('pbf-operation') == 'or')
				values_or[$(this).attr('name')] = $(this).val();
			else
				values[$(this).attr('name')] = $(this).val();
		}
	});

	//	nascondo tutti gli elementi e mostro le classi trovate
	$(config.target).addClass(config.hide_class);
	if (Object.keys(values).length || Object.keys(values_or).length) {
		let values_string = '';
		$.each(values, function (k, v) {
			values_string += '[data-' + k + '="' + v + '"]';
		});
		if (Object.keys(values_or).length)
			$.each(values_or, function (k, v) {
				$(config.target + values_string + '[data-' + k + '="' + v + '"]').removeClass(config.hide_class);
			});
		else
			$(config.target + values_string).removeClass(config.hide_class);
	} else {
		$(config.target).removeClass(config.hide_class);
	}

	//	filtro ulteriormente per i filtri testo
	group.find(DEFAULT_FILTER_TEXT).each(function () {
		let filter = $(this);
		let filter_value = parseInt(filter.val(), 10);
		$(config.target).each(function () {
			let item_value = $(this).text();
			if (item_value.indexOf(filter_value) == -1)
				$(this).addClass(config.hide_class);
		});
	});

	//	filtro ulteriormente per i filtri limite
	group.find(DEFAULT_FILTER_LIMIT).each(function () {
		let filter = $(this);
		let filter_value = parseInt(filter.val(), 10);
		let filter_name = filter.attr('name');
		let filter_limit = filter.data('limit');
		$(config.target).each(function () {
			let item_value = parseInt($(this).data(filter_name), 10);
			switch (filter_limit) {
			case 'min':
				if (item_value < filter_value)
					$(this).addClass(config.hide_class);
				break;
			case 'max':
				if (item_value > filter_value)
					$(this).addClass(config.hide_class);
				break;
			}
		});
	});

	// filtro ulteriormente per i filtri like
	group.find(DEFAULT_FILTER_LIKE).each(function () {
		let filter = $(this);
		let filter_value = filter.val().toLowerCase();
		let filter_name = filter.attr('name');
		if (filter_value) {
			$(config.target).each(function () {
				if ($(this).data(filter_name) != null) {
					let item_value = $(this).data(filter_name).toString().toLowerCase();
					if (item_value.toString().indexOf(filter_value) == -1) {
						$(this).addClass(config.hide_class);
					}
				}
			});
		}
	});

	if (typeof config.callback == 'function') {
		let unfiltered = $(config.target);
		let filtered = unfiltered.not('.' + config.hide_class);

		config.callback.call(group, unfiltered, filtered);
	}
}

// functionality initialization
(function ($) {
	$.pbfFilter = function (config_object) {
		// read configuration object and fire errors
		let config = pbfReadConfig(config_object);

		pbfInit(config);
	};
}(jQuery));