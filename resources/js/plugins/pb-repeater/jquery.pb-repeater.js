/***************************************************/
/* PB Repeater                                      */
/* Version: 1.1                                    */
/* Author: Paolo Bonacina                          */
/***************************************************/

/*
repeats a html node

Typical usage:

$.pbRepeater({key: value, key: value, key: value, ... });

Available parameters:
add_selector			STRING		Jquery selector for add buttons
delete_selector			STRING		Jquery selector for delete buttons
clean_on_duplicate		BOOL		Clean user inputs from cloned elements
allow_delete_last		BOOL		Allows the user to delete the last element, effectively hiding it from view. (form submit must be handled accordingly)
animation_time:			INTEGER		Animation duration in milliseconds. Set to 0 to disable animation.
on_before_clone:		FUNCTION	Callback to run on the object before the cloning
on_after_clone:			FUNCTION	Callback to run on the object after the cloning
});
*/

/*	constants	*/
// core variables
let DEFAULT_ADD_SELECTOR = '.pbr-add';
let DEFAULT_DELETE_SELECTOR = '.pbr-delete';
let DEFAULT_CLEAN_ON_DUPLICATE = true;
let DEFAULT_ALLOW_DELETE_LAST = false;
let DEFAULT_ANIMATION_TIME = 300; // Duration of slide animations
let DEFAULT_CALLBACK = function () {};

let default_config = {
	add_selector: DEFAULT_ADD_SELECTOR,
	delete_selector: DEFAULT_DELETE_SELECTOR,
	clean_on_duplicate: DEFAULT_CLEAN_ON_DUPLICATE,
	allow_delete_last: DEFAULT_ALLOW_DELETE_LAST,
	animation_time: DEFAULT_ANIMATION_TIME,
	on_before_clone: DEFAULT_CALLBACK,
	on_after_clone: DEFAULT_CALLBACK,
};

// returns a config value, or its default
function pbrConfigDefault(var_value, default_value) {
	return (var_value) ? var_value : default_value;
}

// used to print errors in console
function pbrError(content, check) {
	check = check || false;
	if (!check) {
		console.error('PB Repeater - ERROR:');
		console.error(content);
	}
}

// reads a configuration object and fires errors for required parameters
function pbrReadConfig(config_object) {
	let config = {};
	config = $.extend(config, default_config, config_object);
	return config;
}

function pbrGetTarget(elem) {
	let target = elem.data('pbr-target');
	return target;
}

function pbrAdd(to_add, config) {
	// before clone callback
	if (typeof config.on_before_clone == 'function') {
		config.on_before_clone(to_add);
	}
	let clone = to_add.clone(true);
	if (config.clean_on_duplicate) {
		pbrClean(clone);
	}
	to_add.after(clone);
	// after clone fallback
	if (typeof config.on_before_clone == 'function') {
		config.on_after_clone(to_add, clone);
	}
	clone.hide().slideDown(config.animation_time);
}

function pbrDelete(target, to_delete, config) {
	console.log($(target).length);
	if ($(target).length > 1) {
		to_delete.slideUp(config.animation_time, () => {
			to_delete.remove();
		});
	} else if (config.allow_delete_last) {
		to_delete.hide();
	}
}

function pbrClean(clone) {
	clone.find('input[type="text"]').val('');
	clone.find('input[type="hidden"]').val('');
	clone.find('input[type="file"]').val('');
	clone.find('input[type="number"]').val(1);
	clone.find('textarea').val('');
	clone.find('input[type="checkbox"]').prop('checked', false);
	clone.find('input[type="radio"]').prop('checked', false);
}

// functionality initialization
(function ($) {
	$.pbRepeater = function (config_object = {}) {
		// read configuration object and fire errors
		var config = pbrReadConfig(config_object);

		// ADD REPEATER
		$(document).on('click', config.add_selector, function (e) {
			e.preventDefault();
			let elem = $(this);
			let target = pbrGetTarget(elem);
			pbrError('Missing target', target);
			let to_add = elem.closest(target);
			if (!to_add) {
				to_add = $(target).last();
			}
			pbrAdd(to_add, config);
		});

		// DELETE REPEATER
		$(document).on('click', config.delete_selector, function (e) {
			e.preventDefault();
			let elem = $(this);
			let target = pbrGetTarget(elem);
			pbrError('Missing target', target);
			let to_delete = elem.closest(target);
			pbrDelete(target, to_delete, config);
		});
	};
}(jQuery));