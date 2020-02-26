<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            Existing People
                        </div>
                        <div class="col-md-2 float-right">
                            <a class="btn btn-primary" href="/add-person">Add Person</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Job</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="person in persons" v-bind:key="person.id">
                                <th scope="row">{{person.id}}</th>
                                <td>{{person.first_name}}</td>
                                <td>{{person.last_name}}</td>
                                <td>{{person.email}}</td>
                                <td>{{person.job_role.name}}</td>
                                <td><a class="btn btn-secondary btn-sm" :href="'/edit-person/' + person.id">Edit Person</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        props : ['persons']
    }
</script>