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

        return obj;
    }

    import Loading from 'vue-loading-overlay';

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "TestAlert",
        props : [],
        data() {
            return {
                isLoading: false,
                errors: {}
            }
        },
        components: {
            Loading
        },
        methods: {
            handleSubmitTest: handleSubmitTest,
            toJSON: toJSON
        }
    }
</script>
