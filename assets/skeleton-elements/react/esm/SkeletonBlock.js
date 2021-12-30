function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

import React from 'react';

var SkeletonBlock = function SkeletonBlock(_temp) {
  var _ref = _temp === void 0 ? {} : _temp,
      _ref$tag = _ref.tag,
      Tag = _ref$tag === void 0 ? 'div' : _ref$tag,
      width = _ref.width,
      height = _ref.height,
      borderRadius = _ref.borderRadius,
      effect = _ref.effect,
      className = _ref.className,
      style = _ref.style,
      children = _ref.children,
      other = _objectWithoutPropertiesLoose(_ref, ["tag", "width", "height", "borderRadius", "effect", "className", "style", "children"]);

  var skeletonStyle = style || {};
  if (width) skeletonStyle.width = width;
  if (height) skeletonStyle.height = height;
  if (borderRadius) skeletonStyle.borderRadius = borderRadius;
  var skeletonClassName = ['skeleton-block', effect && "skeleton-effect-" + effect, className].filter(function (c) {
    return !!c;
  }).join(' ');
  return /*#__PURE__*/React.createElement(Tag, _extends({
    style: skeletonStyle,
    className: skeletonClassName
  }, other), children);
};

export default SkeletonBlock;