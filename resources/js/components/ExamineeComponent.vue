<template>
    <div class="clearfix">
        <div class="clearfix" style="margin-bottom: 10px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-examinee">
                <i class="glyphicon glyphicon-plus"></i> Add Examinee
            </button>
        </div>

        <!-- modal -->
        <div class="clearfix">
            <div class="modal" tabindex="-1" role="dialog" id="add-examinee">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="needs-validation" method="POST" enctype="multipart/form-data" v-on:submit.prevent="submit">
                            <div class="modal-header">
                                <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control" id="firstname" placeholder="First Name" v-model="form.firstname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Last Name" v-model="form.lastname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="school">School</label>
                                        <input type="text" class="form-control" id="school" placeholder="School" v-model="form.school" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="division">Division</label>
                                        <input type="text" class="form-control" id="division" placeholder="Division" v-model="form.division" required>                                      
                                    </div>

                                    
                            
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>                   
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { EventBus } from '../vue-assets';

    export default {

        data() {
            return {
                form: {
                    firstname: '',
                    lastname: '',
                    school: '',
                    division: '',
                },                
            };
        },

        mounted() {
               
        },

        methods: {

            submit() {
                axios.post(Url.Api + '/data/examinee/create', this.form).then((res) => {
                    
                    console.log(res);

                    if (res.data.result == true) {
                        $('#add-examinee').modal('hide');
                        EventBus.$emit('createdExaminee');
                        this.showMessage(res.data);
                    }

                }).catch(error => {

                    console.log(res);

                });
            },

            showMessage(data){
                if(data.result == true){
                    toastr.success(data.message, 'Success!', {timeOut: 5000});
                    
                }else{
                    toastr.error(data.message, 'Error!', {timeOut: 5000});
                }
            },


           
        },

        
    }
</script>
