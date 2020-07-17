$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

$.ajaxSetup({
	headers: {
		'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	}
});


(function (window, document, undefined) {
	'use strict';

	//jshint unused:false

	var App = window.App = {};

	/*
	 * defining namespace
	 */
	var Helpers = window.Helpers = window.App.helpers = {

		/**
		 * Apply formatting options to the string. This will look for occurrences
		 * of %@ in your string and substitute them with the arguments you pass into
		 * this method.  If you want to control the specific order of replacement,
		 * you can add a number after the key as well to indicate which argument
		 * you want to insert.
		 *
		 * Ordered insertions are most useful when building loc strings where values
		 * you need to insert may appear in different orders.
		 *
		 *
		 * Sample Usage:
		 *
		 *   Helpers.fmt('Hello %@ %@',    'John', 'Doe') // => 'Hello John Doe'
		 *   Helpers.fmt('Hello %@2, %@1', 'John', 'Doe') // => 'Hello Doe, John'
		 *
		 *
		 * @namespace App
		 *
		 * @param  {String}     string  String to be formatted
		 * @param  {args*}              Data to be passed to @string param
		 * @return {String}             Formatted string
		 */
		fmt: function (string /*, arg1, arg2, ..., argn */) {
			var formats;
			var index;

			// Words to fill the string should be all arguments but first
			formats = Array.prototype.slice.call(arguments, 1);

			// First, replace any ORDERED replacements.
			index = 0; // the current index for non-numerical replacements

			return string.replace(/%@([0-9]+)?/g, function (match, argumentIndex) {
				argumentIndex = (argumentIndex) ? parseInt(argumentIndex, 10) - 1 : index++;
				match         = formats[argumentIndex];

				return ((match === null) ? '(null)' : (match === undefined) ? '' : match).toString();
			});
		},

		/** Similar to ES6's rest param (http://ariya.ofilabs.com/2013/03/es6-and-rest-parameter.html)
		 * This accumulates the arguments passed into an array, after a given index.
		 */
		restArgs: function (func, startIndex) {
			startIndex = startIndex == null ? func.length - 1 : +startIndex;
			return function () {
				var length = Math.max(arguments.length - startIndex, 0);
				var rest   = new Array(length);
				for (var index = 0; index < length; index++) {
					rest[index] = arguments[index + startIndex];
				}
				switch (startIndex) {
					case 0: {
						return func.call(this, rest);
					}
					case 1: {
						return func.call(this, arguments[0], rest);
					}
					case 2: {
						return func.call(this, arguments[0], arguments[1], rest);
					}
				}
				var args = new Array(startIndex + 1);
				for (index = 0; index < startIndex; index++) {
					args[index] = arguments[index];
				}
				args[startIndex] = rest;
				return func.apply(this, args);
			};
		},

		/** Returns a function, that, as long as it continues to be invoked, will not
		 * be triggered. The function will be called after it stops being called for
		 * N milliseconds. If `immediate` is passed, trigger the function on the
		 * leading edge, instead of the trailing.
		 */
		debounce: function (func, wait, immediate) {
			var timeout;
			var result;
			var delay = App.helpers.restArgs(function (func, wait, args) {
				return setTimeout(function () {
					return func.apply(null, args);
				}, wait);
			});

			var later = function (context, args) {
				timeout = null;
				if (args) {
					result = func.apply(context, args);
				}
			};

			var debounced = App.helpers.restArgs(function (args) {
				var callNow = immediate && !timeout;
				if (timeout) {
					clearTimeout(timeout);
				}
				if (callNow) {
					timeout = setTimeout(later, wait);
					result  = func.apply(this, args);
				}
				else if (!immediate) {
					timeout = delay(later, wait, this, args);
				}

				return result;
			});

			debounced.cancel = function () {
				clearTimeout(timeout);
				timeout = null;
			};

			return debounced;
		},

		/**
		 * Defining namespace for modal helpers
		 *
		 * @namespace: App.helpers.modal
		 */
		modal: {

			/**
			 * Reposition Bootstrap modals to be vertically aligned
			 *
			 * @return {void}
			 */
			repositionModal: function () {
				var $modal  = $(this);
				var $dialog = $modal.find('.modal-dialog');
				$modal.css('display', 'block');

				// if (!$modal.hasClass('modal-fullscreen')) {
				// Dividing by two centers the modal exactly, but dividing by three
				// or four works better for larger screens.
				// $dialog.css('margin-top', Math.max(0, ($(window).height() - $dialog.outerHeight()) / 2));
				// }

			},

			/**
			 * Load content of modal windowd with AJAX
			 *
			 * @param {string} ajaxUrl - AJAX url of content for modal
			 * @param {function} callback - callback function to be called after modal is loaded
			 * @return {void}
			 */
			loadModalContent: function (ajaxUrl, callback) {
				var self = this;
				$.ajax({
					url: ajaxUrl
				}).done(function (response) {
					self.constructModal(response, callback);
				});
			},


			constructModal: function (modal, callback) {
				var $modalContent = $(modal);

				// We need to trigger some functionality when modal is shown
				$modalContent.on('show.bs.modal', function () {
					var $this           = $(this);
					var scrollbarParams = {
						theme: 'light-thick'
					};

					// Update select pickers
					$modalContent.find('.selectpicker').selectpicker('refresh');

					// Update switchers
					App.switchers($modalContent.find('.js-switch'));
					App.selectors($modalContent.find('.js-select'));

					setTimeout(function () {

						App.helpers.modal.setModalContentDimensions($modalContent);

						// reposition modal window
						App.helpers.modal.repositionModal.apply($this);

						//// Update scrollbars
						$modalContent.find('.scroll-container').perfectScrollbar();


						//callback
						if (typeof callback === 'function') {
							callback($modalContent);
						}
					}, 240);

				});

				$modalContent.modal({
					backdrop: 'static',
					keyboard: false
				});


				$modalContent.on('hidden.bs.modal', function () {
					$modalContent.remove();
					$('.modal-backdrop').last().remove();
				});


				return $modalContent;
			},


			bindModalButons: function () {
				$('body').on('click', '[data-slide-modal]', function () {
					var $this     = $(this);
					var direction = $this.data('slide-modal');

					Helpers.modal.slideModal.apply($this, [direction]);

					return false;
				});

				$('body').on('click', '[data-slide-modal-offset]', function () {
					var $this     = $(this);
					var direction = parseInt($this.data('slide-modal-offset'));

					Helpers.modal.slideModalOffset.apply($this, [direction]);

					return false;
				});
			},

			setModalContentDimensions: function ($modal) {
				if (typeof $modal !== 'undefined') {
					var $modalGroup    = $modal.closest('.modal');
					var $modalWrapper  = $modal.find('.modal-wrapper');
					var $modalContents = $modal.find('.modal-content');

					var numberOfSteps = $modalContents.length;
					var modalWidth    = $modal.find('.modal-dialog').outerWidth();

					if (numberOfSteps > 1) {
						$modalWrapper.width(modalWidth * numberOfSteps);

						if ($modalWrapper.attr('data-slide-modal-first')) {
							var first = parseInt($modalWrapper.attr('data-slide-modal-first'));

							var $firstSlide = $($modalWrapper.find('.modal-content')[first]);
							var newMargin   = parseInt($modalWrapper.css('margin-left'), 10);

							newMargin = newMargin - first * modalWidth;

							$modalWrapper.find('.modal-content').removeClass('active');
							$firstSlide.addClass('active');


							$modalWrapper.css('marginLeft', newMargin + 'px');
							$modalWrapper.find('.modal-body').mCustomScrollbar('update');

							Helpers.modal.repositionModal.apply($modalGroup);

						}

						$modalContents.css({
							width: (100 / numberOfSteps) + '%'
						});
					}
					$modalContents.removeClass('hidden');
				}
			},

			/**
			 * Slide between modals
			 *
			 * @param {string} direction - previous or next
			 * @param {function} callback - callback function to be called after modal is loaded
			 * @return {void}
			 */
			slideModal: function (direction) {
				direction         = direction === 'previous' ? 'previous' : 'next';
				var $this         = $(this);
				var $modalGroup   = $this.closest('.modal');
				var $modal        = $this.closest('.modal-content');
				var width         = $modalGroup.find('.modal-dialog').outerWidth();
				var $modalWrapper = $modalGroup.find('.modal-wrapper');
				var $nextSlide    = direction === 'next' ? $modal.next() : $modal.prev();
				var newMargin     = parseInt($modalWrapper.css('margin-left'), 10);

				if (direction === 'previous') {
					newMargin = newMargin + width;
				}
				else {
					newMargin = newMargin - width;
				}

				$modalGroup.find('.modal-content').removeClass('active');
				$nextSlide.addClass('active');

				Helpers.modal.repositionModal.apply($modalGroup);

				$modalWrapper.animate({
					marginLeft: newMargin + 'px'
				}, {
					duration: 500,
					progress: function () {
						Helpers.modal.repositionModal.apply($modalGroup);
					},
					complete: function () {
						$modalWrapper.find('.modal-body').mCustomScrollbar('update');
					}
				});

			},

			slideModalOffset: function (offset) {
				var $this         = $(this);
				var $modalGroup   = $this.closest('.modal');
				var $modal        = $this.closest('.modal-content');
				var width         = $modalGroup.find('.modal-dialog').outerWidth();
				var $modalWrapper = $modalGroup.find('.modal-wrapper');
				var $nextSlide    = $modal;

				if (offset > 0) {
					for (var i = 0; i < offset; i++) {
						$nextSlide = $nextSlide.next();
					}
				}
				else {
					for (var i = 0; i > offset; i--) {
						$nextSlide = $nextSlide.prev();
					}
				}


				var newMargin = parseInt($modalWrapper.css('margin-left'), 10);
				newMargin     = newMargin + (-1 * offset * width);

				$modalGroup.find('.modal-content').removeClass('active');
				$nextSlide.addClass('active');

				Helpers.modal.repositionModal.apply($modalGroup);

				$modalWrapper.animate({
					marginLeft: newMargin + 'px'
				}, {
					duration: 500,
					progress: function () {
						Helpers.modal.repositionModal.apply($modalGroup);
					},
					complete: function () {
						// $modalWrapper.find('.modal-body').mCustomScrollbar('update');
					}
				});

			}

		}, // modals

		backdrop: {
			element: null,
			offset : null,
			create : function ($element, offset) {

				if (offset == null) {
					offset = 0;
				}

				console.log($element, offset);

				var self     = this;
				this.element = $element;

				if (typeof(offset) == 'number') {
					this.offset = {
						top   : offset,
						right : offset,
						bottom: offset,
						left  : offset
					}
				}
				else if (typeof(offset) == 'string') {
					offset = offset.split(" ");

					var length = offset.length;

					for (var i = 0; i < length; i++) {
						offset[i] = parseInt(offset[i], 10)
					}
					if (offset.length == 1 && !isNaN(offset[0])) {
						this.offset = {
							top   : offset[0],
							right : offset[0],
							bottom: offset[0],
							left  : offset[0]
						}
					}
					else if (offset.length == 2 && !isNaN(offset[0]) && !isNaN(offset[1])) {
						this.offset = {
							top   : offset[0],
							right : offset[1],
							bottom: offset[0],
							left  : offset[1]
						}
					}
					else if (offset.length == 4 && !isNaN(offset[0]) && !isNaN(offset[1]) && !isNaN(offset[2]) && !isNaN(offset[3])) {
						this.offset = {
							top   : offset[0],
							right : offset[1],
							bottom: offset[2],
							left  : offset[3]
						}
					}
				}

				console.log(this.offset);

				var $backdrop = $(
					'<div class="backdrop"></div>' +
					'<div class="backdrop"></div>' +
					'<div class="backdrop"></div>' +
					'<div class="backdrop"></div>'
				);

				$element.parent().prepend($backdrop);

				this.resize();

				$(window).scroll(function () {
					self.resize();
				});
			},

			resize: function () {
				var self = this;

				if (this.element == null) {
					return;
				}
				var $parent   = this.element.parent();
				var $backdrop = $parent.find('.backdrop');

				var top    = this.element.offset().top - $('body').scrollTop();
				var left   = this.element.offset().left - $('body').scrollLeft();
				var right  = left + this.element.outerWidth();
				var bottom = top + this.element.outerHeight();

				if (self.offset != null) {
					top    = top - self.offset.top;
					left   = left - self.offset.left;
					right  = right + self.offset.right;
					bottom = bottom + self.offset.bottom;
				}

				var width  = $('body').outerWidth();
				var height = $('body').outerHeight();

				$backdrop.each(function (index, element) {
					if (index == 0) {
						$(this).css({
							top   : '0px',
							left  : '0px',
							width : right + 'px',
							height: top + 'px'
						});
					}
					else if (index == 1) {
						$(this).css({
							top   : top + 'px',
							left  : '0px',
							width : left + 'px',
							height: (height + bottom - top) + 'px'
						});
					}
					else if (index == 2) {
						$(this).css({
							top   : '0px',
							left  : right + 'px',
							width : (width - right) + 'px',
							height: bottom + 'px'
						});
					}
					else if (index == 3) {
						$(this).css({
							top   : bottom + 'px',
							left  : left + 'px',
							width : (width - left) + 'px',
							height: (height - top) + 'px'
						});
					}
				});
			},

			remove: function () {
				this.element.siblings('.backdrop').remove();
				this.element = null;
				this.offset  = null;
			}
		},

		alert: {

			info: function (header, text, status, callback) {
				var $modal = this.createModal(header, '<p class="text-center">' + text + '</p>', 'info', status);

				$modal.find('a[href="ok"]').click(function (e) {
					e.preventDefault();
					$modal.modal('hide');

					if (typeof(callback) == 'function') {
						callback();
					}
				});
			},

			confirm: function (header, text, status, ok, cancel) {
				var $modal = this.createModal(header, '<p class="text-center">' + text + '</p>', 'confirm', status);

				$modal.find('a[href="ok"]').click(function (e) {
					e.preventDefault();
					$modal.modal('hide');

					if (typeof(ok) == 'function') {
						ok();
					}
				});

				$modal.find('a[href="cancel"]').click(function (e) {
					e.preventDefault();
					$modal.modal('hide');

					if (typeof(cancel) == 'function') {
						cancel();
					}
				});
			},

			prompt: function (header, text, status, callback) {
				var $modal = this.createModal(header, '<p class="text-center">' + text + '</p>', 'prompt', status);

				$modal.find('a[href="ok"]').click(function (e) {
					e.preventDefault();
					$modal.modal('hide');

					if (typeof(callback) == 'function') {
						callback();
					}
				});
			},

			createModal: function (header, content, type, status) {
				if (type === undefined) {
					type = 'info';
				}

				if (status === undefined) {
					status = 'info';
				}

				var lang = App.helpers.lang();

				var footer = '<a href="ok" role="button" class="btn btn-success">' + App.lang[lang].ok + '</a>';

				if (type != 'info') {
					footer = '<a href="cancel" role="button" class="btn btn-primary" data-dismiss="modal">' + App.lang[lang].cancel + '</a>' + footer;
				}

				var $modal =
						$('<div class="modal modal-color-head modal-' + status + ' weebto-editor fade" tabindex="-1" role="dialog">' +
							'    <div class="modal-dialog" role="document">' +
							'        <div class="modal-content">' +
							'            <div class="modal-header">' +
							'                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							'                <h4 class="modal-title">' + header + '</h4>' +
							'            </div>' +
							'            <div class="modal-body">' + content + '</div>' +
							'            <div class="modal-footer">' +
							'               <div class="btn-group btn-group-justified">' + footer + '</div>' +
							'            </div>' +
							'        </div>' +
							'    </div>' +
							'</div>'
						)
				;

				$('body').append($modal);
				$modal.modal('show');

				$modal.on('hidden.bs.modal', function () {
					$(this).remove();
				});

				return $modal;
			}
		},

		flash: {
			init: function () {
				var $flashes = $('#flashes');

				$flashes.find('.speech.hidden').each(function () {
					var self = $(this);
					if (self.hasClass('speech-danger')) {
						Helpers.flash.create('danger', self.text());
					}
					if (self.hasClass('speech-success')) {
						Helpers.flash.create('success', self.text());
					}
					if (self.hasClass('speech-warning')) {
						Helpers.flash.create('warning', self.text());
					}
					self.remove();
					// setTimeout(function () {
					//     self.remove();
					// }, 5000);
				});
			},

			create: function (type, text, time) {
				var $flashes = $('#js-flashes');

				if ($flashes.length == 0) {
					$flashes = window.parent.$('#js-flashes');
				}

				$flashes.removeClass('hidden');

				if (typeof(time) == 'undefined') {
					time = 3000;
				}

				var $flash = $(
					'<div class="speech-container">' +
					'<div class="speech speech-' + type + '">' +
					'<p>' +
					text +
					'</p>' +
					'</div>' +
					'</div>'
				);

				var $appendedFlash = $flash.appendTo('#js-flashes');

				$appendedFlash.hide();
				$appendedFlash.fadeIn(2000, function () {
					if (time > 0) {
						setTimeout(function () {
							$appendedFlash.remove();
						}, time);
					}
				});

				return $flash;
			},
		},


		lang: function () {
			var lang = $('body').closest('[lang]').attr('lang') || 'en';
			return lang;
		},
		/**
		 * Defining namespace for url helpers
		 *
		 * @namespace: App.helpers.url
		 */
		url : {

			/**
			 *
			 * Returns GET param's value
			 *
			 * Sample usage:
			 *
			 *   'http://www.domain.com/articles#hashParam';
			 *   App.helpers.url.contains('myKey');   // => false
			 *   App.helpers.url.contains('#hashParam');  // => true
			 *
			 * @param  {string} key - key to be searched in the url
			 * @return {boolean} true if key is found in the url
			 *
			 */
			contains: function (key) {
				return (window.location.href.search(key) !== -1) ? true : false;
			}
		} // url

	};

	// Document ready bindings
	$(document).ready(function () {
		Helpers.flash.init();
	});

})(this, this.document);


(function (window, document, undefined) {
	'use strict';

	App.trans = function (query) {
		var lang = App.helpers.lang();
		query    = query.split('.');

		var trans = App.lang[lang];
		for (var i = 0; i < query.length; i++) {
			trans = trans[query[i]];
		}

		return trans;
	};

})(window, document);

$(document).on('click', '.btn-delete', function (ev) {
	ev.preventDefault();

	App.helpers.alert.confirm(App.trans('sure-delete'), App.trans('sure-delete-text'), 'warning', function () {
		window.location.href = $(ev.target).attr('href');
	})
});

$('.toCollapse h2').click(function (ev) {
    var target = $(ev.target);
    if (!target.is('h2')) {
        target = target.closest('h2');
    }

    if (target.hasClass('collapsed')) {
        target.find('.cursor').removeClass('fa-chevron-circle-down');
        target.find('.cursor').addClass('fa-chevron-circle-up');
    } else {
        target.find('.cursor').removeClass('fa-chevron-circle-up');
        target.find('.cursor').addClass('fa-chevron-circle-down');
    }

});

$('.toCollapse h3').click(function (ev) {
    var target = $(ev.target);
    if (!target.is('h3')) {
        target = target.closest('h3');
    }

    if (target.hasClass('collapsed')) {
        target.find('.cursor').removeClass('fa-chevron-circle-down');
        target.find('.cursor').addClass('fa-chevron-circle-up');
    } else {
        target.find('.cursor').removeClass('fa-chevron-circle-up');
        target.find('.cursor').addClass('fa-chevron-circle-down');
    }

});
