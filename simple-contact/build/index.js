/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./simple-contact/src/edit.js":
/*!************************************!*\
  !*** ./simple-contact/src/edit.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);


/**
 * Importamos RicheText para poder incluir opciones a nuestro bloque
 */


function Edit(props) {
  const {
    className,
    attributes,
    setAttributes
  } = props;
  const {
    title,
    nameLabel,
    emailLabel,
    mensajeLabel,
    checkboxLabel,
    urlLink,
    urlLabel,
    acordeonLabel,
    acordeonContent
  } = attributes;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: "Etiquetas",
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Etiqueta del nombre",
    value: nameLabel,
    onChange: newLabel => setAttributes({
      nameLabel: newLabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Etiqueta del email",
    value: emailLabel,
    onChange: newLabel => setAttributes({
      emailLabel: newLabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Etiqueta del mensaje",
    value: mensajeLabel,
    onChange: newLabel => setAttributes({
      mensajeLabel: newLabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Texto de la casilla de verificaci\xF3n",
    value: checkboxLabel,
    onChange: newLabel => setAttributes({
      checkboxLabel: newLabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "URL de la politica de privacidad",
    value: urlLink,
    onChange: newUrl => setAttributes({
      urlLink: newUrl
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Etiqueta del enlace de privacidad",
    value: urlLabel,
    onChange: newlabel => setAttributes({
      urlLabel: newlabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: "Etiqueta del boton de acordeon",
    value: acordeonLabel,
    onChange: newlabel => setAttributes({
      acordeonLabel: newlabel
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextareaControl, {
    label: "Contenido del acordeon",
    value: acordeonContent,
    onChange: newContent => setAttributes({
      acordeonContent: newContent
    })
  })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: className
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-contenedor-titulo"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText, {
    tagName: "h2",
    placeholder: "Escribir un titulo",
    className: "gsmtc-contact-titulo",
    value: title,
    onChange: newTitle => setAttributes({
      title: newTitle
    })
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-contenedor-formulario"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("form", {
    className: "gsmtc-contact-form",
    action: "",
    name: "gsmtc-contact-form",
    method: "post",
    enctype: "multipart/form-data"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-nombre"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "text",
    name: "gsmtc-contact-name",
    placeholder: nameLabel
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-email"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "email",
    name: "gsmtc-contact-email",
    placeholder: emailLabel
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-mensaje"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    placeholder: mensajeLabel,
    name: "gsmtc-contact-message"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-checbox"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "checkbox",
    name: "gsmtc-contact-checkbox"
  }), checkboxLabel, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    href: urlLink,
    target: "_blank",
    rel: "noreferrer noopener nofollow"
  }, " ", urlLabel)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-boton"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    name: "gsmtc-contact-boton",
    type: "submit",
    value: "enviar"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-aviso"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-titulo-acordeon"
  }, acordeonLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-contenido-acordeon"
  }, acordeonContent)))));
}

/***/ }),

/***/ "./simple-contact/src/index.js":
/*!*************************************!*\
  !*** ./simple-contact/src/index.js ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./simple-contact/src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./simple-contact/src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./simple-contact/src/save.js");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */


 // function Edit() {
//	 return (
//		 <p {...useBlockProps()}>
//			 {__('Gsmtc Forms – hello from the editor!', 'gsmtc-forms')}
//		 </p>
//	 );
// }
//function save() {
//	return (
//		<p {...useBlockProps()}>
//			{__('Gsmtc Forms – hello from the editor!', 'gsmtc-forms')}
//		</p>
//	);
//};

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('gsmtc-forms/simple-contact', {
  title: "Simple contact",
  category: "widgets",
  icon: "editor-table",
  attributes: {
    title: {
      source: "html",
      selector: "h1",
      default: "Contacto"
    },
    nameLabel: {
      type: "string",
      default: "Name"
    },
    emailLabel: {
      type: "string",
      default: "Email"
    },
    mensajeLabel: {
      type: "string",
      default: "Mensaje"
    },
    checkboxLabel: {
      type: "string",
      default: "He leido y acepto la "
    },
    urlLink: {
      type: "string",
      default: "pega la URL del enlace"
    },
    urlLabel: {
      type: "string",
      default: "politica de privacidad"
    },
    acordeonLabel: {
      type: "string",
      default: "politica de privacidad"
    },
    contentLabel: {
      type: "string",
      default: "politica de privacidad"
    }
  },

  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  //edit: <p>Hola Mundo</p>,

  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"] //save: <p>Hola Mundo</p>,

});

/***/ }),

/***/ "./simple-contact/src/save.js":
/*!************************************!*\
  !*** ./simple-contact/src/save.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Save; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/*import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */

/*import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
 //import {Panel, PanelBody, TextControl} from  "@wordpress/components";

function Save(props) {
  const {
    className,
    attributes
  } = props;
  const {
    title,
    nameLabel,
    emailLabel,
    mensajeLabel,
    checkboxLabel,
    urlLink,
    urlLabel
  } = attributes;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: className
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-contenedor-titulo"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText.Content, {
    tagName: "h2",
    className: "gsmtc-contact-titulo",
    value: title
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-contenedor-formulario"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("form", {
    className: "gsmtc-contact-form",
    action: "",
    name: "gsmtc-contact-form",
    method: "post",
    enctype: "multipart/form-data",
    onsubmit: "gsmtcContactFormSubmit"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-nombre"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "text",
    id: "gsmtc-contact-name",
    name: "name",
    placeholder: nameLabel,
    required: true
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-email"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "email",
    id: "gsmtc-contact-email",
    name: "email",
    placeholder: emailLabel,
    required: true
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-mensaje"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    id: "gsmtc-contact-message",
    name: "message",
    placeholder: mensajeLabel,
    required: true
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-checbox"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "checkbox",
    name: "accept",
    required: true
  }), checkboxLabel, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    href: urlLink,
    target: "_blank",
    rel: "noreferrer noopener nofollow"
  }, " ", urlLabel)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-boton"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    id: "gsmtc-contact-boton",
    type: "submit",
    name: "submit",
    value: "enviar"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-aviso"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "gsmtc-contact-titulo-acordeon"
  }))));
}

/***/ }),

/***/ "./simple-contact/src/style.scss":
/*!***************************************!*\
  !*** ./simple-contact/src/style.scss ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkgsmtc_forms"] = self["webpackChunkgsmtc_forms"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], function() { return __webpack_require__("./simple-contact/src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map