/***************************************************/
/* PB Suggest                                      */
/* Version: 1.3                                    */
/* Author: Paolo Bonacina                          */
/***************************************************/

/*
reads from input elements and displays a dropdown with suggestions
clicking the dropdown copies the selected row to the input with optional form submit

Typical usage:

$(#input).pbsSuggest({key: value, key: value, key: value, ... });

Available parameters:
selector			REQUIRED STRING
call:				REQUIRED STRING		Api to call. It must return an object of key-value pairs. The key will be copied to the input when the user selects a suggestion. The value is the text displayed to the user.
token:				STRING				Cross-site-request-forgery token sent to the api.
count:				INTEGER				Max number of results to display.
locale:				STRING				Result localization string.
min_chars:			INTEGER				Minimum number of characters needed to show suggestions.
submit:				BOOL				Wether to automatically submit the form the input is in when the user selects a suggestion.
filters:			ARRAY				Key-value pairs sent to the api to dynamically change your api call.
target:				STRING				A jQuery selector to an input that will accept the result in place of the input the user is tiping into.
target_container:	STRING				A jQuery selector to an HTML element containing both the input and the target (useful for repeating elements).
append:				BOOL				Wether to append the result to the target instead of replacing it.
append_separator:	STRING				String to prepend to the result before appending it to the target.
navigate_on_select:	BOOL				Wether to navigate to the link instead of copying its content to the input (useful for product search).
text_start:			STRING				Text displayed when clicking inside the input before typing.
text_search:		STRING				Text displayed while searching results.
text_no_results:	STRING				Text displayed when the api did not return any item.
animation_time:		INTEGER				Animation duration in milliseconds. Set to 0 to disable animation.
});

The plugin makes a GET call and sends automatically the following parameters:
search_text:		STRING				The user input,
count:				INTEGER				Max number of results to display,
filters:			ARRAY				Key-value pairs to dynamically change your api call
locale:				STRING				Result localization string.
_token:				STRING				For laravel applications

In the request header, the plugin also sends a parameter named "X-Call-Id". You should return this parameter as-is in the response headers if you want to prevent old but slow responses to override newer an quicker ones.

The plugin expects the call to return results in this format:
{
result1key: result1value,
result2key: result2value,
result3key: result3value
}
*/


/*	constants	*/
// core variables
var DEFAULT_COUNT = 5; // Max number of results to display.
var DEFAULT_MIN_CHARS = 5; // Minimum number of characters needed to show suggestions.
var DEFAULT_SUBMIT = false; // Wether to automatically submit the form the input is in when the user selects a suggestion.
var DEFAULT_FILTERS = []; // Key-value pairs sent to the api to dynamically change your api call.
var DEFAULT_APPEND = false; // Wether to append the result to the target instead of replacing it.
var DEFAULT_APPEND_SEPARATOR = ' '; // String to prepend to the result before appending it to the target.

var DEFAULT_ANIMATION_TIME = 100; // Duration of slide animations

// helper texts
var DEFAULT_TEXT_START = 'Start typing to search.';
var DEFAULT_TEXT_SEARCH = 'Searching...';
var DEFAULT_TEXT_NO_RESULTS = 'No results.';

var default_config = {
	count: DEFAULT_COUNT,
	min_chars: DEFAULT_MIN_CHARS,
	submit: DEFAULT_SUBMIT,
	filters: DEFAULT_FILTERS,
	append: DEFAULT_APPEND,
	append_separator: DEFAULT_APPEND_SEPARATOR,
	text_start: DEFAULT_TEXT_START,
	text_search: DEFAULT_TEXT_SEARCH,
	text_no_results: DEFAULT_TEXT_NO_RESULTS,
	animation_time: DEFAULT_ANIMATION_TIME
};

var cursor = 0;

/*	variables	*/
var result_count; // number of entries found

// returns a config value, or its default
function pbsConfigDefault(var_value, default_value) {
	return (var_value) ? var_value : default_value;
}

// used to print errors in console
function pbsError(content, check) {
	check = check || false;
	if (!check) {
		console.error('PB Suggest - ERROR:');
		console.error(content);
	}
}

// reads a configuration object and fires errors for required parameters
function pbsReadConfig(config_object) {
	let config = {};
	config = $.extend(config, default_config, config_object);

	pbsError('Missing API address.', config.call);

	return config;
}

// when the user clicks a suggested item, the item is copied to the input
function pbsHandleLinks(target, target_container, navigate_on_select) {
	target = target || false;
	$('.pbs-key').on('click', function (e) {
		e.stopPropagation();

		let result = $(this).attr('href');
		let text = $(this).text();

		if (navigate_on_select) {
			window.location.href = result;
			return true;
		}

		e.preventDefault();

		let input = $(this).closest('.pbs-wrapper').find('.pbs-input');
		let target_element, //receives the clicked key
			display_element; // receives the clicked value

		// determine target and display
		if (target) {
			if (target_container) {
				target_element = $(this).closest(target_container).find(target);
			} else {
				target_element = $(target);
			}
			display_element = $(this).closest('.pbs-wrapper').find('.pbs-input');
		} else {
			target_element = input;
		}

		// set the clicked key
		if (input.data('append') && target_element.val()) {
			target_element.val(target_element.val() + input.data('append_separator') + result);
		} else {
			target_element.val(result);
		}

		// set the clicked value
		if (display_element) {
			display_element.val(text);
		}

		input.trigger('pbs-hide');
		if (input.data('submit')) {
			target_element.closest('form').submit();
		}
	});
}

function pbsWrap(current, min, max) {
	current = (current > max) ? min : current;
	current = (current < min) ? max : current;
	return current;
}

function pbsClamp(current, min, max) {
	return Math.min(Math.max(min, current), max);
}

// clears the suggest results and adds generic content
function pbsMessage(text, target) {
	target.html('');
	target.html('<div class="pbs-standard">' + text + '</div>');
}

// clears the suggest results and adds new ones
function pbsRender(data, target, config) {
	target.html('');
	$.each(data, function (k, v) {
		$('<a class="pbs-key">')
			.attr('href', k)
			.html(v)
			.appendTo(target);
	});
	pbsHandleLinks(config.target, config.target_container, config.navigate_on_select);
}

function pbsHighlight(index, target) {
	let entries = target.find('.pbs-key');
	entries.removeClass('active').eq(index).addClass('active');
	target.scrollTop(target.scrollTop() + entries.eq(index).position().top - target.innerHeight() / 2);
}

function pbsSelect(target) {
	target.find('.active').click();
}

// functionality initialization
(function ($) {
	$.pbsSuggest = function (config_object) {
		// read configuration object and fire errors
		let config = pbsReadConfig(config_object);

		let elements = $(config.selector);

		if (!elements.length) {
			pbsError('Selector returned an empty set');
			return false;
		}

		$(config.selector).each(function () {
			let elem = $(this);

			let wrapper = $('<div class="pbs-wrapper"></div>');
			elem.before(wrapper).appendTo(wrapper);

			// add class to input
			elem.addClass('pbs-input');
			elem.data('submit', config.submit);
			elem.data('append', config.append);
			elem.data('append_separator', config.append_separator);

			// create drop-down
			let results_container = $('<div class="pbs-results"></div>');
			elem.after(results_container);

			pbsMessage(config.text_start, results_container);

			// add drop-down events
			elem.on('pbs-show', function () {
				if (config.animation_time) {
					results_container.stop().css('height', 'auto').slideDown(config.animation_time);
				} else {
					results_container.show();
				}
			});
			elem.on('pbs-hide', function () {
				if (config.animation_time) {
					results_container.stop().css('height', 'auto').slideUp(config.animation_time);
				} else {
					results_container.hide();
				}
			});
		});

		$(document).on('click', 'html', function () {
			elements.trigger('pbs-hide');
		});

		$(document).on('click', config.selector, function (e) {
			elements.trigger('pbs-hide');
			$(this).trigger('pbs-show');
			e.stopPropagation();
		});

		// prevent sending the form with enter
		$(document).on('keydown', config.selector, function (e) {
			if ($.inArray(e.key, ['Enter', 'Tab']) != -1)
				e.preventDefault();
		});

		// add event to user input
		$(document).on('keyup', config.selector, function (e) {
			let elem = $(this);
			elem.trigger('pbs-show');
			let results_container = elem.closest('.pbs-wrapper').find('.pbs-results');
			if ($.inArray(e.key, ['ArrowUp', 'ArrowDown']) != -1) {
				// the key is an arrow or an enter and we need to move the cursor
				if (e.key == 'ArrowUp') cursor--;
				if (e.key == 'ArrowDown') cursor++;
				cursor = pbsClamp(cursor, 0, result_count - 1);
				pbsHighlight(cursor, results_container);
			} else if ($.inArray(e.key, ['ArrowLeft', 'ArrowRight']) != -1) {
				return false;
			} else if ($.inArray(e.key, ['Enter', 'Tab']) != -1) {
				// call click event for selected item
				pbsSelect(results_container);
			} else {
				let search_text = elem.val().trim();

				if (search_text.length < config.min_chars) {
					return false;
				}
				if (search_text != '') {
					pbsMessage(config.text_search, results_container);
					let new_call_id = Math.floor(Math.random() * 1000);
					elem.data('call_id', new_call_id);
					$.ajax({
						type: 'GET',
						url: config.call,
						data: {
							search_text: search_text,
							count: config.count,
							filters: config.filters,
							locale: config.locale,
							_token: config.token
						},
						dataType: 'json',
						beforeSend: function (xhr) {
							xhr.setRequestHeader('X-Call-Id', new_call_id);
						},
						success: function (response, _status, request) {
							// we compare the call ids. If they differ, the returned data is ignored
							let return_call_id = request.getResponseHeader('X-Call-Id');
							if (return_call_id && return_call_id != elem.data('call_id')) {
								return false;
							}
							// if we have data
							if (Object.keys(response).length) {
								pbsRender(response, results_container, config);
								result_count = Object.keys(response).length;
								cursor = 0;
								pbsHighlight(cursor, results_container);
							} else {
								pbsMessage(config.text_no_results, results_container);
							}
						},
						error: function (response) {
							pbsError(response);
						}
					});
					return true;
				} else {
					return false;
				}
			}
		});
	};
}(jQuery));