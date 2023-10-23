<template>
    <editor-content :editor="editor" />
</template>

<script>
import Placeholder from '@tiptap/extension-placeholder'
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-3'

export default {
    components: {
        EditorContent,
    },
    props: {
        modelValue: {
            type: String,
        },
        placeholder: {
            type: String,
            default: 'Write Something',
        },
        showBorder: {
            type: Boolean,
            default: false,
        },
        margin: {
            type: String,
            default: '-ml-2',
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            editor: null,
        }
    },

    watch: {
        modelValue(value) {
            const isSame = this.editor.getHTML() === value
            if (isSame) {
                return
            }
            this.editor.commands.setContent(value, false)
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Placeholder.configure({
                    placeholder: this.placeholder,
                }),
            ],
            content: this.modelValue,
            editorProps: {
                attributes: {
                    class: 'w-full prose prose-sm text-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none p-2 border border-gray-200 hover:border-opacity-100 rounded hover:shadow-sm focus:border-opacity-100 focus:shadow-sm'+(this.showBorder ? '' : ' border-opacity-0')+(this.margin ? ' '+this.margin : ''),
                },
            },
            onUpdate: () => {
                // HTML
                this.$emit('update:modelValue', this.editor.getHTML())

                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        })
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>

<style>
/* .tiptap p.is-editor-empty:first-child::before {
    color: #adb5bd;
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
} */
.tiptap p.is-empty::before {
  color: #adb5bd;
  content: attr(data-placeholder);
  float: left;
  height: 0;
  pointer-events: none;
}
</style>
