import { extend } from '../../shared/utils';
import Autocomplete from './autocomplete-class';
import ConstructorMethods from '../../shared/constructor-methods';
export default {
  name: 'autocomplete',
  params: {
    autocomplete: {
      openerEl: undefined,
      inputEl: undefined,
      view: undefined,
      // DropDown
      dropdownContainerEl: undefined,
      dropdownPlaceholderText: undefined,
      typeahead: false,
      highlightMatches: true,
      expandInput: false,
      updateInputValueOnSelect: true,
      inputEvents: 'input',
      value: undefined,
      multiple: false,
      source: undefined,
      limit: undefined,
      valueProperty: 'id',
      textProperty: 'text',
      openIn: 'page',
      // or 'popup' or 'dropdown'
      pageBackLinkText: 'Back',
      popupCloseLinkText: 'Close',
      pageTitle: undefined,
      searchbarPlaceholder: 'Search...',
      searchbarDisableText: 'Cancel',
      searchbarDisableButton: undefined,
      searchbarSpellcheck: false,
      popupPush: false,
      popupSwipeToClose: undefined,
      animate: true,
      autoFocus: false,
      closeOnSelect: false,
      notFoundText: 'Nothing found',
      requestSourceOnOpen: false,
      // Preloader
      preloaderColor: undefined,
      preloader: false,
      // Colors
      formColorTheme: undefined,
      navbarColorTheme: undefined,
      // Routing
      routableModals: false,
      url: 'select/',
      // Custom render functions
      renderDropdown: undefined,
      renderPage: undefined,
      renderPopup: undefined,
      renderItem: undefined,
      renderSearchbar: undefined,
      renderNavbar: undefined
    }
  },
  static: {
    Autocomplete: Autocomplete
  },
  create: function create() {
    var app = this;
    app.autocomplete = extend(ConstructorMethods({
      defaultSelector: undefined,
      constructor: Autocomplete,
      app: app,
      domProp: 'f7Autocomplete'
    }), {
      open: function open(autocompleteEl) {
        var ac = app.autocomplete.get(autocompleteEl);
        if (ac && ac.open) return ac.open();
        return undefined;
      },
      close: function close(autocompleteEl) {
        var ac = app.autocomplete.get(autocompleteEl);
        if (ac && ac.close) return ac.close();
        return undefined;
      }
    });
  }
};