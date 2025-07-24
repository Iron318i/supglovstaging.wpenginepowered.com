(function ($) {
    "use strict";

    $.fn.changeElementType = function (newType) {
        var attrs = {};

        $.each(this[0].attributes, function (idx, attr) {
            attrs[attr.nodeName] = attr.nodeValue;
        });

        this.replaceWith(function () {
            return $("<" + newType + "/>", attrs).append($(this).contents());
        });
    };


    class SGFilter {
        #isInitiated = false;
        #filterID = null;
        #filter = null;
        #searchInput = null;
        #searchLabel = null;
        #topicsDropdown = null;
        #topicsDropdownTitle = null;
        #topicInputs = null;
        #languagesDropdown = null;
        #languagesDropdownTitle = null;
        #languageInputs = null;
        #navItemsToWatch = null;
        #navItemLinksToWatch = null;
        #resetButton = null;
        #resetIsActive = null;
        #content = null;
        #contentToggle = null;
        #resourceSections = null;
        #fieldsState = {
            search: null,
            sanitized_search: null,
            topic: null,
            language: null,
        };
        #fieldsNewState = {
            search: null,
            sanitized_search: null,
            topic: null,
            language: null,
        };
        #defaultLanguage = '';

        constructor($filterElement, filterElementID, $resourceSectionElements) {
            this.#filterID = (filterElementID ? filterElementID.trim() : null);
            this.#filter = ($filterElement.length ? $filterElement : null);
            this.#resourceSections = ($resourceSectionElements.length ? $resourceSectionElements : null);
            let _this = this;

            if (!this.#filter || !this.#filterID || !this.#resourceSections) return;

            this.#searchInput = this.#filter.find('input[name="' + this.#filterID + '_sg_filter_search"]');
            if (!this.#searchInput.length) this.#searchInput = null;

            this.#topicInputs = this.#filter.find('.sg-filter-form__radio--topic');
            if (!this.#topicInputs.length) this.#topicInputs = null;

            this.#languageInputs = this.#filter.find('.sg-filter-form__radio--language');
            if (!this.#languageInputs.length) {
                this.#languageInputs = null;
            } else {
                let defaultLanguageInput = this.#filter.find('#' + this.#filterID + '_sg_filter_language_default');

                if (defaultLanguageInput.length) {
                    this.#defaultLanguage = defaultLanguageInput.val();
                }
            }

            let typeNavItems = this.#filter.find('.sg-filter-form__menu .menu-item');
            if (typeNavItems.length) {
                _this.#navItemsToWatch = [];
                _this.#navItemLinksToWatch = [];

                typeNavItems.each(function () {
                    let navItem = $(this),
                        navItemClasses = navItem.get(0).className.split(' '),
                        typeSlug = '';

                    if (!navItemClasses.length) return;

                    for (let i = 0; i < navItemClasses.length; i++) {
                        if (navItemClasses[i] !== '' && navItemClasses[i].indexOf('sg_type_') === 0) {
                            typeSlug = navItemClasses[i].slice(8);
                        }
                    }

                    if (typeSlug != '') {
                        navItem.attr('data-type', typeSlug);
                        navItem.data('type', typeSlug);

                        _this.#navItemsToWatch.push(navItem);

                        let navItemLink = navItem.children('a');

                        if (navItemLink.length) {
                            navItemLink = navItemLink.first();

                            let navItemLinkHref = navItemLink.attr('href');

                            if (
                                typeof navItemLinkHref !== 'undefined' && navItemLinkHref !== false &&
                                navItemLinkHref !== '' && navItemLinkHref.indexOf('#') !== 0
                            ) {
                                _this.#navItemLinksToWatch.push(navItemLink);
                            }
                        }
                    }
                });

                if (!this.#navItemsToWatch.length) this.#navItemsToWatch = null;
                if (!this.#navItemLinksToWatch.length) this.#navItemLinksToWatch = null;
            }

            this.#content = this.#filter.find('.sg-filter-form__filters');
            if (!this.#content.length) {
                this.#content = null;
            } else {
                this.#contentToggle = this.#filter.find('.sg-filter-form__filters-toggle');
                if (!this.#contentToggle.length) {
                    this.#contentToggle = null;

                    if (!this.#content.hasClass('sg-filter-form__filters--open')) {
                        this.#content.addClass('sg-filter-form__filters--open');
                        this.#content = null;
                    }
                }
            }

            if (!this.#searchInput && !this.#topicInputs && !this.#languageInputs && !this.#navItemsToWatch) {
                if (this.#content && this.#contentToggle) {
                    this.#content.remove();
                    this.#contentToggle.remove();

                    this.#content = null;
                    this.#contentToggle = null;
                }

                return;
            }

            if (this.#searchInput) {
                this.#searchLabel = this.#searchInput.parent().find('.sg-filter-form__label--search');
                if (!this.#searchLabel.length) this.#searchLabel = null;
            }

            this.#topicsDropdown = this.#filter.find('.sg-filter-form__dropdown--topic');
            if (!this.#topicsDropdown.length) {
                this.#topicsDropdown = null;
            } else {
                this.#topicsDropdownTitle = this.#topicsDropdown.find('.sg-filter-form__legend-text--topic');

                if (!this.#topicsDropdownTitle.length) this.#topicsDropdownTitle = null;
            }

            this.#languagesDropdown = this.#filter.find('.sg-filter-form__dropdown--language');
            if (!this.#languagesDropdown.length) {
                this.#languagesDropdown = null;
            } else {
                this.#languagesDropdownTitle = this.#languagesDropdown.find('.sg-filter-form__legend-text--language');

                if (!this.#languagesDropdownTitle.length) this.#languagesDropdownTitle = null;
            }

            this.#isInitiated = true;

            this.#updateNewFieldsState('all');
            this.#fieldsState = {...this.#fieldsNewState};

            this.#resetButton = this.#filter.find('.sg-filter-form__button--reset');
            if (!this.#resetButton.length) {
                this.#resetButton = null;
            } else {
                this.#resetIsActive = false;

                this.#updateResetState();
            }

            if (this.#navItemLinksToWatch.length) {
                this.#updateNavLinks();
            }

            if (
                this.#navItemsToWatch.length && (this.#fieldsNewState.sanitized_search || this.#fieldsNewState.topic || this.#fieldsNewState.language) &&
                sg_ajax_data && typeof sg_ajax_data === 'object' && sg_ajax_data.hasOwnProperty('ajax_url') && sg_ajax_data.ajax_url
            ) {
                this.#performLinksStateRequest();
            }

            let currentURL = new URL(window.location.href);

            if (currentURL.searchParams.has('sg_filter_topic')) {
                currentURL.searchParams.delete('sg_filter_topic');
            }

            if (currentURL.searchParams.has('sg_filter_language')) {
                currentURL.searchParams.delete('sg_filter_language');
            }

            if (currentURL.searchParams.has('sg_filter_search')) {
                currentURL.searchParams.delete('sg_filter_search');
            }

            window.history.replaceState({}, document.title, currentURL.toString());

            let activeMenuItems = this.#filter.find('details .current-menu-item');
            if (activeMenuItems.length) {
                activeMenuItems.each(function () {
                    let parentDetails = $(this).parents('details');

                    if (parentDetails.length) {
                        parentDetails.prop('open', true);
                    }
                });
            }

            this.#initListeners();
        }

        get isInitiated() {
            return this.#isInitiated;
        }

        #updateNewFieldsState(fieldName) {
            if (!this.#isInitiated) return;

            let fields = ['all', 'search', 'topic', 'language'];

            if (!fields.includes(fieldName)) return;

            if ((fieldName === 'all' || fieldName === 'search') && this.#searchInput) {
                this.#fieldsNewState.search = this.#searchInput.val();

                if (this.#fieldsNewState.search) {
                    this.#fieldsNewState.sanitized_search = this.#fieldsNewState.search.replace(/[^\p{L}\p{N} \.,_-]+/gu, '');
                } else {
                    this.#fieldsNewState.search = null;
                    this.#fieldsNewState.sanitized_search = null;
                }
            }

            if ((fieldName === 'all' || fieldName === 'topic') && this.#topicInputs) {
                let selectedTopic = this.#filter.find('input[name="' + this.#filterID + '_sg_filter_topic"]:checked');

                if (selectedTopic.length) {
                    this.#fieldsNewState.topic = selectedTopic.val();

                    if (!this.#fieldsNewState.topic) this.#fieldsNewState.topic = null;

                    if (this.#topicsDropdownTitle.length) {
                        let selectedTopicLabel = selectedTopic.parent().children('.sg-filter-form__label--topic'),
                            selectedTopicLabelText = '';

                        if (selectedTopicLabel.length) {
                            selectedTopicLabel = selectedTopicLabel.first();
                            selectedTopicLabelText = selectedTopicLabel.data('text');

                            if (selectedTopicLabelText) {
                                this.#topicsDropdownTitle.text(selectedTopicLabelText);
                            }
                        }
                    }
                }
            }

            if ((fieldName === 'all' || fieldName === 'language') && this.#languageInputs) {
                let selectedLanguage = this.#filter.find('input[name="' + this.#filterID + '_sg_filter_language"]:checked');

                if (selectedLanguage.length) {
                    this.#fieldsNewState.language = selectedLanguage.val();

                    if (!this.#fieldsNewState.language) this.#fieldsNewState.language = null;

                    if (this.#languagesDropdownTitle.length) {
                        let selectedLanguageLabel = selectedLanguage.parent().children('.sg-filter-form__label--language'),
                            selectedLanguageLabelText = '';

                        if (selectedLanguageLabel.length) {
                            selectedLanguageLabel = selectedLanguageLabel.first();
                            selectedLanguageLabelText = selectedLanguageLabel.data('text');

                            if (selectedLanguageLabelText) {
                                this.#languagesDropdownTitle.text(selectedLanguageLabelText);
                            }
                        }
                    }
                }
            }
        }

        #updateResetState() {
            if (!this.#isInitiated || !this.#resetButton) return;

            if (
                !this.#resetButton.hasClass('sg-filter-form__button--active') &&
                (
                    (this.#fieldsNewState.search !== null && this.#fieldsNewState.search != '') ||
                    (this.#fieldsNewState.topic !== null && this.#fieldsNewState.topic != '') ||
                    (this.#fieldsNewState.language !== null && this.#fieldsNewState.language != '' && this.#fieldsNewState.language != this.#defaultLanguage)
                )
            ) {
                this.#resetButton.addClass('sg-filter-form__button--active');
                this.resetIsActive = true;
            } else if (
                this.#resetButton.hasClass('sg-filter-form__button--active') &&
                (this.#fieldsNewState.search === null || this.#fieldsNewState.search === '') &&
                (this.#fieldsNewState.topic === null || this.#fieldsNewState.topic === '') &&
                (this.#fieldsNewState.language === null || this.#fieldsNewState.language === '' || this.#fieldsNewState.language == this.#defaultLanguage)
            ) {
                this.resetIsActive = false;
                this.#resetButton.removeClass('sg-filter-form__button--active');
            }
        }

        #updateNavLinks() {
            if (!this.#isInitiated || !this.#navItemLinksToWatch.length) return;

            let _this = this;

            this.#navItemLinksToWatch.forEach(function (navItemLink) {
                let navItemURL = new URL(navItemLink.attr('href'));

                if (_this.#fieldsState.topic) {
                    navItemURL.searchParams.set('sg_filter_topic', encodeURIComponent(_this.#fieldsState.topic));
                } else if (navItemURL.searchParams.has('sg_filter_topic')) {
                    navItemURL.searchParams.delete('sg_filter_topic');
                }

                if (_this.#fieldsState.language) {
                    navItemURL.searchParams.set('sg_filter_language', encodeURIComponent(_this.#fieldsState.language));
                } else if (navItemURL.searchParams.has('sg_filter_language')) {
                    navItemURL.searchParams.delete('sg_filter_language');
                }

                if (_this.#fieldsState.sanitized_search) {
                    navItemURL.searchParams.set('sg_filter_search', encodeURIComponent(_this.#fieldsState.sanitized_search));
                } else if (navItemURL.searchParams.has('sg_filter_search')) {
                    navItemURL.searchParams.delete('sg_filter_search');
                }

                navItemLink.attr('href', navItemURL.toString());
            });
        }

        #updateNavState(typeSlugs) {
            if (!this.#isInitiated || !this.#navItemsToWatch.length) return;

            this.#navItemsToWatch.forEach(function (navItem) {
                if (typeSlugs && typeSlugs.length) {
                    if (!typeSlugs.includes(navItem.data('type')) && navItem.data('type') != 'all') {
                        navItem.addClass('menu-item--disabled');
                    } else {
                        navItem.removeClass('menu-item--disabled');
                    }
                } else if (navItem.data('type') != 'all') {
                    navItem.addClass('menu-item--disabled');
                }
            });
        }

        #performLinksStateRequest() {
            if (!this.#isInitiated || !this.#navItemsToWatch) return;

            let _this = this;

            const typeLinksStatePerformCheckup = (filter_obj) => {
                $.ajax({
                    url: sg_ajax_data.ajax_url,
                    method: "POST",
                    dataType: 'json',
                    data: {
                        action: 'sg_resources_filter_get_active_types_for_nav_by_ajax',
                        'filter_search': filter_obj.#fieldsNewState.sanitized_search,
                        'filter_topic': filter_obj.#fieldsNewState.topic,
                        'filter_language': filter_obj.#fieldsNewState.language,
                    },
                })
                    .done(function (response) {
                        // the request was successful
                        //console.log(response);
                        /*if (response.hasOwnProperty('log') && Array.isArray(response.log)) {
                          response.log.forEach((element) => console.log(element));
                        }*/

                        if (response && typeof response === 'object') {
                            if (response.hasOwnProperty('typeSlugs')) {
                                // the request went fine and the response is good, enable/disable/modify type links
                                if (Array.isArray(response.typeSlugs) && response.typeSlugs.length) {
                                    filter_obj.#updateNavState(response.typeSlugs);
                                } else {
                                    filter_obj.#updateNavState(null);
                                }

                            } else {
                                // one of the functions in the php callback returned erroneous result or something else
                                console.log('sg_resources_filter_get_types_for_topic_by_ajax: missing typePostsCount key');
                                filter_obj.#updateNavState(null);
                            }
                        } else {
                            // wrong response type
                            console.log('sg_resources_filter_get_types_for_topic_by_ajax: wrong response type');
                        }
                    })
                    .fail(function (xhr) {
                        // the request was not performed, uncomment logging to debug
                        console.log('sg_resources_filter_get_types_for_topic_by_ajax: error during request');
                        console.log(xhr);
                    })
                    .always(function () {
                        // activate the filter
                        if (filter_obj.#filter.hasClass('sg-resources-filter--inactive')) {
                            filter_obj.#filter.removeClass('sg-resources-filter--inactive');
                        }

                        // publish event
                        sgPublish('sgResourcesInitialTypeLinksStateCheckupPerformed', {
                            filterID: filter_obj.#filterID
                        });
                    });
            }

            typeLinksStatePerformCheckup(_this);
        }

        #performFiltering() {
            console.log('[SGFilter] #performFiltering triggered');
            console.log('[SGFilter] Checking if filtering should happen:', {
                old: this.#fieldsState,
                new: this.#fieldsNewState
            });
            if (
                !this.#isInitiated ||
                (
                    this.#fieldsState.search === this.#fieldsNewState.search &&
                    this.#fieldsState.topic === this.#fieldsNewState.topic &&
                    this.#fieldsState.language === this.#fieldsNewState.language
                )
            ) return;

            let $weglotLink = null;

            if (this.#fieldsState.language !== this.#fieldsNewState.language) {
                if (this.#fieldsNewState.language == 'english') {
                    $weglotLink = $('.weglot-dropdown .weglot-language-en');
                } else if (this.#fieldsNewState.language == 'french') {
                    $weglotLink = $('.weglot-dropdown .weglot-language-fr');
                } else if (this.#fieldsNewState.language == 'spanish') {
                    $weglotLink = $('.weglot-dropdown .weglot-language-es');
                } else if (this.#fieldsNewState.language == 'portuguese-br') {
                    $weglotLink = $('.weglot-dropdown .weglot-language-pt-br');
                }
            }

            if ($weglotLink && $weglotLink.length) {
                /*
                let weglotClick = new Event('click', {bubbles: true, cancelable: true});
                $weglotLink.get(0).dispatchEvent(weglotClick);
                 */
                window.location.href = $weglotLink.attr('href');
            } else {
                if (sg_ajax_data && typeof sg_ajax_data === 'object' && sg_ajax_data.hasOwnProperty('ajax_url') && sg_ajax_data.ajax_url) {
                    // deactivate the filter
                    this.#filter.addClass('sg-resources-filter--inactive');

                    if (this.#topicsDropdown && (this.#topicsDropdown.attr('open') || this.#topicsDropdown.prop('open'))) {
                        this.#topicsDropdown.attr('open', '');
                        this.#topicsDropdown.prop('open', false);
                    }

                    let _this = this,
                        sectionCallbacks = 0,
                        sectionCallbacksDone = 0,
                        reset = false;

                    if (!_this.#fieldsNewState.sanitized_search && !_this.#fieldsNewState.topic && !_this.#fieldsNewState.language) {
                        reset = true;
                    }

                    const resetC = reset;

                    _this.#resourceSections.each(function () {
                        const sectionC = $(this);

                        let container = sectionC.find('.sg-resources-container'),
                            overlay = sectionC.find('.sg-resources-overlay');

                        if (!container.length) {
                            container = sectionC;
                            overlay = null;
                        }

                        const containerC = container,
                            overlayC = overlay;

                        // activate overlay
                        if (overlayC && overlayC.length && !overlayC.hasClass('sg-resources-overlay--active')) {
                            overlayC.addClass('sg-resources-overlay--active');
                        }

                        const performRequest = (filter_obj, section, container, overlay, toReset) => {
                            $.ajax({
                                url: sg_ajax_data.ajax_url,
                                method: "POST",
                                dataType: 'json',
                                data: {
                                    action: 'sg_resources_filter_results_by_ajax',
                                    [filter_obj.#filterID + '_sg_filter_search']: filter_obj.#fieldsNewState.sanitized_search,
                                    [filter_obj.#filterID + '_sg_filter_topic']: filter_obj.#fieldsNewState.topic,
                                    [filter_obj.#filterID + '_sg_filter_language']: filter_obj.#fieldsNewState.language,
                                    'sg_filter_atts': {
                                        'filter_id': filter_obj.#filterID,
                                        'post_types': section.data('post_types'),
                                        'types': section.data('types'),
                                        'exclude_types': section.data('exclude_types'),
                                        'topics': section.data('topics'),
                                        'default_language': section.data('default_language'),
                                        'posts_number': section.data('posts_number'),
                                        'featured_posts': (toReset ? section.data('featured_posts') : null),
                                        'featured_links': (toReset ? section.data('featured_links') : null),
                                        'load_subtypes': section.data('load_subtypes'),
                                        'hide_empty_subtypes': (toReset ? section.data('hide_empty_subtypes') : 1),
                                        'load_top_types': section.data('load_top_types'),
                                        'hide_empty_top_types': (toReset ? section.data('hide_empty_top_types') : 1),
                                        'orderby': section.data('orderby'),
                                        'order': section.data('order'),
                                        'layout': section.data('layout'),
                                        'type_layout': section.data('type_layout'),
                                        'hide_tags': section.data('hide_tags'),
                                        'load_type_tags': section.data('load_type_tags'),
                                        'post_link_text': section.data('post_link_text'),
                                        'show_post_link_arrow': section.data('show_post_link_arrow'),
                                        'hide_section_heading': section.data('hide_section_heading'),
                                        'section_heading': section.data('section_heading'),
                                        'section_link': section.data('section_link'),
                                        'section_link_text': section.data('section_link_text'),
                                        'not_found_text': section.data('not_found_text'),
                                        'id': section.attr('id'),
                                        'class': section.data('section_class'),
                                    },
                                },
                            })
                                .done(function (response) {
                                    // the request was successful
                                    //console.log(response);
                                    /*if (response.hasOwnProperty('log') && Array.isArray(response.log)) {
                                      response.log.forEach((element) => console.log(element));
                                    }*/

                                    if (response && typeof response === 'object') {
                                        if (response.hasOwnProperty('result_html')) {
                                            // the request went fine and the response is good, print the results

                                            let rootParent = section.closest('.sg-resources');
                                            let postsAreEmpty = false,
                                                subtypesAreEmpty = false,
                                                toptypesAreEmpty = false;

                                            if (response.hasOwnProperty('posts_are_empty') && response.posts_are_empty == 1) {
                                                postsAreEmpty = true;
                                            }

                                            if (response.hasOwnProperty('subtypes_are_empty') && response.subtypes_are_empty == 1) {
                                                subtypesAreEmpty = true;
                                            }

                                            if (response.hasOwnProperty('top_types_are_empty') && response.top_types_are_empty == 1) {
                                                toptypesAreEmpty = true;
                                            }

                                            if (rootParent.length) {
                                                if (postsAreEmpty && !rootParent.hasClass('sg-resources--no-posts')) {
                                                    rootParent.addClass('sg-resources--no-posts');
                                                } else if (!postsAreEmpty && rootParent.hasClass('sg-resources--no-posts')) {
                                                    rootParent.removeClass('sg-resources--no-posts');
                                                }

                                                if (subtypesAreEmpty && !rootParent.hasClass('sg-resources--no-subtypes')) {
                                                    rootParent.addClass('sg-resources--no-subtypes');
                                                } else if (!subtypesAreEmpty && rootParent.hasClass('sg-resources--no-subtypes')) {
                                                    rootParent.removeClass('sg-resources--no-subtypes');
                                                }

                                                if (toptypesAreEmpty && !rootParent.hasClass('sg-resources--no-toptypes')) {
                                                    rootParent.addClass('sg-resources--no-toptypes');
                                                } else if (!toptypesAreEmpty && rootParent.hasClass('sg-resources--no-toptypes')) {
                                                    rootParent.removeClass('sg-resources--no-toptypes');
                                                }

                                                if (postsAreEmpty && subtypesAreEmpty && toptypesAreEmpty && !rootParent.hasClass('sg-resources--empty')) {
                                                    rootParent.addClass('sg-resources--empty');
                                                    rootParent.changeElementType('SECTION');
                                                } else if ((!postsAreEmpty || !subtypesAreEmpty || !toptypesAreEmpty) && rootParent.hasClass('sg-resources--empty')) {
                                                    rootParent.removeClass('sg-resources--empty');
                                                    rootParent.changeElementType('DIV');
                                                }
                                            }

                                            container.html(response.result_html);
                                        } else {
                                            // one of the functions in the php callback returned erroneous result or something else
                                            console.log('sg_resources_filter_results_by_ajax: missing result_html key');
                                        }
                                    } else {
                                        // wrong response type
                                        console.log('sg_resources_filter_results_by_ajax: wrong response type');
                                    }
                                })
                                .fail(function (xhr) {
                                    // the request was not performed, uncomment logging to debug
                                    console.log('sg_resources_filter_results_by_ajax: error during request');
                                    console.log(xhr);
                                })
                                .always(function () {
                                    sectionCallbacks++;

                                    // deactivate overlay
                                    if (overlay && overlay.length && overlay.hasClass('sg-resources-overlay--active')) {
                                        overlay.removeClass('sg-resources-overlay--active');
                                    }

                                    // activate the filter
                                    if ((sectionCallbacks >= filter_obj.#resourceSections.length)) {
                                        let isReset = false;

                                        filter_obj.#fieldsState = {...filter_obj.#fieldsNewState};

                                        if (filter_obj.#resetButton) filter_obj.#updateResetState();

                                        if (
                                            (filter_obj.#fieldsState.search === null || filter_obj.#fieldsState.search === '') &&
                                            (filter_obj.#fieldsState.topic === null || filter_obj.#fieldsState.topic === '') &&
                                            (
                                                filter_obj.#fieldsState.language === null ||
                                                filter_obj.#fieldsState.language === '' ||
                                                filter_obj.#fieldsState.language === filter_obj.#defaultLanguage
                                            )
                                        ) {
                                            isReset = true;
                                        }

                                        if (filter_obj.#navItemLinksToWatch.length) {
                                            filter_obj.#updateNavLinks();
                                        }

                                        if (filter_obj.#filter.hasClass('sg-resources-filter--inactive')) {
                                            filter_obj.#filter.removeClass('sg-resources-filter--inactive');
                                        }

                                        // publish event
                                        sgPublish('sgResourcesFiltrationPerformed', {
                                            filterID: filter_obj.#filterID,
                                            isReset: isReset
                                        });
                                    }
                                });
                        };

                        performRequest(_this, sectionC, containerC, overlayC, resetC);
                    });

                    if (_this.#navItemsToWatch.length) {
                        _this.#performLinksStateRequest();
                    }
                } else {
                    this.#filter.submit();
                }
            }
        }

        #initListeners() {
            let _this = this;

            if (!this.#isInitiated) return;

            if (this.#searchInput) {
                this.#searchInput.on('change', function () {
                    _this.#updateNewFieldsState('search');

                    if (!_this.#searchLabel && _this.#fieldsNewState.search.length > 3) {
                        _this.#performFiltering();
                    }
                });

                this.#searchInput.keypress(function (event) {
                    if (event.which == 13) {
                        _this.#updateNewFieldsState('search');
                        _this.#performFiltering();

                        return false;
                    }
                });

                if (this.#searchLabel) {
                    this.#searchLabel.on('click', function () {
                        _this.#updateNewFieldsState('search');
                        _this.#performFiltering();
                    });
                }
            }

            if (this.#topicInputs) {
                this.#topicInputs.on('change', function () {
                    _this.#updateNewFieldsState('topic');
                    _this.#performFiltering();

                    if (_this.#topicsDropdown) {
                        _this.#topicsDropdown.attr('open', '');
                        _this.#topicsDropdown.prop('open', false);
                    }
                });
            }

            if (this.#topicsDropdown) {
                this.#topicsDropdown.on('mouseleave', function (e) {
                    _this.#topicsDropdown.attr('open', '');
                    _this.#topicsDropdown.prop('open', false);
                });
            }

            if (this.#languageInputs) {
                this.#languageInputs.on('change', function () {
                    _this.#updateNewFieldsState('language');
                    console.log('[SGFilter] Language changed to:', _this.#fieldsNewState.language);
                    _this.#performFiltering();

                    if (_this.#languagesDropdown) {
                        _this.#languagesDropdown.attr('open', '');
                        _this.#languagesDropdown.prop('open', false);
                    }
                });
            }

            if (this.#languagesDropdown) {
                this.#languagesDropdown.on('mouseleave', function () {
                    _this.#languagesDropdown.attr('open', '');
                    _this.#languagesDropdown.prop('open', false);
                });
            }

            if (this.#resetButton) {
                this.#resetButton.on('click', function (event) {
                    event.preventDefault();

                    if (!_this.resetIsActive) return;

                    if (_this.#searchInput) {
                        _this.#searchInput.attr('value', '');
                        _this.#searchInput.val('');
                    }

                    if (_this.#topicInputs) {
                        let selectedTopic = _this.#filter.find('input[name="' + _this.#filterID + '_sg_filter_topic"]:checked');

                        if (selectedTopic.length) {
                            selectedTopic.prop('checked', false);
                        }

                        let allTopicsInput = _this.#filter.find('input[name="' + _this.#filterID + '_sg_filter_topic"][value=""]');

                        if (allTopicsInput.length && !allTopicsInput.prop('checked')) {
                            allTopicsInput.prop('checked', true);
                        }
                    }

                    if (_this.#languageInputs) {
                        let selectedLanguage = _this.#filter.find('input[name="' + _this.#filterID + '_sg_filter_language"]:checked');

                        if (selectedLanguage.length) {
                            selectedLanguage.prop('checked', false);
                        }

                        let defaultLanguageInput = _this.#filter.find('#' + _this.#filterID + '_sg_filter_language_default');

                        if (defaultLanguageInput.length && !defaultLanguageInput.prop('checked')) {
                            defaultLanguageInput.prop('checked', true);
                        }
                    }

                    _this.#updateNewFieldsState('all');
                    _this.#performFiltering();
                });
            }

            if (this.#content && this.#contentToggle) {
                this.#contentToggle.on('click', function () {
                    _this.#contentToggle.toggleClass('sg-filter-form__filters-toggle--open');
                    _this.#content.toggleClass('sg-filter-form__filters--open');
                });
            }
        }
    }


    function initGalleryMobileNav() {
        const $singleProdGalleryNavDots = $(
            ".single-product.woocommerce div.product.supro-product-layout-2 .woocommerce-product-gallery .flex-control-thumbs.no-slick li"
        );

        if ($singleProdGalleryNavDots.length) {
            $singleProdGalleryNavDots.first().addClass("flex-active");
        }

        $(document).on(
            "click touchend",
            ".single-product.woocommerce div.product.supro-product-layout-2 .woocommerce-product-gallery .flex-control-thumbs.no-slick li",
            function () {
                var $thisDot = $(this);
                var $otherActiveDots = $thisDot.parent().children(".flex-active");

                if ($otherActiveDots.length) {
                    $otherActiveDots.removeClass("flex-active");
                }

                $thisDot.addClass("flex-active");
            }
        );
    }


    function initResourcesFilter() {
        const $filterElements = $('.sg-filter-form');
        let filters = [];

        if ($filterElements.length) {
            $filterElements.each(function () {
                const $this = $(this);
                let filterID = $this.attr('id'),
                    $resourceSections = null,
                    filterObject = null;

                if (!filterID) return;

                $resourceSections = $('.sg-resources-section[data-filter="' + filterID + '"]');

                if (!$resourceSections.length) return;

                filterObject = new SGFilter($this, filterID, $resourceSections);

                if (filterObject.isInitiated) {
                    filters.push(filterObject);
                }
            });
        }

        return filters;
    }


    function equalizeProductDescriptionHeights($featuredProductDescriptions, $highestDescription) {
        $featuredProductDescriptions.each(function () {
            let $description = $(this);

            if ($description.get(0) !== $highestDescription.get(0)) {
                $description.height($highestDescription.innerHeight());
            }
        });
    }


    function initNewProductHeightsEqualizier() {
        const $newProductsSections = $('.sg-new-products--layout-columns');

        if (!$newProductsSections.length) {
            return;
        }

        $newProductsSections.each(function () {
            const $newProductsSection = $(this);
            const $featuredProductDescriptions = $newProductsSection.find('.sg-featured-product__short-description');
            let $highestDescription, biggestHeight, resizeTimeout;

            if (!$featuredProductDescriptions.length || $featuredProductDescriptions.length < 2) {
                return;
            }

            $highestDescription = $featuredProductDescriptions.first();
            biggestHeight = $highestDescription.innerHeight();

            $(window).on("load", function () {
                $featuredProductDescriptions.each(function () {
                    let $description = $(this);
                    let descriptionHeight = $description.innerHeight();

                    if (descriptionHeight > biggestHeight) {
                        biggestHeight = descriptionHeight;
                        $highestDescription = $description;
                    }
                });

                equalizeProductDescriptionHeights($featuredProductDescriptions, $highestDescription);

                $(window).on("resize", function () {
                    clearTimeout(resizeTimeout);

                    resizeTimeout = setTimeout(function () {
                        equalizeProductDescriptionHeights($featuredProductDescriptions, $highestDescription);
                    }, 200);
                });
            });
        });
    }


    function hideEmptySizeInputsInCheckout() {
        const $firstInput = $('.thwmsc-tab-panel.info_contact #product_1_sizing_value_field');
        const $secondInput = $('.thwmsc-tab-panel.info_contact #product_2_sizing_value_field');
        const $thirdInput = $('.thwmsc-tab-panel.info_contact #product_3_sizing_value_field');
        const $cartItems = $('.thwmsc-tab-panel.info_contact .woocommerce-checkout-review-order-table .cart_item');

        if (!$firstInput.length || !$secondInput.length || !$thirdInput.length || !$cartItems.length)
            return;

        if ($secondInput.length && $cartItems.length < 2) {
            $secondInput.addClass('hidden');
        }

        if ($thirdInput.length && $cartItems.length < 3) {
            $thirdInput.addClass('hidden');
        }
    }


    function handleMultistepCF7() {
        let actionNext = $('#action-next');

        if (actionNext.length) {
            actionNext.click(function () {
                var bussinesEmailInput = $('input[name="business_email_input"]');
                var secondaryEmailInput = $('input[name="secondary_email_input"]');
                var productEmailField = $('input[name="billing_email"]');

                if (bussinesEmailInput.length && productEmailField.length) {
                    var productBrandValue = productEmailField.val(bussinesEmailInput.val());
                } else if (secondaryEmailInput.length && productEmailField.length) {
                    var productBrandValue = productEmailField.val(secondaryEmailInput.val());
                }

                var countryUserS = $('select[name="location_safety_pro_value"]').val();
                var countryUserD = $('select[name="location_distributor_value"]').val();

                var countryUserN = $('select[name="billing_country"], [name="shipping_country"]');

                if (countryUserS.length) {
                    var countrySafeChanged = countryUserN.val(countryUserS);
                } else if (countryUserD.length && countryUserN.length) {
                    var countryDistChanged = countryUserN.val(countryUserD);
                }
            });
        }

        let $contactForms7 = $('.wpcf7-form');

        if ($contactForms7.length) {
            // if there are more than 1 form on a page
            $contactForms7.each(function () {
                let $contactForm = $(this);
                let $nextActionButtons = $contactForm.find('.cf7mls_next'); // all Next buttons

                if ($nextActionButtons.length) {
                    let $businessEmailInput = $contactForm.find('input[name="b_email_field"]');
                    let $customEmailInput = $contactForm.find('input[name="s_email_field"]');
                    let $workEmailInput = $contactForm.find('input[name="info-w-email"]');

                    $nextActionButtons.each(function () {
                        let $nextButton = $(this);

                        $nextButton.click(function () {
                            let $selectedEmailRadio = $contactForm.find('input[name="radio-email"]:checked');

                            let businessEmail = '';
                            let customEmail = '';
                            let preferredEmail = '';

                            if ($customEmailInput.length) {
                                customEmail = $customEmailInput.val();
                            }

                            if ($businessEmailInput.length) {
                                businessEmail = $businessEmailInput.val();
                            }

                            if ($selectedEmailRadio.length && $selectedEmailRadio.val() == 'Secondary Email' && customEmail) {
                                preferredEmail = customEmail;
                            } else if (businessEmail) {
                                preferredEmail = businessEmail;
                            }

                            let $workEmailWrapper = $workEmailInput.closest('[data-id="error-group-info"]');

                            if ($workEmailWrapper.length && $workEmailWrapper.css('display') == 'block') {
                                $workEmailInput.attr('value', preferredEmail);
                                $workEmailInput.val(preferredEmail);
                            }
                        });
                    });
                }
            });
        }
    }


    // Hide the next button for Sample Box form (Safety professionals Company Size)
    function hideNextbutton() {
        let CF7Next = $('.cf7mls #cf7mls-next-btn-cf7mls_step-2');


        if (CF7Next.length) {
            CF7Next.click(function () {
                var SafetyPSize = $('select[name="size_safety_pr"]');

                if (SafetyPSize.val() == 'Less than 100 employees - not qualified for free samples') {
                    $("#cf7mls-next-btn-cf7mls_step-3").addClass('hidden');
                } else {
                    $("#cf7mls-next-btn-cf7mls_step-3").removeClass('hidden');

                }
            });
        }
    }


    function handleCF7FieldsForSalesforce() {
        let $allCF7Forms = $('.wpcf7-form');

        if (!$allCF7Forms.length) return;

        $allCF7Forms.each(function () {
            let $form = $(this);
            let $combineFields = $form.find('.combine-source');
            let $targetFields = $form.find('.combine-target');

            if (!$combineFields.length || !$targetFields.length) return;

            $combineFields.on('change', function () {
                $targetFields.each(function () {
                    let $field = $(this);
                    let targetName = '';
                    let classList = $field.get(0).className.split(/\s+/);
                    let $targetCombineFields = null;
                    let combinedValues = '';

                    // loop through all class names
                    for (let i = 0; i < classList.length; i++) {
                        if (classList[i].indexOf('combine-target--') === 0) {
                            // get this certain target name
                            targetName = classList[i].substring(16, classList[i].length);
                        }
                    }

                    if (targetName) {
                        // get all source fields associated with this certain target field
                        $targetCombineFields = $form.find('.combine-source.combine-source--' + targetName);
                    } else {
                        // get all source fields not associated with any certain target field
                        $targetCombineFields = $form.find('.combine-source:not([class^="combine-source--"])');
                    }

                    if (!$targetCombineFields.length) return;

                    // sture combined field values
                    $targetCombineFields.each(function () {
                        let $combineField = $(this);
                        let $hiddenWrapper = $combineField.closest('.wpcf7cf-hidden');

                        // if this field is not hidden by conditional rules of the form
                        if (!$hiddenWrapper.length) {
                            combinedValues += $(this).val().trim() + ', ';
                        }
                    });

                    if (combinedValues.length) {
                        combinedValues = combinedValues.trim(); // remove spaces from both ends
                        combinedValues = combinedValues.substring(0, combinedValues.length - 1); // remove last ','
                    }

                    $field.val(combinedValues);
                    $field.attr('value', combinedValues);
                });
            });
        });
    }


    function handleBackToResources() {
        let currentURL = new URL(window.location.href);
        let $backLinks = $('a.back-to-resources');

        if (!$backLinks.lemgth || !currentURL.searchParams.has('sg_filter_language')) {
            return;
        }

        $backLinks.each(function () {
            let $link = $(this);
            let href = $link.attr('href');

            if (href && href.indexOf('#') != 0) {
                let linkURL = new URL(href);

                if (!linkURL.searchParams.has('sg_filter_language')) {
                    linkURL.searchParams.set('sg_filter_language', currentURL.searchParams.get('sg_filter_language'));
                }
            }
        });
    }


    $(window).on("load", function () {
        initGalleryMobileNav();
        initResourcesFilter();
    });
})(jQuery);
