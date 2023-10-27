<template>
    <form @submit.prevent="addComment">
        <div class="mb-3">
            <label for="name" class="form-label">User name:</label>
            <input class="form-control" type="text" id="name" v-model="newComment.name" maxlength="255" required />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input class="form-control" type="email" id="email" v-model="newComment.email" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Home page:</label>
            <input class="form-control" type="text" id="homepage" v-model="newComment.homepage" maxlength="255" required />
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Text:</label>
            <textarea class="form-control" id="text" v-model="newComment.text" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
</template>

<script>
import axios from "axios";

export default {
    props: {
        parentId: {
            type: Number,
            //default: null,
        },
    },
    data() {
        return {
            newComment: {
                name: '',
                email: '',
                homepage: '',
                text: '',
                parent_id: 0,
                replies: [],
            }
        };
    },
    methods: {
        async addComment() {
            try {
                console.log(this.parentId);
                this.newComment.parent_id = this.parentId;
                console.log(this.newComment.parent_id);
                console.log(this.newComment);
                const response = await axios.post('/api/comments', this.newComment);
                this.newComment = {
                    name: '',
                    email: '',
                    homepage: '',
                    text: '',
                    parent_id: 0
                };
                this.$emit('form-submitted');
                this.$emit('comment-added', response.data);
            } catch (error) {
                console.error(error);
            }
        },
    }
}
</script>
