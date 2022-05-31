import {bus} from '../../admin/app';

export default  {
    created(){
        bus.$on('reload-grid', (data) => {
            this.queryParams = {
                sort: [],
                filters: [],
                per_page: 15,
                page: 0,
            };
            this.fetchData();
        });
        bus.$on('on-change-query', (data) => {
            console.log("In change query");
            this.onChangeQuery()
        });
    },
    methods: {
        prepareParams(preventSpinner){
            let self = this;
            if (!preventSpinner) self.isLoading = true;

            let sortBy = "";
            let sortOrder = "asc";

            if (this.queryParams.sort.length > 0) {
                sortBy = this.queryParams.sort[0].name;
                sortOrder = this.queryParams.sort[0].order;
            }

            let params = {
                "size": this.queryParams.per_page,
                "page": this.queryParams.page,
                "sort-by": sortBy,
                "sort-order": sortOrder,
            };

            this.queryParams.filters.forEach(item => {
                params[`filter-${item.name}`] = item.text;
            });

            return params
        },
        onChangeQuery(queryParams) {
            this.queryParams = queryParams;
            this.fetchData();
        }
    },
    data() {
        return {
            isLoading: true,
            rows: [],
            queryParams: {
                sort: [],
                filters: [],
                per_page: 15,
                page: 0,
            },
            total_rows: 0,
            formatter: new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN',
                minimumFractionDigits: 0
            }),
        }
    }
}
