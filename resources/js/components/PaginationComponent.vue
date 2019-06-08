<template>
    <nav>
        <ul class="pagination">
            <li v-if="passers.current_page > 1" class="page-item">
                <a href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(passers.current_page - 1, search)" class="page-link">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="page in pagesNumber" :class="{'active': page == passers.current_page}" v-bind:key="page" class="page-item">
                <a href="javascript:void(0)" v-on:click.prevent="changePage(page, search)" class="page-link">{{ page }}</a>
            </li>
            <li v-if="passers.current_page < passers.last_page" class="page-item">
                <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(passers.current_page + 1, search)" class="page-link">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
    import { EventBus } from '../vue-assets';

    export default{
        props: {
            passers: {
                type: Object,
                required: true
            },
            search: {
                type: String,
            },
            offset: {
                type: Number,
                default: 4
            }
        },

        computed: {

            pagesNumber() {
                if (!this.passers.to) {
                    return [];
                }

                let from = this.passers.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                let to = from + (this.offset * 2);            
                if (to >= this.passers.last_page) {
                    to = this.passers.last_page;
                }
                
                let pagesArray = [];
                
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                
                return pagesArray;
            
            }
        },

        methods : {

            changePage(page, search) {
                console.log(search);
                this.passers.current_page = page;
                EventBus.$emit('paginate', page, search);
            }

        }
    }
</script>