<template>
    <tr>
        <template v-for="(column, key, hindex) in columns">
            <td :key="hindex" :class="getCellClass(column)" v-bind:style="getCellStyle(column)">
                <div :class="getCellSlotName(column) === 'action-slot' ? 'd-flex flex-row justify-content-end': '' ">
                    <slot :name="'slot-row-'+getCellSlotName(column)">

                    </slot>
                </div>
            </td>
        </template>
    </tr>
</template>

<script>
    export default {
        name: "TableRow",
        props: {
            row: {
                type: Object,
                required: true
            },
            columns: {
                type: Array,
                default: function () {
                    return [];
                }
            },
        },
        methods: {
            getCellSlotName(column) {
                if (column.slot_name !== null && column.slot_name !== undefined) {
                    return column.slot_name;
                }
                return column.name.replace(/\./g, '_');
            },
            getCellClass(column) {
                if (column.class !== null && column.class !== undefined) {
                    return column.class;
                }
                return [];
            },
            getCellStyle(column) {
                if (column.style !== null && column.style !== undefined) {
                    return column.style;
                }
                return {};
            }
        }

    }
</script>

<style scoped>

</style>