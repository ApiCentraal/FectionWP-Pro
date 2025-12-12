/**
 * Bootstrap Blocks - Editor JavaScript
 *
 * Registreert Bootstrap blocks voor de Gutenberg editor.
 *
 * @package FectionWP_Pro
 * @since 0.2.0
 */

(function (blocks, element, blockEditor, components, i18n) {
    const { registerBlockType } = blocks;
    const { createElement: el, Fragment } = element;
    const { InnerBlocks, InspectorControls, useBlockProps } = blockEditor;
    const { PanelBody, SelectControl, ToggleControl, TextControl, RangeControl } = components;
    const { __ } = i18n;

    // =============================================================================
    // CONTAINER BLOCK
    // =============================================================================
    registerBlockType('fwp/container', {
        title: __('Bootstrap Container', 'fectionwp-pro'),
        icon: 'layout',
        category: 'design',
        description: __('Bootstrap container voor content layout.', 'fectionwp-pro'),
        supports: {
            align: ['wide', 'full'],
            html: false,
        },
        attributes: {
            fluid: { type: 'boolean', default: false },
            breakpoint: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps({
                className: attributes.fluid ? 'is-fluid' : '',
            });

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Container Instellingen', 'fectionwp-pro') },
                        el(ToggleControl, {
                            label: __('Fluid Container', 'fectionwp-pro'),
                            checked: attributes.fluid,
                            onChange: (val) => setAttributes({ fluid: val, breakpoint: '' }),
                        }),
                        !attributes.fluid &&
                            el(SelectControl, {
                                label: __('Max-width Breakpoint', 'fectionwp-pro'),
                                value: attributes.breakpoint,
                                options: [
                                    { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                    { label: 'SM (540px)', value: 'sm' },
                                    { label: 'MD (720px)', value: 'md' },
                                    { label: 'LG (960px)', value: 'lg' },
                                    { label: 'XL (1140px)', value: 'xl' },
                                    { label: 'XXL (1320px)', value: 'xxl' },
                                ],
                                onChange: (val) => setAttributes({ breakpoint: val }),
                            })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        template: [['fwp/row', {}]],
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // ROW BLOCK
    // =============================================================================
    registerBlockType('fwp/row', {
        title: __('Bootstrap Row', 'fectionwp-pro'),
        icon: 'columns',
        category: 'design',
        description: __('Bootstrap row voor kolommen layout.', 'fectionwp-pro'),
        parent: ['fwp/container'],
        supports: {
            html: false,
        },
        attributes: {
            template: { type: 'string', default: '1:1' },
            noGutters: { type: 'boolean', default: false },
            horizontalGutter: { type: 'string', default: '' },
            verticalGutter: { type: 'string', default: '' },
            verticalAlignment: { type: 'string', default: '' },
            horizontalAlignment: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            // Row templates
            const templates = {
                '1:1': [['fwp/column', {}], ['fwp/column', {}]],
                '1:2': [['fwp/column', { sizeMd: '4' }], ['fwp/column', { sizeMd: '8' }]],
                '2:1': [['fwp/column', { sizeMd: '8' }], ['fwp/column', { sizeMd: '4' }]],
                '1:1:1': [['fwp/column', {}], ['fwp/column', {}], ['fwp/column', {}]],
                '1:1:1:1': [['fwp/column', {}], ['fwp/column', {}], ['fwp/column', {}], ['fwp/column', {}]],
                '1': [['fwp/column', { sizeMd: '12' }]],
            };

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Row Instellingen', 'fectionwp-pro') },
                        el(SelectControl, {
                            label: __('Template', 'fectionwp-pro'),
                            value: attributes.template,
                            options: [
                                { label: '1 Kolom', value: '1' },
                                { label: '2 Kolommen (1:1)', value: '1:1' },
                                { label: '2 Kolommen (1:2)', value: '1:2' },
                                { label: '2 Kolommen (2:1)', value: '2:1' },
                                { label: '3 Kolommen', value: '1:1:1' },
                                { label: '4 Kolommen', value: '1:1:1:1' },
                            ],
                            onChange: (val) => setAttributes({ template: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Geen Gutters', 'fectionwp-pro'),
                            checked: attributes.noGutters,
                            onChange: (val) => setAttributes({ noGutters: val }),
                        }),
                        !attributes.noGutters &&
                            el(
                                Fragment,
                                null,
                                el(SelectControl, {
                                    label: __('Horizontale Gutter', 'fectionwp-pro'),
                                    value: attributes.horizontalGutter,
                                    options: [
                                        { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                        { label: '0', value: '0' },
                                        { label: '1', value: '1' },
                                        { label: '2', value: '2' },
                                        { label: '3', value: '3' },
                                        { label: '4', value: '4' },
                                        { label: '5', value: '5' },
                                    ],
                                    onChange: (val) => setAttributes({ horizontalGutter: val }),
                                }),
                                el(SelectControl, {
                                    label: __('Verticale Gutter', 'fectionwp-pro'),
                                    value: attributes.verticalGutter,
                                    options: [
                                        { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                        { label: '0', value: '0' },
                                        { label: '1', value: '1' },
                                        { label: '2', value: '2' },
                                        { label: '3', value: '3' },
                                        { label: '4', value: '4' },
                                        { label: '5', value: '5' },
                                    ],
                                    onChange: (val) => setAttributes({ verticalGutter: val }),
                                })
                            ),
                        el(SelectControl, {
                            label: __('Verticale Uitlijning', 'fectionwp-pro'),
                            value: attributes.verticalAlignment,
                            options: [
                                { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                { label: __('Start', 'fectionwp-pro'), value: 'start' },
                                { label: __('Center', 'fectionwp-pro'), value: 'center' },
                                { label: __('End', 'fectionwp-pro'), value: 'end' },
                            ],
                            onChange: (val) => setAttributes({ verticalAlignment: val }),
                        }),
                        el(SelectControl, {
                            label: __('Horizontale Uitlijning', 'fectionwp-pro'),
                            value: attributes.horizontalAlignment,
                            options: [
                                { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                { label: __('Start', 'fectionwp-pro'), value: 'start' },
                                { label: __('Center', 'fectionwp-pro'), value: 'center' },
                                { label: __('End', 'fectionwp-pro'), value: 'end' },
                                { label: __('Between', 'fectionwp-pro'), value: 'between' },
                                { label: __('Around', 'fectionwp-pro'), value: 'around' },
                                { label: __('Evenly', 'fectionwp-pro'), value: 'evenly' },
                            ],
                            onChange: (val) => setAttributes({ horizontalAlignment: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        allowedBlocks: ['fwp/column'],
                        template: templates[attributes.template] || templates['1:1'],
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // COLUMN BLOCK
    // =============================================================================
    registerBlockType('fwp/column', {
        title: __('Bootstrap Column', 'fectionwp-pro'),
        icon: 'align-center',
        category: 'design',
        description: __('Bootstrap kolom met responsive breakpoints.', 'fectionwp-pro'),
        parent: ['fwp/row'],
        supports: {
            html: false,
        },
        attributes: {
            sizeXs: { type: 'string', default: '' },
            sizeSm: { type: 'string', default: '' },
            sizeMd: { type: 'string', default: '' },
            sizeLg: { type: 'string', default: '' },
            sizeXl: { type: 'string', default: '' },
            sizeXxl: { type: 'string', default: '' },
            offsetXs: { type: 'string', default: '' },
            offsetSm: { type: 'string', default: '' },
            offsetMd: { type: 'string', default: '' },
            offsetLg: { type: 'string', default: '' },
            offsetXl: { type: 'string', default: '' },
            offsetXxl: { type: 'string', default: '' },
            order: { type: 'string', default: '' },
            verticalAlignment: { type: 'string', default: '' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const sizeOptions = [
                { label: __('Auto', 'fectionwp-pro'), value: '' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '5', value: '5' },
                { label: '6', value: '6' },
                { label: '7', value: '7' },
                { label: '8', value: '8' },
                { label: '9', value: '9' },
                { label: '10', value: '10' },
                { label: '11', value: '11' },
                { label: '12', value: '12' },
            ];

            const offsetOptions = [
                { label: __('Geen', 'fectionwp-pro'), value: '' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '5', value: '5' },
                { label: '6', value: '6' },
                { label: '7', value: '7' },
                { label: '8', value: '8' },
                { label: '9', value: '9' },
                { label: '10', value: '10' },
                { label: '11', value: '11' },
            ];

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Kolom Breedte', 'fectionwp-pro') },
                        ['Xs', 'Sm', 'Md', 'Lg', 'Xl', 'Xxl'].map((bp) =>
                            el(SelectControl, {
                                key: bp,
                                label: bp.toUpperCase(),
                                value: attributes['size' + bp],
                                options: sizeOptions,
                                onChange: (val) => setAttributes({ ['size' + bp]: val }),
                            })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Kolom Offset', 'fectionwp-pro'), initialOpen: false },
                        ['Xs', 'Sm', 'Md', 'Lg', 'Xl', 'Xxl'].map((bp) =>
                            el(SelectControl, {
                                key: bp,
                                label: bp.toUpperCase(),
                                value: attributes['offset' + bp],
                                options: offsetOptions,
                                onChange: (val) => setAttributes({ ['offset' + bp]: val }),
                            })
                        )
                    ),
                    el(
                        PanelBody,
                        { title: __('Extra Opties', 'fectionwp-pro'), initialOpen: false },
                        el(SelectControl, {
                            label: __('Volgorde', 'fectionwp-pro'),
                            value: attributes.order,
                            options: [
                                { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                { label: 'First', value: 'first' },
                                { label: '1', value: '1' },
                                { label: '2', value: '2' },
                                { label: '3', value: '3' },
                                { label: '4', value: '4' },
                                { label: '5', value: '5' },
                                { label: 'Last', value: 'last' },
                            ],
                            onChange: (val) => setAttributes({ order: val }),
                        }),
                        el(SelectControl, {
                            label: __('Verticale Uitlijning', 'fectionwp-pro'),
                            value: attributes.verticalAlignment,
                            options: [
                                { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                { label: __('Start', 'fectionwp-pro'), value: 'start' },
                                { label: __('Center', 'fectionwp-pro'), value: 'center' },
                                { label: __('End', 'fectionwp-pro'), value: 'end' },
                            ],
                            onChange: (val) => setAttributes({ verticalAlignment: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(InnerBlocks, {
                        templateLock: false,
                    })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // BUTTON BLOCK
    // =============================================================================
    registerBlockType('fwp/button', {
        title: __('Bootstrap Button', 'fectionwp-pro'),
        icon: 'button',
        category: 'design',
        description: __('Bootstrap button met alle stijlopties.', 'fectionwp-pro'),
        supports: {
            html: false,
        },
        attributes: {
            text: { type: 'string', default: 'Button' },
            url: { type: 'string', default: '#' },
            style: { type: 'string', default: 'primary' },
            size: { type: 'string', default: '' },
            outline: { type: 'boolean', default: false },
            block: { type: 'boolean', default: false },
            disabled: { type: 'boolean', default: false },
            newTab: { type: 'boolean', default: false },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            let btnClass = 'btn';
            if (attributes.outline) {
                btnClass += ' btn-outline-' + attributes.style;
            } else {
                btnClass += ' btn-' + attributes.style;
            }
            if (attributes.size) {
                btnClass += ' btn-' + attributes.size;
            }
            if (attributes.block) {
                btnClass += ' d-block w-100';
            }
            if (attributes.disabled) {
                btnClass += ' disabled';
            }

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Button Instellingen', 'fectionwp-pro') },
                        el(TextControl, {
                            label: __('Tekst', 'fectionwp-pro'),
                            value: attributes.text,
                            onChange: (val) => setAttributes({ text: val }),
                        }),
                        el(TextControl, {
                            label: __('URL', 'fectionwp-pro'),
                            value: attributes.url,
                            onChange: (val) => setAttributes({ url: val }),
                        }),
                        el(SelectControl, {
                            label: __('Stijl', 'fectionwp-pro'),
                            value: attributes.style,
                            options: [
                                { label: 'Primary', value: 'primary' },
                                { label: 'Secondary', value: 'secondary' },
                                { label: 'Success', value: 'success' },
                                { label: 'Danger', value: 'danger' },
                                { label: 'Warning', value: 'warning' },
                                { label: 'Info', value: 'info' },
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' },
                                { label: 'Link', value: 'link' },
                            ],
                            onChange: (val) => setAttributes({ style: val }),
                        }),
                        el(SelectControl, {
                            label: __('Grootte', 'fectionwp-pro'),
                            value: attributes.size,
                            options: [
                                { label: __('Standaard', 'fectionwp-pro'), value: '' },
                                { label: __('Klein', 'fectionwp-pro'), value: 'sm' },
                                { label: __('Groot', 'fectionwp-pro'), value: 'lg' },
                            ],
                            onChange: (val) => setAttributes({ size: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Outline Stijl', 'fectionwp-pro'),
                            checked: attributes.outline,
                            onChange: (val) => setAttributes({ outline: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Volledige Breedte', 'fectionwp-pro'),
                            checked: attributes.block,
                            onChange: (val) => setAttributes({ block: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Uitgeschakeld', 'fectionwp-pro'),
                            checked: attributes.disabled,
                            onChange: (val) => setAttributes({ disabled: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Open in nieuw tabblad', 'fectionwp-pro'),
                            checked: attributes.newTab,
                            onChange: (val) => setAttributes({ newTab: val }),
                        })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'a',
                        { className: btnClass, href: '#', onClick: (e) => e.preventDefault() },
                        attributes.text
                    )
                )
            );
        },

        save: function () {
            return null; // Rendered via PHP
        },
    });

    // =============================================================================
    // ALERT BLOCK
    // =============================================================================
    registerBlockType('fwp/alert', {
        title: __('Bootstrap Alert', 'fectionwp-pro'),
        icon: 'warning',
        category: 'design',
        description: __('Bootstrap alert melding.', 'fectionwp-pro'),
        supports: {
            html: false,
        },
        attributes: {
            type: { type: 'string', default: 'primary' },
            dismissible: { type: 'boolean', default: false },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            let alertClass = 'alert alert-' + attributes.type;
            if (attributes.dismissible) {
                alertClass += ' alert-dismissible';
            }

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Alert Instellingen', 'fectionwp-pro') },
                        el(SelectControl, {
                            label: __('Type', 'fectionwp-pro'),
                            value: attributes.type,
                            options: [
                                { label: 'Primary', value: 'primary' },
                                { label: 'Secondary', value: 'secondary' },
                                { label: 'Success', value: 'success' },
                                { label: 'Danger', value: 'danger' },
                                { label: 'Warning', value: 'warning' },
                                { label: 'Info', value: 'info' },
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' },
                            ],
                            onChange: (val) => setAttributes({ type: val }),
                        }),
                        el(ToggleControl, {
                            label: __('Wegklikbaar', 'fectionwp-pro'),
                            checked: attributes.dismissible,
                            onChange: (val) => setAttributes({ dismissible: val }),
                        })
                    )
                ),
                el(
                    'div',
                    { ...blockProps, className: blockProps.className + ' ' + alertClass, role: 'alert' },
                    el(InnerBlocks, { templateLock: false }),
                    attributes.dismissible &&
                        el('button', {
                            type: 'button',
                            className: 'btn-close',
                            'aria-label': __('Sluiten', 'fectionwp-pro'),
                        })
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });

    // =============================================================================
    // CARD BLOCK
    // =============================================================================
    registerBlockType('fwp/card', {
        title: __('Bootstrap Card', 'fectionwp-pro'),
        icon: 'id-alt',
        category: 'design',
        description: __('Bootstrap card component.', 'fectionwp-pro'),
        supports: {
            html: false,
        },
        attributes: {
            headerText: { type: 'string', default: '' },
            footerText: { type: 'string', default: '' },
            imageUrl: { type: 'string', default: '' },
            imagePosition: { type: 'string', default: 'top' },
            className: { type: 'string', default: '' },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            return el(
                Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Card Instellingen', 'fectionwp-pro') },
                        el(TextControl, {
                            label: __('Header Tekst', 'fectionwp-pro'),
                            value: attributes.headerText,
                            onChange: (val) => setAttributes({ headerText: val }),
                        }),
                        el(TextControl, {
                            label: __('Footer Tekst', 'fectionwp-pro'),
                            value: attributes.footerText,
                            onChange: (val) => setAttributes({ footerText: val }),
                        }),
                        el(TextControl, {
                            label: __('Afbeelding URL', 'fectionwp-pro'),
                            value: attributes.imageUrl,
                            onChange: (val) => setAttributes({ imageUrl: val }),
                        }),
                        attributes.imageUrl &&
                            el(SelectControl, {
                                label: __('Afbeelding Positie', 'fectionwp-pro'),
                                value: attributes.imagePosition,
                                options: [
                                    { label: __('Boven', 'fectionwp-pro'), value: 'top' },
                                    { label: __('Onder', 'fectionwp-pro'), value: 'bottom' },
                                ],
                                onChange: (val) => setAttributes({ imagePosition: val }),
                            })
                    )
                ),
                el(
                    'div',
                    blockProps,
                    el(
                        'div',
                        { className: 'card' },
                        attributes.imageUrl &&
                            attributes.imagePosition === 'top' &&
                            el('img', { src: attributes.imageUrl, className: 'card-img-top', alt: '' }),
                        attributes.headerText &&
                            el('div', { className: 'card-header' }, attributes.headerText),
                        el('div', { className: 'card-body' }, el(InnerBlocks, { templateLock: false })),
                        attributes.footerText &&
                            el('div', { className: 'card-footer' }, attributes.footerText),
                        attributes.imageUrl &&
                            attributes.imagePosition === 'bottom' &&
                            el('img', { src: attributes.imageUrl, className: 'card-img-bottom', alt: '' })
                    )
                )
            );
        },

        save: function () {
            return el(InnerBlocks.Content);
        },
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);
