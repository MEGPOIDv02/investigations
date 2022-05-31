<template>
    <div class="ml-auto align-self-center cursor-pointer">
        <template v-if="order === 'ASC'">
            <slot name="vbt-sort-asc-icon">

            </slot>
        </template>

        <template v-else-if="order==='DESC'">
            <slot name="vbt-sort-desc-icon">

            </slot>
        </template>

        <template v-else>
            <slot name="vbt-no-sort-icon">

            </slot>
        </template>
    </div>
</template>

<script>
    export default {
        name: "SortIcon",
        props: {
            sort: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            column: {
                type: Object,
                default: function () {
                    return {};
                }
            },

        },
        data: function () {
            return {}
        },
        mounted() {

        },
        methods: {},
        computed: {
            order() {

                let sorted = this.sort.filter(_column =>
                    this.column.colId === _column.colId
                );

                if (sorted === undefined || sorted.length === 0) {
                    return null;
                } else {
                    return sorted[0].order;
                }
            }
        },
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
</style>