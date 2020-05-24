<template>
    <div class="container" style="margin-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div>
                        <table class="table">
                            <thead>
                                <th>Content</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-for="note in notes" :key="note.id">
                                    <td>{{ note.content }}</td>
                                    <td>
                                        <button
                                            class="btn btn-danger btn-sm"
                                            @click="destroy(note)"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            notes: []
        };
    },
    mounted() {
        this.fetch();

        Bus.$on("updateNotes", () => {
            this.fetch();
        });
    },
    methods: {
        fetch() {
            axios
                .get("/api/notes")
                .then(response => {
                    this.notes = response.data.data;
                })
                .catch();
        },

        destroy(note) {
            axios
                .delete(`/api/notes/${note.id}`)
                .then(response => {
                    this.fetch();
                })
                .catch();
        }
    }
};
</script>
