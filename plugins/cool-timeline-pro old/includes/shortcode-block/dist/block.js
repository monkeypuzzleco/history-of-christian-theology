/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/content-tm-block.js":
/*!*********************************!*\
  !*** ./src/content-tm-block.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

  __webpack_require__.r(__webpack_exports__);
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
  /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
  /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
  /* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./icons */ "./src/icons.js");
  /* harmony import */ var _layout_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./layout-type */ "./src/layout-type.js");
  /* harmony import */ var _images_timeline_png__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./images/timeline.png */ "./src/images/timeline.png");
  /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
  
  /**
   * Block dependencies
   */
  
  
  
  
  
  
  /**
   * Internal block libraries
   */
  const {
    __
  } = wp.i18n;
  const {
    registerBlockType
  } = wp.blocks;
  const baseURL = ctlUrl.CTP_PLUGIN_URL;
  const wpBaseURL = ctlUrl.baseURL;
  const LayoutImgPath = baseURL + '/includes/gutenberg-block/layout-images';
  const {
    apiFetch
  } = wp;
  const {
    RichText,
    InspectorControls,
    BlockControls
  } = wp.editor;
  const {
    Fragment
  } = wp.element;
  const {
    PanelBody,
    PanelRow,
    TextareaControl,
    TextControl,
    Dashicon,
    Toolbar,
    ButtonGroup,
    Button,
    SelectControl,
    Tooltip,
    RangeControl,
    TabPanel,
    Card,
    CardBody,
    ExternalLink
  } = wp.components;
  /**
   * Register block
  
   */
  /* harmony default export */ __webpack_exports__["default"] = (registerBlockType('cool-content-timeline/ctl-shortcode-block', {
    // Block Title
    title: __('Post Timeline Shortcode'),
    // Block Description
    description: __('Cool Post Timeline Shortcode Generator.'),
    // Block Category
    category: 'common',
    // Block Icon
    icon: _icons__WEBPACK_IMPORTED_MODULE_2__["default"],
    // Block Keywords
    keywords: [__('Cool Content timeline'), __('Content timeline shortcode'), __('Cool Content timeline block')],
    attributes: {
      layout: {
        type: 'string',
        default: 'default'
      },
      skin: {
        type: 'string',
        default: 'default'
      },
      postperpage: {
        type: 'string',
        default: 10
      },
      storyDateVisibility: {
        type: 'string',
        default: 'show'
      },
      dateformat: {
        type: 'string',
        default: 'F j'
      },
      customDateFormat: {
        type: 'string',
        default: ''
      },
      icons: {
        type: 'string',
        default: 'dot'
      },
      animation: {
        type: 'string',
        default: 'none'
      },
      designs: {
        type: 'string',
        default: 'design-1'
      },
      storycontent: {
        type: 'string',
        default: 'short'
      },
      compactelepos: {
        type: 'string',
        default: 'main-date'
      },
      pagination: {
        type: 'string',
        default: 'default'
      },
      hrYearLabel: {
        type: 'string',
        default: 'show'
      },
      hrNavigation: {
        type: 'string',
        default: 'hide'
      },
      hrNavigationPosition: {
        type: 'string',
        default: ''
      },
      filters: {
        type: 'string',
        default: 'no'
      },
      filtercategories: {
        type: 'string',
        default: ''
      },
      items: {
        type: 'string',
        default: ''
      },
      lineFilling: {
        type: 'string',
        default: 'false'
      },
      readMoreVisibility: {
        type: 'string',
        default: 'show'
      },
      contentLength: {
        type: 'string',
        default: 50
      },
      postMetaVisibility: {
        type: 'string',
        default: 'hide'
      },
      autoplay: {
        type: 'string',
        default: 'false'
      },
      autoplayspeed: {
        type: 'string',
        default: 3000
      },
      starton: {
        type: 'string',
        default: 0
      },
      order: {
        type: 'string',
        default: 'DESC'
      },
      // content tm specific fields
      posttype: {
        type: 'string',
        default: 'post'
      },
      taxonomy: {
        type: 'string',
        default: 'category'
      },
      postcategory: {
        type: 'string',
        default: ''
      },
      tags: {
        type: 'string',
        default: ''
      },
      isPreview: {
        type: 'boolean',
        default: false
      },
      filterSettingUsed: {
        type: 'boolean',
        default: false
      },
      metaKey: {
        type: 'string',
        default: ''
      },
      settingsMigration: {
        type: 'string',
        default: 'true'
      }
    },
    // Defining the edit interface
    edit: props => {
      const skinOptions = [{
        value: 'default',
        label: __('Default')
      }, {
        value: 'dark',
        label: __('Dark')
      }, {
        value: 'light',
        label: __('Light')
      }];
      const DfromatOptions = [{
        value: "F j",
        label: "January 1 (F j)"
      }, {
        value: "F j Y",
        label: "January 1 2019 (F j Y)"
      }, {
        value: "Y-m-d",
        label: "2019-01-01 (Y-m-d)"
      }, {
        value: "m/d/Y",
        label: "01/01/2019 (m/d/Y)"
      }, {
        value: "d/m/Y",
        label: "01/01/2019 (d/m/Y)"
      }, {
        value: "F j Y g:i A",
        label: "January 1 2019 11:10 AM (F j Y g:i A)"
      }, {
        value: "Y",
        label: " 2019(Y)"
      }, {
        label: "Custom",
        value: "custom"
      }];
      const layoutOptions = [{
        value: 'default',
        label: __('Vertical')
      }, {
        value: 'horizontal',
        label: __('Horizontal')
      }, {
        value: 'one-side',
        label: __('One Side Layout')
      }, {
        value: 'compact',
        label: __('Compact Layout')
      }];
      const animationOptions = [{
        label: "None",
        value: "none"
      }, {
        label: "fade",
        value: "fade"
      }, {
        label: "zoom-in",
        value: "zoom-in"
      }, {
        label: "flip-right",
        value: "flip-right"
      }, {
        label: "zoom-out",
        value: "zoom-out"
      }, {
        label: "fade-up",
        value: "fade-up"
      }, {
        label: "fade-down",
        value: "fade-down"
      }, {
        label: "fade-left",
        value: "fade-left"
      }, {
        label: "fade-right",
        value: "fade-right"
      }, {
        label: "fade-up-right",
        value: "fade-up-right"
      }, {
        label: "fade-up-left",
        value: "fade-up-left"
      }, {
        label: "fade-down-right",
        value: "fade-down-right"
      }, {
        label: "fade-down-left",
        value: "fade-down-left"
      }, {
        label: "flip-up",
        value: "flip-up"
      }, {
        label: "flip-down",
        value: "flip-down"
      }, {
        label: "flip-left",
        value: "flip-left"
      }, {
        label: "slide-up",
        value: "slide-up"
      }, {
        label: "slide-left",
        value: "slide-left"
      }, {
        label: "slide-right",
        value: "slide-right"
      }, {
        label: "zoom-in-up",
        value: "zoom-in-up"
      }, {
        label: "zoom-in-down",
        value: "zoom-in-down"
      }, {
        label: "slide-down",
        value: "slide-down"
      }, {
        label: "zoom-in-left",
        value: "zoom-in-left"
      }, {
        label: "zoom-in-right",
        value: "zoom-in-right"
      }, {
        label: "zoom-out-up",
        value: "zoom-out-up"
      }, {
        label: "zoom-out-down",
        value: "zoom-out-down"
      }, {
        label: "zoom-out-left",
        value: "zoom-out-left"
      }, {
        label: "zoom-out-right",
        value: "zoom-out-right"
      }];
      const timelineDesigns = [{
        label: "Default",
        value: "design-1"
      }, {
        label: "Flat Design",
        value: "design-2"
      }, {
        label: "Classic Design",
        value: "design-3"
      }, {
        label: "Elegant Design",
        value: "design-4"
      }, {
        label: "Clean Design",
        value: "design-5"
      }, {
        label: "Modern Design",
        value: "design-6"
      }, {
        label: "Minimal Design",
        value: "design-7"
      }];
      const compact_ele_pos = [{
        label: "On top date/label below title",
        value: "main-date"
      }, {
        label: "On top title below date/label",
        value: "main-title"
      }];
      const paginationOptions = [{
        label: "Off",
        value: "off"
      }, {
        label: "Ajax Load More",
        value: "ajax_load_more"
      }];
      const hrNavigationPositionOption = [{
        label: "Left",
        value: "left"
      }, {
        label: "Right",
        value: "right"
      }];
      const hrNavPostion = 'horizontal' === props.attributes.layout ? 'left' : 'right';
      if (props.attributes.filterSettingUsed == false && props.attributes.postcategory != '' && props.attributes.filtercategories == '' && props.attributes.filters == 'yes') {
        props.setAttributes({
          filtercategories: props.attributes.postcategory
        });
        props.setAttributes({
          filterSettingUsed: true
        });
      }
      undefined === props.attributes.settingsMigration || 'true' === props.attributes.settingsMigration && props.setAttributes({
        settingsMigration: 'false'
      });
  
      // Function to add conditional options to an array
      const addConditionalOptions = (options, label, value, position) => {
        if (position) {
          const newOptions = {
            label: label,
            value: value
          };
          options.splice(position, 0, newOptions);
        } else {
          const newOptions = {
            label: label,
            value: value
          };
          options.push(newOptions);
        }
      };
  
      // Logic for updating options based on layout
      if ('horizontal' === props.attributes.layout) {
        const updateOptions = [{
          object: timelineDesigns,
          label: 'Simple Design',
          value: 'design-8',
          position: 0
        }, {
          object: hrNavigationPositionOption,
          label: 'Center',
          value: 'center',
          position: 0
        }];
  
        // Iterate through updateOptions and call addConditionalOptions
        updateOptions.forEach(ele => {
          addConditionalOptions(ele.object, ele.label, ele.value, ele.position);
        });
      } else {
        const updateOptions = [{
          object: hrNavigationPositionOption,
          label: 'Bottom',
          value: 'bottom',
          position: 0
        }, {
          object: paginationOptions,
          label: 'Default',
          value: 'default',
          position: 1
        }];
  
        // Iterate through updateOptions and call addConditionalOptions
        updateOptions.forEach(ele => {
          addConditionalOptions(ele.object, ele.label, ele.value, ele.position);
        });
      }
      const general_settings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
        title: __('Post Timeline General Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Layouts'),
        options: layoutOptions,
        value: props.attributes.layout,
        onChange: value => props.setAttributes({
          layout: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Designs'),
        options: timelineDesigns,
        value: props.attributes.designs,
        onChange: value => props.setAttributes({
          designs: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Skin'),
        options: skinOptions,
        value: props.attributes.skin,
        onChange: value => props.setAttributes({
          skin: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Content Post Type'),
        value: props.attributes.posttype,
        onChange: value => props.setAttributes({
          posttype: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Don't Change This If You Are Creating Blog Posts Timeline or Define Content Type Of Your Timeline Like:- Posts"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Taxonomy Name'),
        value: props.attributes.taxonomy,
        onChange: value => props.setAttributes({
          taxonomy: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Don't Change This If You Are Creating Blog Posts Timeline or Define Content Type Taxonomy."), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Specific category(s) (Add category(s) slug - comma separated)'),
        value: props.attributes.postcategory,
        onChange: value => props.setAttributes({
          postcategory: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Show Category Specific Blog Posts. Like For cooltimeline.com/category/fb-history/ it will be fb-history"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Specific tags(add tags slug)'),
        value: props.attributes.tags,
        onChange: value => props.setAttributes({
          tags: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Show Tag Specific Blog Posts. Like For cooltimeline.com/tag/fb-history/ it will be fb-history."), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Description?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storycontent: 'short'
          });
        },
        className: props.attributes.storycontent == 'short' ? 'active' : '',
        isSmall: true
      }, "Short"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storycontent: 'full'
          });
        },
        className: props.attributes.storycontent == 'full' ? 'active' : '',
        isSmall: true
      }, "Full")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
        label: "Posts Per Page",
        value: parseInt(props.attributes.postperpage),
        onChange: value => props.setAttributes({
          postperpage: value.toString()
        }),
        min: 1,
        max: 50,
        step: 1
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "You Can Show Pagination After These Posts In Vertical Timeline."), props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
        label: "Slide To Show?",
        value: props.attributes.items != '' ? parseInt(props.attributes.items) : 0,
        onChange: value => value == 0 ? props.setAttributes({
          items: ''
        }) : props.setAttributes({
          items: value.toString()
        }),
        min: 0,
        max: 10,
        step: 1
      }));
      const advanced_settings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
        title: __('Post Timeline Advanced Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Order?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            order: 'ASC'
          });
        },
        className: props.attributes.order == 'ASC' ? 'active' : '',
        isSmall: true
      }, "ASC"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            order: 'DESC'
          });
        },
        className: props.attributes.order == 'DESC' ? 'active' : '',
        isSmall: true
      }, "DESC")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "For Ex :- ", props.attributes.order == 'ASC' ? 'ASC(1900-2017)' : 'DESC(2017-1900)'), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Date?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storyDateVisibility: 'show'
          });
        },
        className: props.attributes.storyDateVisibility == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storyDateVisibility: 'hide'
          });
        },
        className: props.attributes.storyDateVisibility == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide")), 'show' === props.attributes.storyDateVisibility && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Date Formats'),
        description: __('yes/no'),
        options: DfromatOptions,
        value: props.attributes.dateformat,
        onChange: value => props.setAttributes({
          dateformat: value
        })
      }), 'custom' === props.attributes.dateformat && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Custom Date Format'),
        value: props.attributes.customDateFormat,
        onChange: value => props.setAttributes({
          customDateFormat: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Stories date formats e.g D,M,Y ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ExternalLink, {
        href: "https://www.php.net/manual/en/function.date.php"
      }, "Click here to view more")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Display Icons (By default Is Dot)")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'icon'
          });
        },
        className: props.attributes.icons == 'icon' ? 'active' : '',
        isSmall: true
      }, "Icons"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'dot'
          });
        },
        className: props.attributes.icons == 'dot' ? 'active' : '',
        isSmall: true
      }, "Dot"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'none'
          });
        },
        className: props.attributes.icons == 'none' ? 'active' : '',
        isSmall: true
      }, "None")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Pagination Settings'),
        options: paginationOptions,
        value: props.attributes.pagination,
        onChange: value => props.setAttributes({
          pagination: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Show Category Filters")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            filters: 'yes'
          });
        },
        className: props.attributes.filters == 'yes' ? 'active' : '',
        isSmall: true
      }, "Yes"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            filters: 'no'
          });
        },
        className: props.attributes.filters == 'no' ? 'active' : '',
        isSmall: true
      }, "No")), props.attributes.filters == 'yes' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Note:-Please add value in Taxonomy field before using it."), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Add categories slug for filters eg(stories,our-history)'),
        value: props.attributes.filtercategories,
        onChange: value => props.setAttributes({
          filtercategories: value
        })
      }))), "compact" !== props.attributes.layout && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Year Label Setting")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrYearLabel: 'show'
          });
        },
        className: props.attributes.hrYearLabel == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrYearLabel: 'hide'
          });
        },
        className: props.attributes.hrYearLabel == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide"))), (props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Year Navigation Setting")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrNavigation: 'show'
          });
        },
        className: props.attributes.hrNavigation == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrNavigation: 'hide'
          });
        },
        className: props.attributes.hrNavigation == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide"))), (props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && props.attributes.hrNavigation == "show" && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Year Navigation Position'),
        options: hrNavigationPositionOption,
        value: props.attributes.hrNavigationPosition === '' ? hrNavPostion : props.attributes.hrNavigationPosition,
        onChange: value => props.setAttributes({
          hrNavigationPosition: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Line Filling Settings?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            lineFilling: 'true'
          });
        },
        className: props.attributes.lineFilling == 'true' ? 'active' : '',
        isSmall: true
      }, "True"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            lineFilling: 'false'
          });
        },
        className: props.attributes.lineFilling == 'false' ? 'active' : '',
        isSmall: true
      }, "False")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Display read more?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            readMoreVisibility: 'show'
          });
        },
        className: props.attributes.readMoreVisibility == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            readMoreVisibility: 'hide'
          });
        },
        className: props.attributes.readMoreVisibility == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide")), 'full' !== props.attributes.storycontent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Content Length'),
        value: props.attributes.contentLength,
        onChange: value => props.setAttributes({
          contentLength: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Display Post Meta?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            postMetaVisibility: 'show'
          });
        },
        className: props.attributes.postMetaVisibility == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            postMetaVisibility: 'hide'
          });
        },
        className: props.attributes.postMetaVisibility == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Meta Key'),
        value: props.attributes.metaKey,
        onChange: value => props.setAttributes({
          metaKey: value
        })
      }), props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Autoplay Settings?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            autoplay: 'true'
          });
        },
        className: props.attributes.autoplay == 'true' ? 'active' : '',
        isSmall: true
      }, "True"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            autoplay: 'false'
          });
        },
        className: props.attributes.autoplay == 'false' ? 'active' : '',
        isSmall: true
      }, "False")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Slideshow Speed ?'),
        value: props.attributes.autoplayspeed,
        onChange: value => props.setAttributes({
          autoplayspeed: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Timeline Starting from Story e.g(2)'),
        value: props.attributes.starton,
        onChange: value => props.setAttributes({
          starton: value
        })
      })), props.attributes.layout != "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Animation'),
        description: __('yes/no'),
        options: animationOptions,
        value: props.attributes.animation,
        onChange: value => props.setAttributes({
          animation: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Add Animations Effect Inside Timeline. You Can Check Effects Demo From ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
        target: "_blank",
        href: "http://michalsnik.github.io/aos/"
      }, "AOS"), "."), props.attributes.layout == "compact" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Compact Layout Date&Title positon'),
        description: __('yes/no'),
        options: compact_ele_pos,
        value: props.attributes.compactelepos,
        onChange: value => props.setAttributes({
          compactelepos: value
        })
      })));
      return [!!props.isSelected && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
        key: "inspector"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TabPanel, {
        className: "ctl_shortcode-tab-settings",
        activeClass: "active-tab",
        tabs: [{
          name: 'general_settings',
          title: 'General',
          className: 'ctl-settings_tab-one',
          content: general_settings
        }, {
          name: 'advanced_settings',
          title: 'Advanced',
          className: 'ctl-settings_tab-two',
          content: advanced_settings
        }]
      }, tab => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Card, null, tab.content))), props.attributes.isPreview ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: _images_timeline_png__WEBPACK_IMPORTED_MODULE_4__
      }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: props.className
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_layout_type__WEBPACK_IMPORTED_MODULE_3__["default"], {
        type: "contenttm",
        LayoutImgPath: LayoutImgPath,
        attributes: props.attributes
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-shortcode"
      }, props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, "[cool-content-timeline post-type=\"", props.attributes.posttype, "\" post-category=\"", props.attributes.postcategory, "\" taxonomy=\"", props.attributes.taxonomy, "\" tags=\"", props.attributes.tags, "\" layout=\"", props.attributes.layout, "\" designs=\"", props.attributes.designs, "\" skin=\"", props.attributes.skin, "\" show-posts=\"", props.attributes.postperpage, "\" story-date=\"", props.attributes.storyDateVisibility, "\" date-format=\"", props.attributes.dateformat, "\" custom-date-format=\"", props.attributes.customDateFormat, "\" icons=\"", props.attributes.icons, "\" story-content=\"", props.attributes.storycontent, "\" items=\"", props.attributes.items, "\" pagination=\"", props.attributes.pagination, "\" filters=\"", props.attributes.filters, "\" filter-categories=\"", props.attributes.filtercategories, "\" start-on=\"", props.attributes.starton, "\" line-filling=\"", props.attributes.lineFilling, "\" read-more=\"", props.attributes.readMoreVisibility, "\" content-length=\"", props.attributes.contentLength, "\" post-meta=\"", props.attributes.postMetaVisibility, "\" meta-key=\"", props.attributes.metaKey, "\" autoplay=\"", props.attributes.autoplay, "\" autoplay-speed=\"", props.attributes.autoplayspeed, "\" order=\"", props.attributes.order, "\"]"), props.attributes.layout != "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, "[cool-content-timeline post-type=\"", props.attributes.posttype, "\" post-category=\"", props.attributes.postcategory, "\" taxonomy=\"", props.attributes.taxonomy, "\" tags=\"", props.attributes.tags, "\" layout=\"", props.attributes.layout, "\" designs=\"", props.attributes.designs, "\" skin=\"", props.attributes.skin, "\" show-posts=\"", props.attributes.postperpage, "\" story-date=\"", props.attributes.storyDateVisibility, "\" date-format=\"", props.attributes.dateformat, "\" custom-date-format=\"", props.attributes.customDateFormat, "icons=\"", props.attributes.icons, "\" animation=\"", props.attributes.animation, "\" story-content=\"", props.attributes.storycontent, "\" compact-ele-pos=\"", props.attributes.compactelepos, "\" pagination=\"", props.attributes.pagination, "\" filters=\"", props.attributes.filters, "\" filter-categories=\"", props.attributes.filtercategories, "\" line-filling=\"", props.attributes.lineFilling, "\" read-more=\"", props.attributes.readMoreVisibility, "\" content-length=\"", props.attributes.contentLength, "\" post-meta=\"", props.attributes.postMetaVisibility, "\" meta-key=\"", props.attributes.metaKey, "\" order=\"", props.attributes.order, "\"]")))];
    },
    // Defining the front-end interface
    save() {
      // Rendering in PHP
      return null;
    },
    example: {
      attributes: {
        isPreview: true
      }
    }
  }));
  
  /***/ }),
  
  /***/ "./src/icons.js":
  /*!**********************!*\
    !*** ./src/icons.js ***!
    \**********************/
  /***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
  
  __webpack_require__.r(__webpack_exports__);
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
  
  const CtlIcon = () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "100%",
    height: "100%",
    viewBox: "0 0 62 62",
    version: "1.1",
    xmlns: "http://www.w3.org/2000/svg",
    xmlnsXlink: "http://www.w3.org/1999/xlink",
    xmlSpace: "preserve",
    xmlnsserif: "http://www.serif.com/",
    style: {
      fillRule: "evenodd",
      clipRule: "evenodd",
      strokeLinecap: "round",
      strokeLinejoin: "round",
      strokeMiterlimit: 1.5
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    id: "icon-only",
    serifid: "icon only"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    id: "icon-only1",
    serifid: "icon-only"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    id: "icon"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    x: "29.146",
    y: "-0.042",
    width: "3.149",
    height: "61.44"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M18.433,21.461l-0.007,-4.311l5.77,-4.905l-5.766,-4.923l0.003,-4.293l-18.433,-0l-0,18.432l18.433,0",
    style: {
      fill: "#f12945"
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("circle", {
    cx: "30.72",
    cy: "12.245",
    r: "3.046",
    style: {
      fill: "#fff",
      stroke: "#000",
      strokeWidth: 2.18 + "px"
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M43.007,21.461l0.007,4.312l-5.77,4.905l5.766,4.922l-0.003,4.294l18.433,-0l0,-18.433l-18.433,0",
    style: {
      fill: "#01c5bd"
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("circle", {
    cx: "30.72",
    cy: "30.678",
    r: "3.046",
    style: {
      fill: "#fff",
      stroke: "#000",
      strokeWidth: 2.18 + "px"
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M18.433,58.326l-0.007,-4.311l5.77,-4.905l-5.766,-4.923l0.003,-4.293l-18.433,-0l-0,18.432l18.433,0",
    style: {
      fill: "#f12945"
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("circle", {
    cx: "30.72",
    cy: "49.11",
    r: "3.046",
    style: {
      fill: "#fff",
      stroke: "#000",
      strokeWidth: 2.18 + "px"
    }
  })))));
  /* harmony default export */ __webpack_exports__["default"] = (CtlIcon);
  
  /***/ }),
  
  /***/ "./src/index.js":
  /*!**********************!*\
    !*** ./src/index.js ***!
    \**********************/
  /***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
  
  __webpack_require__.r(__webpack_exports__);
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
  /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
  /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
  /* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./icons */ "./src/icons.js");
  /* harmony import */ var _layout_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./layout-type */ "./src/layout-type.js");
  /* harmony import */ var _images_timeline_png__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./images/timeline.png */ "./src/images/timeline.png");
  /* harmony import */ var _content_tm_block__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./content-tm-block */ "./src/content-tm-block.js");
  /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
  
  /**
   * Block dependencies
   */
  
  
  
  
  
  
  
  /**
   * Internal block libraries
   */
  const {
    __
  } = wp.i18n;
  const {
    registerBlockType
  } = wp.blocks;
  const baseURL = ctlUrl.CTP_PLUGIN_URL;
  const wpBaseURL = ctlUrl.baseURL;
  const LayoutImgPath = baseURL + '/includes/gutenberg-block/layout-images';
  const {
    apiFetch
  } = wp;
  const {
    RichText,
    InspectorControls,
    BlockControls
  } = wp.editor;
  const {
    Fragment
  } = wp.element;
  const {
    PanelBody,
    PanelRow,
    TextareaControl,
    TextControl,
    Dashicon,
    Toolbar,
    ButtonGroup,
    Button,
    SelectControl,
    Tooltip,
    RangeControl,
    TabPanel,
    Card,
    CardBody,
    FormTokenField,
    ExternalLink
  } = wp.components;
  var ctlCategories = [];
  var ctlfilterCategories = [];
  //http://localhost/wp-test/wp-json/cooltimeline/v1/categories
  const allPosts = wp.apiFetch({
    path: '/cooltimeline/v1/categories'
  }).then(posts => {
    ctlCategories.push({
      label: "Select a Category",
      value: ''
    });
    if (posts.categories !== undefined) {
      for (var key in posts.categories) {
        ctlCategories.push({
          label: posts.categories[key],
          value: key
        });
        ctlfilterCategories.push(posts.categories[key]);
      }
      return ctlCategories;
    }
  });
  /**
   * Register block
  
   */
  /* harmony default export */ __webpack_exports__["default"] = (registerBlockType('cool-timleine/shortcode-block', {
    // Block Title
    title: __('Story Timeline Shortcode'),
    // Block Description
    description: __('Cool Timeline Shortcode Generator.'),
    // Block Category
    category: 'common',
    // Block Icon
    icon: _icons__WEBPACK_IMPORTED_MODULE_2__["default"],
    // Block Keywords
    keywords: [__('cool timeline'), __('timeline shortcode'), __('cool timeline block')],
    attributes: {
      layout: {
        type: 'string',
        default: 'default'
      },
      skin: {
        type: 'string',
        default: 'default'
      },
      postperpage: {
        type: 'string',
        default: 10
      },
      storyDateVisibility: {
        type: 'string',
        default: 'show'
      },
      dateformat: {
        type: 'string',
        default: 'F j'
      },
      customDateFormat: {
        type: 'string',
        default: ''
      },
      icons: {
        type: 'string',
        default: 'dot'
      },
      animation: {
        type: 'string',
        default: 'none'
      },
      designs: {
        type: 'string',
        default: 'design-1'
      },
      storycontent: {
        type: 'string',
        default: 'short'
      },
      category: {
        type: 'string',
        default: ''
      },
      based: {
        type: 'string',
        default: 'default'
      },
      compactelepos: {
        type: 'string',
        default: 'main-date'
      },
      pagination: {
        type: 'string',
        default: 'default'
      },
      hrYearLabel: {
        type: 'string',
        default: 'show'
      },
      hrNavigation: {
        type: 'string',
        default: 'hide'
      },
      hrNavigationPosition: {
        type: 'string',
        default: ''
      },
      filters: {
        type: 'string',
        default: 'no'
      },
      filtercategories: {
        type: 'string',
        default: ''
      },
      items: {
        type: 'string',
        default: ''
      },
      lineFilling: {
        type: 'string',
        default: 'false'
      },
      readMoreVisibility: {
        type: 'string',
        default: 'show'
      },
      contentLength: {
        type: 'string',
        default: 50
      },
      autoplay: {
        type: 'string',
        default: 'false'
      },
      autoplayspeed: {
        type: 'string',
        default: 3000
      },
      starton: {
        type: 'string',
        default: 0
      },
      order: {
        type: 'string',
        default: 'DESC'
      },
      isPreview: {
        type: 'boolean',
        default: false
      },
      filterCategoriesOption: {
        type: 'array',
        default: []
      },
      filterSettingUsed: {
        type: 'boolean',
        default: false
      },
      settingsMigration: {
        type: 'string',
        default: 'true'
      },
      timelineTitle: {
        type: 'string',
        default: ''
      }
    },
    // Defining the edit interface
    edit: props => {
      const skinOptions = [{
        value: 'default',
        label: __('Default')
      }, {
        value: 'dark',
        label: __('Dark')
      }, {
        value: 'light',
        label: __('Light')
      }];
      const DfromatOptions = [{
        value: "F j",
        label: "January 1 (F j)"
      }, {
        value: "F j Y",
        label: "January 1 2019 (F j Y)"
      }, {
        value: "Y-m-d",
        label: "2019-01-01 (Y-m-d)"
      }, {
        value: "m/d/Y",
        label: "01/01/2019 (m/d/Y)"
      }, {
        value: "d/m/Y",
        label: "01/01/2019 (d/m/Y)"
      }, {
        value: "F j Y g:i A",
        label: "January 1 2019 11:10 AM (F j Y g:i A)"
      }, {
        value: "Y",
        label: " 2019(Y)"
      }, {
        label: "Custom",
        value: "custom"
      }];
      const layoutOptions = [{
        value: 'default',
        label: __('Vertical')
      }, {
        value: 'horizontal',
        label: __('Horizontal')
      }, {
        value: 'one-side',
        label: __('One Side Layout')
      }, {
        value: 'compact',
        label: __('Compact Layout')
      }];
      const animationOptions = [{
        label: "None",
        value: "none"
      }, {
        label: "fade",
        value: "fade"
      }, {
        label: "zoom-in",
        value: "zoom-in"
      }, {
        label: "flip-right",
        value: "flip-right"
      }, {
        label: "zoom-out",
        value: "zoom-out"
      }, {
        label: "fade-up",
        value: "fade-up"
      }, {
        label: "fade-down",
        value: "fade-down"
      }, {
        label: "fade-left",
        value: "fade-left"
      }, {
        label: "fade-right",
        value: "fade-right"
      }, {
        label: "fade-up-right",
        value: "fade-up-right"
      }, {
        label: "fade-up-left",
        value: "fade-up-left"
      }, {
        label: "fade-down-right",
        value: "fade-down-right"
      }, {
        label: "fade-down-left",
        value: "fade-down-left"
      }, {
        label: "flip-up",
        value: "flip-up"
      }, {
        label: "flip-down",
        value: "flip-down"
      }, {
        label: "flip-left",
        value: "flip-left"
      }, {
        label: "slide-up",
        value: "slide-up"
      }, {
        label: "slide-left",
        value: "slide-left"
      }, {
        label: "slide-right",
        value: "slide-right"
      }, {
        label: "zoom-in-up",
        value: "zoom-in-up"
      }, {
        label: "zoom-in-down",
        value: "zoom-in-down"
      }, {
        label: "slide-down",
        value: "slide-down"
      }, {
        label: "zoom-in-left",
        value: "zoom-in-left"
      }, {
        label: "zoom-in-right",
        value: "zoom-in-right"
      }, {
        label: "zoom-out-up",
        value: "zoom-out-up"
      }, {
        label: "zoom-out-down",
        value: "zoom-out-down"
      }, {
        label: "zoom-out-left",
        value: "zoom-out-left"
      }, {
        label: "zoom-out-right",
        value: "zoom-out-right"
      }];
      const timelineDesigns = [{
        label: "Default",
        value: "design-1"
      }, {
        label: "Flat Design",
        value: "design-2"
      }, {
        label: "Classic Design",
        value: "design-3"
      }, {
        label: "Elegant Design",
        value: "design-4"
      }, {
        label: "Clean Design",
        value: "design-5"
      }, {
        label: "Modern Design",
        value: "design-6"
      }, {
        label: "Minimal Design",
        value: "design-7"
      }];
      const compact_ele_pos = [{
        label: "On top date/label below title",
        value: "main-date"
      }, {
        label: "On top title below date/label",
        value: "main-title"
      }];
      const timeline_based_on = [{
        label: "Default(Date Based)",
        value: "default"
      }, {
        label: "Custom Order",
        value: "custom"
      }];
      const paginationOptions = [{
        label: "Off",
        value: "off"
      }, {
        label: "Ajax Load More",
        value: "ajax_load_more"
      }];
      const hrNavigationPositionOption = [{
        label: "Left",
        value: "left"
      }, {
        label: "Right",
        value: "right"
      }];
      const hrNavPostion = 'horizontal' === props.attributes.layout ? 'left' : 'right';
      const categoriesFilterUpdate = e => {
        props.setAttributes({
          filterCategoriesOption: e
        });
        const allCategoryList = ctlCategories.map(values => {
          if (e.includes(values.label)) {
            return values.value;
          }
        });
        const categoriesFilter = allCategoryList.filter(values => {
          return values !== undefined;
        });
        props.setAttributes({
          filtercategories: categoriesFilter.toString()
        });
      };
      if (props.attributes.filterSettingUsed == false && props.attributes.category != '' && props.attributes.filtercategories == '' && props.attributes.filters == 'yes') {
        const selectedCat = ctlCategories.filter(value => {
          return value['value'] == props.attributes.category;
        });
        props.setAttributes({
          filterCategoriesOption: [selectedCat[0]['label']]
        });
        props.setAttributes({
          filtercategories: props.attributes.category
        });
        props.setAttributes({
          filterSettingUsed: true
        });
      }
      undefined === props.attributes.settingsMigration || 'true' === props.attributes.settingsMigration && props.setAttributes({
        settingsMigration: 'false'
      });
  
      // Function to add conditional options to an array
      const addConditionalOptions = (options, label, value, position) => {
        if (position) {
          const newOptions = {
            label: label,
            value: value
          };
          options.splice(position, 0, newOptions);
        } else {
          const newOptions = {
            label: label,
            value: value
          };
          options.push(newOptions);
        }
      };
  
      // Logic for updating options based on layout
      if ('horizontal' === props.attributes.layout) {
        const updateOptions = [{
          object: timelineDesigns,
          label: 'Simple Design',
          value: 'design-8',
          position: 0
        }, {
          object: hrNavigationPositionOption,
          label: 'Center',
          value: 'center',
          position: 0
        }];
  
        // Iterate through updateOptions and call addConditionalOptions
        updateOptions.forEach(ele => {
          addConditionalOptions(ele.object, ele.label, ele.value, ele.position);
        });
      } else {
        const updateOptions = [{
          object: hrNavigationPositionOption,
          label: 'Bottom',
          value: 'bottom',
          position: 0
        }, {
          object: paginationOptions,
          label: 'Default',
          value: 'default',
          position: 1
        }];
  
        // Iterate through updateOptions and call addConditionalOptions
        updateOptions.forEach(ele => {
          addConditionalOptions(ele.object, ele.label, ele.value, ele.position);
        });
      }
      const general_settings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
        title: __('Timeline General Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Layouts'),
        options: layoutOptions,
        value: props.attributes.layout,
        onChange: value => props.setAttributes({
          layout: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Designs'),
        options: timelineDesigns,
        value: props.attributes.designs,
        onChange: value => props.setAttributes({
          designs: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Select Skin'),
        options: skinOptions,
        value: props.attributes.skin,
        onChange: value => props.setAttributes({
          skin: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Categories'),
        options: ctlCategories,
        value: props.attributes.category,
        onChange: value => props.setAttributes({
          category: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Create Category Specific Timeline (By Default - All Categories)"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Timeline Based On'),
        options: timeline_based_on,
        value: props.attributes.based,
        onChange: value => props.setAttributes({
          based: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Show either date or custom label/text along with timeline stories."), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Description?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storycontent: 'short'
          });
        },
        className: props.attributes.storycontent == 'short' ? 'active' : '',
        isSmall: true
      }, "Short"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storycontent: 'full'
          });
        },
        className: props.attributes.storycontent == 'full' ? 'active' : '',
        isSmall: true
      }, "Full")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
        label: "Stories Per Page",
        value: parseInt(props.attributes.postperpage),
        onChange: value => props.setAttributes({
          postperpage: value.toString()
        }),
        min: 1,
        max: 50,
        step: 1
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, props.attributes.layout != "horizontal" && 'You Can Show Pagination After These Posts In Vertical Timeline.'), props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
        label: "Slide To Show?",
        value: props.attributes.items != '' ? parseInt(props.attributes.items) : 0,
        onChange: value => value == 0 ? props.setAttributes({
          items: ''
        }) : props.setAttributes({
          items: value.toString()
        }),
        min: 0,
        max: 10,
        step: 1
      })));
      const advanced_settings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
        title: __('Timeline Advanced Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Order?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            order: 'ASC'
          });
        },
        className: props.attributes.order == 'ASC' ? 'active' : '',
        isSmall: true
      }, "ASC"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            order: 'DESC'
          });
        },
        className: props.attributes.order == 'DESC' ? 'active' : '',
        isSmall: true
      }, "DESC")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "For Ex :- ", props.attributes.order == 'ASC' ? 'ASC(1900-2017)' : 'DESC(2017-1900)'), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Stories Date?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storyDateVisibility: 'show'
          });
        },
        className: props.attributes.storyDateVisibility == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            storyDateVisibility: 'hide'
          });
        },
        className: props.attributes.storyDateVisibility == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide")), 'show' === props.attributes.storyDateVisibility && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Date Formats'),
        description: __('yes/no'),
        options: DfromatOptions,
        value: props.attributes.dateformat,
        onChange: value => props.setAttributes({
          dateformat: value
        })
      }), 'custom' === props.attributes.dateformat && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Custom Date Format'),
        value: props.attributes.customDateFormat,
        onChange: value => props.setAttributes({
          customDateFormat: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Stories date formats e.g D,M,Y ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ExternalLink, {
        href: "https://www.php.net/manual/en/function.date.php"
      }, "Click here to view more")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Display Icons (By default Is Dot)")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'icon'
          });
        },
        className: props.attributes.icons == 'icon' ? 'active' : '',
        isSmall: true
      }, "Icons"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'dot'
          });
        },
        className: props.attributes.icons == 'dot' ? 'active' : '',
        isSmall: true
      }, "Dot"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            icons: 'none'
          });
        },
        className: props.attributes.icons == 'none' ? 'active' : '',
        isSmall: true
      }, "None")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Pagination Settings'),
        options: paginationOptions,
        value: props.attributes.pagination,
        onChange: value => props.setAttributes({
          pagination: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Show Category Filters")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            filters: 'yes'
          });
        },
        className: props.attributes.filters == 'yes' ? 'active' : '',
        isSmall: true
      }, "Yes"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            filters: 'no'
          });
        },
        className: props.attributes.filters == 'no' ? 'active' : '',
        isSmall: true
      }, "No"))), props.attributes.filters == 'yes' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(FormTokenField, {
        label: __('Select filter category'),
        value: props.attributes.filterCategoriesOption,
        suggestions: ctlfilterCategories,
        onChange: value => {
          categoriesFilterUpdate(value);
        },
        placeholder: 'All',
        __experimentalExpandOnFocus: true,
        __experimentalShowHowTo: false
      }), "compact" !== props.attributes.layout && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Year Label Setting")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrYearLabel: 'show'
          });
        },
        className: props.attributes.hrYearLabel == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrYearLabel: 'hide'
          });
        },
        className: props.attributes.hrYearLabel == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide"))), (props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Year Navigation Setting")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrNavigation: 'show'
          });
        },
        className: props.attributes.hrNavigation == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            hrNavigation: 'hide'
          });
        },
        className: props.attributes.hrNavigation == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide"))), (props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && props.attributes.hrNavigation == "show" && 'custom' !== props.attributes.based && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Year Navigation Position'),
        options: hrNavigationPositionOption,
        value: props.attributes.hrNavigationPosition === '' ? hrNavPostion : props.attributes.hrNavigationPosition,
        onChange: value => props.setAttributes({
          hrNavigationPosition: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Line Filling Settings?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            lineFilling: 'true'
          });
        },
        className: props.attributes.lineFilling == 'true' ? 'active' : '',
        isSmall: true
      }, "True"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            lineFilling: 'false'
          });
        },
        className: props.attributes.lineFilling == 'false' ? 'active' : '',
        isSmall: true
      }, "False")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Display read more?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            readMoreVisibility: 'show'
          });
        },
        className: props.attributes.readMoreVisibility == 'show' ? 'active' : '',
        isSmall: true
      }, "Show"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            readMoreVisibility: 'hide'
          });
        },
        className: props.attributes.readMoreVisibility == 'hide' ? 'active' : '',
        isSmall: true
      }, "Hide")), 'full' !== props.attributes.storycontent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Content Length'),
        value: props.attributes.contentLength,
        onChange: value => props.setAttributes({
          contentLength: value
        })
      }), props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl_shortcode-button-group_label"
      }, __("Autoplay Settings?")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, {
        className: "ctl_shortcode-button-group"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            autoplay: 'true'
          });
        },
        className: props.attributes.autoplay == 'true' ? 'active' : '',
        isSmall: true
      }, "True"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
        onClick: e => {
          props.setAttributes({
            autoplay: 'false'
          });
        },
        className: props.attributes.autoplay == 'false' ? 'active' : '',
        isSmall: true
      }, "False")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Slideshow Speed ?'),
        value: props.attributes.autoplayspeed,
        onChange: value => props.setAttributes({
          autoplayspeed: value
        })
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Timeline Starting from Story e.g(2)'),
        value: props.attributes.starton,
        onChange: value => props.setAttributes({
          starton: value
        })
      })), props.attributes.layout != "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Animation'),
        description: __('yes/no'),
        options: animationOptions,
        value: props.attributes.animation,
        onChange: value => props.setAttributes({
          animation: value
        })
      }), props.attributes.layout == "compact" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
        label: __('Compact Layout Date&Title positon'),
        description: __('yes/no'),
        options: compact_ele_pos,
        value: props.attributes.compactelepos,
        onChange: value => props.setAttributes({
          compactelepos: value
        })
      })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
        label: __('Timeline Title'),
        value: props.attributes.timelineTitle,
        onChange: value => props.setAttributes({
          timelineTitle: value
        })
      })));
      return [!!props.isSelected && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
        key: "inspector"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TabPanel, {
        className: "ctl_shortcode-tab-settings",
        activeClass: "active-tab",
        tabs: [{
          name: 'general_settings',
          title: 'General',
          className: 'ctl-settings_tab-one',
          content: general_settings
        }, {
          name: 'advanced_settings',
          title: 'Advanced',
          className: 'ctl-settings_tab-two',
          content: advanced_settings
        }]
      }, tab => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Card, null, tab.content))), props.attributes.isPreview ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: _images_timeline_png__WEBPACK_IMPORTED_MODULE_4__
      }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: props.className
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_layout_type__WEBPACK_IMPORTED_MODULE_3__["default"], {
        type: "storytm",
        LayoutImgPath: LayoutImgPath,
        attributes: props.attributes
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-shortcode"
      }, props.attributes.layout == "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, "[cool-timeline category=\"", props.attributes.category, "\" layout=\"", props.attributes.layout, "\" designs=\"", props.attributes.designs, "\" skin=\"", props.attributes.skin, "\" show-posts=\"", props.attributes.postperpage, "\" story-date=\"", props.attributes.storyDateVisibility, "\" date-format=\"", props.attributes.dateformat, "\" custom-date-format=\"", props.attributes.customDateFormat, "\" icons=\"", props.attributes.icons, "\" story-content=\"", props.attributes.storycontent, "\" based=\"", props.attributes.based, "\" items=\"", props.attributes.items, "\" pagination=\"", props.attributes.pagination, "\" year-label=\"", props.attributes.hrYearLabel, "\" year-navigation=\"", props.attributes.hrNavigation, "\" navigation-position=\"", props.attributes.hrNavigationPosition, "\" filters=\"", props.attributes.filters, "\" filter-categories=\"", props.attributes.filtercategories, "\" start-on=\"", props.attributes.starton, "\" line-filling=\"", props.attributes.lineFilling, "\" read-more=\"", props.attributes.readMoreVisibility, "\" content-length=\"", props.attributes.contentLength, "\" autoplay=\"", props.attributes.autoplay, "\" autoplay-speed=\"", props.attributes.autoplayspeed, "\" order=\"", props.attributes.order, "\"]"), props.attributes.layout != "horizontal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, "[cool-timeline category=\"", props.attributes.category, "\" layout=\"", props.attributes.layout, "\" designs=\"", props.attributes.designs, "\" skin=\"", props.attributes.skin, "\" show-posts=\"", props.attributes.postperpage, "\" story-date=\"", props.attributes.storyDateVisibility, "\" date-format=\"", props.attributes.dateformat, "\" custom-date-format=\"", props.attributes.customDateFormat, "\" icons=\"", props.attributes.icons, "\" animation=\"", props.attributes.animation, "\" story-content=\"", props.attributes.storycontent, "\" based=\"", props.attributes.based, "\" compact-ele-pos=\"", props.attributes.compactelepos, "\" pagination=\"", props.attributes.pagination, "\" year-label=\"", props.attributes.hrYearLabel, "\" year-navigation=\"", props.attributes.hrNavigation, "\" navigation-position=\"", props.attributes.hrNavigationPosition, "\" filters=\"", props.attributes.filters, "\" filter-categories=\"", props.attributes.filtercategories, "\" line-filling=\"", props.attributes.lineFilling, "\" read-more=\"", props.attributes.readMoreVisibility, "\" content-length=\"", props.attributes.contentLength, "\" order=\"", props.attributes.order, "\" timeline-title=\"", props.attributes.timelineTitle, "\"]")))];
    },
    // Defining the front-end interface
    save() {
      // Rendering in PHP
      return null;
    },
    example: {
      attributes: {
        isPreview: true
      }
    }
  }));
  
  /***/ }),
  
  /***/ "./src/layout-type.js":
  /*!****************************!*\
    !*** ./src/layout-type.js ***!
    \****************************/
  /***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
  
  __webpack_require__.r(__webpack_exports__);
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
  /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
  /* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./icons */ "./src/icons.js");
  
  
  const CtlLayoutType = props => {
    let heading = '';
    if (!props.attributes.layout) {
      return null;
    }
    if (props.type == 'contenttm') {
      heading = 'Post Timeline Shortcode';
    } else {
      heading = 'Story Timeline Shortcode';
    }
    if (props.attributes.layout == "horizontal") {
      const horizontal_img = props.LayoutImgPath + "/cool-horizontal-timeline.jpg";
      const divStyle = {
        color: 'white',
        backgroundImage: 'url(' + horizontal_img + ')',
        height: '300px',
        width: '100%'
      };
      // return <div style={divStyle} className="ctl-block-image">
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-image"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-icon"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_icons__WEBPACK_IMPORTED_MODULE_1__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, heading));
    } else {
      const vertical_img = props.LayoutImgPath + "/cool-vertical-timeline.jpg";
      const divStylev = {
        color: 'white',
        backgroundImage: 'url(' + vertical_img + ')',
        height: '300px',
        width: '100%'
      };
      // return <div style={divStylev} className="ctl-block-image">
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-image"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "ctl-block-icon"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_icons__WEBPACK_IMPORTED_MODULE_1__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, heading));
    }
  };
  /* harmony default export */ __webpack_exports__["default"] = (CtlLayoutType);
  
  /***/ }),
  
  /***/ "./src/style.scss":
  /*!************************!*\
    !*** ./src/style.scss ***!
    \************************/
  /***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
  
  __webpack_require__.r(__webpack_exports__);
  // extracted by mini-css-extract-plugin
  
  
  /***/ }),
  
  /***/ "./src/images/timeline.png":
  /*!*********************************!*\
    !*** ./src/images/timeline.png ***!
    \*********************************/
  /***/ (function(module, __unused_webpack_exports, __webpack_require__) {
  
  module.exports = __webpack_require__.p + "images/timeline.27d3f3c7.png";
  
  /***/ }),
  
  /***/ "react":
  /*!************************!*\
    !*** external "React" ***!
    \************************/
  /***/ (function(module) {
  
  module.exports = window["React"];
  
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
  /******/ 	/* webpack/runtime/global */
  /******/ 	!function() {
  /******/ 		__webpack_require__.g = (function() {
  /******/ 			if (typeof globalThis === 'object') return globalThis;
  /******/ 			try {
  /******/ 				return this || new Function('return this')();
  /******/ 			} catch (e) {
  /******/ 				if (typeof window === 'object') return window;
  /******/ 			}
  /******/ 		})();
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
  /******/ 	/* webpack/runtime/publicPath */
  /******/ 	!function() {
  /******/ 		var scriptUrl;
  /******/ 		if (__webpack_require__.g.importScripts) scriptUrl = __webpack_require__.g.location + "";
  /******/ 		var document = __webpack_require__.g.document;
  /******/ 		if (!scriptUrl && document) {
  /******/ 			if (document.currentScript)
  /******/ 				scriptUrl = document.currentScript.src
  /******/ 			if (!scriptUrl) {
  /******/ 				var scripts = document.getElementsByTagName("script");
  /******/ 				if(scripts.length) scriptUrl = scripts[scripts.length - 1].src
  /******/ 			}
  /******/ 		}
  /******/ 		// When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration
  /******/ 		// or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.
  /******/ 		if (!scriptUrl) throw new Error("Automatic publicPath is not supported in this browser");
  /******/ 		scriptUrl = scriptUrl.replace(/#.*$/, "").replace(/\?.*$/, "").replace(/\/[^\/]+$/, "/");
  /******/ 		__webpack_require__.p = scriptUrl;
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
  /******/ 		var chunkLoadingGlobal = self["webpackChunkgutenberg_block"] = self["webpackChunkgutenberg_block"] || [];
  /******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
  /******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
  /******/ 	}();
  /******/ 	
  /************************************************************************/
  /******/ 	
  /******/ 	// startup
  /******/ 	// Load entry module and return exports
  /******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
  /******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], function() { return __webpack_require__("./src/index.js"); })
  /******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
  /******/ 	
  /******/ })()
  ;