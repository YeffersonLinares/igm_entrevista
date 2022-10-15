<template>
    <div class="d-flex justify-content-between align-content-center mb-2">
        <div class="d-flex justify-content-center">
            <div>
                <div class="d-flex align-items-center">
                    <label for="paginate" class="text-nowrap mr-2 mb-0">Cantidad</label>
                    <select v-model="paginate" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>

        </div>
        <!-- <div class="col-md-4">
            <input type="search" v-model.lazy="search" class="form-control" autocomplete="off" placeholder="Search" />
        </div> -->
    </div>
    <slot></slot>
    <div class="table-responsive d-flex justify-content-between ">
        <span class="d-flex align-items-center ml-2">
            Mostrando {{ dataList.meta.from }}
            a {{ dataList.meta.to }}
            de {{ dataList.meta.total }} registros
        </span>
        <Pagination :limit="limit" :data="dataList" @pagination-change-page="list" />
    </div>

</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    emits: ["paginationChangePage"],
    props: {
        dataList: Object
    },
    components: {
    },
    data() {
        return {
            paginate: 10,
            search: '',
            limit: 2,
        };
    },
    mounted() {
    },
    watch: {
        paginate: function () {
            this.page = 1;
            this.list(this.page);
        },
        search: function () {
            this.list(this.page);
        }
    },
    methods: {
        list(data) {
            this.$emit("paginationChangePage", { page: data, paginate: this.paginate });
        }
    }
});
</script>
