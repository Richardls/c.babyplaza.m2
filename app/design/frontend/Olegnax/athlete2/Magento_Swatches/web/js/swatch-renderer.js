/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'underscore',
    'mage/template',
    'mage/smart-keyboard-handler',
    'mage/translate',
    'priceUtils',
    'jquery-ui-modules/widget',
    'jquery/jquery.parsequery',
    'mage/validation/validation'
], function ($, _, mageTemplate, keyboardHandler, $t, priceUtils) {
    'use strict';

    /**
     * Extend form validation to support swatch accessibility
     */
    $.widget('mage.validation', $.mage.validation, {
        /**
         * Handle form with swatches validation. Focus on first invalid swatch block.
         *
         * @param {jQuery.Event} event
         * @param {Object} validation
         */
        listenFormValidateHandler: function (event, validation) {
            var swatchWrapper, firstActive, swatches, swatch, successList, errorList, firstSwatch;

            this._superApply(arguments);

            swatchWrapper = '.swatch-attribute-options';
            swatches = $(event.target).find(swatchWrapper);

            if (!swatches.length) {
                return;
            }

            swatch = '.swatch-attribute';
            firstActive = $(validation.errorList[0].element || []);
            successList = validation.successList;
            errorList = validation.errorList;
            firstSwatch = $(firstActive).parent(swatch).find(swatchWrapper);

            keyboardHandler.focus(swatches);

            $.each(successList, function (index, item) {
                $(item).parent(swatch).find(swatchWrapper).attr('aria-invalid', false);
            });

            $.each(errorList, function (index, item) {
                $(item.element).parent(swatch).find(swatchWrapper).attr('aria-invalid', true);
            });

            if (firstSwatch.length) {
                $(firstSwatch).trigger('focus');
            }
        }
    });

    /**
     * Render tooltips by attributes (only to up).
     * Required element attributes:
     *  - data-option-type (integer, 0-3)
     *  - data-option-label (string)
     *  - data-option-tooltip-thumb
     *  - data-option-tooltip-value
     *  - data-thumb-width
     *  - data-thumb-height
     */
    $.widget('mage.SwatchRendererTooltip', {
        options: {
            delay: 200,                             //how much ms before tooltip to show
            tooltipClass: 'swatch-option-tooltip'  //configurable, but remember about css
        },

        /**
         * @private
         */
        _init: function () {
            var $widget = this,
                $this = this.element,
                $element = $('.' + $widget.options.tooltipClass),
                timer,
                type = parseInt($this.data('option-type'), 10),
                label = $this.data('option-label'),
                thumb = $this.data('option-tooltip-thumb'),
                value = $this.data('option-tooltip-value'),
                width = $this.data('thumb-width'),
                height = $this.data('thumb-height'),
                $image,
                $title,
                $corner;

            if (!$element.length) {
                $element = $('<div class="' +
                    $widget.options.tooltipClass +
                    '"><div class="image"></div><div class="title"></div><div class="corner"></div></div>'
                );
                $('body').append($element);
            }

            $image = $element.find('.image');
            $title = $element.find('.title');
            $corner = $element.find('.corner');

            $this.on('mouseenter', function () {
                if (!$this.hasClass('disabled')) {
                    timer = setTimeout(
                        function () {
                            var leftOpt = null,
                                leftCorner = 0,
                                left,
                                $window;

                            if (type === 2) {
                                // Image
                                $image.css({
                                    'background': 'url("' + thumb + '") no-repeat center', //Background case
                                    'background-size': 'initial',
                                    'width': width + 'px',
                                    'height': height + 'px'
                                });
                                $image.show();
                            } else if (type === 1) {
                                // Color
                                $image.css({
                                    background: value
                                });
                                $image.show();
                            } else if (type === 0 || type === 3) {
                                // Default
                                $image.hide();
                            }

                            $title.text(label);

                            leftOpt = $this.offset().left;
                            left = leftOpt + $this.width() / 2 - $element.width() / 2;
                            $window = $(window);

                            // the numbers (5 and 5) is magick constants for offset from left or right page
                            if (left < 0) {
                                left = 5;
                            } else if (left + $element.width() > $window.width()) {
                                left = $window.width() - $element.width() - 5;
                            }

                            // the numbers (6,  3 and 18) is magick constants for offset tooltip
                            leftCorner = 0;

                            if ($element.width() < $this.width()) {
                                leftCorner = $element.width() / 2 - 3;
                            } else {
                                leftCorner = (leftOpt > left ? leftOpt - left : left - leftOpt) + $this.width() / 2 - 6;
                            }

                            $corner.css({
                                left: leftCorner
                            });
                            $element.css({
                                left: left,
                                top: $this.offset().top - $element.height() - $corner.height() - 18
                            }).show();
                        },
                        $widget.options.delay
                    );
                }
            });

            $this.on('mouseleave', function () {
                $element.hide();
                clearTimeout(timer);
            });
            /* OX start, fix click outside */
            $(document).on('click', function (event) {
                if (!$(event.target).closest($widget.element).length) {
                    $element.hide();
                    clearTimeout(timer);
                }
            });
            /* OX start end */
            $(document).on('tap', function () {
                $element.hide();
                clearTimeout(timer);
            });

            $this.on('tap', function (event) {
                event.stopPropagation();
            });
        }
    });

    /**
     * Render swatch controls with options and use tooltips.
     * Required two json:
     *  - jsonConfig (magento's option config)
     *  - jsonSwatchConfig (swatch's option config)
     *
     *  Tuning:
     *  - numberToShow (show "more" button if options are more)
     *  - onlySwatches (hide selectboxes)
     *  - moreButtonText (text for "more" button)
     *  - selectorProduct (selector for product container)
     *  - selectorProductPrice (selector for change price)
     */
    $.widget('mage.SwatchRenderer', {
        options: {
            classes: {
                attributeClass: 'swatch-attribute',
                attributeLabelClass: 'swatch-attribute-label',
                attributeSelectedOptionLabelClass: 'swatch-attribute-selected-option',
                attributeOptionsWrapper: 'swatch-attribute-options',
                attributeInput: 'swatch-input',
                optionClass: 'swatch-option',
                selectClass: 'swatch-select',
                moreButton: 'swatch-more',
                loader: 'swatch-option-loading'
            },
            // option's json config
            jsonConfig: {},

            // swatch's json config
            jsonSwatchConfig: {},

            // selector of parental block of prices and swatches (need to know where to seek for price block)
            selectorProduct: '.product-info-main',

            // selector of price wrapper (need to know where set price)
            selectorProductPrice: '[data-role=priceBox]',

            //selector of product images gallery wrapper
            mediaGallerySelector: '[data-gallery-role=gallery-placeholder]',

            // selector of category product tile wrapper
            selectorProductTile: '.product-item',

            // number of controls to show (false or zero = show all)
            numberToShow: false,

            // show only swatch controls
            onlySwatches: false,

            // enable label for control
            enableControlLabel: true,

            // control label id
            controlLabelId: '',

            // text for more button
            moreButtonText: $t('More'),

            // Callback url for media
            mediaCallback: '',

            // Local media cache
            mediaCache: {},

            // Cache for BaseProduct images. Needed when option unset
            mediaGalleryInitial: [{}],

            // Use ajax to get image data
            useAjax: false,

            /**
             * Defines the mechanism of how images of a gallery should be
             * updated when user switches between configurations of a product.
             *
             * As for now value of this option can be either 'replace' or 'prepend'.
             *
             * @type {String}
             */
            gallerySwitchStrategy: 'replace',

            // whether swatches are rendered in product list or on product page
            inProductList: false,

            // sly-old-price block selector
            slyOldPriceSelector: '.sly-old-price',

            // tier prise selectors start
            tierPriceTemplateSelector: '#tier-prices-template',
            tierPriceBlockSelector: '[data-role="tier-price-block"]',
            tierPriceTemplate: '',
            // tier prise selectors end

            // A price label selector
            normalPriceLabelSelector:  '.product-info-main .normal-price .price-label',
            qtyInfo: '#qty'
        },

        /**
         * Get chosen product
         *
         * @returns int|null
         */
        getProduct: function () {
            var products = this._CalcProducts();

            return _.isArray(products) ? products[0] : null;
        },

        /**
         * Get chosen product id
         *
         * @returns int|null
         */
        getProductId: function () {
            var products = this._CalcProducts();

            return _.isArray(products) && products.length === 1 ? products[0] : null;
        },

        /**
         * @private
         */
        _init: function () {
            // Don't render the same set of swatches twice
            if ($(this.element).attr('data-rendered')) {
                return;
            }

            $(this.element).attr('data-rendered', true);

            if (_.isEmpty(this.options.jsonConfig.images)) {
                this.options.useAjax = true;
                // creates debounced variant of _LoadProductMedia()
                // to use it in events handlers instead of _LoadProductMedia()
                this._debouncedLoadProductMedia = _.debounce(this._LoadProductMedia.bind(this), 500);
            }

            this.options.tierPriceTemplate = $(this.options.tierPriceTemplateSelector).html();

            if (this.options.jsonConfig !== '' && this.options.jsonSwatchConfig !== '') {
                // store unsorted attributes
                this.options.jsonConfig.mappedAttributes = _.clone(this.options.jsonConfig.attributes);
                this._sortAttributes();
                this._RenderControls();
                this._setPreSelectedGallery();
                $(this.element).trigger('swatch.initialized');
            } else {
                console.log('SwatchRenderer: No input data received');
            }
        },

        /**
         * @private
         */
        _sortAttributes: function () {
            this.options.jsonConfig.attributes = _.sortBy(this.options.jsonConfig.attributes, function (attribute) {
                return parseInt(attribute.position, 10);
            });
        },

        /**
         * @private
         */
        _create: function () {
            var options = this.options,
                gallery = $('[data-gallery-role=gallery-placeholder]', '.column.main'),
                productData = this._determineProductData(),
                $main = productData.isInProductView ?
                    this.element.parents('.column.main') :
                    this.element.parents('.product-item-info');

            if (productData.isInProductView) {
                gallery.data('gallery') ?
                    this._onGalleryLoaded(gallery) :
                    gallery.on('gallery:loaded', this._onGalleryLoaded.bind(this, gallery));
            } else {
                options.mediaGalleryInitial = [{
                    'img': $main.find('.product-image-photo').attr('src')
                }];
                /** OX_START: **/
                this._ox_create();
                /** OX_END **/
            }

            this.productForm = this.element.parents(this.options.selectorProductTile).find('form:first');
            this.inProductList = this.productForm.length > 0;
            $(this.options.qtyInfo).on('input', this._onQtyChanged.bind(this));
        },

        /**
         * Determine product id and related data
         *
         * @returns {{productId: *, isInProductView: bool}}
         * @private
         */
        _determineProductData: function () {
            // Check if product is in a list of products.
            var productId,
                isInProductView = false;

            productId = this.element.parents('.product-item-info')
                    .find('.price-box.price-final_price').attr('data-product-id');
            if (!productId) {
                // Check individual product.
                productId = $('[name=product]').val();
                isInProductView = productId > 0;
            }
            return {
                productId: productId,
                isInProductView: isInProductView
            };
        },

        /**
         * Render controls
         *
         * @private
         */
        _RenderControls: function () {
            var $widget = this,
                container = this.element,
                classes = this.options.classes,
                chooseText = this.options.jsonConfig.chooseText,
                showTooltip = this.options.showTooltip;
            /** OX_START: **/
            if (container.find('.' + classes.attributeClass).length) {
                return;
            }
            /** OX_END **/
            $widget.optionsMap = {};

            $.each(this.options.jsonConfig.attributes, function () {
                var item = this,
                    controlLabelId = 'option-label-' + item.code + '-' + item.id,
                    options = $widget._RenderSwatchOptions(item, controlLabelId),
                    select = $widget._RenderSwatchSelect(item, chooseText),
                    input = $widget._RenderFormInput(item),
                    listLabel = '',
                    label = '';

                // Show only swatch controls
                if ($widget.options.onlySwatches && !$widget.options.jsonSwatchConfig.hasOwnProperty(item.id)) {
                    return;
                }

                if ($widget.options.enableControlLabel) {
                    label +=
                        '<span id="' + controlLabelId + '" class="' + classes.attributeLabelClass + '">' +
                        $('<i></i>').text(item.label).html() +
                        '</span>' +
                        '<span class="' + classes.attributeSelectedOptionLabelClass + '"></span>';
                }

                if ($widget.inProductList) {
                    $widget.productForm.append(input);
                    input = '';
                    listLabel = 'aria-label="' + $('<i></i>').text(item.label).html() + '"';
                    /** OX_START: **/
                    $widget.options.selectorProduct = '.product-item-info';
                    /** OX_END **/
                } else {
                    listLabel = 'aria-labelledby="' + controlLabelId + '"';
                }

                // Create new control
                container.append(
                    '<div class="' + classes.attributeClass + ' ' + item.code + '" ' +
                         'data-attribute-code="' + item.code + '" ' +
                         'data-attribute-id="' + item.id + '">' +
                        label +
                        '<div aria-activedescendant="" ' +
                             'tabindex="0" ' +
                             'aria-invalid="false" ' +
                             'aria-required="true" ' +
                             'role="listbox" ' + listLabel +
                             'class="' + classes.attributeOptionsWrapper + ' clearfix">' +
                            options + select +
                        '</div>' + input +
                    '</div>'
                );

                $widget.optionsMap[item.id] = {};

                // Aggregate options array to hash (key => value)
                $.each(item.options, function () {
                    if (this.products.length > 0) {
                        let salableProducts = this.products;

                        if ($widget.options.jsonConfig.canDisplayShowOutOfStockStatus) {
                            salableProducts = $widget.options.jsonConfig.salable[item.id][this.id];
                        }
                        $widget.optionsMap[item.id][this.id] = {
                            price: parseInt(
                                $widget.options.jsonConfig.optionPrices[this.products[0]].finalPrice.amount,
                                10
                            ),
                            products: salableProducts
                        };
                    }
                });
            });

            if (showTooltip === 1) {
                // Connect Tooltip
                container
                    .find('[data-option-type="1"], [data-option-type="2"],' +
                        ' [data-option-type="0"], [data-option-type="3"]')
                    .SwatchRendererTooltip();
            }

            // Hide all elements below more button
            $('.' + classes.moreButton).nextAll().hide();

            // Handle events like click or change
            $widget._EventListener();

            // Rewind options
            $widget._Rewind(container);

            //Emulate click on all swatches from Request
            $widget._EmulateSelected($.parseQuery());
            $widget._EmulateSelected($widget._getSelectedAttributes());
        },

        disableSwatchForOutOfStockProducts: function () {
            let $widget = this, container = this.element;

            $.each(this.options.jsonConfig.attributes, function () {
                let item = this;

                if ($widget.options.jsonConfig.canDisplayShowOutOfStockStatus) {
                    let salableProducts = $widget.options.jsonConfig.salable[item.id],
                        swatchOptions = $(container).find(`[data-attribute-id='${item.id}']`).find('.swatch-option');

                    swatchOptions.each(function (key, value) {
                        let optionId = $(value).data('option-id');

                        if (!salableProducts.hasOwnProperty(optionId)) {
                            $(value).attr('disabled', true).addClass('disabled');
                        }
                    });
                }
            });
        },
        /**
         * Render swatch options by part of config
         *
         * @param {Object} config
         * @param {String} controlId
         * @returns {String}
         * @private
         */
        _RenderSwatchOptions: function (config, controlId) {
            var optionConfig = this.options.jsonSwatchConfig[config.id],
                optionClass = this.options.classes.optionClass,
                sizeConfig = this.options.jsonSwatchImageSizeConfig,
                moreLimit = parseInt(this.options.numberToShow, 10),
                moreClass = this.options.classes.moreButton,
                moreText = this.options.moreButtonText,
                countAttributes = 0,
                html = '';

            if (!this.options.jsonSwatchConfig.hasOwnProperty(config.id)) {
                return '';
            }

            $.each(config.options, function (index) {
                var id,
                    type,
                    value,
                    thumb,
                    label,
                    width,
                    height,
                    attr,
                    swatchImageWidth,
                    swatchImageHeight;

                if (!optionConfig.hasOwnProperty(this.id)) {
                    return '';
                }

                // Add more button
                if (moreLimit === countAttributes++) {
                    html += '<a href="#" class="' + moreClass + '"><span>' + moreText + '</span></a>';
                }

                id = this.id;
                type = parseInt(optionConfig[id].type, 10);
                value = optionConfig[id].hasOwnProperty('value') ?
                    $('<i></i>').text(optionConfig[id].value).html() : '';
                thumb = optionConfig[id].hasOwnProperty('thumb') ? optionConfig[id].thumb : '';
                width = _.has(sizeConfig, 'swatchThumb') ? sizeConfig.swatchThumb.width : 110;
                height = _.has(sizeConfig, 'swatchThumb') ? sizeConfig.swatchThumb.height : 90;
                label = this.label ? $('<i></i>').text(this.label).html() : '';
                attr =
                    ' id="' + controlId + '-item-' + id + '"' +
                    ' index="' + index + '"' +
                    ' aria-checked="false"' +
                    ' aria-describedby="' + controlId + '"' +
                    ' tabindex="0"' +
                    ' data-option-type="' + type + '"' +
                    ' data-option-id="' + id + '"' +
                    ' data-option-label="' + label + '"' +
                    ' aria-label="' + label + '"' +
                    ' role="option"' +
                    ' data-thumb-width="' + width + '"' +
                    ' data-thumb-height="' + height + '"';

                attr += thumb !== '' ? ' data-option-tooltip-thumb="' + thumb + '"' : '';
                attr += value !== '' ? ' data-option-tooltip-value="' + value + '"' : '';

                swatchImageWidth = _.has(sizeConfig, 'swatchImage') ? sizeConfig.swatchImage.width : 30;
                swatchImageHeight = _.has(sizeConfig, 'swatchImage') ? sizeConfig.swatchImage.height : 20;

                if (!this.hasOwnProperty('products') || this.products.length <= 0) {
                    attr += ' data-option-empty="true"';
                }

                if (type === 0) {
                    // Text
                    html += '<div class="' + optionClass + ' text" ' + attr + '>' + (value ? value : label) +
                        '</div>';
                } else if (type === 1) {
                    // Color
                    html += '<div class="' + optionClass + ' color" ' + attr +
                        ' style="background: ' + value +
                        ' no-repeat center; background-size: initial;">' + '' +
                        '</div>';
                } else if (type === 2) {
                    // Image
                    html += '<div class="' + optionClass + ' image" ' + attr +
                        ' style="background: url(' + value + ') no-repeat center; background-size: initial;width:' +
                        swatchImageWidth + 'px; height:' + swatchImageHeight + 'px">' + '' +
                        '</div>';
                } else if (type === 3) {
                    // Clear
                    html += '<div class="' + optionClass + '" ' + attr + '></div>';
                } else {
                    // Default
                    html += '<div class="' + optionClass + '" ' + attr + '>' + label + '</div>';
                }
            });

            return html;
        },

        /**
         * Render select by part of config
         *
         * @param {Object} config
         * @param {String} chooseText
         * @returns {String}
         * @private
         */
        _RenderSwatchSelect: function (config, chooseText) {
            var html;

            if (this.options.jsonSwatchConfig.hasOwnProperty(config.id)) {
                return '';
            }

            html =
                '<select class="' + this.options.classes.selectClass + ' ' + config.code + '">' +
                '<option value="0" data-option-id="0">' + chooseText + '</option>';

            $.each(config.options, function () {
                var label = this.label,
                    attr = ' value="' + this.id + '" data-option-id="' + this.id + '"';

                if (!this.hasOwnProperty('products') || this.products.length <= 0) {
                    attr += ' data-option-empty="true"';
                }

                html += '<option ' + attr + '>' + label + '</option>';
            });

            html += '</select>';

            return html;
        },

        /**
         * Input for submit form.
         * This control shouldn't have "type=hidden", "display: none" for validation work :(
         *
         * @param {Object} config
         * @private
         */
        _RenderFormInput: function (config) {
            return '<input class="' + this.options.classes.attributeInput + ' super-attribute-select" ' +
                'name="super_attribute[' + config.id + ']" ' +
                'type="text" ' +
                'value="" ' +
                'data-selector="super_attribute[' + config.id + ']" ' +
                'data-validate="{required: true}" ' +
                'aria-required="true" ' +
                'aria-invalid="false">';
        },

        /**
         * Event listener
         *
         * @private
         */
        _EventListener: function () {
            var $widget = this,
                options = this.options.classes,
                target;

            $widget.element.on('click', '.' + options.optionClass, function () {
                return $widget._OnClick($(this), $widget);
            });

            $widget.element.on('change', '.' + options.selectClass, function () {
                return $widget._OnChange($(this), $widget);
            });

            $widget.element.on('click', '.' + options.moreButton, function (e) {
                e.preventDefault();

                return $widget._OnMoreClick($(this));
            });

            $widget.element.on('keydown', function (e) {
                if (e.which === 13) {
                    target = $(e.target);

                    if (target.is('.' + options.optionClass)) {
                        return $widget._OnClick(target, $widget);
                    } else if (target.is('.' + options.selectClass)) {
                        return $widget._OnChange(target, $widget);
                    } else if (target.is('.' + options.moreButton)) {
                        e.preventDefault();

                        return $widget._OnMoreClick(target);
                    }
                }
            });
        },

        /**
         * Load media gallery using ajax or json config.
         *
         * @private
         */
        _loadMedia: function () {
            var $main = this.inProductList ?
                    this.element.parents('.product-item-info') :
                    this.element.parents('.column.main'),
                images;

            if (this.options.useAjax) {
                this._debouncedLoadProductMedia();
            }  else {
                images = this.options.jsonConfig.images[this.getProduct()];

                if (!images) {
                    images = this.options.mediaGalleryInitial;
                }
                this.updateBaseImage(this._sortImages(images), $main, !this.inProductList);
            }
        },

        /**
         * Sorting images array
         *
         * @private
         */
        _sortImages: function (images) {
            return _.sortBy(images, function (image) {
                return parseInt(image.position, 10);
            });
        },

        /**
         * Event for swatch options
         *
         * @param {Object} $this
         * @param {Object} $widget
         * @private
         */
        _OnClick: function ($this, $widget) {
            var $parent = $this.parents('.' + $widget.options.classes.attributeClass),
                $wrapper = $this.parents('.' + $widget.options.classes.attributeOptionsWrapper),
                $label = $parent.find('.' + $widget.options.classes.attributeSelectedOptionLabelClass),
                /** OX_OLD:
                attributeId = $parent.data('attribute-id'),
                /** OX_START: **/
                attributeId = $parent.data('attribute-id') || $parent.attr('attribute-id'),
                /** OX_END **/
                $input = $parent.find('.' + $widget.options.classes.attributeInput),
                checkAdditionalData = JSON.parse(this.options.jsonSwatchConfig[attributeId]['additional_data']),
                $priceBox = $widget.element.parents($widget.options.selectorProduct)
                    .find(this.options.selectorProductPrice);

            if ($widget.inProductList) {
                $input = $widget.productForm.find(
                    '.' + $widget.options.classes.attributeInput + '[name="super_attribute[' + attributeId + ']"]'
                );
            }

            if ($this.hasClass('disabled')) {
                return;
            }
            if ($this.hasClass('selected')) {
                $parent.removeAttr('data-option-selected').find('.selected').removeClass('selected');
                $input.val('');
                $label.text('');
                $this.attr('aria-checked', false);
                /* OX_START for thumb carousel */
                if($this.parents('.product-item-info').length){
                    $this.parents('.product-item-info').removeClass('swatch-selected');
                }
                /* OX_END */
            } else {
                $parent.attr('data-option-selected', $this.data('option-id')).find('.selected').removeClass('selected');
                $label.text($this.data('option-label'));
                $input.val($this.data('option-id'));
                $input.attr('data-attr-name', this._getAttributeCodeById(attributeId));
                $this.addClass('selected');
                $widget._toggleCheckedAttributes($this, $wrapper);
                /* OX_START for thumb carousel */
                if($this.parents('.product-item-info').length){
                    $this.parents('.product-item-info').addClass('swatch-selected');
                }
                /* OX_END */
            }
            $widget._Rebuild();
            /* Ox Start */
            $widget._UpdateStock();
            $widget._UpdateSku();
            /* Ox End */
            if ($priceBox.is(':data(mage-priceBox)')) {
                $widget._UpdatePrice();
            }

            $(document).trigger('updateMsrpPriceBlock',
                [
                    this._getSelectedOptionPriceIndex(),
                    $widget.options.jsonConfig.optionPrices,
                    $priceBox
                ]);

            if (parseInt(checkAdditionalData['update_product_preview_image'], 10) === 1) {
                $widget._loadMedia();
            }

            $input.trigger('change');
        },

        /**
         * Get selected option price index
         *
         * @return {String|undefined}
         * @private
         */
        _getSelectedOptionPriceIndex: function () {
            var allowedProduct = this._getAllowedProductWithMinPrice(this._CalcProducts());

            if (_.isEmpty(allowedProduct)) {
                return undefined;
            }

            return allowedProduct;
        },

        /**
         * Get human readable attribute code (eg. size, color) by it ID from configuration
         *
         * @param {Number} attributeId
         * @returns {*}
         * @private
         */
        _getAttributeCodeById: function (attributeId) {
            var attribute = this.options.jsonConfig.mappedAttributes[attributeId];

            return attribute ? attribute.code : attributeId;
        },

        /**
         * Toggle accessibility attributes
         *
         * @param {Object} $this
         * @param {Object} $wrapper
         * @private
         */
        _toggleCheckedAttributes: function ($this, $wrapper) {
            $wrapper.attr('aria-activedescendant', $this.attr('id'))
                    .find('.' + this.options.classes.optionClass).attr('aria-checked', false);
            $this.attr('aria-checked', true);
        },

        /**
         * Event for select
         *
         * @param {Object} $this
         * @param {Object} $widget
         * @private
         */
        _OnChange: function ($this, $widget) {
            var $parent = $this.parents('.' + $widget.options.classes.attributeClass),
                /** OX_OLD:
                attributeId = $parent.data('attribute-id'),
                /** OX_START: **/
                attributeId = $parent.data('attribute-id') || $parent.attr('attribute-id'),
                /** OX_END **/
                $input = $parent.find('.' + $widget.options.classes.attributeInput);

            if ($widget.productForm.length > 0) {
                $input = $widget.productForm.find(
                    '.' + $widget.options.classes.attributeInput + '[name="super_attribute[' + attributeId + ']"]'
                );
            }

            if ($this.val() > 0) {
                $parent.attr('data-option-selected', $this.val());
                $input.val($this.val());
            } else {
                $parent.removeAttr('data-option-selected');
                $input.val('');
            }

            $widget._Rebuild();
            $widget._UpdatePrice();
            /* Ox Start */
            $widget._UpdateStock();
            $widget._UpdateSku();
            /* Ox End */
            $widget._loadMedia();
            $input.trigger('change');
        },
        _UpdatePriceDiff: function(result) {
            let $widget = this;
            if(typeof result === 'undefined' || $widget.priceDiffDisabled){
                return;
            }
            let $wrap;
            let priceDiff = 0;
            if(!$widget.priceDiffElement){
                if($widget.inProductList){
                    $wrap = $widget.element.parents($widget.options.selectorProduct);
                } else {
                    $wrap = $('.product-info-main, .product-bar__info-price');
                }
                let $el = $wrap?.find('.ox-sale-price-dif');
                if($el.length){
                    $widget.priceDiffElement = $el;
                }else{
                    $widget.priceDiffDisabled = true;
                }
            }
            if(!$widget.priceDiffDisabled && $widget.priceDiffElement?.length){
                $widget.priceDiffAsPercent = $widget.priceDiffElement.hasClass('as-percent');
                if($widget.priceDiffAsPercent){
                    priceDiff = Math.round((1 - result.finalPrice?.amount / result.oldPrice?.amount) * 100);
                } else{
                    priceDiff = result.oldPrice?.amount - result.finalPrice?.amount;
                }
                $widget._togglePriceDiff($widget.priceDiffElement, priceDiff, $widget.priceDiffAsPercent);
            }
        },
        _togglePriceDiff: function($el, price, asPercent){
            if(!$el){
                return;
            }
            const $priceDiffEl = $el.find('.js-ox-price-diff');
            if(0 >= price || !$priceDiffEl.length){
                $el.addClass('d-none');
            } else{
                if(asPercent){
                    $priceDiffEl.html(price);
                } else{
                    this._formatedPriceDiff($priceDiffEl, price);
                }
                $el.removeClass('d-none');                
            }
        },
        _formatedPriceDiff: function($el, price){
            let formatedPrice = priceUtils.formatPrice(price, this.options.jsonConfig.currencyFormat);
            let priceTemplate = mageTemplate(this.options.jsonConfig.template);
            let usePriceTemplate = false;
            /* for some 3rd party modules */
            if(usePriceTemplate && priceTemplate){
                $el.html(priceTemplate({
                    data: {price: formatedPrice}
                }));
            } else{
                $el.html(formatedPrice);
            }
        },
        _UpdateStock: function() {
            if(this.stockDisabled){
                return;
            }
            let prod_id = this.getProduct();
            let $stockWrap = $('.js-ox-stock-values');
            if(prod_id && $stockWrap.length){
                $stockWrap?.children()?.removeClass('show');
                $stockWrap.find('[data-product-id="' + prod_id + '"]')?.addClass('show');
            } else{
                this.stockDisabled = true;
            }
        },
        _UpdateSku: function () {
            if(this.skuDisabled){
                return;
            }
            const $sku_wrapper = $('.product-info-stock-sku .sku');
            if($sku_wrapper.length){
                if(!$sku_wrapper.data('sku')){
                    $sku_wrapper.data('sku', $sku_wrapper.find('.value').text());
                }
                let prod_id = this.getProduct();
                if( prod_id && this.options.jsonConfig.hasOwnProperty('sku')){
                    let sku = this.options.jsonConfig.sku[prod_id];
                    if(sku === undefined){
                        sku = $sku_wrapper.data('sku');
                    }
                    $sku_wrapper.find('.value')?.html(sku);
                }
            } else {
                this.skuDisabled = true;
            }
        },
        /**
         * Event for more switcher
         *
         * @param {Object} $this
         * @private
         */
        _OnMoreClick: function ($this) {
            $this.nextAll().show();
            $this.trigger('blur').remove();
        },

        /**
         * Rewind options for controls
         *
         * @private
         */
        _Rewind: function (controls) {
            controls.find('div[data-option-id], option[data-option-id]')
            .removeClass('disabled')
            .prop('disabled', false);
            controls.find('div[data-option-empty], option[data-option-empty]')
                .attr('disabled', true)
                .addClass('disabled')
                .attr('tabindex', '-1');
        },

        /**
         * Rebuild container
         *
         * @private
         */
        _Rebuild: function () {
            var $widget = this,
                controls = $widget.element.find('.' + $widget.options.classes.attributeClass + '[data-attribute-id]'),
                selected = controls.filter('[data-option-selected]');

            // Enable all options
            $widget._Rewind(controls);

            // done if nothing selected
            if (selected.length <= 0) {
                return;
            }

            // Disable not available options
            controls.each(function () {
                var $this = $(this),
                    /** OX_OLD:
                    id = $this.data('attribute-id'),
                    /** OX_START: **/
                    id = $this.data('attribute-id') || $this.attr('attribute-id'),
                    /** OX_END **/
                    products = $widget._CalcProducts(id);

                /** OX_OLD:
                if (selected.length === 1 && selected.first().data('attribute-id') === id) {
                /** OX_START: **/
                if (selected.length === 1 && (selected.first().data('attribute-id') || selected.first().attr('attribute-id')) === id) {
                /** OX_END **/
                    return;
                }

                $this.find('[data-option-id]').each(function () {
                    var $element = $(this),
                        option = $element.data('option-id');

                    if (!$widget.optionsMap.hasOwnProperty(id) || !$widget.optionsMap[id].hasOwnProperty(option) ||
                        $element.hasClass('selected') ||
                        $element.is(':selected')) {
                        return;
                    }

                    if (_.intersection(products, $widget.optionsMap[id][option].products).length <= 0) {
                        $element.attr('disabled', true).addClass('disabled');
                    }
                });
            });
        },

        /**
         * Get selected product list
         *
         * @returns {Array}
         * @private
         */
        _CalcProducts: function ($skipAttributeId) {
            var $widget = this,
                selectedOptions = '.' + $widget.options.classes.attributeClass + '[data-option-selected]',
                products = [];

            // Generate intersection of products
            $widget.element.find(selectedOptions).each(function () {
                /** OX_OLD:
                var id = $(this).data('attribute-id'),
                /** OX_START: **/
                var id = $(this).data('attribute-id') || $(this).attr('attribute-id'),
                /** OX_END **/
                    option = $(this).attr('data-option-selected');

                if ($skipAttributeId !== undefined && $skipAttributeId === id) {
                    return;
                }

                if (!$widget.optionsMap.hasOwnProperty(id) || !$widget.optionsMap[id].hasOwnProperty(option)) {
                    return;
                }

                if (products.length === 0) {
                    products = $widget.optionsMap[id][option].products;
                } else {
                    products = _.intersection(products, $widget.optionsMap[id][option].products);
                }
            });

            return products;
        },

        /**
         * Update total price
         *
         * @private
         */
        _UpdatePrice: function () {
            var $widget = this,
                $product = $widget.element.parents($widget.options.selectorProduct),
                $productPrice = $product.find(this.options.selectorProductPrice),
                result = $widget._getNewPrices(),
                tierPriceHtml,
                isShow;
                /* Ox Start */
                $widget._UpdatePriceDiff(result);
                /* Ox End */
            $productPrice.trigger(
                'updatePrice',
                {
                    'prices': $widget._getPrices(result, $productPrice.priceBox('option').prices)
                }
            );

            isShow = typeof result != 'undefined' && result.oldPrice.amount !== result.finalPrice.amount;

            $productPrice.find('span:first').toggleClass('special-price', isShow);

            $product.find(this.options.slyOldPriceSelector)[isShow ? 'show' : 'hide']();

            if (typeof result != 'undefined' && result.tierPrices && result.tierPrices.length) {
                if (this.options.tierPriceTemplate) {
                    tierPriceHtml = mageTemplate(
                        this.options.tierPriceTemplate,
                        {
                            'tierPrices': result.tierPrices,
                            '$t': $t,
                            'currencyFormat': this.options.jsonConfig.currencyFormat,
                            'priceUtils': priceUtils
                        }
                    );
                    $(this.options.tierPriceBlockSelector).html(tierPriceHtml).show();
                }
            } else {
                $(this.options.tierPriceBlockSelector).hide();
            }

            $product.find(this.options.normalPriceLabelSelector).hide();
            _.each(this.element.find('.' + this.options.classes.attributeOptionsWrapper), function (attribute) {
                if ($(attribute).find('.' + this.options.classes.optionClass + '.selected').length === 0) {
                    if ($(attribute).find('.' + this.options.classes.selectClass).length > 0) {
                        _.each($(attribute).find('.' + this.options.classes.selectClass), function (dropdown) {
                            if ($(dropdown).val() === '0') {
                                $product.find(this.options.normalPriceLabelSelector).show();
                            }
                        }.bind(this));
                    } else {
                        $product.find(this.options.normalPriceLabelSelector).show();
                    }
                }
            }.bind(this));
        },

        /**
         * Get new prices for selected options
         *
         * @returns {*}
         * @private
         */
        _getNewPrices: function () {
            var $widget = this,
                newPrices = $widget.options.jsonConfig.prices,
                allowedProduct = this._getAllowedProductWithMinPrice(this._CalcProducts());

            if (!_.isEmpty(allowedProduct)) {
                newPrices = this.options.jsonConfig.optionPrices[allowedProduct];
            }

            return newPrices;
        },

        /**
         * Get prices
         *
         * @param {Object} newPrices
         * @param {Object} displayPrices
         * @returns {*}
         * @private
         */
        _getPrices: function (newPrices, displayPrices) {
            var $widget = this;

            if (_.isEmpty(newPrices)) {
                newPrices = $widget._getNewPrices();
            }
            _.each(displayPrices, function (price, code) {

                if (newPrices[code]) {
                    displayPrices[code].amount = newPrices[code].amount - displayPrices[code].amount;
                }
            });

            return displayPrices;
        },

        /**
         * Get product with minimum price from selected options.
         *
         * @param {Array} allowedProducts
         * @returns {String}
         * @private
         */
        _getAllowedProductWithMinPrice: function (allowedProducts) {
            var optionPrices = this.options.jsonConfig.optionPrices,
                product = {},
                optionFinalPrice, optionMinPrice;

            _.each(allowedProducts, function (allowedProduct) {
                optionFinalPrice = parseFloat(optionPrices[allowedProduct].finalPrice.amount);

                if (_.isEmpty(product) || optionFinalPrice < optionMinPrice) {
                    optionMinPrice = optionFinalPrice;
                    product = allowedProduct;
                }
            }, this);

            return product;
        },

        /**
         * Gets all product media and change current to the needed one
         *
         * @private
         */
        _LoadProductMedia: function () {
            var $widget = this,
                $this = $widget.element,
                productData = this._determineProductData(),
                mediaCallData,
                mediaCacheKey,

                /**
                 * Processes product media data
                 *
                 * @param {Object} data
                 * @returns void
                 */
                mediaSuccessCallback = function (data) {
                    if (!(mediaCacheKey in $widget.options.mediaCache)) {
                        $widget.options.mediaCache[mediaCacheKey] = data;
                    }
                    $widget._ProductMediaCallback($this, data, productData.isInProductView);
                    setTimeout(function () {
                        $widget._DisableProductMediaLoader($this);
                    }, 300);
                };

            if (!$widget.options.mediaCallback) {
                return;
            }

            mediaCallData = {
                'product_id': this.getProduct()
            };

            mediaCacheKey = JSON.stringify(mediaCallData);

            if (mediaCacheKey in $widget.options.mediaCache) {
                $widget._XhrKiller();
                $widget._EnableProductMediaLoader($this);
                mediaSuccessCallback($widget.options.mediaCache[mediaCacheKey]);
            } else {
                mediaCallData.isAjax = true;
                $widget._XhrKiller();
                $widget._EnableProductMediaLoader($this);
                $widget.xhr = $.ajax({
                    url: $widget.options.mediaCallback,
                    cache: true,
                    type: 'GET',
                    dataType: 'json',
                    data: mediaCallData,
                    success: mediaSuccessCallback
                }).done(function () {
                    $widget._XhrKiller();
                });
            }
        },

        /**
         * Enable loader
         *
         * @param {Object} $this
         * @private
         */
        _EnableProductMediaLoader: function ($this) {
            var $widget = this;

            if ($('body.catalog-product-view').length > 0) {
                $this.parents('.column.main').find('.photo.image')
                    .addClass($widget.options.classes.loader);
            } else {
                //Category View
                $this.parents('.product-item-info').find('.product-image-photo')
                    .addClass($widget.options.classes.loader);
            }
        },

        /**
         * Disable loader
         *
         * @param {Object} $this
         * @private
         */
        _DisableProductMediaLoader: function ($this) {
            var $widget = this;

            if ($('body.catalog-product-view').length > 0) {
                $this.parents('.column.main').find('.photo.image')
                    .removeClass($widget.options.classes.loader);
            } else {
                //Category View
                $this.parents('.product-item-info').find('.product-image-photo')
                    .removeClass($widget.options.classes.loader);
            }
        },

        /**
         * Callback for product media
         *
         * @param {Object} $this
         * @param {String} response
         * @param {Boolean} isInProductView
         * @private
         */
        _ProductMediaCallback: function ($this, response, isInProductView) {
            var $main = isInProductView ? $this.parents('.column.main') : $this.parents('.product-item-info'),
                $widget = this,
                images = [],

                /**
                 * Check whether object supported or not
                 *
                 * @param {Object} e
                 * @returns {*|Boolean}
                 */
                support = function (e) {
                    return e.hasOwnProperty('large') && e.hasOwnProperty('medium') && e.hasOwnProperty('small');
                };

            if (_.size($widget) < 1 || !support(response)) {
                this.updateBaseImage(this.options.mediaGalleryInitial, $main, isInProductView);

                return;
            }

            images.push({
                full: response.large,
                img: response.medium,
                /** OX_START: **/
                resized: this.hasOwnProperty('medium_resized') ? response.medium_resized : '',
                /** OX_END **/
                thumb: response.small,
                isMain: true
            });

            if (response.hasOwnProperty('gallery')) {
                $.each(response.gallery, function () {
                    if (!support(this) || response.large === this.large) {
                        return;
                    }
                    images.push({
                        full: this.large,
                        img: this.medium,
                        /** OX_OLD:
                        thumb: this.small
                        /** OX_START: **/
                        thumb: this.small,
                        resized: this.hasOwnProperty('medium_resized') ? this.medium_resized : '',
                        isHover: this.isHover,
                        /** OX_END **/
                    });
                });
            }

            this.updateBaseImage(images, $main, isInProductView);
        },

        /**
         * Check if images to update are initial and set their type
         * @param {Array} images
         */
        _setImageType: function (images) {

            images.map(function (img) {
                if (!img.type) {
                    img.type = 'image';
                }
            });

            return images;
        },

        /**
         * Update [gallery-placeholder] or [product-image-photo]
         * @param {Array} images
         * @param {jQuery} context
         * @param {Boolean} isInProductView
         */
        updateBaseImage: function (images, context, isInProductView) {
            var justAnImage = images[0],
                initialImages = this.options.mediaGalleryInitial,
                imagesToUpdate,
                gallery = context.find(this.options.mediaGallerySelector).data('gallery'),
                /** OX_START: **/
                hoverAnImage,
                /** OX_END **/
                isInitial;
            /** OX_START: **/
            $.each(images, function () {
                if (!this.isHover) {
                    justAnImage = this;
                    return false;
                }
            });
            $.each(images, function () {
                if (this.isHover) {
                    hoverAnImage = this;
                    return false;
                }
            });
            /** OX_END **/
            if (isInProductView) {
                /** OX_START: **/
                initialImages = this._ox_load_mediaGalleryInitial(initialImages, context);
                if (_.isEqual([{}], images)) {
                    images = initialImages;
                    justAnImage = images[0];
                }
                /** OX_END **/
                if (_.isUndefined(gallery)) {
                    context.find(this.options.mediaGallerySelector).on('gallery:loaded', function () {
                        this.updateBaseImage(images, context, isInProductView);
                    }.bind(this));
                    /** OX_START: **/
                    this._ox_updateBaseImage_without_gallery(images, context);
                    /** OX_END **/
                    return;
                }

                imagesToUpdate = images.length ? this._setImageType($.extend(true, [], images)) : [];
                isInitial = _.isEqual(imagesToUpdate, initialImages);

                if (this.options.gallerySwitchStrategy === 'prepend' && !isInitial) {
                    imagesToUpdate = imagesToUpdate.concat(initialImages);
                }

                imagesToUpdate = this._setImageIndex(imagesToUpdate);

                gallery.updateData(imagesToUpdate);
                this._addFotoramaVideoEvents(isInitial);
            } else if (justAnImage && justAnImage.img) {
                /** OX_OLD:
                context.find('.product-image-photo').attr('src', justAnImage.img);
                /** OX_START: **/
                this._ox_updateBaseImage_listing(context, justAnImage, hoverAnImage);
                /** OX_END **/
            }
        },

        /**
         * Add video events
         *
         * @param {Boolean} isInitial
         * @private
         */
        _addFotoramaVideoEvents: function (isInitial) {
            if (_.isUndefined($.mage.AddFotoramaVideoEvents)) {
                return;
            }

            if (isInitial) {
                $(this.options.mediaGallerySelector).AddFotoramaVideoEvents();

                return;
            }

            $(this.options.mediaGallerySelector).AddFotoramaVideoEvents({
                selectedOption: this.getProduct(),
                dataMergeStrategy: this.options.gallerySwitchStrategy
            });
        },

        /**
         * Set correct indexes for image set.
         *
         * @param {Array} images
         * @private
         */
        _setImageIndex: function (images) {
            var length = images.length,
                i;

            for (i = 0; length > i; i++) {
                images[i].i = i + 1;
            }

            return images;
        },

        /**
         * Kill doubled AJAX requests
         *
         * @private
         */
        _XhrKiller: function () {
            var $widget = this;

            if ($widget.xhr !== undefined && $widget.xhr !== null) {
                $widget.xhr.abort();
                $widget.xhr = null;
            }
        },

        /**
         * Emulate mouse click on all swatches that should be selected
         * @param {Object} [selectedAttributes]
         * @private
         */
        _EmulateSelected: function (selectedAttributes) {
            $.each(selectedAttributes, $.proxy(function (attributeCode, optionId) {
                var elem = this.element.find('.' + this.options.classes.attributeClass +
                    '[data-attribute-code="' + attributeCode + '"] [data-option-id="' + optionId + '"]'),
                    parentInput = elem.parent();

                if (elem.hasClass('selected')) {
                    return;
                }

                if (parentInput.hasClass(this.options.classes.selectClass)) {
                    parentInput.val(optionId);
                    parentInput.trigger('change');
                } else {
                    elem.trigger('click');
                }
            }, this));
        },

        /**
         * Emulate mouse click or selection change on all swatches that should be selected
         * @param {Object} [selectedAttributes]
         * @private
         */
        _EmulateSelectedByAttributeId: function (selectedAttributes) {
            $.each(selectedAttributes, $.proxy(function (attributeId, optionId) {
                var elem = this.element.find('.' + this.options.classes.attributeClass +
                    '[data-attribute-id="' + attributeId + '"] [data-option-id="' + optionId + '"]'),
                    parentInput = elem.parent();

                if (elem.hasClass('selected')) {
                    return;
                }

                if (parentInput.hasClass(this.options.classes.selectClass)) {
                    parentInput.val(optionId);
                    parentInput.trigger('change');
                } else {
                    elem.trigger('click');
                }
            }, this));
        },

        /**
         * Get default options values settings with either URL query parameters
         * @private
         */
        _getSelectedAttributes: function () {
            var hashIndex = window.location.href.indexOf('#'),
                selectedAttributes = {},
                params;

            if (hashIndex !== -1) {
                params = $.parseQuery(window.location.href.substr(hashIndex + 1));

                selectedAttributes = _.invert(_.mapObject(_.invert(params), function (attributeId) {
                    var attribute = this.options.jsonConfig.mappedAttributes[attributeId];

                    return attribute ? attribute.code : attributeId;
                }.bind(this)));
            }

            /** OX_OLD:
            return selectedAttributes;
            /** OX_START: **/
            return this._ox_getSelectedAttributes(selectedAttributes);
            /** OX_END **/
        },

        /**
         * Callback which fired after gallery gets initialized.
         *
         * @param {HTMLElement} element - DOM element associated with a gallery.
         */
        _onGalleryLoaded: function (element) {
            var galleryObject = element.data('gallery');

            this.options.mediaGalleryInitial = galleryObject.returnCurrentImages();
        },
        /** OX_START: **/
        _ox_create: function () {
            var productData = this._determineProductData(),
                $main = productData.isInProductView ?
                    this.element.parents('.column.main') :
                    this.element.parents('.product-item-info');
            var __image = $main.find('.product-image-photo:not(.product-second-image-photo)');
            this.options.mediaGalleryInitial = [{
                'img': __image.attr('data-original') ? __image.attr('data-original') : __image.attr('src')
            }];
            let __image2 = $main.find('.product-image-photo.product-second-image-photo');
            if (__image2.length) {
                this.options.mediaGalleryInitial.push({
                    'img': __image2.attr('data-original') ? __image2.attr('data-original') : __image2.attr('src'),
                    'isHover': true
                })
            }
        },
        _ox_getSelectedAttributes: function (selectedAttributes) {
            for (let i in this.options.jsonConfig.mappedAttributes) {
                let item = this.options.jsonConfig.mappedAttributes[i];
                if (selectedAttributes.hasOwnProperty(item.code)) {
                    continue;
                }
                if (1 === item.options.length) {
                    let option = item.options[0];
                    selectedAttributes[item.code] = option.id;
                } else if (1 < item.options.length) {
                    let options = item.options.filter((a) => 0 < a.products.length).map((a) => a.id);
                    if (1 === options.length) {
                        selectedAttributes[item.code] = options[0];
                    }
                }
            }
            return selectedAttributes;
        },
        _ox_load_mediaGalleryInitial: function(initialImages, context) {
            if (_.isEqual([{}], initialImages)) {
                let _initialImages = [];
                context.find(this.options.mediaGallerySelector).find('.gallery__item img:not(.zoomImg)').each(function () {
                    let $this = $(this);
                    _initialImages.push({
                        'img': $this.attr('data-original') || $this.attr('src'),
                        'full': $this.data('full'),
                    });
                });
                if (0<_initialImages.length) {
                    this.options.mediaGalleryInitial = initialImages = _initialImages;
                }
            }
            return initialImages;
        },
        _ox_updateBaseImage_without_gallery: function(images, context) {
            var $gallery = context.find(this.options.mediaGallerySelector),
                mgallery = $gallery.data('owl.carousel');
            if (mgallery) {
                $gallery.trigger('toggleDisable.OXmobileNoSlider');
            }
            var new_gallery = context.find(this.options.mediaGallerySelector),
                items = new_gallery.find('.gallery__item'),
                need_lazy = false,
                replace_gallery = new_gallery.hasClass('gallery--with-replace');
            $.each(images, function (index, element) {
                var item = items.eq(index);
                if (replace_gallery) {
                    if (!item.length) {
                        items.last().clone().appendTo(new_gallery);
                        items = new_gallery.find('.gallery__item');
                        item = items.eq(index);
                    }
                    item.addClass('gallery__item-to-display').show();
                }
                let image = item.find('img');
                if ((image.attr('src') == element.img || image.attr('data-original') == element.img || image.data('original') == element.img) && image.data('full') == element.full) {
                    return;
                }
                if (image.data('original')) {
                    image.addClass('lazy').attr({
                        'data-original': element.img,
                    }).data('original', element.img);
                    need_lazy = true;
                } else {
                    image.attr('src', element.img)
                }
                image.data('full', element.full);
            });
            if (replace_gallery) {
                new_gallery.find('.gallery__item').each(function (index) {
                    $(this).find('img').data('index', index);
                });
                items.filter(':not(.gallery__item-to-display)').remove();
                items.removeClass('gallery__item-to-display');
            }
            if (need_lazy) {
                $('body').trigger('contentUpdated.oxlazy');
            }

            if (mgallery) {
                $gallery.trigger('toggleEnable.OXmobileNoSlider');
            }
            $('body').trigger('contentUpdated');
        },
        _ox_updateBaseImage_listing: function (context, justAnImage, hoverAnImage) {
            let first = context.find('.product-image-photo:not(.product-second-image-photo)');
            if (!first.length) {
                first = context.find('img:first');
            }
            /* OX_START for thumb carousel */
            if(first.length > 1 && first.hasClass('product-thumb-image-photo')){
                first.addClass('hide').removeClass('show');
                first = $(first[0]);
                first.addClass('show').removeClass('hide');
            }
            /* OX_END */
            first.attr({
                'src': justAnImage.resized || justAnImage.img,
                'data-original': justAnImage.resized || justAnImage.img
            });
            if (hoverAnImage && hoverAnImage.img) {
                if (!context.find('.product-image-photo.product-second-image-photo').length) {
                    let second = first.clone().removeClass('product-first-image-photo').addClass('product-second-image-photo');
                    first.addClass('product-first-image-photo').after(second);
                    first.closest('.product-image-container').eq(0).addClass('ox-product-hover-image-container');
                }

                context.find('.product-image-photo.product-second-image-photo').attr({
                    'src': hoverAnImage.resized || hoverAnImage.img,
                    'data-original': hoverAnImage.resized || hoverAnImage.img
                });
            } else {
                context.find('.product-image-photo.product-second-image-photo').remove();
                first
                .removeClass('product-first-image-photo')
                .closest('.product-image-container')
                .eq(0)
                .removeClass('ox-product-hover-image-container');
            }
        },
        _ox_setPreSelectedGallery: function () {
            var mediaCallData;

            if (this.options.jsonConfig.preSelectedGallery && this.options.jsonConfig.preSelectedId) {
                mediaCallData = {
                    'product_id': this.options.jsonConfig.preSelectedId
                };
                this.options.mediaCache[JSON.stringify(mediaCallData)] = this.options.jsonConfig.preSelectedGallery;
            }
        },
        /** OX_END **/

        /**
         * Sets mediaCache for cases when jsonConfig contains preSelectedGallery on layered navigation result pages
         *
         * @private
         */
        _setPreSelectedGallery: function () {
            return this._ox_setPreSelectedGallery();
            var mediaCallData;

            if (this.options.jsonConfig.preSelectedGallery) {
                mediaCallData = {
                    'product_id': this.getProduct()
                };

                this.options.mediaCache[JSON.stringify(mediaCallData)] = this.options.jsonConfig.preSelectedGallery;
            }
        },

        /**
         * Callback for quantity change event.
         */
        _onQtyChanged: function () {
            var $price = this.element.parents(this.options.selectorProduct)
                .find(this.options.selectorProductPrice);

            $price.trigger(
                'updatePrice',
                {
                    'prices': this._getPrices(this._getNewPrices(), $price.priceBox('option').prices)
                }
            );
        }
    });

    return $.mage.SwatchRenderer;
});
