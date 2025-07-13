<!-- ToolbarItem.vue -->
<template>
    <button class="flex items-center mx-2 py-2 px-4 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="emitToolSelection">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'ToolbarItem',
    methods: {
        emitToolSelection() {
            const toolName = this.$el.querySelector('span').textContent.toLowerCase();
            this.$emit('tool-selected', toolName);
        }
    }
}
</script>
