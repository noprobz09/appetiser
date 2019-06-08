<template>
    <div class="clearfix">

        <button 
            type="button" 
            class="btn btn-success"
            @click.prevent="load"
            :disabled="loading"
        >
            {{ (!loading)   ?   'Load Data from 2018 PSHS NCE Passers'  :   'Processing...' }}
        </button>
    </div>
</template>

<script>
    import { EventBus } from '../vue-assets';

    export default {

        data() {
            return {
                loading: false,
                message: ''
            };
        },

        mounted() {
            console.log('Component mounted.');
        },

        methods: {

            load() {
                this.loading = true;
                axios.post(Url.Api + '/data/load').then((res) => {
                    
                    if (res.data.result == true) {
                        EventBus.$emit('loadedData');
                    }

                    this.loading = false;
                    this.showMessage(res.data);

                
                }).catch(error => {
                    
                    console.log(error)
                    this.loading = false;
                    this.showMessage(error.data);
                });
            },

            showMessage(data){
                if(data.result == true){
                    toastr.success(data.message, 'Success!', {timeOut: 5000});
                    
                }else{
                    toastr.error(data.message, 'Error!', {timeOut: 5000});
                }
            },

        }

    }
</script>
