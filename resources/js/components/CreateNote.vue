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
import { EThree } from "@virgilsecurity/e3kit-browser";
import findUserPublicKey from "../functions/findUserPublicKey.js";

export default {
    data: () => {
        return {
            content: ""
        };
    },
    mounted() {},
    methods: {
        async store() {
            // const publicKeys = await eThree.findUsers([appUser.email]);
            const content = await eThree.authEncrypt(this.content);
            axios
                .post("/api/notes", {
                    content
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
