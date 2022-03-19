<template>
    <flat-pickr :config="config" class="p-inputtext" id="next_action_scheduled_date" :modelValue="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input"></flat-pickr>
</template>

<script>
import flatPickr from "vue-flatpickr-component";
import 'flatpickr/dist/flatpickr.css';
import MonthSelect from "flatpickr/dist/plugins/monthSelect"
import "flatpickr/dist/plugins/monthSelect/style.css"
import {defineComponent, toRef} from "vue";
export default defineComponent({
    name: "AcaciaDatepicker",
    components: {flatPickr},
    props: {
        'modelValue': {},
        'config': {
            type: Object,
            default: () => {return {}}
        },
        'monthSelect': {
            type: Boolean,
            default: false,
        }
    },
    emits: ['update:modelValue'],
    setup(props) {
        const pickerConfig = toRef(props,"config");
        const monthSelect = toRef(props, "monthSelect");
        if (monthSelect.value) {
            pickerConfig.value.plugins = [new MonthSelect({
                dateFormat: 'Y-m',
            })]
        }
    }
})
</script>

<style scoped>

</style>
