<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">

    <div class="container-fluid">

        <v-simple-table style="min-height: 55rem">

            <template v-slot:default>

                <thead>
                <div class="d-inline-flex">
                    <img class="ml-3 mt-2 img-fluid" style="object-fit: contain"
                         v-if="iconPath != null" :src="iconPath" width="22px" alt="">
                    <span style="font-size: 1.2rem; white-space: nowrap"
                          class="ml-3 mt-3 font-weight-bold d-inline-block" v-if="title != null">
                    {{title}}
                </span>
                </div>
                <div v-if="optionalComponent">
                    {{optionalComponent}}
                </div>

                <tr>
                    <!--Headers-->
                    <th v-for="column in indexedColumns" :key="column.colId"
                        v-on="isSortableColumn(column) ? {click:() => updateSortQuery(column)} : {}">
                        <div class="d-flex flex-row align-center text-secondary font-weight-bold" >
                            <span style="color: black; font-size: medium">{{column.label}}</span>

                            <template v-if="isSortableColumn(column)">
                                <SortIcon :sort="query.sort" :column="column">
                                    <template slot="vbt-sort-asc-icon">
                                        <slot name="sort-asc-icon">
                                            <i class="mdi mdi-menu-down" style="font-size: 1.4rem"></i>
                                        </slot>
                                    </template>
                                    <template slot="vbt-sort-desc-icon">
                                        <slot name="sort-desc-icon">
                                            <i class="mdi mdi-menu-up" style="font-size: 1.4rem"></i>
                                        </slot>
                                    </template>
                                    <template slot="vbt-no-sort-icon">
                                        <slot name="no-sort-icon">
                                            <i class="mdi mdi-menu-swap" style="font-size: 1.4rem"></i>
                                        </slot>
                                    </template>
                                </SortIcon>
                            </template>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <!--Filters-->
                    <template v-for="column in indexedColumns">
                        <th v-if="hasFilter(column)" v-bind:style="getFilterCellStyle(column)">
                            <v-text-field
                                clearable
                                outlined
                                dense
                                @keyup.enter="onUpdateFilter($event,column)"
                                @click:clear="clearFilter(column)"
                                clear-icon="mdi-close-circle"
                                prepend-inner-icon="mdi-magnify">
                            </v-text-field>
                        </th>

                        <th v-else v-bind:style="getFilterCellStyle(column)">

                        </th>
                    </template>
                </tr>
                <!--Skeleton-->
                <tr>
                    <td :colspan=columns.length v-if="is_loading">
                        <v-skeleton-loader
                            type="table-tbody">

                        </v-skeleton-loader>
                    </td>
                </tr>
                <!--Data-->
                <!--If empty-->
                <tr v-if="rows.length === 0 && !is_loading">
                    <td :colspan=columns.length class="text-center">
                        <h4 class="grey--text"> No existen datos </h4>
                    </td>
                </tr>

                <TableRow v-for="(row, index) in indexedRows"
                          v-if="!is_loading"
                          :key="index"
                          :row="row"
                          :columns="indexedColumns">

                    <template v-for="(column) in indexedColumns"
                              :slot="'slot-row-'+getCellSlotName(column)">

                        <slot :name="getCellSlotName(column)"
                              :row="row"
                              :column="column"
                              v-bind:data="row"
                              :cell_value="getValueFromRow(row,column.name)">
                            {{getValueFromRow(row,column.name)}}
                        </slot>

                        <template v-if="getCellSlotName(column) === 'action-slot' ">
                            <toggle-button :data-update-url="update_status_url"
                                           :entity-id="row.id"
                                           :active="row.active"
                                           v-if="toggle_button"
                                           style="color: #36c651">

                            </toggle-button>
                        </template>
                    </template>
                </TableRow>


                </tbody>
            </template>

        </v-simple-table>

        <div class="row mt-5">
            <v-pagination
                v-if="rows.length !== 0"
                class="ml-auto"
                v-model="page"
                prev-icon="mdi-menu-left"
                next-icon="mdi-menu-right"
                :length="number_pages">
            </v-pagination>
        </div>
    </div>

</template>

<script>
import SortIcon from './components/SortIcon'
import TableRow from './components/TableRow'
import ToggleButton from './components/ToggleButton'

export default {
    name: "SatoriGrid",
    props: {
        rows: {
            type: Array,
            required: true
        },
        columns: {
            type: Array,
            required: true
        },
        total_rows: {
            required: true
        },
        is_loading: {
            type: Boolean,
            required: true
        },
        toggle_button: {
            type: Boolean,
            required: false,
            default: function () {
                return false;
            }
        },
        title:{
            type: String,
            required: false,
            default: function(){
                return null;
            }
        },
        optionalComponent:{
            required: false,
            default: function(){
                return null;
            }
        },
        iconPath:{
            type: String,
            required: false,
            default: function(){
                return null;
            }
        },
        update_status_url: {
            type: String,
            required: false
        },
        page_size: {
            required: false,
            default: function () {
                return 10;
            }
        },
    },
    methods: {
        hasFilter(column) {
            return column.filter !== undefined && column.filter.type !== undefined;
        },
        isSortableColumn(column) {
            if (column.sort === null || column.sort === undefined) {
                return false;
            } else {
                return column.sort;
            }
        },
        getCellSlotName(column) {
            if (column.slot_name !== null && column.slot_name !== undefined) {
                return column.slot_name;
            }
            return column.name.replace(/\./g, '_');
        },
        getValueFromRow(row, name) {
            let paths = name.split('.'),
                current = row,
                i;

            for (i = 0; i < paths.length; ++i) {
                // noinspection EqualityComparisonWithCoercionJS
                if (current[paths[i]] == undefined) {
                    return undefined;
                } else {
                    current = current[paths[i]];
                }
            }
            return current;
        },
        onUpdateFilter(e, column) {
            let newFilter = {
                colId: column.colId,
                name: column.name,
                text: e.target.value
            };
            let indexFind = 0;
            let filter = this.query.filters.filter((_filter, index) => {
                if (_filter.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (filter.length === 0) {
                this.query.filters.push(newFilter)
            } else {
                this.query.filters[indexFind] = newFilter;
            }

            this.emitQueryParams(0)
        },
        clearFilter(column) {
            this.query.filters = this.query.filters.filter((_filter) =>
                _filter.colId !== column.colId
            );
            this.emitQueryParams()
        },
        emitQueryParams(page = null) {
            // console.log("Emit query params");
            let queryParams = {...this.query};

            let payload = {
                sort: queryParams.sort,
                filters: queryParams.filters,
                per_page: this.per_page,
                page: page === null ? this.page - 1 : page
            };

            // console.log("- payload", payload);

            this.$emit('on-change-query', payload);
        },
        updateSortQuery(column) {
            //Can sort by one column
            //If need sort by multiple, send config param

            let indexFind = 0;
            let sort = this.query.sort.filter((_sort, index) => {
                if (_sort.colId === column.colId) {
                    indexFind = index;
                    return true;
                }
            });

            if (sort.length === 0) {
                //Remove Other Filters
                this.query.sort = [];

                this.query.sort.push({
                    colId: column.colId,
                    name: column.name,
                    order: "ASC"
                });
            } else {
                this.query.sort[indexFind].order = this.query.sort[indexFind].order === "ASC" ? "DESC" : "ASC";
            }
            this.emitQueryParams()
        },
        getFilterCellStyle(column) {
            if (column.filter !== undefined && column.filter.th_style !== undefined) {
                return column.filter.th_style;
            }
            return {};
        }
    },
    data: function () {
        return {
            indexedRows: [],
            indexedColumns: [],
            page: 1,
            per_page: 15,
            number_pages: 1,
            query: {
                sort: [],
                filters: [],
            },
        }
    },
    mounted() {
        this.indexedColumns = [...this.columns];
        this.indexedRows = [...this.rows];
        this.indexedRows = [...this.rows];
        this.per_page = this.page_size;

        this.indexedColumns = this.indexedColumns.map(function (element, index) {
            element.colId = index + 1;
            return element;
        });

        this.emitQueryParams();
    },
    watch: {
        columns: {
            handler: function (newVal, oldVal) {
                this.indexedColumns = [...this.columns];
                this.indexedColumns = this.indexedColumns.map(function (element, index) {
                    element.colId = index + 1;
                    return element;
                });
            },
            deep: true
        },
        rows: {
            handler: function (newVal, oldVal) {
                this.indexedRows = [...this.rows];
                let number_pages = (this.total_rows / this.per_page);
                if (number_pages % 1 === 0) {
                    this.number_pages = number_pages;
                } else {
                    number_pages = number_pages - number_pages % 1;
                    this.number_pages = number_pages + 1;
                }
            },
            deep: true
        },
        page: {
            handler: function (newVal, oldVal) {
                this.emitQueryParams()
            },
            deep: true
        },
    },
    components: {
        SortIcon,
        ToggleButton,
        TableRow,
    }
}
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
