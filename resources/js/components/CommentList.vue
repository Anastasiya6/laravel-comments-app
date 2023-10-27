<template>
    <div class="m-3">
        <h2>Комментарии</h2>
        <comment
            :index="index"
            v-for="(comment,index) in comments"
            :key="comment.id"
            :comment="comment"
            @comment-added="updateComments"
            @toggle-reply-form="toggleReplyForm"
            :depth="0"
        ></comment>
        <comment-form
            @comment-added="updateComments"
        ></comment-form>
    </div>
</template>

<script>
import axios from "axios";
import CommentForm from "./CommentForm.vue";
import Comment from "./Comment.vue";

export default {
    data() {
        return {
            comments: [],
        };
    },
    components: {
        CommentForm,
        Comment,
    },
    async created() {
        try {
            const response = await axios.get("/api/comments");
            this.comments = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        updateComments(comment) {
            this.comments.push(comment);
        },
        toggleReplyForm(comment) {
            comment.showReplyForm = !comment.showReplyForm;
        },
    },
};
</script>
<style scoped>
    .comment {
        margin-left: 10px; /* Отступ слева для комментариев */
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    .reply {
        margin-left: 20px; /* Больший отступ слева для ответов */
        padding: 10px;
        border: 1px solid #00f;
        margin-bottom: 10px;
    }
</style>
