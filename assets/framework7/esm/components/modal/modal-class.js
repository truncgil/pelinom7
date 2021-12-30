function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inheritsLoose(subClass, superClass) { subClass.prototype = Object.create(superClass.prototype); subClass.prototype.constructor = subClass; subClass.__proto__ = superClass; }

import { getDocument } from 'ssr-window';
import $ from '../../shared/dom7';
import { extend, deleteProps } from '../../shared/utils';
import Framework7Class from '../../shared/class';
var openedModals = [];
var dialogsQueue = [];

function clearDialogsQueue() {
  if (dialogsQueue.length === 0) return;
  var dialog = dialogsQueue.shift();
  dialog.open();
}

var Modal = /*#__PURE__*/function (_Framework7Class) {
  _inheritsLoose(Modal, _Framework7Class);

  function Modal(app, params) {
    var _this;

    _this = _Framework7Class.call(this, params, [app]) || this;

    var modal = _assertThisInitialized(_this);

    var defaults = {}; // Extend defaults with modules params

    modal.useModulesParams(defaults);
    modal.params = extend(defaults, params);
    modal.opened = false;
    var $containerEl = modal.params.containerEl ? $(modal.params.containerEl).eq(0) : app.$el;
    if (!$containerEl.length) $containerEl = app.$el;
    modal.$containerEl = $containerEl;
    modal.containerEl = $containerEl[0]; // Install Modules

    modal.useModules();
    return _assertThisInitialized(_this) || _assertThisInitialized(_this);
  }

  var _proto = Modal.prototype;

  _proto.onOpen = function onOpen() {
    var modal = this;
    modal.opened = true;
    openedModals.push(modal);
    $('html').addClass("with-modal-" + modal.type.toLowerCase());
    modal.$el.trigger("modal:open " + modal.type.toLowerCase() + ":open");
    modal.emit("local::open modalOpen " + modal.type + "Open", modal);
  };

  _proto.onOpened = function onOpened() {
    var modal = this;
    modal.$el.trigger("modal:opened " + modal.type.toLowerCase() + ":opened");
    modal.emit("local::opened modalOpened " + modal.type + "Opened", modal);
  };

  _proto.onClose = function onClose() {
    var modal = this;
    modal.opened = false;
    if (!modal.type || !modal.$el) return;
    openedModals.splice(openedModals.indexOf(modal), 1);
    $('html').removeClass("with-modal-" + modal.type.toLowerCase());
    modal.$el.trigger("modal:close " + modal.type.toLowerCase() + ":close");
    modal.emit("local::close modalClose " + modal.type + "Close", modal);
  };

  _proto.onClosed = function onClosed() {
    var modal = this;
    if (!modal.type || !modal.$el) return;
    modal.$el.removeClass('modal-out');
    modal.$el.hide();
    modal.$el.trigger("modal:closed " + modal.type.toLowerCase() + ":closed");
    modal.emit("local::closed modalClosed " + modal.type + "Closed", modal);
  };

  _proto.open = function open(animateModal) {
    var modal = this;
    var document = getDocument();
    var app = modal.app;
    var $el = modal.$el;
    var $backdropEl = modal.$backdropEl;
    var type = modal.type;
    var animate = true;
    if (typeof animateModal !== 'undefined') animate = animateModal;else if (typeof modal.params.animate !== 'undefined') {
      animate = modal.params.animate;
    }

    if (!$el || $el.hasClass('modal-in')) {
      return modal;
    }

    if (type === 'dialog' && app.params.modal.queueDialogs) {
      var pushToQueue;

      if ($('.dialog.modal-in').length > 0) {
        pushToQueue = true;
      } else if (openedModals.length > 0) {
        openedModals.forEach(function (openedModal) {
          if (openedModal.type === 'dialog') pushToQueue = true;
        });
      }

      if (pushToQueue) {
        dialogsQueue.push(modal);
        return modal;
      }
    }

    var $modalParentEl = $el.parent();
    var wasInDom = $el.parents(document).length > 0;

    if (!$modalParentEl.is(modal.$containerEl)) {
      modal.$containerEl.append($el);
      modal.once(type + "Closed", function () {
        if (wasInDom) {
          $modalParentEl.append($el);
        } else {
          $el.remove();
        }
      });
    } // Show Modal


    $el.show();
    /* eslint no-underscore-dangle: ["error", { "allow": ["_clientLeft"] }] */

    modal._clientLeft = $el[0].clientLeft; // Modal

    function transitionEnd() {
      if ($el.hasClass('modal-out')) {
        modal.onClosed();
      } else if ($el.hasClass('modal-in')) {
        modal.onOpened();
      }
    }

    if (animate) {
      if ($backdropEl) {
        $backdropEl.removeClass('not-animated');
        $backdropEl.addClass('backdrop-in');
      }

      $el.animationEnd(function () {
        transitionEnd();
      });
      $el.transitionEnd(function () {
        transitionEnd();
      });
      $el.removeClass('modal-out not-animated').addClass('modal-in');
      modal.onOpen();
    } else {
      if ($backdropEl) {
        $backdropEl.addClass('backdrop-in not-animated');
      }

      $el.removeClass('modal-out').addClass('modal-in not-animated');
      modal.onOpen();
      modal.onOpened();
    }

    return modal;
  };

  _proto.close = function close(animateModal) {
    var modal = this;
    var $el = modal.$el;
    var $backdropEl = modal.$backdropEl;
    var animate = true;
    if (typeof animateModal !== 'undefined') animate = animateModal;else if (typeof modal.params.animate !== 'undefined') {
      animate = modal.params.animate;
    }

    if (!$el || !$el.hasClass('modal-in')) {
      if (dialogsQueue.indexOf(modal) >= 0) {
        dialogsQueue.splice(dialogsQueue.indexOf(modal), 1);
      }

      return modal;
    } // backdrop


    if ($backdropEl) {
      var needToHideBackdrop = true;

      if (modal.type === 'popup') {
        modal.$el.prevAll('.popup.modal-in').add(modal.$el.nextAll('.popup.modal-in')).each(function (popupEl) {
          var popupInstance = popupEl.f7Modal;
          if (!popupInstance) return;

          if (popupInstance.params.closeByBackdropClick && popupInstance.params.backdrop && popupInstance.backdropEl === modal.backdropEl) {
            needToHideBackdrop = false;
          }
        });
      }

      if (needToHideBackdrop) {
        $backdropEl[animate ? 'removeClass' : 'addClass']('not-animated');
        $backdropEl.removeClass('backdrop-in');
      }
    } // Modal


    $el[animate ? 'removeClass' : 'addClass']('not-animated');

    function transitionEnd() {
      if ($el.hasClass('modal-out')) {
        modal.onClosed();
      } else if ($el.hasClass('modal-in')) {
        modal.onOpened();
      }
    }

    if (animate) {
      $el.animationEnd(function () {
        transitionEnd();
      });
      $el.transitionEnd(function () {
        transitionEnd();
      });
      $el.removeClass('modal-in').addClass('modal-out'); // Emit close

      modal.onClose();
    } else {
      $el.addClass('not-animated').removeClass('modal-in').addClass('modal-out'); // Emit close

      modal.onClose();
      modal.onClosed();
    }

    if (modal.type === 'dialog') {
      clearDialogsQueue();
    }

    return modal;
  };

  _proto.destroy = function destroy() {
    var modal = this;
    if (modal.destroyed) return;
    modal.emit("local::beforeDestroy modalBeforeDestroy " + modal.type + "BeforeDestroy", modal);

    if (modal.$el) {
      modal.$el.trigger("modal:beforedestroy " + modal.type.toLowerCase() + ":beforedestroy");

      if (modal.$el.length && modal.$el[0].f7Modal) {
        delete modal.$el[0].f7Modal;
      }
    }

    deleteProps(modal);
    modal.destroyed = true;
  };

  return Modal;
}(Framework7Class);

export default Modal;