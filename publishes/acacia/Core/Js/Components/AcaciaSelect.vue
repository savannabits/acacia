<template>
    <v-select
        class="p-input-filled p-inputtext p-inputtext-sm"
        :model-value="modelValue"
        @update:modelValue="onSelect"
        :multiple="multiple"
        :options="options"
        :label="label"
        :append-to-body="false"
        :close-on-select="closeOnSelect"
        :placeholder="placeholder"
        :reduce="reduce"
        ref="select"
    >
        <template #search="{ attributes, events }">
            <input
                style="border-right: none !important;"
                class="vs__search"
                v-bind="attributes"
                v-on="events"
            >
        </template>
    </v-select>
</template>

<script>
import vSelect from "vue-select"
export default {
    name: "AcaciaSelect",
    emits: ['update:modelValue'],
    components: {
        vSelect,
    },
    props: {
        multiple: {
            default: false,
        },
        modelValue: {
            default: null,
        },
        options: {
            default: () => [],
        },
        placeholder: {
            default: "Search or Select"
        },
        label: {
            default: 'name'
        },
        closeOnSelect: {default: true},
        reduce: {
            type: Function,
            default: option => option,
        },
    },
    model: {
        prop: 'value',
        event: 'input'
    },
    methods: {
        onSelect(value) {
            this.$emit('update:modelValue', value);
        },
    }
}
</script>

<style lang="scss">
@import "vue-select/src/scss/vue-select.scss";

.loader {
    text-align: center;
    color: #bbbbbb;
}
.vs__dropdown-toggle {
    border: none !important;
}
</style>

