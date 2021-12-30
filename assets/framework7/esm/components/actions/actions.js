import Actions from './actions-class';
import ModalMethods from '../../shared/modal-methods';
export default {
  name: 'actions',
  params: {
    actions: {
      convertToPopover: true,
      forceToPopover: false,
      backdrop: true,
      backdropEl: undefined,
      cssClass: null,
      closeByBackdropClick: true,
      closeOnEscape: false,
      render: null,
      renderPopover: null,
      containerEl: null
    }
  },
  static: {
    Actions: Actions
  },
  create: function create() {
    var app = this;
    app.actions = ModalMethods({
      app: app,
      constructor: Actions,
      defaultSelector: '.actions-modal.modal-in'
    });
  },
  clicks: {
    '.actions-open': function openActions($clickedEl, data) {
      if (data === void 0) {
        data = {};
      }

      var app = this;
      app.actions.open(data.actions, data.animate, $clickedEl);
    },
    '.actions-close': function closeActions($clickedEl, data) {
      if (data === void 0) {
        data = {};
      }

      var app = this;
      app.actions.close(data.actions, data.animate, $clickedEl);
    }
  }
};