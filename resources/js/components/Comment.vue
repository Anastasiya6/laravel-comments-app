<template>
    <div :style="indent">
        <p>{{ comment.id }}</p>
        <p>{{ comment.text }}</p>
        <button v-if="!comment.showReplyForm" @click="toggleReplyForm">Answer</button>
        <comment-form
            v-if="comment.showReplyForm"
            :key="comment.id"
            @form-submitted="handleFormSubmitted"
            @comment-added="updateComments"
            :comment="comment"
            :parent-id="comment.id"
        ></comment-form>
        <!-- Рекурсивный вызов компонента Comment для дочерних комментариев -->
        <comment
            v-for="childComment in comment.replies"
            :key="childComment.id"
            :comment="childComment"
            @toggle-reply-form="toggleReplyForm"
            @comment-added="updateComments"
            :depth="depth + 1"
        ></comment>
    </div>
</template>

<script>
import CommentForm from "./CommentForm.vue";

export default {
    name: 'Comment',
    computed: {
        indent() {
            return { transform: `translate(${this.depth * 15}px)` }
        }
    },
    props: {
        comment: Object,
        depth: Number
    },
    components: {
        CommentForm
    },
    methods: {
        toggleReplyForm() {
            this.comment.showReplyForm = !this.comment.showReplyForm;
        },
        updateComments(comment) {
            this.comment.replies.push(comment);
        },
        handleFormSubmitted() {
            this.comment.showReplyForm = false;
        },
    },
};
</script>
