<template>
    <div class="clearfix">
        
        <div class="card">
            
            <div class="card-body">

                <div class="clearfix" style="margin-bottom: 15px;">
                    <input type="text" class="form-control" placeholder="Search..." v-model="search" @keyup="doSearch"/>
                </div>

                <div class="clearfix">
                    <table class="table table-sm" v-cloak>
                        <thead>
                            <tr>
                                <th scope="col">Name of Examinee</th>
                                <th scope="col">School</th>
                                <th scope="col">Division</th>
                            </tr>
                        </thead>
                        <tbody v-if="this.passers.hasOwnProperty('data') && Object.keys(this.passers.data).length > 0">
                            <tr v-for="passer in passers.data" v-bind:key="passer.id">
                                <td>{{ passer.lastname }}, {{ passer.firstname }}</td>
                                <td>{{ passer.school.name }}</td>
                                <td>{{ passer.school.division.name }}</td>
                            </tr>
                        </tbody>

                        <tbody v-else>
                            <tr>
                                <td colspan="3">No Data Found.</td>
                            </tr>
                        </tbody>

                    </table>

                    <pagination  
                        :passers="passers"
                        :search="search"
                        @paginate="load()"
                        :offset="4">
                    </pagination>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../vue-assets';
    import Pagination from  './PaginationComponent.vue';
    

    export default {

        components: {
            Pagination
        },

        data() {
            return {
                passers: {},
                search: ''                
            };
        },

        mounted() {
            const _this = this;
            
            EventBus.$on('loadedData', () => {
                _this.load(1);
            });

            EventBus.$on('createdExaminee', () => {
                console.log('created examinee');
                _this.load(1);
            });


            EventBus.$on('paginate', (page, search) => {
                console.log('paginate page=' + page);
                _this.load(page, search);
            });
    
        },

        methods: {

            load(page, search) {

                page = (page)   ?   page    :   this.passers.current_page;
                search = (search)   ?   search  :   '';

                //get passers data
                axios.get(Url.Api + '/data/get?page=' + page + '&search='+search).then((res) => {
                    
                   if (res.data.result == true) {
                       console.log(res.data.passers);

                       this.passers = res.data.passers;

                       console.log(this.passers.hasOwnProperty('data'));
 
                   }
                
                }).catch(error => {
                    
                    console.log(error)
                    
                });

            },

            doSearch() {
                //console.log(this.search);
                this.load(1, this.search);
            }
           
        },

        created() {
            this.load();
        }

    }
</script>
