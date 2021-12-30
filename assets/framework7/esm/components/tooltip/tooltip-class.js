function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inheritsLoose(subClass, superClass) { subClass.prototype = Object.create(superClass.prototype); subClass.prototype.constructor = subClass; subClass.__proto__ = superClass; }

import { getDocument } from 'ssr-window';
import $ from '../../shared/dom7';
import { extend, deleteProps } from '../../shared/utils';
import { getSupport } from '../../shared/get-support';
import Framework7Class from '../../shared/class';

var Tooltip = /*#__PURE__*/function (_Framework7Class) {
  _inheritsLoose(Tooltip, _Framework7Class);

  function Tooltip(app, params) {
    var _this;

    if (params === void 0) {
      params = {};
    }

    _this = _Framework7Class.call(this, params, [app]) || this;

    var tooltip = _assertThisInitialized(_this);

    var support = getSupport();
    var defaults = extend({}, app.params.tooltip);
    var document = getDocument(); // Extend defaults with modules params

    tooltip.useModulesParams(defaults);
    tooltip.params = extend(defaults, params);

    if (typeof params.offset === 'undefined' && support.touch && tooltip.params.trigger === 'hover') {
      tooltip.params.offset = 10;
    }

    var _tooltip$params = tooltip.params,
        targetEl = _tooltip$params.targetEl,
        containerEl = _tooltip$params.containerEl;
    if (!targetEl && !tooltip.params.delegated) return tooltip || _assertThisInitialized(_this);
    var $targetEl = $(targetEl);
    if ($targetEl.length === 0 && !tooltip.params.delegated) return tooltip || _assertThisInitialized(_this);
    if ($targetEl[0] && $targetEl[0].f7Tooltip && !tooltip.params.delegated) return $targetEl[0].f7Tooltip || _assertThisInitialized(_this);
    var $containerEl = $(containerEl || app.$el).eq(0);

    if ($containerEl.length === 0) {
      $containerEl = app.$el;
    }

    var $el = $(tooltip.render()).eq(0);
    extend(tooltip, {
      app: app,
      $targetEl: $targetEl,
      targetEl: $targetEl && $targetEl[0],
      $containerEl: $containerEl,
      containerEl: $containerEl && $containerEl[0],
      $el: $el,
      el: $el && $el[0],
      text: tooltip.params.text || '',
      visible: false,
      opened: false
    });
    if ($targetEl[0]) $targetEl[0].f7Tooltip = tooltip;
    var touchesStart = {};
    var isTouched;

    function handleClick() {
      if (tooltip.opened) tooltip.hide();else tooltip.show(this);
    }

    function handleClickOut(e) {
      if (tooltip.opened && ($(e.target).closest($targetEl).length || $(e.target).closest(tooltip.$el).length)) return;
      tooltip.hide();
    }

    function handleTouchStart(e) {
      if (isTouched) return;
      isTouched = true;
      touchesStart.x = e.type === 'touchstart' ? e.targetTouches[0].pageX : e.pageX;
      touchesStart.y = e.type === 'touchstart' ? e.targetTouches[0].pageY : e.pageY;
      tooltip.show(this);
    }

    function handleTouchMove(e) {
      if (!isTouched) return;
      var x = e.type === 'touchmove' ? e.targetTouches[0].pageX : e.pageX;
      var y = e.type === 'touchmove' ? e.targetTouches[0].pageY : e.pageY;
      var distance = Math.pow(Math.pow(x - touchesStart.x, 2) + Math.pow(y - touchesStart.y, 2), 0.5);

      if (distance > 50) {
        isTouched = false;
        tooltip.hide();
      }
    }

    function handleTouchEnd() {
      if (!isTouched) return;
      isTouched = false;
      tooltip.hide();
    }

    function handleMouseEnter() {
      tooltip.show(this);
    }

    function handleMouseLeave() {
      tooltip.hide();
    }

    function handleTransitionEnd() {
      if (!$el.hasClass('tooltip-in')) {
        $el.removeClass('tooltip-out').remove();
      }
    }

    tooltip.attachEvents = function attachEvents() {
      $el.on('transitionend', handleTransitionEnd);

      if (tooltip.params.trigger === 'click') {
        if (tooltip.params.delegated) {
          $(document).on('click', tooltip.params.targetEl, handleClick);
        } else {
          tooltip.$targetEl.on('click', handleClick);
        }

        $('html').on('click', handleClickOut);
        return;
      }

      if (tooltip.params.trigger === 'manual') return;

      if (support.touch) {
        var passive = support.passiveListener ? {
          passive: true
        } : false;

        if (tooltip.params.delegated) {
          $(document).on(app.touchEvents.start, tooltip.params.targetEl, handleTouchStart, passive);
        } else {
          tooltip.$targetEl.on(app.touchEvents.start, handleTouchStart, passive);
        }

        app.on('touchmove', handleTouchMove);
        app.on('touchend:passive', handleTouchEnd);
      } else {
        // eslint-disable-next-line
        if (tooltip.params.delegated) {
          $(document).on(support.pointerEvents ? 'pointerenter' : 'mouseenter', tooltip.params.targetEl, handleMouseEnter, true);
          $(document).on(support.pointerEvents ? 'pointerleave' : 'mouseleave', tooltip.params.targetEl, handleMouseLeave, true);
        } else {
          tooltip.$targetEl.on(support.pointerEvents ? 'pointerenter' : 'mouseenter', handleMouseEnter);
          tooltip.$targetEl.on(support.pointerEvents ? 'pointerleave' : 'mouseleave', handleMouseLeave);
        }
      }
    };

    tooltip.detachEvents = function detachEvents() {
      $el.off('transitionend', handleTransitionEnd);

      if (tooltip.params.trigger === 'click') {
        if (tooltip.params.delegated) {
          $(document).on('click', tooltip.params.targetEl, handleClick);
        } else {
          tooltip.$targetEl.off('click', handleClick);
        }

        $('html').off('click', handleClickOut);
        return;
      }

      if (tooltip.params.trigger === 'manual') return;

      if (support.touch) {
        var passive = support.passiveListener ? {
          passive: true
        } : false;

        if (tooltip.params.delegated) {
          $(document).off(app.touchEvents.start, tooltip.params.targetEl, handleTouchStart, passive);
        } else {
          tooltip.$targetEl.off(app.touchEvents.start, handleTouchStart, passive);
        }

        app.off('touchmove', handleTouchMove);
        app.off('touchend:passive', handleTouchEnd);
      } else {
        // eslint-disable-next-line
        if (tooltip.params.delegated) {
          $(document).off(support.pointerEvents ? 'pointerenter' : 'mouseenter', tooltip.params.targetEl, handleMouseEnter, true);
          $(document).off(support.pointerEvents ? 'pointerleave' : 'mouseleave', tooltip.params.targetEl, handleMouseLeave, true);
        } else {
          tooltip.$targetEl.off(support.pointerEvents ? 'pointerenter' : 'mouseenter', handleMouseEnter);
          tooltip.$targetEl.off(support.pointerEvents ? 'pointerleave' : 'mouseleave', handleMouseLeave);
        }
      }
    }; // Install Modules


    tooltip.useModules();
    tooltip.init();
    return tooltip || _assertThisInitialized(_this);
  }

  var _proto = Tooltip.prototype;

  _proto.setTargetEl = function setTargetEl(targetEl) {
    var tooltip = this;
    tooltip.detachEvents();
    tooltip.$targetEl = $(targetEl);
    tooltip.targetEl = tooltip.$targetEl[0];
    tooltip.attachEvents();
    return tooltip;
  };

  _proto.position = function position(targetEl) {
    var tooltip = this;
    var $el = tooltip.$el,
        app = tooltip.app,
        $containerEl = tooltip.$containerEl;
    var hasContainerEl = !!tooltip.params.containerEl;
    var tooltipOffset = tooltip.params.offset || 0;
    $el.css({
      left: '',
      top: ''
    });
    var $targetEl = $(targetEl || tooltip.targetEl);
    var _ref = [$el.width(), $el.height()],
        width = _ref[0],
        height = _ref[1];
    $el.css({
      left: '',
      top: ''
    });
    var targetWidth;
    var targetHeight;
    var targetOffsetLeft;
    var targetOffsetTop;
    var boundaries = hasContainerEl && $containerEl.length ? $containerEl[0].getBoundingClientRect() : app;

    if ($targetEl && $targetEl.length > 0) {
      targetWidth = $targetEl.outerWidth();
      targetHeight = $targetEl.outerHeight();

      if (typeof targetWidth === 'undefined' && typeof targetHeight === 'undefined') {
        var clientRect = $targetEl[0].getBoundingClientRect();
        targetWidth = clientRect.width;
        targetHeight = clientRect.height;
      }

      var targetOffset = $targetEl.offset();
      targetOffsetLeft = targetOffset.left - boundaries.left;
      targetOffsetTop = targetOffset.top - boundaries.top;
      var targetParentPage = $targetEl.parents('.page');

      if (targetParentPage.length > 0) {
        targetOffsetTop -= targetParentPage[0].scrollTop;
      }
    }

    var _ref2 = [0, 0, 0],
        left = _ref2[0],
        top = _ref2[1]; // Top Position

    var position = 'top';

    if (height + tooltipOffset < targetOffsetTop) {
      // On top
      top = targetOffsetTop - height - tooltipOffset;
    } else if (height < boundaries.height - targetOffsetTop - targetHeight) {
      // On bottom
      position = 'bottom';
      top = targetOffsetTop + targetHeight + tooltipOffset;
    } else {
      // On middle
      position = 'middle';
      top = targetHeight / 2 + targetOffsetTop - height / 2;

      if (top <= 0) {
        top = 8;
      } else if (top + height >= boundaries.height) {
        top = boundaries.height - height - 8;
      }
    } // Horizontal Position


    if (position === 'top' || position === 'bottom') {
      left = targetWidth / 2 + targetOffsetLeft - width / 2;
      if (left < 8) left = 8;
      if (left + width > boundaries.width) left = boundaries.width - width - 8;
      if (left < 0) left = 0;
    } else if (position === 'middle') {
      left = targetOffsetLeft - width;

      if (left < 8 || left + width > boundaries.width) {
        if (left < 8) left = targetOffsetLeft + targetWidth;
        if (left + width > boundaries.width) left = boundaries.width - width - 8;
      }
    } // Apply Styles


    $el.css({
      top: top + "px",
      left: left + "px"
    });
  };

  _proto.show = function show(aroundEl) {
    var tooltip = this;
    var $el = tooltip.$el,
        $targetEl = tooltip.$targetEl,
        $containerEl = tooltip.$containerEl;

    if ($containerEl[0] && $el[0] && !$containerEl[0].contains($el[0])) {
      $containerEl.append($el);
    }

    tooltip.position(aroundEl);
    var $aroundEl = $(aroundEl);
    tooltip.visible = true;
    tooltip.opened = true;
    $targetEl.trigger('tooltip:show');
    $el.trigger('tooltip:show');

    if ($aroundEl.length && $aroundEl[0] !== $targetEl[0]) {
      $aroundEl.trigger('tooltip:show');
    }

    tooltip.emit('local::show tooltipShow', tooltip);
    $el.removeClass('tooltip-out').addClass('tooltip-in');
    return tooltip;
  };

  _proto.hide = function hide() {
    var tooltip = this;
    var $el = tooltip.$el,
        $targetEl = tooltip.$targetEl;
    tooltip.visible = false;
    tooltip.opened = false;
    $targetEl.trigger('tooltip:hide');
    $el.trigger('tooltip:hide');
    tooltip.emit('local::hide tooltipHide', tooltip);
    $el.addClass('tooltip-out').removeClass('tooltip-in');
    return tooltip;
  };

  _proto.render = function render() {
    var tooltip = this;
    if (tooltip.params.render) return tooltip.params.render.call(tooltip, tooltip);
    var _tooltip$params2 = tooltip.params,
        cssClass = _tooltip$params2.cssClass,
        text = _tooltip$params2.text;
    return ("\n      <div class=\"tooltip " + (cssClass || '') + "\">\n        <div class=\"tooltip-content\">" + (text || '') + "</div>\n      </div>\n    ").trim();
  };

  _proto.setText = function setText(newText) {
    var tooltip = this;

    if (typeof newText === 'undefined') {
      return tooltip;
    }

    tooltip.params.text = newText;
    tooltip.text = newText;

    if (tooltip.$el) {
      tooltip.$el.children('.tooltip-content').html(newText);
    }

    if (tooltip.opened) {
      tooltip.position();
    }

    return tooltip;
  };

  _proto.init = function init() {
    var tooltip = this;
    tooltip.attachEvents();
  };

  _proto.destroy = function destroy() {
    var tooltip = this;
    if (!tooltip.$targetEl || tooltip.destroyed) return;
    tooltip.$targetEl.trigger('tooltip:beforedestroy');
    tooltip.emit('local::beforeDestroy tooltipBeforeDestroy', tooltip);
    tooltip.$el.remove();
    if (tooltip.$targetEl[0]) delete tooltip.$targetEl[0].f7Tooltip;
    tooltip.detachEvents();
    deleteProps(tooltip);
    tooltip.destroyed = true;
  };

  return Tooltip;
}(Framework7Class);

export default Tooltip;