<!-- <template>
    <editor-content :editor="editor" />
</template>

<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import { ref, onBeforeUnmount, onMounted } from 'vue'

const value = ref('')

const editor = useEditor({
    content: value.value,
    extensions: [
        StarterKit,
        Placeholder.configure({
            placeholder: 'Write Something',
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none p-2 -ml-2 border border-gray-200 border-opacity-0 hover:border-opacity-100 rounded hover:shadow-sm focus:border-opacity-100 focus:shadow-sm',
        },
    },
})

// Watch for changes in the editor's content and update the value
onMounted(() => {
  editor.emit('transaction', (tr) => {
    if (tr.docChanged) {
      value.value = tr.doc.toString();
    }
  });
});

// Clean up the editor when the component is unmounted
onBeforeUnmount(() => {
  editor.destroy();
});
</script>

<style>
.tiptap p.is-editor-empty:first-child::before {
  content: attr(data-placeholder);
  float: left;
  pointer-events: none;
  height: 0;
}
</style>

<style lang="postcss">
.tiptap p.is-editor-empty:first-child::before {
    @apply text-gray-400 text-sm
  }
</style> -->

<template>
    <editor-content :editor="editor" />
  </template>

  <script>
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
    },

    emits: ['update:modelValue'],

    data() {
      return {
        editor: null,
      }
    },

    watch: {
      modelValue(value) {
        // HTML
        const isSame = this.editor.getHTML() === value

        // JSON
        // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

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
        ],
        content: this.modelValue,
        editorProps: {
            attributes: {
                class: 'prose prose-sm text-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none p-2 -ml-2 border border-gray-200 border-opacity-0 hover:border-opacity-100 rounded hover:shadow-sm focus:border-opacity-100 focus:shadow-sm',
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
