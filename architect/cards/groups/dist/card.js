/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/Card.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SessionHistory__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SessionHistory */ "./resources/Components/SessionHistory.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    SessionHistory: _SessionHistory__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    data: Object | Array,
    labels: Object | Array
  },
  data: function data() {
    return {
      groups: [],
      viewedSession: null,
      viewedName: null,
      showMemberModal: false,
      showSessionDetail: false,
      sessionId: null
    };
  },
  mounted: function mounted() {
    var _this = this;

    window.Architect.request().get('/external/groups/list').then(function (response) {
      _this.groups = response.data;
    });
  },
  methods: {
    formatDate: function formatDate(date) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'Do MMMM YYYY';
      return moment(date).format(format);
    },
    viewMemberList: function viewMemberList(groupSession, name) {
      if (groupSession.members_count === 0) {
        return;
      }

      this.viewedName = name;
      this.viewedSession = groupSession;
      this.showMemberModal = true;
    },
    viewSessionHistory: function viewSessionHistory(id, name) {
      this.viewedName = name;
      this.sessionId = id;
      this.showSessionDetail = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/MemberList.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/MemberList.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    groupSessionId: {
      type: Number,
      required: true
    }
  },
  data: function data() {
    return {
      members: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    window.Architect.request().get("/external/groups/members/".concat(this.groupSessionId)).then(function (response) {
      _this.members = response.data;
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/SessionHistory.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/SessionHistory.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    groupName: {
      type: String,
      required: true
    },
    sessionId: {
      type: Number,
      required: true
    }
  },
  data: function data() {
    return {
      loaded: false,
      session: {},
      showMembers: false,
      groupSessionId: 0
    };
  },
  mounted: function mounted() {
    var _this = this;

    window.Architect.request().get("/external/groups/session/".concat(this.sessionId)).then(function (response) {
      _this.session = response.data;
      _this.loaded = true;
    });
  },
  methods: {
    formatDate: function formatDate(date) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'Do MMMM YYYY';
      return moment(date).format(format);
    },
    viewMemberList: function viewMemberList(groupSessionId, count) {
      if (count === 0) {
        return;
      }

      this.groupSessionId = groupSessionId;
      this.showMembers = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=template&id=52f81d61&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/Card.vue?vue&type=template&id=52f81d61& ***!
  \****************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", [
        _c(
          "div",
          { staticClass: "flex flex-col" },
          _vm._l(_vm.groups, function(group) {
            return _c("div", { staticClass: "bg-blue-100 p-2 rounded my-2" }, [
              _c(
                "h3",
                { staticClass: "text-xl text-gray-900 mb-2 font-semibold" },
                [_vm._v(_vm._s(group.name))]
              ),
              _vm._v(" "),
              _c("h4", { staticClass: "text-gray-700 font-semibold text-lg" }, [
                _vm._v("Sessions")
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "flex flex-col lg:flex-row lg:justify-between lg:-mx-2 lg:flex-wrap"
                },
                _vm._l(group.group_sessions, function(groupSession) {
                  return _c("div", { staticClass: "p-2 lg:w-1/2" }, [
                    _c("div", { staticClass: "bg-gray-100 rounded p-2" }, [
                      _c("div", { staticClass: "flex justify-between" }, [
                        _c("div", { staticClass: "flex flex-col mb-2" }, [
                          _c("strong", { staticClass: "font-semibold" }, [
                            _vm._v("Date")
                          ]),
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.formatDate(groupSession.date)) +
                              "\n                                "
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "flex flex-col mb-2" }, [
                          _c("strong", { staticClass: "font-semibold" }, [
                            _vm._v("Time")
                          ]),
                          _vm._v(
                            "\n                                    " +
                              _vm._s(groupSession.session.human_start_time) +
                              " - " +
                              _vm._s(groupSession.session.human_end_time) +
                              "\n                                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "flex justify-between" }, [
                        _c("strong", { staticClass: "font-semibold" }, [
                          _vm._v("Members")
                        ]),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            directives: [
                              {
                                name: "tooltip",
                                rawName: "v-tooltip",
                                value: "View List",
                                expression: "'View List'"
                              }
                            ],
                            staticClass:
                              "font-semibold text-blue-500 hover:underline cursor-pointer",
                            on: {
                              click: function($event) {
                                return _vm.viewMemberList(
                                  groupSession,
                                  group.name
                                )
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(groupSession.members_count) +
                                "/" +
                                _vm._s(groupSession.session.capacity) +
                                "\n                                "
                            )
                          ]
                        )
                      ])
                    ])
                  ])
                }),
                0
              ),
              _vm._v(" "),
              _c(
                "h4",
                { staticClass: "text-gray-700 font-semibold text-lg mt-4" },
                [_vm._v("View Session History")]
              ),
              _vm._v(" "),
              _c(
                "ul",
                { staticClass: "my-2" },
                _vm._l(group.sessions, function(session) {
                  return _c(
                    "li",
                    {
                      staticClass:
                        "cursor-pointer hover:underline font-semibold",
                      on: {
                        click: function($event) {
                          return _vm.viewSessionHistory(session.id, group.name)
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(session.day.day) +
                          "'s, " +
                          _vm._s(session.human_start_time) +
                          "\n                    "
                      )
                    ]
                  )
                }),
                0
              )
            ])
          }),
          0
        )
      ]),
      _vm._v(" "),
      _vm.showMemberModal
        ? _c(
            "portal",
            { attrs: { to: "modal" } },
            [
              _c("modal", [
                _c(
                  "div",
                  { staticClass: "w-full bg-gray-100 p-2" },
                  [
                    _c(
                      "div",
                      {
                        staticClass:
                          "absolute top-0 right-0 p-1 leading-none text-xl cursor-pointer",
                        on: {
                          click: function($event) {
                            _vm.showMemberModal = false
                          }
                        }
                      },
                      [
                        _c("font-awesome-icon", {
                          attrs: { icon: ["fas", "times"] }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("p", { staticClass: "font-semibold text-lg" }, [
                      _vm._v(
                        "\n                    Member List for " +
                          _vm._s(_vm.viewedName) +
                          ", " +
                          _vm._s(_vm.formatDate(_vm.viewedSession.date)) +
                          " - " +
                          _vm._s(_vm.viewedSession.session.human_start_time) +
                          "\n                "
                      )
                    ]),
                    _vm._v(" "),
                    _c("p", [
                      _c(
                        "a",
                        {
                          attrs: {
                            href:
                              "/admin/api/external/groups/printMembers/" +
                              _vm.viewedSession.id,
                            target: "_blank"
                          }
                        },
                        [
                          _vm._v(
                            "Printer\n                        Friendly List"
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c("groups-member-list", {
                      attrs: { "group-session-id": _vm.viewedSession.id }
                    })
                  ],
                  1
                )
              ])
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.showSessionDetail
        ? _c(
            "portal",
            { attrs: { to: "modal" } },
            [
              _c("modal", [
                _c(
                  "div",
                  { staticClass: "w-full bg-gray-100 p-2" },
                  [
                    _c(
                      "div",
                      {
                        staticClass:
                          "absolute top-0 right-0 p-1 leading-none text-xl cursor-pointer",
                        on: {
                          click: function($event) {
                            _vm.showSessionDetail = false
                          }
                        }
                      },
                      [
                        _c("font-awesome-icon", {
                          attrs: { icon: ["fas", "times"] }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("session-history", {
                      attrs: {
                        "group-name": _vm.viewedName,
                        "session-id": _vm.sessionId
                      }
                    })
                  ],
                  1
                )
              ])
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e& ***!
  \**********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "ul",
    { staticClass: "my-2 border-t border-blue-200" },
    [
      _c(
        "li",
        {
          staticClass:
            "p-2 border-b border-blue-200 font-semibold text-blue-700 bg-blue-200"
        },
        [_vm._v("\n        Name | Email Address | Phone Number\n    ")]
      ),
      _vm._v(" "),
      _vm._l(_vm.members, function(member) {
        return _c("li", { staticClass: "p-2 border-b border-blue-200" }, [
          _c("span", { staticClass: "capitalize" }, [
            _vm._v(_vm._s(member.name))
          ]),
          _vm._v(
            " | " +
              _vm._s(member.email) +
              " | " +
              _vm._s(member.phone) +
              "\n    "
          )
        ])
      })
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f& ***!
  \**************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.loaded
    ? _c(
        "div",
        [
          _c("div", [
            _c(
              "h2",
              { staticClass: "text-xl font-semibold text-center mb-2" },
              [
                _vm._v(
                  "\n            " +
                    _vm._s(_vm.groupName) +
                    ", " +
                    _vm._s(_vm.session.day.day) +
                    ", " +
                    _vm._s(_vm.session.human_start_time) +
                    " - " +
                    _vm._s(_vm.session.human_end_time) +
                    "\n        "
                )
              ]
            ),
            _vm._v(" "),
            _c("table", { staticClass: "w-full" }, [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.session.group_sessions, function(group) {
                  return _c(
                    "tr",
                    {
                      staticClass: "border-b-2 border-blue-500",
                      class:
                        group.type === "past"
                          ? "bg-red-500"
                          : group.type === "future"
                          ? "bg-green-500"
                          : ""
                    },
                    [
                      _c(
                        "td",
                        { staticClass: "p-2 border-r border-blue-500" },
                        [_vm._v(_vm._s(_vm.formatDate(group.date)))]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "p-2 text-right",
                          on: {
                            click: function($event) {
                              return _vm.viewMemberList(
                                group.id,
                                group.members_count
                              )
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                    " +
                              _vm._s(group.members_count) +
                              "/" +
                              _vm._s(_vm.session.capacity) +
                              "\n                "
                          )
                        ]
                      )
                    ]
                  )
                }),
                0
              )
            ])
          ]),
          _vm._v(" "),
          _vm.showMembers
            ? _c(
                "portal",
                { attrs: { to: "secondary-modal" } },
                [
                  _c("modal", [
                    _c(
                      "div",
                      { staticClass: "w-full bg-gray-100 p-2" },
                      [
                        _c(
                          "div",
                          {
                            staticClass:
                              "absolute top-0 right-0 p-1 leading-none text-xl cursor-pointer",
                            on: {
                              click: function($event) {
                                _vm.showMembers = false
                              }
                            }
                          },
                          [
                            _c("font-awesome-icon", {
                              attrs: { icon: ["fas", "times"] }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("p", [
                          _c(
                            "a",
                            {
                              attrs: {
                                href:
                                  "/admin/api/external/groups/printMembers/" +
                                  _vm.groupSessionId,
                                target: "_blank"
                              }
                            },
                            [
                              _vm._v(
                                "Printer\n                        Friendly List"
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c("groups-member-list", {
                          attrs: { "group-session-id": _vm.groupSessionId }
                        })
                      ],
                      1
                    )
                  ])
                ],
                1
              )
            : _vm._e()
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c(
        "tr",
        {
          staticClass:
            "bg-blue-500 text-white font-semibold border-b-2 border-white"
        },
        [
          _c(
            "th",
            { staticClass: "text-left w-10/12 p-2 border-r border-white" },
            [_vm._v("Date")]
          ),
          _vm._v(" "),
          _c("th", { staticClass: "text-left p-2" }, [_vm._v("Members")])
        ]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/Components/Card.vue":
/*!***************************************!*\
  !*** ./resources/Components/Card.vue ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Card.vue?vue&type=template&id=52f81d61& */ "./resources/Components/Card.vue?vue&type=template&id=52f81d61&");
/* harmony import */ var _Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Card.vue?vue&type=script&lang=js& */ "./resources/Components/Card.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/Card.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/Card.vue?vue&type=script&lang=js&":
/*!****************************************************************!*\
  !*** ./resources/Components/Card.vue?vue&type=script&lang=js& ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./Card.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/Card.vue?vue&type=template&id=52f81d61&":
/*!**********************************************************************!*\
  !*** ./resources/Components/Card.vue?vue&type=template&id=52f81d61& ***!
  \**********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./Card.vue?vue&type=template&id=52f81d61& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=template&id=52f81d61&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/Components/MemberList.vue":
/*!*********************************************!*\
  !*** ./resources/Components/MemberList.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MemberList.vue?vue&type=template&id=8957bc2e& */ "./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e&");
/* harmony import */ var _MemberList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MemberList.vue?vue&type=script&lang=js& */ "./resources/Components/MemberList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MemberList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/MemberList.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/MemberList.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/Components/MemberList.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MemberList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./MemberList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/MemberList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MemberList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e&":
/*!****************************************************************************!*\
  !*** ./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./MemberList.vue?vue&type=template&id=8957bc2e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/MemberList.vue?vue&type=template&id=8957bc2e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MemberList_vue_vue_type_template_id_8957bc2e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/Components/SessionHistory.vue":
/*!*************************************************!*\
  !*** ./resources/Components/SessionHistory.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SessionHistory.vue?vue&type=template&id=0dd85d2f& */ "./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f&");
/* harmony import */ var _SessionHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SessionHistory.vue?vue&type=script&lang=js& */ "./resources/Components/SessionHistory.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SessionHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/SessionHistory.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/SessionHistory.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/Components/SessionHistory.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SessionHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./SessionHistory.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/SessionHistory.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SessionHistory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f&":
/*!********************************************************************************!*\
  !*** ./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./SessionHistory.vue?vue&type=template&id=0dd85d2f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/SessionHistory.vue?vue&type=template&id=0dd85d2f&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SessionHistory_vue_vue_type_template_id_0dd85d2f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/card.js":
/*!***************************!*\
  !*** ./resources/card.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Components_Card__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Components/Card */ "./resources/Components/Card.vue");
/* harmony import */ var _Components_MemberList__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Components/MemberList */ "./resources/Components/MemberList.vue");
/* harmony import */ var _Components_SessionHistory__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Components/SessionHistory */ "./resources/Components/SessionHistory.vue");



Architect.onBoot(function (Vue) {
  Vue.component('groups-card', _Components_Card__WEBPACK_IMPORTED_MODULE_0__["default"]);
  Vue.component('groups-member-list', _Components_MemberList__WEBPACK_IMPORTED_MODULE_1__["default"]);
  Vue.component('group-session-history', _Components_SessionHistory__WEBPACK_IMPORTED_MODULE_2__["default"]);
});

/***/ }),

/***/ "./resources/card.scss":
/*!*****************************!*\
  !*** ./resources/card.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************!*\
  !*** multi ./resources/card.js ./resources/card.scss ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/jamiepeters/code/swx/architect/cards/groups/resources/card.js */"./resources/card.js");
module.exports = __webpack_require__(/*! /Users/jamiepeters/code/swx/architect/cards/groups/resources/card.scss */"./resources/card.scss");


/***/ })

/******/ });