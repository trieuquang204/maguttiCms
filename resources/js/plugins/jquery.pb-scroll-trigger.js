/***************************************************/
/* PB Scroll Trigger                               */
/* Version: 0.1                                    */
/* Author: Paolo Bonacina                          */
/***************************************************/
/*
Detects window scroll and applies a class to selected elements
 */

/*	constants	*/

let default_config = {
	class: 'scrolled', // class to be applied to specified selector after scroll
	namespace: '', // not mandatory, but required to handle multiple scroll triggers on the same page. Set to a different string for every selector to check
	delay: 50, // delay in milliseconds after which we check for scroll
	threshold: 100, // threshold in pixels below which we don't trigger classes after scroll
	use_element_position: true, // if true, use the element position within the window
	apply_class_to_body: true, // if true, also apply the scoll class to the body as well
};

// returns a config value, or its default
function pbstConfigDefault(var_value, default_value) {
	return (var_value) ? var_value : default_value;
}

// used to print errors in console
function pbstError(content, check) {
	check = check || false;
	if (!check) {
		console.error('PB Scroll Trigger - ERROR:');
		console.error(content);
	}

	return check;
}

// reads a configuration object and fires errors for required parameters
function pbstReadConfig(config_object) {
	var config = Object.assign({}, default_config, config_object);

	pbstError('Missing selector', config.selector);

	return config;
}

function pbstAddScrollEvents(config) {
	let WINDOW = $(window);
	if (config.delay) {
		WINDOW.on('scroll.pbst.' + config.name, function () {
			let timeout;
			timeout = setTimeout(function () {
				pbstCheckScroll(config);
				clearTimeout(timeout);
			}, config.delay);
		});
	} else {
		WINDOW.on('scroll.pbst.' + config.name, function () {
			pbstCheckScroll(config);
		});
	}
}

function pbstCheckScroll(config) {
	let ELEM = $(config.selector);

	let valid = pbstError('Selector returned an empty set', ELEM.length);

	if (valid) {
		ELEM.each(function (_index, el) {
			pbstCheckElement($(el), config);
		});
	}
}

function pbstCheckElement(elem, config) {
	let WINDOW = $(window);
	let BODY = $('body');
	let offset;
	if (config.use_element_position) {
		offset = elem.offset().top;
	} else {
		offset = 0;
	}

	if (WINDOW.scrollTop() > offset + config.threshold) {
		elem.addClass(config.class);
		if (config.apply_class_to_body) {
			BODY.addClass(config.class);
		}
	} else {
		elem.removeClass(config.class);
		if (config.apply_class_to_body) {
			BODY.removeClass(config.class);
		}
	}
}

// functionality initialization
(function ($) {
	$.pbScrollTriger = function (config_object) {
		let config = pbstReadConfig(config_object);
		pbstAddScrollEvents(config);
		pbstCheckScroll(config);
	};
}(jQuery));