<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Note</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                v-model="title"
                            />
                        </div>

                        <div class="form-group">
                            <label for="content">Content *</label>
                            <textarea
                                type="text"
                                class="form-control"
                                id="content"
                                v-model="content"
                            >
                            </textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button
                            class="btn btn-primary"
                            :disabled="content == '' || title == ''"
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
import { mapState } from "vuex";
import encrypt from "../functions/encrypt";

export default {
    data: () => {
        return {
            title: "",
            content: ""
        };
    },
    mounted() {},

    computed: mapState({
        publicKey: state => state.user.publicKey
    }),

    methods: {
        async store() {
            let payload = {};

            payload["title"] = await encrypt([this.publicKey], this.title);
            payload["content"] = await encrypt([this.publicKey], this.content);

            axios
                .post("/api/notes", payload)
                .then(response => {
                    this.content = "";
                    this.title = "";
                    Bus.$emit("updateNotes");
                })
                .catch();
        }
    }
};
</script>
