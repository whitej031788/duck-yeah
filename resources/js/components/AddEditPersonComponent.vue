<template>
    <div class="row justify-content-center">
        <loading :active.sync="isLoading" :can-cancel="false" ></loading>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <span v-if="!isEdit">Add</span>
                            <span v-if="isEdit">Edit</span> 
                            Person or Team
                        </div>                        
                    </div>
                </div>
                <div class="card-body">
                    <form @submit="handleSubmit" method="post" novalidate="true">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3>Basic Info</h3>
                            </div>
                            <div v-if="errors && errors.main_error" class="text-danger col-md-12 text-center">{{ errors.main_error[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                            <div class="col-md-6">
                                <input v-model="first_name" id="first_name" type="text" class="form-control" name="first_name" required autocomplete="first_name" autofocus>
                            </div>
                            <div v-if="errors && errors.first_name" class="text-danger col-md-12 text-center">{{ errors.first_name[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                            <div class="col-md-6">
                                <input v-model="last_name" id="last_name" type="text" class="form-control" name="last_name" required autocomplete="last_name" autofocus>
                            </div>
                            <div v-if="errors && errors.last_name" class="text-danger col-md-12 text-center">{{ errors.last_name[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                            <div class="col-md-6">
                                <input v-model="email" id="email" type="email" class="form-control" name="email" required autocomplete="email">
                            </div>
                            <div v-if="errors && errors.email" class="text-danger col-md-12 text-center">{{ errors.email[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="job_role" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">
                                <select v-model="job_role" class="form-control" id="job_role">
                                    <option value=""></option>
                                    <option v-for="role in roles" v-bind:key="role.id" v-bind:value="role.id">{{role.name}}</option>
                                </select>
                            </div>
                            <div v-if="errors && errors.job_role" class="text-danger col-md-12 text-center">{{ errors.job_role[0] }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3>Event Actions</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <button type="button" class="btn btn-primary float-right" @click="handleAddEvent()">
                                    + Add Event Action
                                </button>
                            </div>
                        </div>
                        <div class="row ko-alternate">
                            <div v-if="errors && errors.event_actions" class="text-danger col-md-12 text-center">{{ errors.event_actions[0] }}</div>
                            <div class="col-md-12" v-for="(action, index) in event_actions" v-bind:key="index" :class="{'even': index % 2 === 0, 'odd': index % 2 !== 0 }">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">Action Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" v-model="action.event_type_id" required>
                                            <option value=""></option>
                                            <option v-for="event in eventTypes" v-bind:key="event.id" v-bind:value="event.id">{{event.event_name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="close" aria-label="Close" @click="handleRemoveEvent(index)">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">GIF URL</label>
                                    <div class="col-md-6">
                                        <input type="url" class="form-control" required autofocus v-model="action.giphy_url">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right">Youtube Key</label>
                                    <div class="col-md-3">
                                        <input type="url" class="form-control" required autofocus v-model="action.youtube_key">
                                    </div>
                                    <label class="col-md-3 col-form-label text-md-right">Start (sec)</label>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" required autofocus v-model="action.youtube_start">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">Description</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control"  required autofocus v-model="action.description">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-4 offset-md-2 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <span v-if="!isEdit">Add</span><span v-if="isEdit">Edit</span> Person / Team
                                </button>
                            </div>
                            <div class="col-md-4 text-right" v-if="isEdit">
                                <button @click="handleDeletePerson" type="button" class="btn btn-danger">Delete Person / Team</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    function eventActionModel() {
        this.event_type_id = '';
        this.giphy_url = '';
        this.youtube_key = '';
        this.youtube_start = 0;
        this.description = '';
    }

    function handleAddEvent() {
        this.event_actions.push(new eventActionModel());
    }

    function handleRemoveEvent(index) {
        this.event_actions.splice(index, 1);
    }

    function handleDeletePerson() {
        if (!this.person || !this.person.id) {
            alert('You cannot delete this person');
            return;
        }

        if (confirm('Are you sure you want to delete this person?')) {
            this.errors = {};
            this.isLoading = true;

            axios.post('/delete-person', {"person_id" : this.person.id}).then(response => {
                this.isLoading = false;
                this.$redirect('/home');
            }).catch(error => {
                this.isLoading = false;
                this.$scrollToTop();
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.errors.main_error = ['Something went wrong when trying to delete the person'];
                }
            });
            return;
        } else {
            return;
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (this.isEdit) {
            this.handleEditPerson();
        } else {
            this.handleAddPerson();
        }
    }

    function handleEditPerson() {
        this.errors = {};
        this.isLoading = true;

        /* TO DO */
        // Should add front end input validation here, no time pre-hackathon
        axios.post('/edit-person', this.toJSON(true)).then(response => {
            this.isLoading = false;
            this.$redirect('/home');
        }).catch(error => {
            this.isLoading = false;
            this.$scrollToTop();
            if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
            } else {
                this.errors.main_error = ['Something went wrong, please make sure all fields are filled out and try again'];
            }
        });
    }

    function handleAddPerson() {
        this.errors = {};
        this.isLoading = true;

        /* TO DO */
        // Should add front end input validation here, no time pre-hackathon
        axios.post('/add-person', this.toJSON(false)).then(response => {
            this.isLoading = false;
            this.$redirect('/home');
        }).catch(error => {
            this.isLoading = false;
            this.$scrollToTop();
            if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
            } else {
                this.errors.main_error = ['Something went wrong, please make sure all fields are filled out and try again'];
            }
        });
    }

    function toJSON(isEdit) {
        let obj = {};

        obj.first_name = this.first_name.trim();
        obj.last_name = this.last_name.trim();
        obj.email = this.email.trim();
        obj.job_role = this.job_role;
        obj.event_actions = this.event_actions;

        if (isEdit) {
            obj.person_id = this.person.id;
        }

        return obj;
    }

    import Loading from 'vue-loading-overlay';

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "AddPerson",
        props : ['roles', 'event-types', 'person'],
        data() {
            return {
                first_name: '',
                last_name: '',
                email: '',
                job_role: '',
                isLoading: false,
                event_actions: [],
                isEdit: false,
                errors: {}

            }
        },
        components: {
            Loading
        },
        mounted() {
            if (this.person) {
                console.log(this.person);
                this.initEditPerson()
            }
        },
        methods: {
            handleAddEvent: handleAddEvent,
            handleRemoveEvent: handleRemoveEvent,
            handleAddPerson: handleAddPerson,
            toJSON: toJSON,
            handleDeletePerson: handleDeletePerson,
            handleEditPerson: handleEditPerson,
            handleSubmit: handleSubmit,
            initEditPerson: function() {
                this.first_name = this.person.first_name;
                this.last_name = this.person.last_name;
                this.email = this.person.email;
                this.job_role = this.person.job_role_id;
                this.event_actions = this.person.event_actions;

                this.isEdit = true;
            }
        }
    }
</script>
