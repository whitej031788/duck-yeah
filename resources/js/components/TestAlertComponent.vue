<template>
    <div class="row justify-content-center">
        <loading :active.sync="isLoading" :can-cancel="false" ></loading>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Test Alert</div>
                <div class="card-body">
                    <div v-if="errors && errors.main_error" class="text-danger col-md-12 text-center">{{ errors.main_error[0] }}</div>
                    <form @submit="handleSubmitTest" method="post" novalidate="true">
                        <div class="form-group row mb-0 mt-3">
                            <label for="first_name" class="col-md-2 offset-md-2 col-form-label text-md-right">Person</label>
                            <div class="col-md-6 text-center">
                                <select class="form-control" v-model="selected_person">
                                    <option value=""></option>
                                    <option v-for="person in persons" v-bind:key="person.id" v-bind:value="person.id">{{person.first_name}} {{person.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-3" v-if="selected_person">
                            <label for="first_name" class="col-md-2 offset-md-2 col-form-label text-md-right">Event</label>
                            <div class="col-md-6 text-center">
                                <select class="form-control" v-model="selected_action">
                                    <option value=""></option>
                                    <option v-for="action in available_actions" v-bind:key="action.id" v-bind:value="action.id">{{action.event_type_info.event_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-8 offset-md-2 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Initiate Test
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    function handleSubmitTest(e) {
        e.preventDefault();

        if (this.selected_person == 0 || this.selected_action == 0) {
            this.errors.main_error = ['Please select a person and one of those persons actions'];
            return;
        }

        this.errors = {};
        this.isLoading = true;
        /* TO DO */
        // Should add front end input validation here, no time pre-hackathon
        axios.post('/test-alert', this.toJSON()).then(response => {
            this.isLoading = false;
            alert('Test has been sent');
        }).catch(error => {
            this.isLoading = false;
            this.$scrollToTop();
            this.errors.main_error = ['Something went wrong'];
        });
    }

    function toJSON() {
        let obj = {};
        obj.person_id = this.selected_person;
        obj.person_event_action_id = this.selected_action;
        return obj;
    }

    import Loading from 'vue-loading-overlay';

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "TestAlert",
        props : ['persons'],
        data() {
            return {
                isLoading: false,
                errors: {},
                selected_person: '',
                available_actions: {},
                selected_action: ''
            }
        },
        watch: {
            selected_person: function(val) {
                if (val) {
                    let result = this.persons.filter(obj => {
                        return obj.id === val
                    });

                    this.available_actions = result[0].event_actions;
                } else {
                    this.selected_action = '';
                    this.available_actions = {};
                }
                console.log(val);
            }
        },
        components: {
            Loading
        },
        mounted() {
            console.log(this.persons);
        },
        methods: {
            handleSubmitTest: handleSubmitTest,
            toJSON: toJSON
        }
    }
</script>
