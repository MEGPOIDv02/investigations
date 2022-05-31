export const fetchData = () => {
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

    axios.get(self.dataContentUrl, {params: params}).then((response) => {
        this.isLoading = false;
        this.rows = response.data.data;
        this.total_rows = response.data.count;
    }).catch(function (error) {
        console.error(error);
    });
};