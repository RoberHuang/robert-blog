<template>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item" v-for="task in tasks" v-text="task"></li>
        </ul>
        <hr>
        <form @submit.prevent="addTask" method="post">
            <div class="form-group">
                <input v-model="newTask" type="text" class="form-control" placeholder="Add a Task">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                tasks: [],
                newTask: ''
            }
        },
        mounted() {
            //console.log('Component mounted.')
            axios.get('/api/admin/task/'+ this.user).then(response => {
                this.tasks = response.data
            });
        },
        methods: {
            addTask() {
                axios.post(`/api/admin/task/${this.user}`, {body: this.newTask});
                this.tasks.push(this.newTask);
                this.newTask = '';
            }
        }
    }
</script>