<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Note</div>

                    <div class="card-body">
                        <textarea
                            class="form-control"
                            rows="5"
                            v-model="content"
                        ></textarea>
                    </div>

                    <div class="card-footer">
                        <button
                            class="btn btn-primary"
                            :disabled="content == ''"
                            @click="store"
                        >
                            Create
                        </button>
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
            content: ""
        };
    },
    mounted() {
        console.log("Example mounted.");
    },
    methods: {
        store() {
            axios
                .post("/api/notes", {
                    content: this.content
                })
                .then(response => {
                    this.content = "";
                    Bus.$emit("updateNotes");
                })
                .catch();
        }
    }
};
</script>
