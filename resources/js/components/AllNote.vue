<template>
    <div class="container" style="margin-top: 20px;">
        <div class="row ">
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <table class="table">
                            <thead>
                                <th>Title</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-for="note in notes" :key="note.id">
                                    <td
                                        style="word-break: break-all"
                                        @click="loadNote(note)"
                                    >
                                        {{ note.title }}
                                    </td>
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

            <div class="col-md-8" v-if="note">
                <div class="card">
                    <div class="card-header">{{ note.title }}</div>
                    <div class="card-body">
                        {{ note.content }}

                        <hr />

                        <h6>Access</h6>

                        <ul>
                            <li v-for="acc in note.access">
                                {{ acc.email }} - {{ acc.role }}
                            </li>
                        </ul>

                        <hr />

                        <div v-if="note.is_owner">
                            <div class="form-group">
                                <label for="share">Share *</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="share"
                                    v-model="share"
                                />
                            </div>

                            <button
                                class="btn btn-primary"
                                :disabled="share == ''"
                                @click="shareNote"
                            >
                                Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import decrypt from "../functions/decrypt";
import encrypt from "../functions/encrypt";

export default {
    props: ["privateKey", "publicKey", "user"],

    data: () => {
        return {
            notes: [],
            note: null,
            share: ""
        };
    },

    mounted() {
        this.fetch();

        Bus.$on("updateNotes", () => {
            this.fetch();
        });
    },
    methods: {
        loadNote(note) {
            axios
                .get(`/api/notes/${note.id}`)
                .then(async response => {
                    let note = response.data.data;

                    let title = await decrypt(this.privateKey, note.title);
                    let content = await decrypt(this.privateKey, note.content);

                    note.title = title;
                    note.content = content;

                    note.access.forEach(a => {
                        if (a.email == this.user.email && a.role == "owner") {
                            note.is_owner = true;
                        }
                    });

                    this.note = note;
                })
                .catch();
        },

        async fetch() {
            this.notes = [];

            axios
                .get("/api/notes")
                .then(response => {
                    response.data.data.forEach(async (note, index) => {
                        let title = await decrypt(this.privateKey, note.title);
                        let content = await decrypt(
                            this.privateKey,
                            note.content
                        );

                        note.title = title;
                        note.content = content;

                        this.notes.push(note);

                        if (index == 0) {
                            this.loadNote(note);
                        }
                    });
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
        },

        async update(note, pubKeys, access) {
            let payload = {};

            pubKeys = pubKeys.map(p => {
                return window.atob(p);
            });

            payload["title"] = await encrypt(pubKeys, note.title);
            payload["content"] = await encrypt(pubKeys, note.content);
            payload["access"] = access;

            axios
                .put(`/api/notes/${this.note.id}`, payload)
                .then(response => {
                    this.share = "";
                    this.loadNote(this.note);
                })
                .catch();
        },

        getKeys() {
            let emails = [...this.note.access];

            emails = emails.map(e => {
                return e.email;
            });

            emails.push(this.share);

            emails = emails.filter((v, i, a) => a.indexOf(v) === i);

            axios
                .post("/api/get-keys", {
                    emails: emails
                })
                .then(response => {
                    this.update(this.note, response.data, this.share);
                })
                .catch(err => {});
        },

        shareNote() {
            axios
                .post("/api/share-note", {
                    email: this.share
                })
                .then(response => {
                    this.getKeys();
                })
                .catch(err => {
                    alert("no such user");
                });
        }
    }
};
</script>
