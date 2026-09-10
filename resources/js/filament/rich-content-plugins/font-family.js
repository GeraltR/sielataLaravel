const { Mark } = window.FilamentRichEditor.tiptap.core

export default Mark.create({
    name: 'fontFamily',

    parseHTML() {
        return [
            {
                tag: 'span',
                getAttrs: (element) => element.classList?.contains('font-family'),
            },
        ]
    },

    addAttributes() {
        return {
            'data-font-family': {
                default: null,
                parseHTML: (element) => element.getAttribute('data-font-family'),
                renderHTML: (attributes) => {
                    if (!attributes['data-font-family']) return {}

                    return { 'data-font-family': attributes['data-font-family'] }
                },
            },
        }
    },

    renderHTML({ HTMLAttributes }) {
        const attrs = { ...HTMLAttributes }
        const existingClass = HTMLAttributes.class
        attrs.class = ['font-family', existingClass].filter(Boolean).join(' ')

        const fontFamily = HTMLAttributes['data-font-family']

        if (fontFamily) {
            const existingStyle =
                typeof HTMLAttributes.style === 'string' ? HTMLAttributes.style : ''
            const style = `font-family: ${fontFamily}`
            attrs.style = existingStyle ? `${style}; ${existingStyle}` : style
        }

        return ['span', attrs, 0]
    },

    addCommands() {
        return {
            setFontFamily:
                ({ fontFamily }) =>
                ({ commands }) => {
                    if (!fontFamily) {
                        return commands.unsetMark(this.name)
                    }

                    return commands.setMark(this.name, { 'data-font-family': fontFamily })
                },
            unsetFontFamily:
                () =>
                ({ commands }) => {
                    return commands.unsetMark(this.name)
                },
        }
    },
})
