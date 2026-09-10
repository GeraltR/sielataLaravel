const { Mark } = window.FilamentRichEditor.tiptap.core

export default Mark.create({
    name: 'fontSize',

    parseHTML() {
        return [
            {
                tag: 'span',
                getAttrs: (element) => element.classList?.contains('font-size'),
            },
        ]
    },

    addAttributes() {
        return {
            'data-font-size': {
                default: null,
                parseHTML: (element) => element.getAttribute('data-font-size'),
                renderHTML: (attributes) => {
                    if (!attributes['data-font-size']) return {}

                    return { 'data-font-size': attributes['data-font-size'] }
                },
            },
        }
    },

    renderHTML({ HTMLAttributes }) {
        const attrs = { ...HTMLAttributes }
        const existingClass = HTMLAttributes.class
        attrs.class = ['font-size', existingClass].filter(Boolean).join(' ')

        const fontSize = HTMLAttributes['data-font-size']

        if (fontSize) {
            const existingStyle =
                typeof HTMLAttributes.style === 'string' ? HTMLAttributes.style : ''
            const style = `font-size: ${fontSize}`
            attrs.style = existingStyle ? `${style}; ${existingStyle}` : style
        }

        return ['span', attrs, 0]
    },

    addCommands() {
        return {
            setFontSize:
                ({ fontSize }) =>
                ({ commands }) => {
                    if (!fontSize) {
                        return commands.unsetMark(this.name)
                    }

                    return commands.setMark(this.name, { 'data-font-size': fontSize })
                },
            unsetFontSize:
                () =>
                ({ commands }) => {
                    return commands.unsetMark(this.name)
                },
        }
    },
})
