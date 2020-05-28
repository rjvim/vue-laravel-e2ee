<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Enter your encryption password
                    </div>

                    <div class="card-body">
                        <input
                            type="text"
                            class="form-control"
                            v-model="encryption"
                        />
                    </div>

                    <div class="card-footer">
                        <button
                            class="btn btn-primary"
                            @click="savePassword"
                            :disabled="encryption == ''"
                        >
                            Save
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
            encryption: ""
        };
    },

    mounted() {
        // if (localStorage.encryptionPassword) {
        //     this.$store.dispatch("user/setEncryptionPassword", {
        //         encryptionPassword: localStorage.encryptionPassword
        //     });
        // }
    },

    methods: {
        savePassword() {
            this.$store.dispatch("user/setEncryptionPassword", {
                encryptionPassword: this.encryption
            });
            // localStorage.encryptionPassword = this.encryption;
        }
    }
};
</script>
