<template>
    <div :style="indent" class="m-3">
        <div>
            <b>{{ comment.user.name }}</b> {{ formattedDate }}
        </div>
        <p>{{ comment.text }}</p>
        <button v-if="!comment.showReplyForm" @click="toggleReplyForm">Ответить</button>
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
        },
        formattedDate() {
            const dateTime = this.comment.created_at;
            const date = new Date(dateTime);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear().toString().slice(-2);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');

            return `${day}.${month}.${year} в ${hours}.${minutes}`;
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
