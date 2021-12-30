"use strict";

exports.__esModule = true;
exports["default"] = void 0;

var _vue = require("vue");

var _default = {
  name: 'skeleton-text',
  props: {
    tag: {
      type: String,
      "default": 'span'
    },
    effect: String
  },
  render: function render() {
    var _class;

    return (0, _vue.h)(this.tag, {
      "class": (_class = {
        'skeleton-text': true
      }, _class["skeleton-effect-" + this.effect] = this.effect, _class)
    }, this.$slots["default"] && this.$slots["default"]());
  }
};
exports["default"] = _default;